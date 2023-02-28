<?php 
declare(strict_types = 1);

namespace src\Router;

class Router{
    protected Array $routes = [];
    protected Array $params = [];
    protected Array $matches = [];
    protected Array|null $route = null;

    public function __construct(){
        $file = sprintf('%s/%s', dirname(__FILE__, 3), 'routes/Routes.php');

        (is_file($file)) 
        ? $this->routes = require_once $file 
        : throw new \Exception('No hay rutas definidas', 404);
    }

    /**
     * Inicializa el router
     * 
     * @return Void
     */
    public function dispatch():Void{
        try {
            $url = $_GET['url'];
            $method = $_SERVER['REQUEST_METHOD'];

            $controller = $this->checkRoute($url, $method);
            $this->route = $this->decodeController($controller);

            $controllerObject = ($this->classExist()) ?: new $this->route['controller'];

            if(!$this->classExist()) throw new \Exception(sprintf("El controlador '%s' no ha sido encontrado", $this->route['controller']));
            $controllerObject = new $this->route['controller'] ;

            if(!$this->methodExist($controllerObject)) throw new \Exception(sprintf("El metodo '%s' no ha sido definido o no puede ser ejecutado", $this->route['method']));
            call_user_func_array([$controllerObject, $this->route['method']], $this->params);

        } catch (\Exception $error) {
            die(json_encode([
                'result' => false,
                'message' => $error->getMessage()
            ]));
        }
        
    } 

    /**
     * recorrerá las diferentes rutas previamente registradas y comprobará si la ruta coincide con la URL
     * Ej: '/url' => 'controlador@metodo'
     * 
     * @param String $url
     * @param String $method
     * 
     * @return String
     */
    private function checkRoute(String $url, String $method):String{
        try {
            foreach ($this->routes[$method] as $route => $controller) {
                if($this->match($url, $route)) return $controller;
            }

            $default = $this->routes['GET']['/'];

            if(!isset($default))throw new \Exception("No se ha encontrado la ruta", 404);

            return $default;
            
        } catch (\Exception $error) {
            die(json_encode([
                'result' => false,
                'message' => $error->getMessage()
            ]));
        }
    }

    /**
     * Comprueba si la ruta es una URL valida
     * Ej: '/posts/:id'
     * 
     * @param String $url
     * @param String $route
     * 
     * @return Bool
     */
    private function match(String $url, String $route):Bool{
        try {
            $url = trim($url, '/');
            $route = trim($route, '/');
            $routePath = preg_replace_callback('#:([\w]+)#', [$this, 'paramsMatch'], $route);
            $regex = sprintf('#^%s$#i', $routePath);

            if(!preg_match($regex, $url, $matches)) return false;

            array_shift($matches);
            $this->params = $matches;
            return true;
            
        } catch (\Exception $error) {
            die(json_encode([
                'result' => false,
                'message' => $error->getMessage()
            ]));
        }
    }

    /**
     * 
     * 
     * @param Array $match
     * 
     * @return String
     */
    private function paramsMatch(Array $match):String{
        return (isset($this->matches[$match[1]]))
        ? sprintf('(%s)', $this->matches[$match[1]])
        : '([^/]+)';
    }

    /**
     * Devuelve el controlador y el metodo separados en un Array
     * 
     * @param String $controller
     * 
     * @return Array
     */
    private function decodeController(String $controller):Array{
        $controller = explode('@', $controller);

        return [
            'controller' => sprintf('app\\Controllers\\%sController', $controller[0]),
            'method' => $controller[1]
        ];
    }

    /**
     * Comprueba si el controlador existe
     * 
     * @return Bool
     */
    private function classExist():Bool{
       return class_exists($this->route['controller']);
    }


    /**
     * Comprueba si el metodo existe
     * 
     * @return Bool
     */
    private function methodExist($controllerObject):Bool{
        return method_exists($controllerObject, $this->route['method']);
     }

}