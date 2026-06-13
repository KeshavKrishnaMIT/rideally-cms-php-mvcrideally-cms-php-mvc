<?php
// ============================================================
// MODEL: Category
// ============================================================

class Category {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM categories ORDER BY name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findBySlug($slug) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $slug) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $slug);
        return $stmt->execute();
    }

    public function update($id, $name, $slug) {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
        $stmt->bind_param('ssi', $name, $slug, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function slugExists($slug, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->conn->prepare("SELECT id FROM categories WHERE slug = ? AND id != ? LIMIT 1");
            $stmt->bind_param('si', $slug, $excludeId);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM categories WHERE slug = ? LIMIT 1");
            $stmt->bind_param('s', $slug);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}