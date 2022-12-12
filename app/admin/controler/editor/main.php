<?php
date_default_timezone_set('Asia/Jakarta');
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
 * @var DOCUMENT $this - this file is part of DOCUMENT 
 */

use classes\CONN;
use module\shortCode;

$PDO = (new CONN())->_PDO();

$html = file_get_contents(__DIR__ . "/editing.html");

$shortCode = new shortCode();

/** POST EXECUTE */
if(isset($_POST['title'], $_POST['id'], $_POST['description'])) {


    $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
    $title = filter_input(INPUT_POST, "title", FILTER_DEFAULT);
    $description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
    $date = date("Y-m-d H:i:s");


    $stmt = $PDO->prepare("SELECT id FROM contents WHERE id=?");
    $stmt->execute([ $id ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if($result) {

        $stmt = $PDO->prepare("UPDATE contents SET title=?, description=?, date=? WHERE id=?");
        $stmt->execute([ $title, $description, $date, $id ]);
    } else {

        $stmt = $PDO->prepare("INSERT INTO contents (id, title, description, date) VALUES (?, ?, ?, ?)");
        $stmt->execute([ $id, $title, $description, $date ]);
    }


    $trueHtmlName = $id.".html";
    $truePath = $_SERVER['SELF_ROOT']."/app/contents/".$trueHtmlName;


    $stream = fopen($truePath, "w+");
    fwrite($stream, $_POST['editing']);
    fclose($stream);

}





/** GET EXECUTE */

if (isset($_GET['edit'])) {


    $id = $_GET['edit'];
    $title = "";
    $description = "";


    $stmt = $PDO->prepare("SELECT * FROM contents WHERE id=?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($result) {

        $title = $result['title'];
        $description = $result['description'];
    }


    $shortCode->addShortCode("TITLE");
    $shortCode->addShortCode("DESCRIPTION");
    $shortCode->addShortCode("CONTENT_ID");


    $shortCode->addOnRender(function ($code) use ($title, $description, $id) {

        switch ($code) {

            case "TITLE":
                return $title;
                break;
            case "DESCRIPTION":
                return $description;
                break;
            case "CONTENT_ID":
                return $id;
                break;

        }
    });

    $trueHtmlName = $id.".html";
    $truePath = $_SERVER['SELF_ROOT']."/app/contents/".$trueHtmlName;
    $contentHTML = file_get_contents($truePath);

    $this->body .= "<script> document.getElementById('editing').innerHTML = '$contentHTML'; </script>";
}

return $shortCode->render($html);
