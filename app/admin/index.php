<?php

use classes\DOCUMENT;
use classes\Plugin;
use classes\UriManager;

require_once $_SERVER['DOCUMENT_ROOT'] . '/module/init.php';

$uriManager = new UriManager();
$path = $uriManager->getPath();

if (!array_key_exists('1', $path) ||  array_key_exists('1', $path) && $path[1] == "") {

    header("Location: /mrp/dashboard/");
}
if (array_key_exists('1', $path) && $path[1] != "login" && !isset($_COOKIE['user'])) {

    header("Location: /mrp/login/");
}


$listPlugin = Plugin::getActivePlugin();

foreach($listPlugin AS $plugin) {

    $plugin->callOnPanel();
}

switch ($path[1]) {

    case "dashboard":
    case "content":
    case "page":
    case "menu":
    case "theme":
    case "plugin":
    case "user":
    case "setting":

        $menu = [
            'content' => '<a {ATTR} href="/mrp/content/">CONTENT</a>',
            'page' => '<a {ATTR} href="/mrp/page/">PAGE</a>',
            'menu' => '<a {ATTR} href="/mrp/menu/">MENU</a>',
                '<hr/>',
            'theme' => '<a {ATTR} href="/mrp/theme/">THEME</a>',
            'plugin' => '<a {ATTR} href="/mrp/plugin/">PLUGIN</a>',
            'user' => '<a {ATTR} href="/mrp/user/">USER</a>',
                '<hr/>',
            'setting' => '<a {ATTR} href="/mrp/setting">SETTING</a>'
        ];

        $html = file_get_contents(__DIR__ . "/layout/main.html");
        $document = new DOCUMENT($html);


        foreach ($menu as $key => $val) {

            if($path[1] == $key) {
                
                $menu[$key] = str_replace("{ATTR}", "class='active'", $menu[$key]);

                $controller = $_SERVER['DOCUMENT_ROOT']."/app/admin/controler/" . $path[1] . ".php";
                if(is_file($controller)) {

                    $document->setControler($controller);
                }

            } else $menu[$key] = str_replace("{ATTR}", "", $menu[$key]);
        }


        $document->body = str_replace("[{LINKS}]", implode("\n", $menu), $document->body);
        $document->body = str_replace("{PAGE_TITLE}", $path[1], $document->body);

        print($document->render());
        break;

    case "login":
        $html = file_get_contents(__DIR__ . "/layout/login.html");
        $document = new DOCUMENT($html);
        $document->setControler(__DIR__ . "/controler/login.php");
        print($document->render());
        break;

    default:
        $html = file_get_contents(__DIR__ . "/layout/404.html");
        $document = new DOCUMENT($html);
        print($document->render());
}

exit;
