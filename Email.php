<?php

require 'vendorv/autoload.php';

class Email
{

    private String $to;
    private String $name;

    const VERIFY = 0;
    const RESET_PASSWORD = 1;
    const BLOCKED = 2;
    const DELETED = 3;
    const UNBLOCKED = 4;
    const ACTIVATE = 5;

    public function __construct($to, $name)
    {
        $this->to = $to;
        $this->name = $name;
    }

    public function sendMessage($type,$reason,$action,$sender_name){


        $subject = "";
        $emailRes = "";
        $template = "";
        $res_two = "";

        switch ($type){
            case self::BLOCKED:{
                $subject = "Your Account Has Been Blocked";
                $template = "/emailTemplates/message.html";
                break;
            }
            case self::DELETED:{
                $subject = "Your Account Has Been Deleted";
                $template = "/emailTemplates/message.html";
                break;
            }
            case self::UNBLOCKED:{
                $subject = "Your Account Has Been Unblocked";
                $template = "/emailTemplates/unblocked.html";
                break;
            }
            case self::ACTIVATE:{
                $subject = "Your Account Has Been Activated";
                $template = "/emailTemplates/activated.html";
                break;
            }
        }

        switch ($reason){
            case "breach_of_terms_and_conditiosn":{
                $emailRes = "Breach Of Terms And Conditions";
                break;
            }
            case "inactive_account":{
                $emailRes = "Inactive Account";
                break;
            }
            case "reported_by_several_users":{
                $emailRes = "Reported By Several Users";
                break;
            }
            case "continous_incmopliance":{
                $emailRes = "Continous Incompliance";
                break;
            }
            case "reported_by_use":{
                $emailRes = "Reported By Users";
                break;
            }
        }

        $cont = file_get_contents(__DIR__.$template);
        $res = str_replace("{{user_name}}", $this->name, $cont);
        $res_one = str_replace( "{{action}}", $action, $res);

        if($type === self::BLOCKED || $type === self::DELETED){
            $res_two = str_replace( "{{reason}}", $emailRes, $res_one);
        }

        $res_three = str_replace( "{{sender_name}}", $sender_name, $res_two);

        $this->sendEmail($subject, $res_three, $this->getTo());
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
        $encryt_res = "http://www.idate.ie/verification.php?$key=".$this->encrypt($this->getName());
        $res_one = str_replace( "href=\"#replace\"", "href=\"".$encryt_res."\"", $res);
        $res_two = str_replace( "{{Replace}}", $encryt_res, $res_one);
        $this->sendEmail($message, $res_two, $this->getTo());
    }

    private function encrypt($username){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "University_Of_Limerick".date("m.d.y");//code only valid for a day

        return openssl_encrypt($username, $ciphering, $encryption_key, $options, $encryption_iv);
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
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
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
