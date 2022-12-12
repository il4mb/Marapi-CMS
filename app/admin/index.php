<?php

/**
 * Copyright 2022 Ilham B
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use classes\DOCUMENT;
use classes\Plugin;
use classes\UriManager;

require_once $_SERVER['SELF_ROOT'] . '/module/init.php';

try {

    $uriManager = new UriManager();
    $path = $uriManager->getPath();


    if (array_key_exists(1, $path) && $path[1] == "api") {

        if (array_key_exists(2, $path) && $path[2] == "hook") {

            require_once __DIR__ . "/../api/hook/main.php";
            exit;
        }
    } elseif (array_key_exists(1, $path) && $path[1] == "install") {

        require_once __DIR__ . "/../install/index.php";
        exit;
    }



    if (!array_key_exists('1', $path) ||  array_key_exists('1', $path) && $path[1] == "") {

       header("Location: ".SELF_PATH."/mrp/dashboard/");
    }

    if (array_key_exists('1', $path) && $path[1] != "login" && !isset($_COOKIE['user'])) {

        header("Location: ".SELF_PATH."/mrp/login/");
    }

    $menu = [
        "dashboard" => "<a {ATTR} style=\"font-weight: 900; padding: 15px 15px;\" href=\"{SELF_PATH}/mrp/dashboard/\">\n\t<svg width=\"40\" height=\"28\" color=\"currentColor\" version=\"1.1\" viewBox=\"0 0 126.4 97.009\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:cc=\"http://creativecommons.org/ns#\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n\t\t<g transform=\"translate(-38.675 -125.31)\">\n\t\t\t<path d=\"m93.979 136.81 8.7573 11.332 13.744-22.837 48.59 96.886-20.335-0.0209-29.298-58.489-10.509 14.449-8.472-8.9149-31.166 52.807s-26.691 0.2253-26.615 0.10806z\" fill=\"currentColor\" stroke-width=\".26458\"/>\n\t\t</g>\n\t</svg>\n\t<span style='margin-left:-2px'>arapi</span>\n\t<small class='text-secondary'><i>Dasborad</i></small>\n</a>",
        "<hr/>",
        'content' => '<a {ATTR} href="{SELF_PATH}/mrp/content/">CONTENT</a>',
        'page' => '<a {ATTR} href="{SELF_PATH}/mrp/page/">PAGE</a>',
        'menu' => '<a {ATTR} href="{SELF_PATH}/mrp/menu/">MENU</a>',
        '<hr/>',
        'theme' => '<a {ATTR} href="{SELF_PATH}/mrp/theme/">THEME</a>',
        'plugin' => '<a {ATTR} href="{SELF_PATH}/mrp/plugin/">PLUGIN</a>',
        'users' => '<a {ATTR} href="{SELF_PATH}/mrp/users/">USERS</a>',
        '<hr/>',
        'setting' => '<a {ATTR} href="{SELF_PATH}/mrp/setting">SETTING</a>'
    ];

    $html = "";
    $document = new DOCUMENT(null);

    switch ($path[1]) {

        case "login":
            $document->setControler(__DIR__ . "/controler/login.php");
            break;

        default:
            $html = file_get_contents(__DIR__ . "/layout/main.html");
            //  $document->setShortCodes(["container", "page_title", "menus", "tool_item"]);
    }

    // SET DOCUMENT HTML
    $document->setDocument($html);



    $listPlugin = Plugin::getActivePlugin();

    foreach ($listPlugin as $plugin) {

        $plugin->callOnPanel($document);
    }



    foreach ($menu as $key => $val) {

        if (gettype($key) == "string" && 0 == strcmp(strtolower($path[1]), strtolower($key))) {

            $menu[$key] = str_replace("{ATTR}", "class='active'", $menu[$key]);

            if (array_key_exists($key, $menu)) {
               
                $controller = initController($key);

                if (is_file($controller)) {

                    $document->setControler($controller);
                }
            }
        } else $menu[$key] = str_replace("{ATTR}", "", $menu[$key]);
    }



    $document->ShortCode->addShortCode("SELF_PATH");

    $document->ShortCode->addOnRender(function ($code)
    use ($menu, $path, $document) {

        $value = "";
        switch ($code) {

            case "MENUS":
                $value = implode("\n", $menu);
                break;
            case "PAGE_TITLE":
                $value = $path[1];
                break;
            case "CONTAINER":
                $value = $document->getController();
                break;
            case "TOOL_ITEM":
                $value = require_once __DIR__ . '/controler/_toolitem.php';
                break;
            case "SELF_PATH":
                $value = SELF_PATH;
        }
        return $value;
    });



    print($document->render(false));
    exit;



} catch (Exception $e) {



    print "<h1 style='color: red'>ERROR</h1><p>" . $e->getMessage() . "</p>";
    exit;
}
