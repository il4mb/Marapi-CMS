<?php

use classes\DOCUMENT;
use classes\UriManager;

require_once $_SERVER['DOCUMENT_ROOT'] . '/module/init.php';

$uriManager = new UriManager();
$path = $uriManager->getPath();

if(! array_key_exists('1', $path) ||  array_key_exists('1', $path) && $path[1] == "") {

    header("Location: /mrp/dashboard/");
}
if(array_key_exists('1', $path) && $path[1] != "login" && ! isset($_COOKIE['user'])) {

    header("Location: /mrp/login/");
}

switch ($path[1]) {

    case "dashboard":
        $html = file_get_contents(__DIR__ . "/layout/main.html");
        $document = new DOCUMENT($html);
        print($document->render());
        break;

    case "login":
        $html = file_get_contents(__DIR__ . "/layout/login.html");
        $document = new DOCUMENT($html);
        $document->setControler(__DIR__."/controler/login.php");
        print($document->render());
        break;

    default:
        $html = file_get_contents(__DIR__ . "/layout/404.html");
        $document = new DOCUMENT($html);
        print($document->render());
}

exit;
