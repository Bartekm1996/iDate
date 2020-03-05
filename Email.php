<?php

require 'vendor/autoload.php';


class Email
{


    private $from;
    private $to;
    private $subject;
    private $content;
    private $apiKey;
    private $sg;

    public function __construct($from, $to, $subject, $content)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->content = $content;
        $this->apiKey = getenv('SENDGRID_API_KEY');
        $this->sg = new \SendGrid($this->apiKey);

    }

    public function sendEmail(){
        $emailFrom = new SendGrid\Email(null, $this->getFrom());
        $emailSubject = $this->getSubject();
        $emailTo = new SendGrid\Email(null, $this->getTo());
        $emailContent = new SendGrid\Content("text/plain", $this->getContent());
        $mail = new SendGrid\Mail($emailFrom, $emailSubject, $emailTo, $emailContent);

        $response = $this->sg->client->mail()->send()->post($mail);
        echo $response->statusCode();
        echo $response->headers();
        echo $response->body();
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from): void
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}