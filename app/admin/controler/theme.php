<?php

use classes\THEME;

$theme = new THEME(null);
$list = $theme->getList();

$html = "<div class='flex justify-center'>";
foreach ($list as $key => $val) {

    /**
     * @var THEME $val - theme --
     */
    $active = THEME::getActiveTheme();
    $params = $val->params;

    $active_tooltip = "\n<a trigger='layer' class='action text-primary'><i class='micon-front'></i></a>";
    if(0 == strcmp(strtolower($active->path), strtolower($val->path))) { 
        $active_tooltip .= "\n<a class='text-success status'><i class='micon-check2-circle'></i> Active</a>";
    }

    $title = $params['@name'];
    $author = $params['@author'];
    $description = $params['@description'];

    $mail = $params['main'];
    $content = $params['content'];

    $html .= "<div class='card-theme'>";
    $html .= "<div class='thumbnail'></div>";
    $html .= "<h4 class='title'>$title</h4>";
    $html .= "$active_tooltip</div>";
}
$html .= "<div>";

$this->body = str_replace("[{CONTENT}]", $html, $this->body);
