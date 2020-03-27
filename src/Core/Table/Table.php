<?php


namespace App\Core\Table;


use App\Database\Database;

class Table
{
    protected $table;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
        if(is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name));
        }
    }

    public function all() {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    public function query($sql, $attributes = null, $one = false) {
        if($attributes) {
            return $this->db->prepare($sql, $attributes, str_replace('Table', 'Entity', get_class($this)), $one);
        } else {
            return $this->db->query($sql, str_replace('Table', 'Entity', get_class($this)), $one);
        }
    }
}