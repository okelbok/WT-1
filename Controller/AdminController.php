<?php

declare(strict_types=1);

require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../Core/TemplateEngine.php";
require_once __DIR__ . "/../Service/AdminService.php";

class AdminController extends BaseController {
    private templateEngine $templateEngine;
    private AdminService $adminService;
    private string $templateBasePath  = __DIR__ . "/../view/admin/html/";

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->adminService = new AdminService();
    }

    protected function renderTemplate(string $fileName, array $data = []): string {
        $fileName = $this->templateBasePath . $fileName;
        $htmlResponse = "";

        if (file_exists($fileName)) {
            $htmlResponse = $this->templateEngine->render($fileName, $data);
        }

        return $htmlResponse;
    }

    public function listAction(): void
    {
        $currentDir = $_GET["dir"] ?? $this->adminService->getBasePath();
        $files = $this->adminService->getFiles($currentDir);

        echo $this->renderTemplate("admin_index.html", [
            'files' => $files,
            'currentDir' => $currentDir,
            'message' => $_GET['message'] ?? null,
            'error' => $_GET['error'] ?? null
        ]);
    }

    public function fileUploadAction(): void
    {
        try {
            $currentDir = $_POST['dir'] ?? '';
            $this->adminService->uploadFile($_FILES['file'], $currentDir);
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&message=File has been Loaded');
        } catch (Exception $e) {
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function createDirectoryAction(): void
    {
        $currentDir = $_POST['dir'] ?? '';
        $dirName = $_POST['new_dir_name'] ?? '';

        if ($this->adminService->createDirectory($dirName, $currentDir)) {
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&message=Directory has been created');
        } else {
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&error=Directory could not be created');
        }
    }

    public function deleteItemAction(): void
    {
        $currentDir = dirname($_POST['path']);
        if ($this->adminService->deleteItem($_POST['path'])) {
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&message=File has been deleted');
        } else {
            $this->redirect('/admin/files?dir=' . urlencode($currentDir) . '&error=File could not be deleted');
        }
    }

    public function fileEditorAction(): void
    {
        $filePath = $_GET['file'] ?? '';
        $content = $this->adminService->getFileContent($filePath);

        echo $this->renderTemplate('admin_file_editing.html', [
            'filePath' => $filePath,
            'fileName' => basename($filePath),
            'fileContent' => $content,
            'currentDir' => dirname($filePath)
        ]);
    }

    public function saveFileAction(): void
    {
        $filePath = $_POST['file_path'] ?? '';
        $content = $_POST['content'] ?? '';

        if ($this->adminService->editFile($filePath, $content)) {
            $this->redirect('/admin/files?dir=' . urlencode(dirname($filePath)) . '&message=File has been saved');
        } else {
            $this->redirect('/admin/files?dir=' . urlencode(dirname($filePath)) . '&error=File could not be saved');
        }
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}