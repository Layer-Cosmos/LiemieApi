<?php


namespace App\Controller;


use App\Auth\Authentication;
use App\Core\Controller\Controller;
use App\Core\Http\HttpException;
use App\Entity\UserEntity;

class AuthController extends Controller
{
    public function connexion() {
        $auth = new Authentication();

        $user = $this->getUser();

        if($auth->checkUser($user)) {
            $auth->createToken($this->response);
        } else {
            throw new HttpException("Unauthorized", 401);
        }

        $this->send();
    }

    public function inscription() {

    }

    public function token() {
        $auth = new Authentication();

        if($auth->hasRefreshToken($this->request, $this->response)) {
            if(!$auth->hasValidRefreshToken($this->request, $this->response)) {
                throw new HttpException("Unauthorized", 401);
            }
        } else {
            throw new HttpException("Unauthorized", 401);
        }

        $this->send();
    }

    private function getUser() {
        return UserEntity::build($this->request->getContents()->mail, $this->request->getContents()->password);
    }
}