<?php

declare(strict_types = 1);

class Router {
    private string $basePath = "/AstroCalendar";
    private array $routes = [
        '/' => ['CalendarController', 'listAction'],

        '/admin' => ['AdminController', 'listAction'],
        '/admin/upload' => ['AdminController', 'fileUploadAction'],
        '/admin/create-dir' => ['AdminController', 'createDirectoryAction'],
        '/admin/delete' => ['AdminController', 'deleteItemAction'],
        '/admin/edit' => ['AdminController', 'fileEditorAction'],
        '/admin/save' => ['AdminController', 'saveFileAction'],
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
            exit;
        }

        [$controllerClass, $method] = $this->routes[$path];

        if (!$this->classExists($controllerClass) || !method_exists($controllerClass, $method)) {
            http_response_code(404);
            exit;
        }

        $controller = new $controllerClass();
        $controller->$method();
    }
}