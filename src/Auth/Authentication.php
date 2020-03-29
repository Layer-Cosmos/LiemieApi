<?php


namespace App\Auth;


use App\App;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Database\Database;
use App\Entity\UserEntity;
use Firebase\JWT\JWT;

class Authentication
{
    private $user;

    public function checkUser(UserEntity $user) {

        $this->user = $user;

        $res = App::getInstance()->getTable("user")->checkUser($this->user);

        if($res) {
            $this->user = App::getInstance()->getTable("user")->getUserByMail($this->user->getMail());;
            return true;
        }

        return false;
    }

    public function hasToken(Request $request, Response $response) : bool {
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
        if($request->hasToken()) {
            return true;
        }
        $response->setUnauthorized();
        return false;
    }

    public function hasValidTokenFormat(Request $request) : bool {
        try {
            $token = JWT::decode($request->getToken(), "Liemie", array('HS256'));
        } catch (\Exception $e) {
            if($e->getMessage() == "Wrong number of segments") {
                return false;
            }
            if($e->getMessage() == "Malformed UTF-8 characters") {
                return false;
            }
        }
        return true;
    }

    public function hasValidRefreshToken(Request $request, Response $response) {
        $refreshToken = $request->getRefreshToken();

        $pdo = new Database("api");
        if($request->hasToken() && $this->hasValidTokenFormat($request)) {
            $body = $this->decodeJwt($request->getToken());

            $user = new UserEntity();
            $user->setId($body->user_id);
            $user->setMail($body->user_mail);
            $this->user = $user;

            $res = $pdo->prepare("SELECT token FROM token WHERE id = ?", array($body->user_id));

            if($res["token"] == $refreshToken) {
                $this->createToken($response);
                return true;
            } else {
                $response->setUnauthorized();
                return false;
            }
        }
        return false;
    }

    public function createToken(Response $response) {
        $key = "Liemie";
        $token = [
            'user_id' => $this->user->getId(),
            'user_mail' => $this->user->getMail(),
            'exp' => time() + 30
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
        $this->okRefreshJson($response);
    }

    private function decodeJwt($token) {
        $tks = explode('.', $token);
        list($headb64, $bodyb64, $cryptob64) = $tks;

        return json_decode(JWT::urlsafeB64Decode($bodyb64));

    }

    private function okRefreshJson(Response $response) {
        $json = [
            'Auth' => "Ok"
        ];

        $response->setContent(json_encode($json));
    }
}