<?php
$HOST = "localhost";
$LOGIN = "intita";
$PASSWORD = "1234567";
$DB = "test_db";

$connect = mysql_connect($HOST, $LOGIN, $PASSWORD) or die("Error connect!!");

mysql_query("CREATE DATABASE IF NOT EXISTS test_db",$connect);
mysql_select_db($DB, $connect) or die("Error db!");
?>
