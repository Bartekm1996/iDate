<?php
require("db.php");
require("Email.php");

if (isset($_REQUEST['username']) && isset($_REQUEST['pass'])
&& isset($_REQUEST['email']) && isset($_REQUEST['name'])) {

    $uname = $_REQUEST['username'];
    $upass = $_REQUEST['pass'];
    $email = $_REQUEST['email'];
    $name = $_REQUEST['name'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);
        $email = $conn->real_escape_string($email);

        $sql = "SELECT registered FROM user where username='{$uname}' LIMIT 1;";

        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            echo "This username $uname is already taken";
        } else {
            mysqli_free_result($result);
            $sql = "INSERT INTO user (email, username, password) VALUES('{$email}','{$uname}','{$upass}');";
            if($conn->query($sql) === TRUE) {
                echo "User inserted into the database";
                $email = new Email($email, $name);
                $email -> sendRegisterEmail();
            } else {
                echo "Failed to insert user into the database";
            }
        }
    }
    $conn->close();
} else {
    //didn't set username or pass
    echo "Invalid data";
}