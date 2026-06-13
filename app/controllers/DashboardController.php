<?php
// ============================================================
// CONTROLLER: DashboardController
// ============================================================

class DashboardController {

    public function index() {
        requireLogin();
        $postModel = new Post();
        $stats     = $postModel->getStats();
        include dirname(__DIR__) . '/views/dashboard/index.php';
    }
}