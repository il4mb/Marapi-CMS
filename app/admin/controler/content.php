<?php

use classes\CONN;

$html = "<h1>hallo world</h1>";
$conn = new CONN();
$PDO = $conn->_PDO();

$sql = "SELECT * FROM `contents`";
$stmt = $PDO->prepare($sql);
$stmt->execute([]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$html = "false";
foreach ($result as $content) {

    $id = $content['id'];
    $html = $content['html'];
    $publish = $content['publish'];
    $modify = $content['modify'];
    $author = $content['author'];


    $htmlCOntent .= "<h4>$id</h4>";

}


return $html;
