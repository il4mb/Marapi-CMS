<?php
use classes\Json;
use classes\THEME;

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

} else if ($kode == 0) {

    $theme = THEME::getThemeFromPath($value);

    echo json_encode([
        "title" => "Confirm Deletion",
        "body" => "Are you sure to delete Theme <span class='text-primary'>". $theme->params['@name']."</span> ? 
                   path : <span class='fn-i text-secondary'>".$theme->path."</span>
                   \n<span class='fn-i text-warning'>This will delete all file in this theme folder</span>"
    ]);
}