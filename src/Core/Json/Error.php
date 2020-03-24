<?php


namespace App\Core\Json;


class Error implements \JsonSerializable
{
    private $status;
    private $title;

    /**
     * Error constructor.
     * @param $status
     */
    public function __construct()
    {
        $this->status = "";
        $this->title = "";
    }

    /**
     * @param string $status
     * @return Error
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $title
     * @return Error
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return
            [
                'status'   => $this->status,
                'title' => $this->title
            ];
    }
}