<?php
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
}else if(isset($_POST['get_all_tickets'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT userName,email,description,reason,date FROM
                queries";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new Query($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}else if(isset($_POST['deleteUser'])){

}