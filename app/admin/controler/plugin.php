<?php

use classes\Plugin;

$dir = $_SERVER['DOCUMENT_ROOT']."/app/plugin";
$listDir = scandir($dir);

$html = "<div class='flex justify-center'>";

foreach($listDir AS $child) {

    $pluginPath = $dir."/$child";

    if (Plugin::is_plugin($pluginPath)) {
        
        $plugin = new Plugin($pluginPath);

        $html .= "<div class='card-theme'>".json_encode($plugin)."</div>";
    }
    
}
$html .= "</div>";


$this->body = str_replace("[{CONTENT}]", $html, $this->body);