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

	echo "<h1>ERROR CONNECTION</h1>
	<h4>Message :</h4>
	<p>".$e->getMessage()."</p>	<a href='/mrp/install'>Fix with installer</a>";
	exit;
}