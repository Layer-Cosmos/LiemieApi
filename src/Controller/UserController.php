<?php

namespace App\Controller;

use App\App;
use App\Auth\Authentication;
use App\Core\Controller\Controller;
use App\Core\Http\HttpException;
use App\Database\Database;
use App\Entity\UserEntity;
use Firebase\JWT\JWT;

class UserController extends Controller
{

    public function index() {

        $this->isAuth();

        $res = App::getInstance()->getTable("user")->all();

        $this->response(json_encode($res));
    }

    public function connexion() {

    }


}