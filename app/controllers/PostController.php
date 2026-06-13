<?php
// ============================================================
// CONTROLLER: PostController
// Handles both public post browsing and dashboard post management.
// ============================================================

class PostController {

    private $postModel;
    private $categoryModel;

    public function __construct() {
        $this->postModel     = new Post();
        $this->categoryModel = new Category();
    }

    // ----------------------------------------------------------
    // PUBLIC: List all approved posts (with simple pagination)
    // ----------------------------------------------------------
    public function publicList() {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 6;
        $offset = ($page - 1) * $limit;

        $posts      = $this->postModel->getApproved($limit, $offset);
        $total      = $this->postModel->countApproved();
        $totalPages = ceil($total / $limit);
        $categories = $this->categoryModel->getAll();

        include dirname(__DIR__) . '/views/public/posts.php';
    }

    // ----------------------------------------------------------
    // PUBLIC: View a single post
    // ----------------------------------------------------------
    public function view($slug) {
        $post = $this->postModel->getBySlug($slug);
        if (!$post) {
            http_response_code(404);
            include dirname(__DIR__) . '/views/layouts/header.php';
            echo '<div class="container mt-5"><div class="alert alert-warning">Post not found.</div></div>';
            include dirname(__DIR__) . '/views/layouts/footer.php';
            return;
        }

        $commentModel = new Comment();
        $comments     = $commentModel->getByPost($post['id']);
        $categories   = $this->categoryModel->getAll();

        include dirname(__DIR__) . '/views/public/single_post.php';
    }

    // ----------------------------------------------------------
    // PUBLIC: Posts by category
    // ----------------------------------------------------------
    public function byCategory($slug) {
        $category = $this->categoryModel->findBySlug($slug);
        if (!$category) {
            redirect(BASE_URL . 'posts');
        }

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 6;
        $offset = ($page - 1) * $limit;

        $posts      = $this->postModel->getByCategory($category['id'], $limit, $offset);
        $total      = count($this->postModel->getByCategory($category['id'], 999, 0));
        $totalPages = ceil($total / $limit);
        $categories = $this->categoryModel->getAll();

        include dirname(__DIR__) . '/views/public/posts.php';
    }

    // ----------------------------------------------------------
    // PUBLIC: Search
    // ----------------------------------------------------------
    public function search() {
        $keyword    = trim($_GET['q'] ?? '');
        $posts      = [];
        $categories = $this->categoryModel->getAll();

        if ($keyword !== '') {
            $posts = $this->postModel->search($keyword);
        }

        include dirname(__DIR__) . '/views/public/search.php';
    }

    // ----------------------------------------------------------
    // DASHBOARD: List posts (role-aware)
    // ----------------------------------------------------------
    public function dashboardList() {
        requireRole(['Super Admin', 'Admin', 'Editor', 'Author']);
        $posts = $this->postModel->getDashboardPosts($_SESSION['user_id'], $_SESSION['user_role']);
        include dirname(__DIR__) . '/views/dashboard/posts/list.php';
    }

    // ----------------------------------------------------------
    // DASHBOARD: Create post
    // ----------------------------------------------------------
    public function create() {
        requireRole(['Super Admin', 'Admin', 'Author']);
        $categories = $this->categoryModel->getAll();
        $errors     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title      = trim($_POST['title'] ?? '');
            $content    = trim($_POST['content'] ?? '');
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $action     = $_POST['action'] ?? 'draft'; // 'draft' or 'submit'

            if (empty($title))   $errors[] = 'Title is required.';
            if (empty($content)) $errors[] = 'Content is required.';
            if ($categoryId < 1) $errors[] = 'Please select a category.';

            if (empty($errors)) {
                $slug = makeSlug($title);
                // Ensure slug uniqueness
                $base = $slug;
                $i    = 1;
                while ($this->postModel->slugExists($slug)) {
                    $slug = $base . '-' . $i++;
                }

                // Determine status
                $status = 'draft';
                if ($action === 'submit') {
                    $status = 'pending';
                } elseif (hasRole(['Super Admin', 'Admin'])) {
                    $status = ($action === 'publish') ? 'approved' : 'draft';
                }

                // Handle image upload
                $image = null;
                if (!empty($_FILES['featured_image']['name'])) {
                    $image = uploadImage($_FILES['featured_image']);
                    if (!$image) {
                        $errors[] = 'Invalid image file. Use JPG, PNG, GIF, or WebP under 2MB.';
                    }
                }

                if (empty($errors)) {
                    $this->postModel->create($title, $slug, $content, $image, $categoryId, $_SESSION['user_id'], $status);
                    setFlash('success', 'Post saved successfully.');
                    redirect(BASE_URL . 'dashboard/posts');
                }
            }
        }

        include dirname(__DIR__) . '/views/dashboard/posts/create.php';
    }

    // ----------------------------------------------------------
    // DASHBOARD: Edit post
    // ----------------------------------------------------------
    public function edit($id) {
        requireRole(['Super Admin', 'Admin', 'Editor', 'Author']);
        $post = $this->postModel->findById($id);

        if (!$post) {
            setFlash('danger', 'Post not found.');
            redirect(BASE_URL . 'dashboard/posts');
        }

        // Authors can only edit their own posts
        if (hasRole(['Author']) && $post['author_id'] != $_SESSION['user_id']) {
            setFlash('danger', 'You cannot edit this post.');
            redirect(BASE_URL . 'dashboard/posts');
        }

        $categories = $this->categoryModel->getAll();
        $errors     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title      = trim($_POST['title'] ?? '');
            $content    = trim($_POST['content'] ?? '');
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $action     = $_POST['action'] ?? 'draft';

            if (empty($title))   $errors[] = 'Title is required.';
            if (empty($content)) $errors[] = 'Content is required.';
            if ($categoryId < 1) $errors[] = 'Please select a category.';

            if (empty($errors)) {
                $slug = makeSlug($title);
                $base = $slug;
                $i    = 1;
                while ($this->postModel->slugExists($slug, $id)) {
                    $slug = $base . '-' . $i++;
                }

                $status = $post['status']; // keep current by default
                if (hasRole(['Author'])) {
                    $status = ($action === 'submit') ? 'pending' : 'draft';
                } elseif (hasRole(['Editor'])) {
                    $status = $post['status']; // editors use approve/reject separately
                } elseif (hasRole(['Super Admin', 'Admin'])) {
                    $status = $action;
                }

                $image = null;
                if (!empty($_FILES['featured_image']['name'])) {
                    $image = uploadImage($_FILES['featured_image']);
                    if (!$image) {
                        $errors[] = 'Invalid image. Use JPG, PNG, GIF, or WebP under 2MB.';
                    }
                }

                if (empty($errors)) {
                    $this->postModel->update($id, $title, $slug, $content, $image, $categoryId, $status);
                    setFlash('success', 'Post updated.');
                    redirect(BASE_URL . 'dashboard/posts');
                }
            }
        }

        include dirname(__DIR__) . '/views/dashboard/posts/edit.php';
    }

    // ----------------------------------------------------------
    // DASHBOARD: Delete post
    // ----------------------------------------------------------
    public function delete($id) {
        requireRole(['Super Admin', 'Admin', 'Author']);
        $post = $this->postModel->findById($id);

        if ($post) {
            // Authors can only delete their own drafts
            if (hasRole(['Author']) && ($post['author_id'] != $_SESSION['user_id'] || $post['status'] !== 'draft')) {
                setFlash('danger', 'You can only delete your own drafts.');
                redirect(BASE_URL . 'dashboard/posts');
            }
            $this->postModel->delete($id);
            setFlash('success', 'Post deleted.');
        }

        redirect(BASE_URL . 'dashboard/posts');
    }

    // ----------------------------------------------------------
    // DASHBOARD: Approve a post
    // ----------------------------------------------------------
    public function approve($id) {
        requireRole(['Super Admin', 'Admin', 'Editor']);
        $this->postModel->updateStatus($id, 'approved');
        setFlash('success', 'Post approved and published.');
        redirect(BASE_URL . 'dashboard/posts');
    }

    // ----------------------------------------------------------
    // DASHBOARD: Reject a post
    // ----------------------------------------------------------
    public function reject($id) {
        requireRole(['Super Admin', 'Admin', 'Editor']);
        $this->postModel->updateStatus($id, 'rejected');
        setFlash('warning', 'Post rejected.');
        redirect(BASE_URL . 'dashboard/posts');
    }
}