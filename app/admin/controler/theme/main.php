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

    $active_tooltip = "\n<a trigger='layer' data='theme.". $key ."' class='bottom-right btn text-primary'><i class='ic-front'></i></a>";
    if(0 == strcmp(strtolower($active->path), strtolower($val->path))) { 
        $active_tooltip .= "\n<a class='text-success status'><i class='ic-check2-circle'></i> Active</a>";
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

return $html;