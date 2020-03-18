
<?php
require 'vendorv/autoload.php';
require("db.php");
require("SweetalertResponse.php");
//echo "<img src='images/iDtae.png' height='300' width='900' alt='iDate' class='center'/>";
header('Content-Type: application/json');
 function decrypt($data) {
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "University_Of_Limerick".date("m.d.y");

    return openssl_decrypt($data,$ciphering, $encryption_key, $options, $encryption_iv);
}

if(isset($_POST['updateemail'] ) && isset($_POST['updatepass'] )) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $decryptedEmail = decrypt($_POST['updateemail']);
        $sql = "UPDATE user SET password='{$_POST['updatepass']}' WHERE email='{$decryptedEmail}'";

        $isValid = ($conn->query($sql) === TRUE);

        $resp = new SweetalertResponse($isValid ? 105 : 106,
            'Password Reset',
            $isValid ? "Password updated for $decryptedEmail" :
                "Failed to update password for $decryptedEmail",
            $isValid ? SweetalertResponse::SUCCESS : SweetalertResponse::ERROR
        );

        echo $resp->jsonSerialize();
    }

}
?>