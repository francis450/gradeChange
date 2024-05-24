<?php
class BaseController
{
    protected $viewPath = 'views/';
    protected $layout = 'layout/main.php';

    // Render a view with optional data
    protected function render($view, $data = [], $useLayout = true)
    {
        extract($data);
        ob_start(); // Start output buffering
        require $this->viewPath . $view . '.php';
        $content = ob_get_clean(); // Get buffered content and clean buffer

        if ($useLayout) {
            require $this->viewPath . $this->layout;
        } else {
            echo $content; // Directly output the content without layout
        }
    }

    // Redirect to a different URL
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    protected function checkAuthentication()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/grade-change/login');
        }
    }

    protected function uploadFile($file, $path)
    {
        $fileName = uniqid() . '_' . $file['name'];
        move_uploaded_file($file['tmp_name'], $path . $fileName);
        return $fileName;
    }
}
