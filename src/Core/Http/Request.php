<?php


namespace App\Core\Http;


class Request
{

    private $headers;
    private $contents;
    private $cookies;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->headers = apache_request_headers();
        $this->contents = json_decode(file_get_contents('php://input'));
        $this->cookies = $_COOKIE;
    }

    public function getContents() {
        return $this->contents;
    }

    public function getToken() {
        if(isset($this->headers["Authorization"])) {
            return str_replace('Bearer ', '', $this->headers["Authorization"]);
        }
        return "";
    }

    public function getRefreshToken() {
        return "";
    }

    public function hasRefreshToken() {

    }

    public function hasToken() {
        if((isset($this->headers["Authorization"]))) {
            return true;
        }
        return false;
    }
}