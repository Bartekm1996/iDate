<?php

include("MongoConnect.php");

$mongo = new MongoConnect();

$connString = "mongodb+srv://Btech96:LeoN1996%40@idate-l8bbf.mongodb.net/test?retryWrites=true&w=majority";
$listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);

$res = $mongo->getConnection()->executeCommand("admin", $listdatabases);

$result = $res->getServer()->getInfo();
print_r($result);

