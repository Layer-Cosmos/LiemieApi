<?php


namespace App\Controller;


use App\Core\Controller\Controller;
use App\Database\Database;

class VisiteController extends Controller
{
    public function index() {
        $pdo = new Database("api");

        $res = $pdo->query("SELECT * FROM visite");



        $this->response(json_encode($res));
    }
}