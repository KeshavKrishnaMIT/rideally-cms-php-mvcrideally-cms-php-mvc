<?php
// ============================================================
// MODEL: Comment
// ============================================================

class Comment {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /**
     * Get all comments for a given post, oldest first.
     */
    public function getByPost($postId) {
        $stmt = $this->conn->prepare(
            "SELECT c.*, u.full_name 
             FROM comments c
             JOIN users u ON u.id = c.user_id
             WHERE c.post_id = ?
             ORDER BY c.created_at ASC"
        );
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Add a new comment.
     */
    public function create($postId, $userId, $content) {
        $stmt = $this->conn->prepare(
            "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)"
        );
        $stmt->bind_param('iis', $postId, $userId, $content);
        return $stmt->execute();
    }
}