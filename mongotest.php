<?php
$connectionString = getenv("MONGO_URI");

$conn = new MongoDB\Driver\Manager($connectionString);

$listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
$res = $conn->executeCommand("admin", $listdatabases);

$result = $res->getServer()->getHost()."\n";
$result = $res->getServer()->getInfo();
print_r($result);

