<?php

use classes\THEME;

$theme = new THEME(null);
$list = $theme->getList();

$html = "<div class='flex justify-center'>";
foreach ($list as $key => $val) {

    /**
     * @var THEME $val - theme --
     */
    $params = $val->params;

    $title = $params['@name'];
    $author = $params['@author'];
    $description = $params['@description'];

    $mail = $params['main'];
    $content = $params['content'];

    $html .= "<div class='card-theme'>";
    $html .= "<div class='thumbnail'></div>";
    $html .= "<h4 class='title'>$title</h4>";
    $html .= "<small class='author'>$author</small>";
    $html .= "<p>$description</p>";
    $html .= "<div class='footer'>
                <a class='tooltip text-danger'>
                    <i class='mri-trash'></i> Delete
                </a>
                <a class='tooltip text-info'>
                    <i class='mri-exclamation-circle'></i> Info
                </a>
                </div>";
    $html .= "</div>";
}
$html .= "<div>";

$this->body = str_replace("[{CONTENT}]", $html, $this->body);
