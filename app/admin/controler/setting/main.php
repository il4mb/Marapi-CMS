<?php

use classes\Plugin;
use classes\UriManager;

$uriManager = new UriManager();
$path = $uriManager->getPath();

if (array_key_exists('2', $path)) {

    $regCode = $path[2];

    $plugin = Plugin::getByRegCode($regCode);
    $settings = file_get_contents($plugin->path."/.setting");

    return "$settings";

} else {

    return "setting";
}