<?php
require("db.php");
require("Email.php");
$resp = null;

if (isset($_POST['username']) && isset($_POST['pass'])
&& isset($_POST['email']) && isset($_POST['name'])) {

    $uname = $_POST['username'];
    $upass = $_POST['pass'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    header('Content-Type: application/json');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);
        $email = $conn->real_escape_string($email);

        //check is username is taken
        $sql = "SELECT registered FROM user where username='{$uname}' LIMIT 1;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {

            $resp = new SweetalertResponse(10,
                'Username is taken',
                "This username $uname is already taken",
                SweetalertResponse::ERROR,
            );

        } else {
            mysqli_free_result($result);
            $sql = "INSERT INTO user (email, username, password) VALUES('{$email}','{$uname}','{$upass}');";
            if($conn->query($sql) === TRUE) {


                try {
                    $semail = new Email($email, $uname);
                    $semail->sendRegisterEmail();
                } catch (Exception $e) {
                    //do nothing....
                }

                $resp = new SweetalertResponse(11,
                    'Registered',
                    "$email Registered successfully. Please check email and confirm activation link",
                    SweetalertResponse::SUCCESS,
                );


            } else {
                $resp = new SweetalertResponse(12,
                    'Error',
                    "Failed to Register user",
                    SweetalertResponse::ERROR,
                );
            }
        }

    }

    $conn->close();
} else {
    //didn't set username or pass etc...
    $resp = new SweetalertResponse(4,
        'Login Failed',
        "Invalid Parameters set",
        SweetalertResponse::ERROR,
    );
}

echo $resp->jsonSerialize();