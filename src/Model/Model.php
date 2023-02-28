<?php 
declare(strict_types = 1);

namespace src\Model;

class Model{
    protected static $db = null;
    protected Array $config = [];

    public function __construct(){
        $file = sprintf('%s/%s', dirname(__FILE__, 3), 'config/db.php');

        if(is_file($file)){
            $this->config = require_once $file; 
            $this->connection();
        } else{
            throw new \Exception("No se han definido los datos de configuración", 404);
        }              
    }

    /**
     * Realiza la conexión a la base de datos
     * 
     * @return Void
     */
    private function connection():Void{
        try {
            if(static::$db === null){
                $host = $this->config['host'];
                $user = $this->config['user'];
                $pass = $this->config['pass'];
                $name = $this->config['name'];
                $charset = $this->config['charset'];

                $options = [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ];

                $dsn = sprintf('mysql:localhost=%s;dbname=%s;charset=%s', $host, $name, $charset);

                static::$db = new \PDO($dsn, $user, $pass, $options);
            }

        } catch (\PDOException $error) {
            echo $error->getMessage();
            die(json_encode(['result' => false, 'message' => 'Error en la conexion']));
        }

    }

    //TODO: Cambiar el tipo de retorno
    /**
     * Devuelve una conexión de base de datos PDO.
     * 
     * @return [type]
     */
    private function DB(){
        return static::$db;
    }
}