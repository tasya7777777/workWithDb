<?php
$HOST = "localhost";
$LOGIN = "intita";
$PASSWORD = "1234567";
$DB = "test_db";

$connect = mysql_connect($HOST, $LOGIN, $PASSWORD);

if (!$connect) {
    printf("Can't connect to localhost. Error: %s\n", mysql_error());
    exit();
}
if (!mysql_query ("CREATE DATABASE IF NOT EXISTS test_db",$connect)){
	printf("Error". "\n");
}
mysql_select_db($DB, $connect) or die("Error db!");

?>