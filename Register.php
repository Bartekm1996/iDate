<?php
require("db.php");

if (isset($_REQUEST['username']) && isset($_REQUEST['pass'])
&& isset($_REQUEST['email'])) {

    $uname = $_REQUEST['username'];
    $upass = $_REQUEST['pass'];
    $email = $_REQUEST['email'];

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