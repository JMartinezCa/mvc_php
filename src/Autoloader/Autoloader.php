<?php 
declare(strict_types = 1);

namespace src\Autoloader;

class Autoloader{
    protected Array $config = [];

    public function __construct(){
        $file = sprintf('%s/%s', dirname(__FILE__, 3), 'config/app.php');

        (is_file($file)) 
        ? $this->config = require_once $file 
        : throw new \Exception("No se han definido los datos de configuración", 404);
    }
        
    /**
     * Cargador de registros con pila SPL autoloader
     * 
     * @return Void
     */
    public function register():Void{
        spl_autoload_register([$this, 'loader']);
    }

    /**
     * Carga la clase
     * 
     * @param String $class
     * 
     * @return Void
     */
    private function loader(String $class):Void{
        try {
            $class = trim($class, '/');
            $class = str_replace('\\', '/', $class);
            $root = $this->config['path']['root'];
            $file = sprintf('%s/%s.php', $root, $class);

            (is_file($file)) 
            ? require_once $file
            : throw new \Exception(sprintf('No se ha encontrado la clase %s.php', $this->fileNotFound($class)), 404);
            
        } catch (\Exception $error) {
            die(json_encode([
                'result' => false,
                'message' => $error->getMessage()
            ]));
        }
    }

    /**
     * Retorna el nombre de la clase que no ha sido encontrda
     * 
     * @param String $class
     * 
     * @return String
     */
    private function fileNotFound(String $class):String {
        $classError = explode('/', $class);
        $classError = end($classError);

        return $classError;
    }
}