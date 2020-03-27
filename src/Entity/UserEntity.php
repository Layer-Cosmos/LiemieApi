<?php


namespace App\Entity;


use App\Core\Entity\Entity;
use JsonSerializable;

class UserEntity extends Entity implements JsonSerializable
{
    private $id;
    private $mail;
    private $password;


    public static function build($mail = "", $password = "") {
        $user = new UserEntity;
        $user->setMail("$mail");
        $user->setPassword($password);
        return $user;
    }

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'mail' => $this->getMail(),
                'password' => $this->getPassword()
            ];
    }
}