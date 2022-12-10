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
 * 
 */

use classes\CONN;
use classes\UriManager;

$content_path = $_SERVER['DOCUMENT_ROOT'] . "/app/contents";
if (!file_exists($content_path)) {
    mkdir($content_path);
}

$uriManager = new UriManager();
$path = $uriManager->getPath();

if (array_key_exists(2, $path) && $path[2] == "new") {


    return file_get_contents(__DIR__ . "/editing.html");
}


$conn = new CONN();
$PDO = $conn->_PDO();

$scandir = scandir($content_path);
$scandir = array_values(array_filter($scandir, function ($e) {

    $pathinfo = pathinfo($e);
    return $e != "." && $e != ".." && $pathinfo['extension'] == 'html';
}));


$html = $this->getHtmlFile(__DIR__ . "/content.html");
$contentHTML = "<div class=\"content-wrapper\">";

foreach ($scandir as $key) {

    $key = str_replace(".html", "", $key);

    $stmt = $PDO->prepare("SELECT * FROM contents WHERE id=?");
    $stmt->execute([$key]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = "No title";
    $description = "No description";
    $date = "~";
    $author = "~";

    if ($result != null) {

        $title = $result['title'];
        $description = $result['description'];
        $date = $result['date'];
        $author = $result['author'];
    }

    $contentHTML .= "<div>\n
    <h4>$title</h4>
    <p>$description</p>
    <span>$author</span><span>$date</span>
    </div>";
}

$contentHTML .= "</div>";

$html .= $contentHTML;

return $html;
