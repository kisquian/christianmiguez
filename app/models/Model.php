<?php
/**
 * Model
 */
class Model
{
    // Datos de conexión a la base de datos
    const DB_NAME = "christianmiguez_com";
    const DB_USER = "christianmiguezc";
    const DB_PASS = "VjBZp44b";

    // Manejamos todos los errores en una misma variable
    private $_error;

    private static $instance;

    /**
     * Protegido para que no sea accesible con "new"
     * Prohibe el uso de: "new Model()"
     */
    protected function __construct() {}

    /**
     * Devuelve la instancia
     * Model::getInstance()
     */
    public static function getInstance() {
        if( null === self::$instance ) {
          // Creamos una nueva conexión
          try {
              self::$instance = new PDO ("mysql:host=mysql.christianmiguez.com;dbname=".self::DB_NAME."; charset=utf8", self::DB_USER, self::DB_PASS );
              self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
              $this->_error = $e->getMessage();
          }
        }

        return self::$instance;
    }

    /**
     * [getError description]
     * @return [type] [description]
     */
    public function getError() {
        return $this->_error;
    }
}