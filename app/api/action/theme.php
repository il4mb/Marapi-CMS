<?php
use classes\Json;

$conf_path = $_SERVER['DOCUMENT_ROOT'] . "/conf-data.json";
$json = new Json($conf_path);

if($kode == 1) { 
    /**
     * CHANGE ACTIVE THEME
     */

    $json->data['theme'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $value);
    
    $stream = fopen($conf_path, 'w+');
    fwrite($stream, json_encode($json->data));
    fclose($stream);

    echo "success";
} 