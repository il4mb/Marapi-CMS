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

$html = "";

$uriManager = new UriManager();
$path = $uriManager->getPath();

if(array_key_exists(2, $path) && $path[2] == "new" ) {

    
    return "under";
}





$conn = new CONN();
$PDO = $conn->_PDO();

$sql = "SELECT * FROM `contents`";
$stmt = $PDO->prepare($sql);
$stmt->execute([]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = $this->getHtmlFile(__DIR__."/html/content.html");

foreach ($result as $content) {

    $id = $content['id'];
    $content = $content['html'];
    $publish = $content['publish'];
    $modify = $content['modify'];
    $author = $content['author'];


    $html .= "<h4>$id</h4>";

}

return $html;
