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
    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}