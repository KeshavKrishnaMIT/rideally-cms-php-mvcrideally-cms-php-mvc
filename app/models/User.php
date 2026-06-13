<?php
// ============================================================
// MODEL: User
// Handles all database operations related to users.
// ============================================================

class User {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /**
     * Find a user by their email address.
     * Joins roles table to get role_name in one query.
     */
    public function findByEmail($email) {
        $stmt = $this->conn->prepare(
            "SELECT u.*, r.name AS role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.email = ? LIMIT 1"
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Find a user by their ID.
     */
    public function findById($id) {
        $stmt = $this->conn->prepare(
            "SELECT u.*, r.name AS role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Register a new user with a selected role_id.
     * Password must already be hashed before calling this.
     */
    public function create($fullName, $email, $hashedPassword, $roleId) {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (full_name, email, password, role_id) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param('sssi', $fullName, $email, $hashedPassword, $roleId);
        return $stmt->execute();
    }

    /**
     * Get the ID of the last inserted row.
     * Used after create() to immediately log the user in.
     */
    public function getLastInsertId() {
        return $this->conn->insert_id;
    }

    /**
     * Check if an email is already registered.
     */
    public function emailExists($email) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM users WHERE email = ? LIMIT 1"
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Get all users with their role names (for admin panel).
     */
    public function getAll() {
        $result = $this->conn->query(
            "SELECT u.id, u.full_name, u.email, r.name AS role_name, u.created_at
             FROM users u
             JOIN roles r ON r.id = u.role_id
             ORDER BY u.id DESC"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update a user's role.
     */
    public function updateRole($userId, $roleId) {
        $stmt = $this->conn->prepare(
            "UPDATE users SET role_id = ? WHERE id = ?"
        );
        $stmt->bind_param('ii', $roleId, $userId);
        return $stmt->execute();
    }

    /**
     * Delete a user by ID.
     */
    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    /**
     * Get all roles from the roles table.
     * Used to populate the role dropdown on register/login forms.
     */
    public function getRoles() {
        $result = $this->conn->query(
            "SELECT * FROM roles ORDER BY id ASC"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Check if a role ID actually exists in the roles table.
     * Security check — prevents submitting fake role IDs.
     */
    public function roleExists($roleId) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM roles WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $roleId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}