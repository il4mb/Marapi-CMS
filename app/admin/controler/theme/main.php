<?php

use classes\THEME;

$theme = new THEME(null);
$list = $theme->getList();

$_data = ["theme" => $list];
$passData = "<script>window.MARAPI = " . json_encode($_data) . "</script>";
$this->head .= $passData;
$html = "<div class='content-wrapper'>";
$html .= "<div class='flex flex-wrap'>";
foreach ($list as $key => $val) {

    /**
     * @var THEME $val - theme --
     */
    $active = THEME::getActiveTheme();
    $params = $val->params;

    $active_tooltip = "\n<a trigger='layer' data='theme.". $key ."' class='btn text-primary ps-2 pe-2 pt-1 pb-1 ms-auto'><i class='ic-front'></i></a>";
    if(0 == strcmp(strtolower($active->path), strtolower($val->path))) { 
        $active_tooltip .= "\n<a class='text-success status p-0'><i class='ic-check2-circle'></i> Active</a>";
    }

    $title = $params['@name'];
    $author = $params['@author'];
    $description = $params['@description'];

    $mail = $params['main'];
    $content = $params['content'];

    $html .= "<div class='card-theme'>";
    $html .= "<div class='thumbnail'></div>";

    $html.="<div class='flex p-1'>
                <h4 class='title mt-0 mb-0'>$title</h4>
                $active_tooltip</div>";

    $html .= "</div>";
}
$html .= "</div>";
$html .= "</div>";

return $html;