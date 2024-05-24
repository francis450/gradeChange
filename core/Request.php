<?php
// class to handle all requests
class Request
{
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function params()
    {
        $params = [];
        if ($this->method() === 'GET') {
            foreach ($_GET as $key => $value) {
                $params[$key] = $value;
            }
        } elseif ($this->method() === 'POST') {
            foreach ($_POST as $key => $value) {
                $params[$key] = $value;
            }
        }
        return $params;
    }
}
