<?php


namespace App\Controller;


use App\App;
use App\Core\Controller\Controller;
use App\Database\Database;

class PatientController extends Controller
{
    public function index()
    {
        $this->isAuth();

        $res = App::getInstance()->getTable("patient")->all();

        $this->response(json_encode($res));
    }
}