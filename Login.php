<?php
require("db.php");
if (isset($_POST['user_name']) && isset($_POST['password']) ) {
    $uname = $_POST['user_name'];
    $upass = $_POST['password'];



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
            echo $row[0] ? "You logged and registered": "You are logged in but not registered";
        } else {
            echo "Failed to log in";
        }
    }
    $conn->close();
} else {
    //didn't set username or pass
    echo $_POST['user_name'].$_POST['password'];
}