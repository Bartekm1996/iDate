<?php
require("db.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT * FROM cs4116.country;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<option value='{$row[0]}'>{$row[1]}</option>";
        }
    }
}
