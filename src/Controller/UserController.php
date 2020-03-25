<?php

namespace App\Controller;

use App\Auth\Authentication;
use App\Core\Controller\Controller;
use App\Core\Http\HttpException;
use App\Database\Database;
use App\Entity\User;
use Firebase\JWT\JWT;

class UserController extends Controller
{

    public function index() {

        $this->isAuth();

        $pdo = new Database("api");

        $res = $pdo->query("SELECT * FROM user");

        $this->response(json_encode($res));
    }

    public function connexion() {

    }


}