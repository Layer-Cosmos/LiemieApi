<?php


namespace App\Core\Http;


use App\Core\Json\Error;

class Response
{
    private $headers;
    private $content;
    private $error;

    public function __construct() {
        header_remove();
        $this->headers["Date"] = date(DATE_RFC2822);
        $this->headers["Server"] = $_SERVER["SERVER_SOFTWARE"];
        $this->headers["Content-Type"] = "application/json";
        $this->headers["HTTP/1.1"] = "200 OK";
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setHeader($header, $message) {
        $this->headers[$header] = $message;
    }

    public function setUnauthorized() {
        $this->headers["HTTP/1.1"] = "401 Unauthorized";
        $this->error = new Error();
        $this->error->setStatus("401")->setTitle("Unauthorized");
    }

    public function setTokenExpired() {
        $this->headers["HTTP/1.1"] = "498 Token expired/invalid";
        $this->error = new Error();
        $this->error->setStatus("498")->setTitle("Token expired/invalid");
    }

    public function setHTTP($code, $message, $error = false) {
        $this->headers["HTTP/1.1"] = "$code $message";
        if($error) {
            $this->error = new Error();
            $this->error->setStatus($code)->setTitle($message);
        }
    }

    public function createCookie($name, $value, $expire = 3600) {
        setcookie($name, $value, time() + $expire);
    }

    public function exec() {
        foreach($this->headers as $k => $v ) {
            header($k . ": " . $v);
        }

        if(isset($this->error)) {
            echo json_encode($this->error);
        } else {
            echo $this->content;
        }
    }


}