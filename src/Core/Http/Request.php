<?php


namespace App\Core\Http;


class Request
{

    private $headers;

    /**
     * Request constructor.
     */
    public function __construct($headers)
    {
        $this->headers = $headers;
    }

    public function getToken() {
        if(isset($this->headers["Authorization"])) {
            return str_replace('Bearer ', '', $this->headers["Authorization"]);
        }
        return "";
    }
}