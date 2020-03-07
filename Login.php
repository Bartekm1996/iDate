<?php
require("db.php");
require("SweetalertResponse.php");
$resp = null;
if (isset($_POST['user_name']) && isset($_POST['login_password']) ) {
    $uname = $_POST['user_name'];
    $upass = $_POST['login_password'];

    header('Content-Type: application/json');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);

        $sql = "SELECT registered FROM user where username='{$uname}' AND password='{$upass}' LIMIT 1;";

        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            $row=mysqli_fetch_row($result);
            //echo $row[0] ? "You logged and registered": "You are logged in but not registered";
            $reg = $row[0] == 0;
            $resp = new SweetalertResponse($reg ? 1 : 2,
                $reg ? 'Please Verify' : 'Login Success',
                $reg ? "Please verify $uname" : "$uname logged in successfully",
                $reg ? SweetalertResponse::WARNING : SweetalertResponse::SUCCESS
            );

        } else {

            $resp = new SweetalertResponse(3,
                'Login Failed',
                 "Failed to login with username $uname",
                SweetalertResponse::ERROR
            );
        }
    }


    $conn->close();
} else {
    //didn't set username or pass
    $resp = new SweetalertResponse(4,
        'Login Failed',
        "Invalid Parameters set",
        SweetalertResponse::ERROR,
    );
}

echo $resp->jsonSerialize();