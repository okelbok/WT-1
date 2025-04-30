<?php

declare(strict_types=1);

class AdminService {
    private string $basePath;
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'css', 'js', 'html', 'txt'];

    public function __construct() {
        $this->basePath = (string)realpath(__DIR__ . '/../view/public/');

        if (!file_exists($this->basePath)) {
            mkdir($this->basePath, 0755, true);
        }
    }

    public function getBasePath(): string {
        return $this->basePath;
    }

    public function getFiles(string $directory = ''): array
    {
        $fullPath = $this->validatePath($directory);
        $items = [];

        foreach (scandir($fullPath) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $itemPath = $fullPath . DIRECTORY_SEPARATOR . $item;
            $relativePath = ($directory ? $directory . '/' : '') . $item;

            $items[] = [
                'name' => $item,
                'path' => $relativePath,
                'size' => $this->formatSize($itemPath),
                'modified' => date('Y-m-d H:i:s', filemtime($itemPath)),
                'extension' => pathinfo($item, PATHINFO_EXTENSION),
                'permissions' => substr(sprintf('%o', fileperms($itemPath)), -4)
            ];
        }

        return $items;
    }

    public function uploadFile(array $file, string $directory = ''): bool
    {
        $targetDir = $this->validatePath($directory);
        $fileName = basename($file['name']);
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->allowedExtensions)) {
            http_response_code(400);
        }

        return move_uploaded_file($file['tmp_name'], $targetPath);
    }

    public function createDirectory(string $dirName, string $parentDir = ''): bool
    {
        $fullPath = $this->validatePath($parentDir) . DIRECTORY_SEPARATOR . $dirName;
        return !file_exists($fullPath) && mkdir($fullPath, 0755);
    }

    public function deleteItem(string $path): bool
    {
        $fullPath = $this->validatePath($path);

        if (is_dir($fullPath)) {
            return $this->deleteDirectory($fullPath);
        }

        return unlink($fullPath);
    }

    public function editFile(string $path, string $content): bool
    {
        $fullPath = $this->validatePath($path);
        return file_put_contents($fullPath, $content) !== false;
    }

    public function getFileContent(string $path): string
    {
        $fullPath = $this->validatePath($path);
        return file_get_contents($fullPath);
    }

    private function validatePath(string $path): string
    {
        $fullPath = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;

        if (!str_starts_with(realpath($fullPath), $this->basePath)) {
            http_response_code(403);
            echo "File Access is not allowed";
            exit();
        }

        return $fullPath;
    }

    private function deleteDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }

        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }

        return rmdir($dir);
    }

    private function formatSize(string $path): string
    {
        if (is_dir($path)) {
            return '-';
        }

        $size = filesize($path);
        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }
}