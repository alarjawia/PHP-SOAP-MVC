<?php

class Router
{
    private array $routes = [];

    public function add(string $method, string $url, array $controller)
    {
        $url = $this->normalizeUrl($url);
        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $url);



        $this->routes[] = [
            'path' => $url,
            'method' => strtoupper($method),
            'controller' => $controller,
            'regexPath' => $regexPath,
            'middleware' => null,
        ];

        return $this;
    }

    public function only($key)
    {

        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url, '/');
        $url = "/{$url}/";
        $url = preg_replace('#[/]{2,}#', '/', $url);

        return $url;
    }

    public function dispatch(string $url, string $method)
    {

        $url = $this->normalizeUrl($url);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {

            if (
                !preg_match("#^{$route['regexPath']}$#", $url, $paramValues) ||
                $route['method'] !== $method
            ) {
                continue;
            } else {
                MiddlewareMap::resolve($route['middleware']);
            }

            array_shift($paramValues);

            preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);

            $paramKeys = $paramKeys[1];

            $params = array_combine($paramKeys, $paramValues);

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;
            $controllerInstance->{$function}($params);
        }
    }
}
