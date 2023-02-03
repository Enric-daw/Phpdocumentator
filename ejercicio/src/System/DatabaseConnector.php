<?php
namespace Src\System;

class DatabaseConnector {
     /**
    * @access private
    * @var DatabaseConnector
    */	
    private $dbConnection = null;


     /**
    * Constructor de la clase DatabaseConnector.php
    */
    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db   = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


      /**
     * Funcionalidad que realiza la conexión a la base de datos.
     * @return dbConnection
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }
}
