<?php

use classes\THEME;

$theme = new THEME(null);
$list = $theme->getList();

$_data = ["theme" => $list];
$passData = "<script>window.MARAPI = " . json_encode($_data) . "</script>";
$this->head .= $passData;

$html = "<div class='flex justify-center'>";
foreach ($list as $key => $val) {

    /**
     * @var THEME $val - theme --
     */
    $active = THEME::getActiveTheme();
    $params = $val->params;

<<<<<<< HEAD
    $active_tooltip = "\n<a trigger='layer' class='action text-primary'><i class='micon-front'></i></a>";
=======
    $active_tooltip = "\n<a trigger='layer' data='theme.". $key ."' class='bottom-right btn text-primary'><i class='micon-front'></i></a>";
>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
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
