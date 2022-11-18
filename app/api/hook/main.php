<?php
require_once $_SERVER['DOCUMENT_ROOT']."/module/init.php";

use classes\UriManager;

$mURI = new UriManager();

$paths = $mURI->getPath();

if(isset($_POST['key'], $_POST['kode'])) {

    $key = filter_input(INPUT_POST, 'key', FILTER_UNSAFE_RAW);
    $kode = filter_input(INPUT_POST, 'kode', FILTER_UNSAFE_RAW);
    $value = filter_input(INPUT_POST, 'value', FILTER_UNSAFE_RAW);

    if(0 == strcmp(strtolower($key), "theme")) {

        require_once __DIR__."/../action/theme.php";
    }
}