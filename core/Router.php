<?php
// ============================================================
// ROUTER
// Maps incoming URL segments to the correct controller/method.
// This is a simple front-controller router — all requests go
// through public/index.php and are dispatched from here.
// ============================================================

class Router {

    private $routes = [];

    /**
     * Register a route.
     * $pattern  = URL pattern, e.g. 'auth/login'
     * $callback = [ControllerClass, method] or a closure
     */
    public function add($pattern, $callback) {
        $this->routes[$pattern] = $callback;
    }

    /**
     * Dispatch the current request to the matching route.
     */
    public function dispatch($url) {
        // Strip query string
        $url = strtok($url, '?');
        // Trim leading slashes
        $url = trim($url, '/');

        if (isset($this->routes[$url])) {
            $callback = $this->routes[$url];
            if (is_array($callback)) {
                [$class, $method] = $callback;
                (new $class())->$method();
            } else {
                call_user_func($callback);
            }
            return;
        }

        // Try dynamic segments (e.g. posts/view/42)
        foreach ($this->routes as $pattern => $callback) {
            $regex = preg_replace('/\{[a-z_]+\}/', '([^/]+)', $pattern);
            $regex = '#^' . $regex . '$#';
            if (preg_match($regex, $url, $matches)) {
                array_shift($matches); // remove full match
                $callback = $this->routes[$pattern];
                if (is_array($callback)) {
                    [$class, $method] = $callback;
                    (new $class())->$method(...$matches);
                } else {
                    call_user_func_array($callback, $matches);
                }
                return;
            }
        }

        // 404
        http_response_code(404);
        include dirname(__DIR__) . '/app/views/layouts/header.php';
        echo '<div class="container mt-5 text-center">
                <h1 class="display-1 fw-bold text-muted">404</h1>
                <p class="lead">Page not found.</p>
                <a href="' . BASE_URL . '" class="btn btn-primary">Go Home</a>
              </div>';
        include dirname(__DIR__) . '/app/views/layouts/footer.php';
    }
}