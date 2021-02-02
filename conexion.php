<?php

    //Clase para la conexion a la base de datos
    class Conexion{

        private $dbhost     = 'localhost:3308';
        private $dbusuario  = 'root';
        private $dbclave    = '';
        private $dbnombre   = 'prueba_tecnica';
        private $charset    = 'utf8mb4';
        private $dsn;
        private $opciones;

        //Constructor de la clase, establece el string de conexion
        public function __construct()
        {
            $this->dsn = "mysql:host=$this->dbhost;dbname=$this->dbnombre;charset=$this->charset";
            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        }

        //Realiza la conexion y devuelve el objeto PDO
        public function conectar(){
            try {
                $pdo = new PDO($this->dsn, $this->dbusuario, $this->dbclave, $this->opciones);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
            return $pdo;
        }

    }
?>