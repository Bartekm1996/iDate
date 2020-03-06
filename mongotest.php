<?php
$connectionString = getenv("MONGO_URI");

//$mongo = new MongoDB\Client($connectionString);
//
//$dbs = $mongo->listDatabases();
//echo $dbs;
$conn = new MongoDB\Driver\Manager($connectionString);

$listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
$res = $conn->executeCommand("admin", $listdatabases);
echo $res->getServer()->getHost()."\n";
