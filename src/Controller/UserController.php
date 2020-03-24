<?php


namespace App\Controller;


use App\Core\Controller\Controller;
use App\Database\Database;
use App\Entity\User;
use Firebase\JWT\JWT;

class UserController extends Controller
{

    public function index() {

        if($this->isAuth()) {
            $pdo = new Database("api");

            $res = $pdo->query("SELECT * FROM user");

            echo json_encode($res);
        }

        $this->response("test");
    }

    public function connexion() {
        $pdo = new Database("api");

        $user = $this->getUser();
        $res = $pdo->prepare("SELECT * FROM user WHERE mail = ? AND password = ?", array($user->getMail(), $user->getPassword()), "App\Entity\User");

        //echo "1";
        if(empty($res)){
            http_response_code(401);
        } else {
            http_response_code(200);

        }

        $key = "Liemie";
        $token = [
            'user_id' => 1,
            'user_mail' => $user->getMail(),
            'exp' => time() + 3660
        ];

        $token = JWT::encode($token, $key);


        header("Authorization: Bearer $token");
        header("Content-Type: application/json");

        $this->response($token);
    }

    private function getUser() {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        return User::build($post->mail, $post->password);
    }
}