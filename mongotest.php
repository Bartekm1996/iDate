<?php
$connectionString = "mongodb://idev.ie:27017";

//$mongo = new MongoDB\Client($connectionString);
//
//$dbs = $mongo->listDatabases();
//echo $dbs;
$conn = new MongoClient($connectionString);
echo 'Is connected '. $conn->connect();
echo $conn->listDBs();