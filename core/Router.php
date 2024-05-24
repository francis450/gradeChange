<?php
class Router
{
    protected $request;
    protected $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function put($path, $callback)
    {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete($path, $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }



    public function resolve()
    {
        $method = $this->request->method();
        $path = $this->stripBasePath($this->request->path());

        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            http_response_code(404);
            return require_once 'views/errors/404.php';
        }

        if (is_string($callback)) {
            $parts = explode('@', $callback);
            $controller = new $parts[0];
            $method = $parts[1];
            echo call_user_func_array([$controller, $method], [$this->request->params()]);
        } else {
            echo call_user_func($callback);
        }
    }

    protected function stripBasePath($path)
    {
        $baseDir = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }
        return $path;
    }
}