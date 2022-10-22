<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */
$list = scandir($_SERVER['DOCUMENT_ROOT']."/module/classes");
foreach( $list AS $file ) {

    if(is_file($_SERVER['DOCUMENT_ROOT']."/module/classes/".$file)) {

        include_once $_SERVER['DOCUMENT_ROOT']."/module/classes/".$file;
    }
}