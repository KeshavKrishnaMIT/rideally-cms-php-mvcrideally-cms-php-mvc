<?php
// ============================================================
// MODEL: Post
// ============================================================

class Post {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getApproved($limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                    u.full_name AS author_name
             FROM posts p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.author_id
             WHERE p.status = 'approved'
             ORDER BY p.created_at DESC
             LIMIT ? OFFSET ?"
        );

        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countApproved() {
        $result = $this->conn->query(
            "SELECT COUNT(*) AS total FROM posts WHERE status = 'approved'"
        );

        return $result->fetch_assoc()['total'];
    }

    public function getBySlug($slug) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                    u.full_name AS author_name
             FROM posts p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.author_id
             WHERE p.slug = ? AND p.status = 'approved'
             LIMIT 1"
        );

        $stmt->bind_param('s', $slug);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name, u.full_name AS author_name
             FROM posts p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.author_id
             WHERE p.id = ?
             LIMIT 1"
        );

        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getByCategory($categoryId, $limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                    u.full_name AS author_name
             FROM posts p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.author_id
             WHERE p.status = 'approved'
               AND p.category_id = ?
             ORDER BY p.created_at DESC
             LIMIT ? OFFSET ?"
        );

        $stmt->bind_param('iii', $categoryId, $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function search($keyword, $limit = 10, $offset = 0) {
        $like = '%' . $keyword . '%';

        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                    u.full_name AS author_name
             FROM posts p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.author_id
             WHERE p.status = 'approved'
               AND (p.title LIKE ? OR p.content LIKE ?)
             ORDER BY p.created_at DESC
             LIMIT ? OFFSET ?"
        );

        $stmt->bind_param('ssii', $like, $like, $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDashboardPosts($userId, $role) {
        if (in_array($role, ['Super Admin', 'Admin', 'Editor'])) {

            $result = $this->conn->query(
                "SELECT p.*, c.name AS category_name, u.full_name AS author_name
                 FROM posts p
                 JOIN categories c ON c.id = p.category_id
                 JOIN users u ON u.id = p.author_id
                 ORDER BY p.created_at DESC"
            );

        } else {

            $stmt = $this->conn->prepare(
                "SELECT p.*, c.name AS category_name, u.full_name AS author_name
                 FROM posts p
                 JOIN categories c ON c.id = p.category_id
                 JOIN users u ON u.id = p.author_id
                 WHERE p.author_id = ?
                 ORDER BY p.created_at DESC"
            );

            $stmt->bind_param('i', $userId);
            $stmt->execute();

            $result = $stmt->get_result();
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($title, $slug, $content, $image, $categoryId, $authorId, $status) {
        $stmt = $this->conn->prepare(
            "INSERT INTO posts
             (title, slug, content, featured_image, category_id, author_id, status)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            'ssssiis',
            $title,
            $slug,
            $content,
            $image,
            $categoryId,
            $authorId,
            $status
        );

        return $stmt->execute();
    }

   public function update($id, $title, $slug, $content, $image, $categoryId, $status) {
    if ($image) {
        $stmt = $this->conn->prepare(
            "UPDATE posts SET title=?, slug=?, content=?, featured_image=?, 
             category_id=?, status=?, updated_at=NOW() WHERE id=?"
        );
        $stmt->bind_param('ssssisi', $title, $slug, $content, $image, $categoryId, $status, $id);
    } else {
        $stmt = $this->conn->prepare(
            "UPDATE posts SET title=?, slug=?, content=?, 
             category_id=?, status=?, updated_at=NOW() WHERE id=?"
        );
        $stmt->bind_param('sssisi', $title, $slug, $content, $categoryId, $status, $id);
    }
    return $stmt->execute();
}

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare(
            "UPDATE posts SET status = ? WHERE id = ?"
        );

        $stmt->bind_param('si', $status, $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM posts WHERE id = ?"
        );

        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    public function slugExists($slug, $excludeId = null) {

        if ($excludeId !== null) {

            $stmt = $this->conn->prepare(
                "SELECT id
                 FROM posts
                 WHERE slug = ?
                   AND id != ?
                 LIMIT 1"
            );

            $stmt->bind_param('si', $slug, $excludeId);

        } else {

            $stmt = $this->conn->prepare(
                "SELECT id
                 FROM posts
                 WHERE slug = ?
                 LIMIT 1"
            );

            $stmt->bind_param('s', $slug);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getStats() {

        $stats = [];

        $stats['total'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM posts")
            ->fetch_assoc()['n'];

        $stats['approved'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM posts WHERE status = 'approved'")
            ->fetch_assoc()['n'];

        $stats['pending'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM posts WHERE status = 'pending'")
            ->fetch_assoc()['n'];

        $stats['draft'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM posts WHERE status = 'draft'")
            ->fetch_assoc()['n'];

        $stats['users'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM users")
            ->fetch_assoc()['n'];

        $stats['comments'] = $this->conn
            ->query("SELECT COUNT(*) AS n FROM comments")
            ->fetch_assoc()['n'];

        return $stats;
    }
}