<?php


namespace App\Controller;


use App\App;
use App\Core\Controller\Controller;
use App\Database\Database;

class VisiteController extends Controller
{
    public function index() {
        $this->isAuth();

        $res = App::getInstance()->getTable("visite")->all();

        $this->response(json_encode($res));
    }
}