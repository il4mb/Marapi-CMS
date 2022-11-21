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

require_once $_SERVER['DOCUMENT_ROOT'] . '/module/init.php';

$uriManager = new UriManager();
$path = $uriManager->getPath();

if (!array_key_exists('1', $path) ||  array_key_exists('1', $path) && $path[1] == "") {

    header("Location: /mrp/dashboard/");
}
if (array_key_exists('1', $path) && $path[1] != "login" && !isset($_COOKIE['user'])) {

    header("Location: /mrp/login/");
}

$menu = [
    "dashboard" => "<a {ATTR} style=\"font-weight: 900; padding: 15px 15px;\" href=\"/mrp/dashboard/\">
    <svg width=\"40\" height=\"28\" color=\"currentColor\" version=\"1.1\" viewBox=\"0 0 126.4 97.009\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:cc=\"http://creativecommons.org/ns#\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">
        <g transform=\"translate(-38.675 -125.31)\">
            <path d=\"m93.979 136.81 8.7573 11.332 13.744-22.837 48.59 96.886-20.335-0.0209-29.298-58.489-10.509 14.449-8.472-8.9149-31.166 52.807s-26.691 0.2253-26.615 0.10806z\" fill=\"currentColor\" stroke-width=\".26458\"/>
        </g>
    </svg><span style='margin-left:-2px'>arapi</span>
    <small class='text-secondary'><i>Dasborad</i></small>
</a>",
    "<hr/>",
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

$document = new DOCUMENT(null);

switch ($path[1]) {

    case "login":
        $html = file_get_contents(__DIR__ . "/layout/login.html");
        $document->setControler(__DIR__ . "/controler/login.php");
        break;

    default:
        $html = file_get_contents(__DIR__ . "/layout/main.html");
        $document->setMenu($menu);
}

$document->setDocument($html);

$listPlugin = Plugin::getActivePlugin();
foreach ($listPlugin as $plugin) {

    $plugin->callOnPanel($document);
}

$menu = $document->getMenu();
foreach ($menu as $key => $val) {

    if ($path[1] == $key) {

        $menu[$key] = str_replace("{ATTR}", "class='active'", $menu[$key]);

        $controller = $_SERVER['DOCUMENT_ROOT'] . "/app/admin/controler/" . $path[1] . ".php";
        if (is_file($controller)) {

            $document->setControler($controller);
        }
    } else $menu[$key] = str_replace("{ATTR}", "", $menu[$key]);
}
$document->setMenu($menu);
$document->setBody(str_replace("{PAGE_TITLE}", $path[1], $document->getBody()));

print($document->render());
exit;
