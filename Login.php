<?php
require("db.php");
if (isset($_POST['user_name']) && isset($_POST['login_password']) ) {
    $uname = $_POST['user_name'];
    $upass = $_POST['login_password'];

    header('Content-Type: application/json');
    $data = [];

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

            $data = ['statuscode' => $reg ? 1 : 2,
                'title' => $reg ? 'Please Verify' : 'Login Success',
                'type' => $reg ? 'warning' : 'success',
                'message' => $reg ? "Please verify $uname" : "$uname logged in successfully"
            ];

        } else {
            $data = ['statuscode' => 3,
                'title' => 'Login Failed',
                'type' => 'error',
                'message' => "Failed to login with username $uname"
            ];
        }
    }
    echo json_encode($data);

    $conn->close();
} else {
    //didn't set username or pass
    echo "invalid data";
}