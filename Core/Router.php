<?php

class Router {
    private string $basePath = "/AstroCalendar";
    private array $routes = [
        '/' => ['BodiesListController', 'listAction'],

        '/admin/files' => ['AdminController', 'listAction'],
        '/admin/files/upload' => ['AdminController', 'fileUploadAction'],
        '/admin/files/create-dir' => ['AdminController', 'createDirectoryAction'],
        '/admin/files/delete' => ['AdminController', 'deleteItemAction'],
        '/admin/files/edit' => ['AdminController', 'fileEditorAction'],
        '/admin/files/save' => ['AdminController', 'saveFileAction'],
    ];

    private function extractPath($uri): string {
        return substr($uri, strlen($this->basePath));
    }

    private function classExists($class): bool {
        $file = __DIR__ . '/../Controller/' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            if (class_exists($class) || class_exists("Controller\\" . $class)) {
                return true;
            }
        }

        return false;
    }

    public function dispatch(string $uri): void {
        $uri = parse_url($uri, PHP_URL_PATH);
        $path = $this->extractPath($uri);

        if (!array_key_exists($path, $this->routes)) {
            http_response_code(404);
            echo "Page not found";
            return;
        }

        [$controllerClass, $method] = $this->routes[$path];

        if (!$this->classExists($controllerClass) || !method_exists($controllerClass, $method)) {
            http_response_code(404);
            echo "Page not found";
            return;
        }

        $controller = new $controllerClass();
        $controller->$method();
    }
}