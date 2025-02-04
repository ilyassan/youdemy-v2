<?php

class Router
{
    private $routes = [];

    public function add($method, $path, $callback, $roles)
    {
        $this->routes[] = compact('method', 'path', 'callback', "roles");
    }

    public function get($path, $callback, $roles)
    {
        $this->add('GET', $path, $callback, $roles);
    }

    public function post($path, $callback, $roles)
    {
        $this->add('POST', $path, $callback, $roles);
    }

    public function dispatch($request)
    {
        if ($request->getMethod() === 'POST' && !validateCsrfToken()) {
            redirect('');
        }

        foreach ($this->routes as $route) {
            $isRouteAcceptParam = strpos($route['path'], "/{id}") != false;
            $param = null;
            if ($isRouteAcceptParam) {
                $route['path'] = str_replace('/{id}', '', $route['path']);
                $param = str_replace($route['path'], '', $request->getPath());
            }

            $requestPath = $param ? str_replace($param, '', $request->getPath()) : $request->getPath();
            if ($route['method'] === $request->getMethod() &&
                $route['path'] === $requestPath) {


                if (isLoggedIn()) {
                    // If the user role matched one of the route roles
                    if (! in_array(user()->getRoleName(), $route['roles'])) {
                        continue;
                    }
                }
                else{
                    if (! in_array("visitor", $route['roles'])) {
                        redirect("login");
                    }
                }

                
                if (is_callable($route['callback'])) {
                    return call_user_func($route['callback']);
                }
                
                if (is_array($route['callback'])) {
                    [$controller, $action] = $route['callback'];
                    $controllerInstance = new $controller();
                    return $param != null ? $controllerInstance->$action(str_replace("/", "", $param)) : $controllerInstance->$action();
                }
            }
        }

        redirect('');
    }
}