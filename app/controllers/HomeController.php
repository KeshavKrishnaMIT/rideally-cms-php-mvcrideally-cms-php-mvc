<?php
class HomeController {

    public function index() {
        $postModel    = new Post();
        $categoryModel = new Category();

        $recentPosts = $postModel->getApproved(6, 0);
        $categories  = $categoryModel->getAll();

        include dirname(__DIR__) . '/views/public/home.php';
    }
}