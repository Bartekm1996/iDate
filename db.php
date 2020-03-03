 <?php
$servername = "localhost";
$username = "uldev";
$password = "uldev@cs4116";
$dbname = "cs4116";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	echo "Db connection working";
}
$conn->close();
?>