<?php


namespace App\Core\Entity;


class Entity
{
    public function __set($key, $value) {
        $method = 'set' . ucfirst($key);
        $this->$method($value);
    }
    public function __get($key){
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}