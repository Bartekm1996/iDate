<?php
ob_start();
require ('db.php');
require ('model/UserManagment.php');
require ('model/Query.php');

if(isset($_POST['get_all_users'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT id,userName,firstname,lastname,email,blocked,registered,admin FROM
                (SELECT a.id, a.userName, a.firstname, a.lastname, a.email, a.registered,a.admin, b.userID, b.blocked 
                FROM user as a LEFT JOIN(select userID, blocked from profile group by userID) as b on a.id = b.userID) as users";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new UserManagment($row[$i++], $row[$i++], $row[$i++]." ".$row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}
else if(isset($_POST['get_user_info'])){

    $uname = $conn->real_escape_string($_POST['username']);

    $sql = "";
    if(ctype_digit($uname)){
        $sql = "SELECT id,userName,firstname,lastname,email, Description, age FROM
                (SELECT a.id, a.userName, a.firstname, a.lastname, a.email,a.age, b.Description
                FROM user as a LEFT JOIN(select userID, Description from profile group by userID) as b on a.id = b.userID) as user WHERE id = '{$uname}'";
    }else{
        $sql = "SELECT id, userName,firstname,lastname,email, Description, age FROM
                (SELECT a.id, a.userName, a.firstname, a.lastname, a.email,a.age, b.Description
                FROM user as a LEFT JOIN(select userID, Description from profile group by userID) as b on a.id = b.userID) as user WHERE userName = '{$uname}'";
    }


    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $res = $result->fetch_row();
            $user = new UserInfo($res[1], $res[2], $res[3], $res[4], $res[5], $res[6]) ;
            echo $user->jsonSerialize();
    }
}
else if(isset($_POST['get_all_tickets'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT userName,email,description,reason,date,queryNumber, status, archived FROM
                queries";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new Query($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}else if(isset($_POST['updateTicket'])){
    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $sqlQuery = "";
        $number = $_POST['number'];
        if(isset($_POST['archived_ticket'])){
            $sql = $conn->real_escape_string($_POST['archived_ticket']);
            $sqlQuery = "UPDATE queries SET archived = 'True' WHERE id='{$number}'";
        }else if(isset($_POST['close_ticket'])){
            $sql = $conn->real_escape_string($_POST['close_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Closed' WHERE id='{$number}'";
        }else if(isset($_POST['unresolved_ticket'])){
            $sql = $conn->real_escape_string($_POST['unresolved_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Unresolved' WHERE id='{$number}'";
        }


        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(3,
                'Updated ticket successfully',
                "Updated ticket ".$number." Successfully",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(3,
                'Failed to update ticket',
                "Failed to update ticket ".$number,
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();

    }

}else if(isset($_POST['deleteTicket'])){

    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $number = $_POST['number'];

        $sql = "DELETE FROM queries WHERE queryNumber = '{$number}'";

        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(3,
                'Deleted ticket Successfully',
                "Deleted ticket ".$number." Successfully",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(3,
                'Failed to delete ticket',
                "Failed to delete ticket ".$number,
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();

    }

}else if(isset($_POST['resend_verification_email'])){

    $email = $_POST['email'];
    $uname = $_POST['username'];

    $semail = new Email($email, $uname);
    $semail->sendRegisterEmail(Email::VERIFY);

}else if(isset($_POST['change_user_admin_status'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $username = $conn->real_escape_string($_POST['username']);
        $change = $conn->real_escape_string($_POST['change']);

        if($change === "Add"){
            $sql = "UPDATE user SET admin = true WHERE userName = '{$username}'";
        }else if($change === "Remove"){
            $sql = "UPDATE user SET admin = false WHERE userName = '{$username}'";
        }

        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(1,
                '',
                "",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(2,
                '',
                "",
                SweetalertResponse::SUCCESS
            );
        }
        echo $resp->jsonSerialize();

}