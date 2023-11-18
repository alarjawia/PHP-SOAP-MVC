<?php

class App
{
    private Router $router;
    // private Container $Container;

    public function __construct()
    {
        $this->router = new Router();
        // $this->Container = new Container();
    }

    public function run()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($url, $method);
    }

    public function get(string $path, array $controller)
    {
        return $this->router->add('GET', $path, $controller);
    }

    public function post(string $path, array $controller)
    {
        return $this->router->add('POST', $path, $controller);
    }

    

    
}
