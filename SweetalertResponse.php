<?php


class SweetalertResponse implements \JsonSerializable
{
    const SUCCESS = 'success';
    const ERROR = 'error';
    const WARNING = 'warning';
    const INFO = 'info';
    const QUESTION = 'question';

    private $statusCode; //we use this to identify what the exact message is
    private $title;
    private $message;
    private $type;
    private $img;

    public function __construct($statusCode, $title, $message, $type)
    {
        $this->statusCode = $statusCode;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}