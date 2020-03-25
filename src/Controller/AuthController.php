<?php


namespace App\Controller;


use App\Auth\Authentication;
use App\Core\Controller\Controller;
use App\Core\Http\HttpException;
use App\Entity\User;

class AuthController extends Controller
{
    public function connexion() {

        var_dump($_COOKIE);
        $auth = new Authentication();

        $user = $this->getUser();

        if($auth->checkUser($user)) {
            $auth->createToken($this->response);
        } else {
            throw new HttpException("Unauthorized", 401);
        }

        $this->response("");
    }

    public function token() {
        $auth = new Authentication();

        if($auth->hasRefreshToken($this->request, $this->response)){

        } else {
            throw new HttpException("Unauthorized", 401);
        }
    }

    private function getUser() {
        return User::build($this->request->getContents()->mail, $this->request->getContents()->password);
    }
}