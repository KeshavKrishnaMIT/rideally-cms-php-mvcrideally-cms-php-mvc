<?php
// ============================================================
// CONTROLLER: CategoryController
// ============================================================

class CategoryController {

    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        requireRole(['Super Admin', 'Admin']);
        $categories = $this->categoryModel->getAll();
        include dirname(__DIR__) . '/views/dashboard/categories/list.php';
    }

    public function create() {
        requireRole(['Super Admin', 'Admin']);
        $errors = [];
        $old    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = makeSlug($name);
            $old  = ['name' => $name];

            if (empty($name)) {
                $errors[] = 'Category name is required.';
            } elseif ($this->categoryModel->slugExists($slug)) {
                $errors[] = 'A category with a similar name already exists.';
            }

            if (empty($errors)) {
                $this->categoryModel->create($name, $slug);
                setFlash('success', 'Category created.');
                redirect(BASE_URL . 'dashboard/categories');
            }
        }

        $editing = false;
        include dirname(__DIR__) . '/views/dashboard/categories/form.php';
    }

    public function edit($id) {
        requireRole(['Super Admin', 'Admin']);
        $category = $this->categoryModel->findById($id);
        if (!$category) {
            setFlash('danger', 'Category not found.');
            redirect(BASE_URL . 'dashboard/categories');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = makeSlug($name);

            if (empty($name)) {
                $errors[] = 'Category name is required.';
            } elseif ($this->categoryModel->slugExists($slug, $id)) {
                $errors[] = 'Another category with a similar name already exists.';
            }

            if (empty($errors)) {
                $this->categoryModel->update($id, $name, $slug);
                setFlash('success', 'Category updated.');
                redirect(BASE_URL . 'dashboard/categories');
            }
        }

        $old     = ['name' => $category['name']];
        $editing = true;
        include dirname(__DIR__) . '/views/dashboard/categories/form.php';
    }

    public function delete($id) {
        requireRole(['Super Admin', 'Admin']);
        $this->categoryModel->delete($id);
        setFlash('success', 'Category deleted.');
        redirect(BASE_URL . 'dashboard/categories');
    }
}