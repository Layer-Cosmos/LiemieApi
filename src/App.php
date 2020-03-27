<?php


namespace App;


use App\Core\Table\Table;
use App\Database\Database;

class App
{
    private static $_instance;
    private $db_instance;

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public function getTable($table) : Table {
        $class_name = '\\App\\Table\\' . ucfirst($table) . 'Table';
        return new $class_name($this->getDb());
    }

    public function getDb() {
        if(is_null($this->db_instance)) {
            $this->db_instance = new Database("api", "root", "", "localhost");
        }
        return $this->db_instance;
    }
}