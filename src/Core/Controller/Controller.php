<?php


namespace App\Core\Controller;


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
        $this->request = new Request(apache_request_headers());
        $this->response = new Response();
    }

    public function response($content) {
        $this->response->setContent($content);
        $this->response->exec();
    }

    public function isAuth() {
        try {
            $token = JWT::decode($this->request->getToken(), "Liemie", array('HS256'));
        } catch (\Exception $e) {
            $this->response->setUnauthorized();
        }

        if(isset($token)) {
            return true;
        }

        return false;
    }


}