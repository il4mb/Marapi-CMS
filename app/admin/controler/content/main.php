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

$content_path = $_SERVER['SELF_ROOT'] . "/app/contents";
if (!file_exists($content_path)) {
    mkdir($content_path);
}



$conn = new CONN();
$PDO = $conn->_PDO();



$scandir = scandir($content_path);
$scandir = array_values(array_filter($scandir, function ($e) {

    $pathinfo = pathinfo($e);
    return $e != "." && $e != ".." && $pathinfo['extension'] == 'html';
}));


$html = $this->getHtmlFile(__DIR__ . "/content.html");
$contentHTML = "<ol class=\"ms-5 content-wrapper\">";

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

    $editPath = "{ADMIN_PATH}/editor/?edit=" . $key;

    $contentHTML .= "<li class='p-2 content'>\n
                     $title
                        <div class='meta hidden font-medium'>
                            <div class='flex items-flex-end'>

                                <div class='me-auto'>
                                    <p class='font-small ps-2'>$description</p>
                                    <span class='text-secondary font-x-small'><i class='ic-person'></i>$author</span>
                                    <span class='ms-3 text-secondary font-x-small'><i class='ic-clock'></i>$date</span>
                                </div>

                                <div class='ms-auto mb-1'>
                                    <a class='btn btn-sm bg-primary text-white' href='$editPath'>EDIT</a>
                                    <a class='btn btn-sm bg-danger text-white'>DELETE</a>
                                </div>

                            </div>
                        </div>
                     </li>";
}

$contentHTML .= "</ol>";

$html .= $contentHTML;

return $html;
