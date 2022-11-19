<?php
### GENERATE BY SYSTEM
$host = "localhost";
$user = "root";
$pass = "";

try {

	$DB = new PDO("mysql:host=$host;dbname=marapi", $user, $pass);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

	print $e->getMessage();
	exit;
}