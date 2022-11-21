<?php
### GENERATE BY SYSTEM
$host = "localhost";
$database = "marapi";
$user = "root";
$pass = "";

$DB = null;
try {

	$DB = new PDO("mysql:host=$host;dbname=$database", $user, $pass);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

	print $e->getMessage();
	exit;
}