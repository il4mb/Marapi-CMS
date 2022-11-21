<?php
use classes\Json;
use classes\THEME;

$conf_path = $_SERVER['DOCUMENT_ROOT'] . "/conf-data.json";
$json = new Json($conf_path);

if($code == 1) { 
    /**
     * CHANGE ACTIVE THEME
     */

    $json->data['theme'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $value);
    
    $stream = fopen($conf_path, 'w+');
    fwrite($stream, json_encode($json->data));
    fclose($stream);

    echo "success";

} else if ($code == 0) {

    $theme = THEME::getThemeFromPath($value);
    if(file_exists($theme->path)) {

        if(deleteDirectory($theme->path)) {
            
            echo "success";
        }
    }
}