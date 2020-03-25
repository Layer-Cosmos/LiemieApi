<?php


namespace App\Controller;


use App\Core\Controller\Controller;
use App\Database\Database;

class VisiteController extends Controller
{
    public function index() {
        $this->isAuth();
        $pdo = new Database("api");

        $res = $pdo->query("SELECT * FROM visite");



        $this->response(json_encode($res));
    }
}