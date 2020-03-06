<?php
require("db.php");

if (isset($_REQUEST['user_name']) && isset($_REQUEST['password']) ) {
    $uname = $_REQUEST['user_name'];
    $upass = $_REQUEST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);

        $sql = "SELECT registered FROM user where username='{$uname}' AND password='{$upass}' LIMIT 1;";

        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            echo "You logged in";
        } else {
            echo "Failed to log in";
        }
    }
    $conn->close();
} else {
    //didn't set username or pass
    echo "Invalid data";
}