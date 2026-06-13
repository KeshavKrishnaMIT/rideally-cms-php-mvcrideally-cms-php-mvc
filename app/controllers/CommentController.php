<?php
// ============================================================
// CONTROLLER: CommentController
// ============================================================

class CommentController {

    public function store() {
        // Only logged-in users can comment
        if (!isLoggedIn()) {
            setFlash('warning', 'Please sign in to leave a comment.');
            redirect(BASE_URL . 'auth/login');
        }

        $postId  = (int)($_POST['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        $slug    = trim($_POST['slug'] ?? '');

        if (empty($content)) {
            setFlash('danger', 'Comment cannot be empty.');
            redirect(BASE_URL . 'posts/view/' . $slug);
            return;
        }

        $commentModel = new Comment();
        $commentModel->create($postId, $_SESSION['user_id'], $content);

        setFlash('success', 'Comment added.');
        redirect(BASE_URL . 'posts/view/' . $slug . '#comments');
    }
}