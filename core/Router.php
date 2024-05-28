<?php
class Router
{
    protected $request;
    protected $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // public function get($path, $callback)
    // {
    //     $this->routes['GET'][$path] = $callback;
    // }
    public function get($path, $callback, $middleware = null) {
        $this->routes['GET'][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    // public function post($path, $callback)
    // {
    //     $this->routes['POST'][$path] = $callback;
    // }

    public function post($path, $callback, $middleware = null) {
        $this->routes['POST'][$path] = ['callback' => $callback, 'middleware' => $middleware];
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

        $route = $this->findRoute($method, $path);

        if (!$route) {
            http_response_code(404);
            return require_once 'views/errors/404.php';
        }

        if ($route['middleware']) {
            call_user_func($route['middleware']);
        }

        $callback = $route['callback'];

        if (is_string($callback)) {
            $parts = explode('@', $callback);

            $controller = new $parts[0];
            $method = $parts[1];

            echo call_user_func_array([$controller, $method], $this->request->params);
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

    protected function findRoute($method, $path)
    {

        foreach ($this->routes[$method] as $route => $callback) {
            
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);

            if (preg_match("#^$pattern$#", $path, $matches)) {
                array_shift($matches);
                $this->request->params = $matches; // override parameters with dynnamic ones
                return $callback;
            }
        }
        return false;
    }
}
