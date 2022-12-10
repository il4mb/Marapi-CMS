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
$loged = (array)$ench->decrypt();


$html = file_get_contents(__DIR__."/fragment.html");

$html .= "<ul class='list-item'>";
foreach ($result as $user) {

    $id = $user['id'];
    $username = function () use ($user, $loged) {

        if ($loged['id'] == $user['id']) {
            return $user['username'] . " <i> ( You ) </i>";
        } else return $user['username'];
    };
    $password = $user['password'];
    $role = function () use ($user) {
        $value = "unknown";
        switch ($user['role']) {
            case 1:
                $value = "Admin";
                break;
                // ...

        }
        return $value;
    };

    $tool = function () use ($user, $loged) {

        $html = "<a class='action-btn text-primary'>Edit</a>";

        if ($loged['id'] !== $user['id']) {

            if ($loged['role'] == 1) 
                $html .= "<a trigger='delete' data-act='user' act-key='".$user['id']."' class='action-btn text-danger'>Delete</a>";

        } else $html .= "<a class='text-danger action-btn'>Logout</a>";

        return $html;
    };


    $html .= "<li class='item'>

        <div class='item-body flex align-items-center'>

            <i style='font-size: 35px;' class='micon-person-circle'></i>
            <h4 class='item-title' style='margin: 0 10px;'>" . $username() . "</h4>

            <span>role : " . $role() . "</span>

            <div style='width: 100%; padding: 15px 8px 0px 8px;' class='action-wrapper'>
                " . $tool() . "
            </div>
           
        </div>

    </li>";
}
$html .= "</ul>";


return $html;
