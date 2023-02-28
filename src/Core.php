<?php 
declare(strict_types = 1);

namespace src;

require_once 'Autoloader/Autoloader.php';

use src\Autoloader\Autoloader;
use src\Router\Router;

class Core{
    public function __construct(){
        
    }

    /**
     * Inicializa la aplicación
     * @return Void
     */
    public static function run():Void{
        static::init();
        static::loader();
        static::dispatcher();
    }

    /**
     * Inicia una nueva sesión
     * 
     * @return Void
     */
    private static function init():Void{
        session_start();
    }

    /**
     * Inicializa la Autocarga de clases
     * 
     * @return Void
     */
    private static function loader():Void{
        $loader = new Autoloader;
        $loader->register();
    }

    /**
     * Inicializa el enrutador
     * 
     * @return Void
     */
    private static function dispatcher():Void{
        $router = new Router;
        $router->dispatch();
    }
}