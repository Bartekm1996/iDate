 <?php
 //$conn = new mysqli(getenv("DB_URL"), getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_SCHEMA"));
 $servername = "idev.ie";
 $username = "uldev";
 $password = "uldev@cs4116";
 $dbname = "cs4116";

 $conn = new mysqli($servername, $username, $password, $dbname);