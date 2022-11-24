<?php

use classes\CONN;
use Module\classes\ENCH;

$html = "<h1>hallo world</h1>";
$conn = new CONN();
$PDO = $conn->_PDO();

$sql = "SELECT * FROM `users`";
$stmt = $PDO->prepare($sql);
$stmt->execute([]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$loged = $_COOKIE['user'];
$ench = new ENCH($loged);
$loged = $ench->decrypt();



$html = "<ul class='list-item'>";
foreach ($result as $content) {

    $id = $content['id'];
    $username = $content['username'];
    $password = $content['password'];
    $role = function() use ($content) {

        $value = "unknown";
        switch($content['role']) {
            case 1:
                $value = "Admin";
                break;
            // ...

        }

        return $value;
    };


    $html .= "<li class='item'>

        <div class='item-body flex align-items-center'>

            <i style='font-size: 35px;' class='micon-person-circle'></i>
            <h4 class='item-title' style='margin: 0 10px;'>" . $username . "</h4>

            <span>role : " . $role() . "</span>

            <div style='width: 100%; padding: 8px;'>
                <span>ID : $id</span>
            </div>
           
        </div>

    </li>";

}
$html .= "</ul>";


return $html;