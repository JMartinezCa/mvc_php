<?php 
declare(strict_types = 1);

namespace src\View;

require dirname(__FILE__, 3) . '/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View{
    protected Array $config = [];

    public function __construct(){
        $file = sprintf('%s/%s', dirname(__FILE__, 3), 'config/app.php');

        (is_file($file)) 
        ? $this->config = require_once $file 
        : throw new \Exception("No se han definido los datos de configuración", 404);
    }

    /**
     * Renderiza la plantilla y el contenido del sitio
     * 
     * @param string $view
     * @param Array $params
     * 
     * @return Void
     */
    public static function render(string $view, Array $params = []):Void{
        try {
            $config = include '../config/app.php';
            $root = $config['path']['root'];
            $template = sprintf('%s/app/Views/', $root);
            $content = sprintf('%s.html.twig', $view);
            
            extract($params, EXTR_SKIP);

            $loader = new FilesystemLoader($template);
            $twig = new Environment($loader);

            echo $twig->render($content, $params);

        } catch (\Exception $error) {
            die(json_encode([
                'result' => false,
                'message' => $error->getMessage()
            ]));
        }
    }
}