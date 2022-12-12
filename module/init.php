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

$list = scandir($_SERVER['SELF_ROOT'] . "/module/interface");
foreach ($list as $file) {

    if (is_file($_SERVER['SELF_ROOT'] . "/module/interface/" . $file)) {

        include_once $_SERVER['SELF_ROOT'] . "/module/interface/" . $file;
    }
}

$list = scandir($_SERVER['SELF_ROOT'] . "/module/classes");
foreach ($list as $file) {

    if (is_file($_SERVER['SELF_ROOT'] . "/module/classes/" . $file)) {

        include_once $_SERVER['SELF_ROOT'] . "/module/classes/" . $file;
    }
}

/**
 * deleteDirectory()
 * - Delete not empty directory
 * 
 * @param String $dir - full path directory address
 */
function deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

function generateRandomString($length = 10)
{
    $characters = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function initController($base)
{
    $controller = $_SERVER['SELF_ROOT'] . "/app/admin/controler/" . $base;
    if (!file_exists($controller)) {
        mkdir($controller);
    }

    $controller .= "/main.php";
    if (!file_exists($controller) && !is_file($controller)) {

        $pathinfo = pathinfo($controller);
        $file = fopen($controller, "w+") or die("Unable to open file!");
        $txt = "<?php \n//Edit this file and return you html \nreturn \"<p>Edit this file at <b><i>" . $pathinfo['dirname'] . "/</i></b> file name is <b><i>" .  $pathinfo['basename'] . "</i></b></p>\";";
        fwrite($file, $txt);
        fclose($file);
    }

    return $controller;
}
