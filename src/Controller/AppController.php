<?php


namespace App\Controller;


use App\Core\Controller\Controller;
use App\Entity\App;

class AppController extends Controller
{
    public function index() {
        $app = new App();

        $this->response(json_encode($app));
    }
}