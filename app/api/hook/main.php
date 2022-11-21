<?php
require_once $_SERVER['DOCUMENT_ROOT']."/module/init.php";

use classes\UriManager;

$mURI = new UriManager();

$paths = $mURI->getPath();

if(isset($_POST['act'])) {

    $act = filter_input(INPUT_POST, 'act', FILTER_UNSAFE_RAW);
    $code = filter_input(INPUT_POST, 'kode', FILTER_UNSAFE_RAW);
    $value = filter_input(INPUT_POST, 'value', FILTER_UNSAFE_RAW);

    if(0 == strcmp(strtolower($act), "theme")) {

        require_once __DIR__."/../action/theme.php";
    } else
    if(0 == strcmp(strtolower($act), "plugin")) {

        require_once __DIR__."/../action/plugin.php";
    }
}