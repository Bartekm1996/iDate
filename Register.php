<?php
require("db.php");
require("Email.php");

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
        $data = [];
        if ($result->num_rows > 0)
        {

            $data = ['statuscode' => 10,
                'title' => 'Username is taken',
                'type' => 'error',
                'message' => "This username $uname is already taken"];


        } else {
            mysqli_free_result($result);
            $sql = "INSERT INTO user (email, username, password) VALUES('{$email}','{$uname}','{$upass}');";
            if($conn->query($sql) === TRUE) {

                /* This isn't working */
                try {
                    $semail = new Email($email, $name);
                    $semail->sendRegisterEmail();
                } catch (Exception $e) {
                    //do nothing....
                }

                $data = ['statuscode' => 11,
                    'title' => 'Registered',
                    'type' => 'success',
                    'message' => "$email Registered successfully. Please check email click link"];

            } else {
                $data = ['statuscode' => 12,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => "Failed to Register user"];
            }
        }

        echo json_encode($data);
    }

    $conn->close();
} else {
    //didn't set username or pass
    echo "Invalid data";
}