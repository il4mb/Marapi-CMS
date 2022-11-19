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

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}