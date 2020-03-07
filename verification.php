<?php
require 'vendorv/autoload.php';
require("db.php");

if (isset($_GET['verification'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // decrypt here
        $decryptedEmail = "";
        $sql = "UPDATE user SET regisitered = 1 WHERE email='{$decryptedEmail}'";

        if ($conn->query($sql) === TRUE)
        {
            //display success message and redirect
        }
    }

}