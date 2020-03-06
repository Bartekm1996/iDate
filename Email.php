<?php

require 'vendorv/autoload.php';

class Email
{

    private String $to;


    public function __construct($to)
    {
        $this->to = $to;
    }

    public function sendRegisterEmail(){
        $cont = file_get_contents(__DIR__."/emailTemplates/passWordReset.html");
        $res = str_replace("{{user_name}}", $this->getTo(), $cont);
        $this->sendEmail("Email Verification", $res, $this->getTo());
    }


    private function sendEmail(String $subject, String $content, String $to){
        $emailFrom = new SendGrid\Email("iDate", "noreply@idate.ie");
        $emailContent = new SendGrid\Content("text/html", $content);
        $mail = new SendGrid\Mail($emailFrom, $subject, $to, $emailContent);


        $apiKey = "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";
        $sg = new \SendGrid($apiKey);

        try {
            $response = $sg->client->mail()->send()->post($mail);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

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



    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}