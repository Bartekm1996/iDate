<h1 align="center">Verification Page of</h1>
<div style="text-align: center;">
    <img src="images/iDtae.png"  width="450" height="150">


<?php
require 'vendorv/autoload.php';
require("db.php");
//echo "<img src='images/iDtae.png' height='300' width='900' alt='iDate' class='center'/>";

 function decrypt($data) {
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "University_Of_Limerick".date("m.d.y");

    return openssl_decrypt($data,$ciphering, $encryption_key, $options, $encryption_iv);
}

if (isset($_GET['verification'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $decryptedEmail = decrypt($_GET['verification']);
        $sql = "UPDATE user SET registered = 1 WHERE email='{$decryptedEmail}'";


        if ($conn->query($sql) === TRUE)
        {

            //display success message and redirect
            echo "$decryptedEmail has been verified. <br/><br>Please return to <a href=\"http://www.idate.ie\">Login Page</a>";
        } else {
            echo "Key is invalid or has expired please try again.";
            //TODO: we need to add text box to let them enter email to send a new generated code
        }
    }

}
?>
</div>
