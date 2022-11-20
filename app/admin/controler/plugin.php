<?php

use classes\Plugin;

$dir = $_SERVER['DOCUMENT_ROOT']."/app/plugin";
$listDir = scandir($dir);

$html = "<div class='flex justify-center'>";

foreach($listDir AS $child) {

    $pluginPath = $dir."/$child";

    if (Plugin::is_plugin($pluginPath)) {
        
        $plugin = new Plugin($pluginPath);

        $html .= "<div class='card-theme'>".$plugin->meta['@name']."</div>";
    }
    
}
$html .= "</div>";


$this->body = str_replace("[{CONTENT}]", $html, $this->body);