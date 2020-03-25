<?php


namespace App\Core\Controller;


use App\Auth\Authentication;
use App\Core\Http\HttpException;
use App\Core\Http\Request;
use App\Core\Http\Response;

use Firebase\JWT\JWT;

class Controller
{
    protected $request;
    protected $response;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function response($content) {
        $this->response->setContent($content);
        $this->response->exec();
    }

    public function isAuth() {
        $auth = new Authentication();
        if($auth->hasToken($this->request, $this->response)) {
            return true;
        }
        throw new HttpException("Unauthorized", 401);
    }
}