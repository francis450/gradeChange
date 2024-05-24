<?php

class BaseController
{
    protected $viewPath = 'views/';
    protected $layoutPath = 'views/layout/main,php';

    public function render($view, $data = [], $useLayout = true) {
        extract($data);

        ob_start(); // Start output buffering
        require $this->viewPath . $view . '.php';
        $content = ob_get_clean(); // Get the content of the buffer and clean it

        if ($useLayout) {
            require $this->layoutPath;
        } else {
            echo $content; // If we don't want to use a layout, just echo the content
        }
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    protected function back() {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    protected function checkAuthentication() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/grade-change/login');
        }
    }

    protected function checkAuthorization($role) {
        if ($_SESSION['role'] != $role) {
            $this->redirect($this->back());
        }
    }

    protected function uploadFile($file, $path) {
        $fileName = uniqid() . '_' . $file['name'];
        move_uploaded_file($file['tmp_name'], $path . $fileName);
        return $fileName;
    }
}