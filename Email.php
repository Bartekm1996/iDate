<?php

require 'vendorv/autoload.php';

class Email
{

    private String $to;
    private String $name;

    const VERIFY = 0;
    const RESET_PASSWORD = 1;

    public function __construct($to, $name)
    {
        $this->to = $to;
        $this->name = $name;
    }

    public function sendRegisterEmail($type){
        $template = "";
        $key = "";
        $message ="";
        switch ($type) {
            case self::VERIFY:
                $template = "/emailTemplates/passWordReset.html";
                $key = "verification";
                $message = "Email Verification";
                break;
            case self::RESET_PASSWORD:
                $template = "/emailTemplates/passWordReset2.html";
                $key = "reset";
                $message = "Password Reset";
                break;
        }
        $cont = file_get_contents(__DIR__.$template);
        $res = str_replace("{{user_name}}", $this->name, $cont);
        $encryt_res = "http://www.idate.ie/verification.php?$key=".$this->encrypt($this->getTo());
        $res_one = str_replace( "href=\"#replace\"", "href=\"".$encryt_res."\"", $res);
        $res_two = str_replace( "{{Replace}}", $encryt_res, $res_one);
        $this->sendEmail($message, $res_two, $this->getTo());
    }

    private function encrypt($email){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "University_Of_Limerick".date("m.d.y");//code only valid for a day

        return openssl_encrypt($email,$ciphering, $encryption_key, $options, $encryption_iv);
    }


    private function sendEmail(String $subject, String $content, String $to){
        $emailTo = new SendGrid\Email(null, $to);
        $emailFrom = new SendGrid\Email("iDate", "noreply@idate.ie");
        $emailContent = new SendGrid\Content("text/html", $content);
        $mail = new SendGrid\Mail($emailFrom, $subject, $emailTo, $emailContent);


        $apiKey = "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";
        $sg = new SendGrid($apiKey);

        try {
            $response = $sg->client->mail()->send()->post($mail);
            //These cause output that message with json response
//            print $response->statusCode() . "\n";
//            print_r($response->headers());
//            print $response->body() . "\n";
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
