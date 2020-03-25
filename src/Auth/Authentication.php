<?php


namespace App\Auth;


use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Database\Database;
use App\Entity\User;
use Firebase\JWT\JWT;

class Authentication
{
    private $user;

    public function checkUser(User $user) {

        $this->user = $user;

        $pdo = new Database("api");

        $res = $pdo->prepare("SELECT * FROM user WHERE mail = ? AND password = ?", array($user->getMail(), $user->getPassword()), "App\Entity\User");

        if(empty($res)) {
            return false;
        } else {
            $this->user = $res;
            return true;
        }
    }

    public function hasToken(Request $request, Response $response) {
        if($request->hasToken()) {
            try {
                $token = JWT::decode($request->getToken(), "Liemie", array('HS256'));
            } catch (\Exception $e) {
                $response->setUnauthorized();
                return false;
            }
            return true;
        }

        return false;
    }

    public function hasRefreshToken(Request $request, Response $response) {

    }

    public function createToken(Response $response) {
        $key = "Liemie";
        $token = [
            'user_id' => $this->user->getId(),
            'user_mail' => $this->user->getMail(),
            'exp' => time() + 120
        ];

        $token = JWT::encode($token, $key);

        $response->setHeader("Authorization", "Bearer $token");

        $this->createRefreshToken($response);
    }

    private function createRefreshToken(Response $response) {

        $pdo = new Database("api");


        $token = [
            'user_id' => $this->user->getId(),
            'user_mail' => $this->user->getMail(),
            'exp' => time() + 86400
        ];

        $token = json_encode($token);

        $token = hash_hmac("sha256", $token, "Liemie");

        $res = $pdo->prepare("SELECT * FROM token WHERE id = ?", array($this->user->getId()));

        if(!empty($res)) {
            $res = $pdo->prepare("UPDATE token SET token = ? WHERE id = ?", array($token, $this->user->getId()));
        } else {
            $res = $pdo->prepare("INSERT INTO token (id, token) VALUE(?, ?)", array($this->user->getId(), $token));
        }

        //$res = $pdo->prepare("INSERT INTO token (id, token) VALUE(?, ?)", array($this->user->getId(), $token));


        $response->createCookie("Refresh", $token, 86400);
    }
}