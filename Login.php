<?php
require("db.php");
print_r($_POST);
if (isset($_POST['user_name']) && isset($_POST['password']) ) {
    $uname = $_POST['user_name'];
    $upass = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);

        $sql = "SELECT username,password,registered FROM users LIMIT 1;";

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