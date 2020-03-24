<?php


namespace App\Entity;


use JsonSerializable;

class App implements JsonSerializable
{
    private $version;
    private $message;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->version = "0.1.0";
        $this->message = "Liemie Api";
    }

    public function jsonSerialize()
    {
        return
            [
                'version' => $this->version,
                'message' => $this->message
            ];
    }


}