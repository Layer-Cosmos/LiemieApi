<?php


namespace App\Table;


use App\Core\Table\Table;
use App\Entity\UserEntity;

class UserTable extends Table
{
    public function addUser(UserEntity $user) {
        if(!$this->userExist($user)) {
            $this->query("INSERT INTO user SET mail = ?, password = ?", array($user->getMail(), $user->getPassword()));
        }
    }

    public function getUserByMail($mail) : UserEntity {
        return $this->query("SELECT * FROM user WHERE mail = ?", array($mail));
    }

    public function userExist(UserEntity $user) : bool {
        $res = $this->query("SELECT * FROM user WHERE mail = ?", array($user->getMail()));

        if(empty($res)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUser(UserEntity $user) : bool {
        $res = $this->query("SELECT * FROM user WHERE mail = ? && password = ?", array($user->getMail(), $user->getPassword()));

        if(empty($res)) {
            return false;
        } else {
            return true;
        }
    }

}