<?php

use classes\UriManager;

$list = scandir($_SERVER['DOCUMENT_ROOT']."/module/classes");
foreach( $list AS $file ) {

    if(is_file($_SERVER['DOCUMENT_ROOT']."/module/classes/".$file)) {

        include_once $_SERVER['DOCUMENT_ROOT']."/module/classes/".$file;
    }
}

$uriM = new UriManager();

print_r($uriM->in_array());
