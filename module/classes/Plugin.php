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

namespace classes;

use Exception;
use Module\classes\ENCH;
use PDO;

/**
 * Plugin Class **Marapi CMS**
 */
class Plugin
{

    /**
     * @var Array $meta Meta data about plugin
     * 
     * - @name - *name plugin*
     * - @author - *author plugin*
     * - @description - *plugin description*
     */
    public $path = null, $meta;
    private static $relativeDirectory = "/app/plugin";

    /**
     * **__construct()**
     * 
     * Constructor of Plugin
     * 
     * Required :
     * - full path address
     * @param String $path full path directory address of plugin
     * @return Plugin
     */
    function __construct($path)
    {


        if (is_file($path . "/.plugin")) {

            $metaText = file_get_contents($path . "/.plugin");
            if ($metaText) {

                $rawText = explode("\r\n", $metaText);
                $rawText = array_values(array_filter($rawText,  function ($E) {
                    return $E !== "" || $E != null;
                }));

                foreach ($rawText as $key => $val) {

                    $meta = explode("=", $val);

                    $this->meta[preg_replace("/[^a-z@]+/i", "", $meta[0])] = $meta[1];
                }
            }

            $this->path = $path;
        }
    }

    function is_setting_exist() {

        return is_file($this->path."/.setting");
    }
    /**
     * module()
     * - call theme module
     * @return PluginInterface of plugin module
     */
    public function module()
    {

        global $value;

        if ($this->path && is_file($this->path . "/module.php")) {

            $file = $this->path . "/module.php";

            $buffer = file_get_contents($file);

            preg_match("/(?<=class\s)(\w+)(?=\s)/i", $buffer, $match);
            $className = $match[1];

            if ($className != null) {

                $tempClass = $this->regCode();

                $buffer = str_replace($className, $tempClass, $buffer);
                $file = $this->path . "/temp.php";
                file_put_contents($file, $buffer);
                
                $value = include_once($file);
                unlink($file);

                return $value;
            }
        } else {

            echo "Error: Cant call plugin module";
        }
    }

    function regCode() {

        $code = "";

        if(is_file($this->path."/.reg")) {

            $code = file_get_contents($this->path."/.reg");

        } else {

            $code = generateRandomString();
            $stream = fopen($this->path."/.reg", "w+");
            fwrite($stream, $code);
            fclose($stream);
        }

        return $code;
    }

    function unReg() {
        if(is_file($this->path."/.reg")) {
            unlink($this->path."/.reg");
        }
    }

    /**
     * callOnPanel()
     * - call this plugin on admin panel
     */
    public function callOnPanel($document)
    {

        ob_start();
        $this->module()->onPanel($document);
        ob_clean();
    }

    /**
     * callOnFront()
     * - call this plugin on public area
     * 
     * This method will passing main object to this plugin
     * @param Main $main Main object
     */
    public function callOnFront(Main $main)
    {

        $this->module()->onFront($main);
    }

    /**
     * setActive()
     * - enable this plugin
     */
    public function setActive()
    {

        $relativePath = substr($this->path, strlen($_SERVER['DOCUMENT_ROOT']));

        $conn = new CONN();
        $DB = $conn->_PDO();

        $stmt = $DB->prepare("SELECT * FROM `plugin` WHERE `path`=?");
        $stmt->execute([$relativePath]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {

            $stmt = $DB->prepare("INSERT INTO `plugin` (`path`) VALUE (?)");
            $stmt->execute([$relativePath]);

            echo "11";
        } else echo "01";
    }

    /**
     * setInactive()
     * - disable this plugin
     */
    public function setInactive()
    {

        $relativePath = substr($this->path, strlen($_SERVER['DOCUMENT_ROOT']));
        $conn = new CONN();
        $DB = $conn->_PDO();

        $sql = "DELETE FROM plugin WHERE path=?";
        $stmt = $DB->prepare($sql);
        $stmt->execute([$relativePath]);
    }

    /**
     * delete()
     * - Remove this plugin
     */
    public function delete()
    {

        $this->setInactive();
        deleteDirectory($this->path);
    }
    /**
     * - Check plugin is active
     * @return bool|int
     */
    public function is_active(): bool
    {

        $relativePath = substr($this->path, strlen($_SERVER['DOCUMENT_ROOT']));
        $conn = new CONN();
        $DB = $conn->_PDO();

        $stmt = $DB->prepare("SELECT * FROM `plugin` WHERE `path`=?");
        $stmt->execute([$relativePath]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return true;
        } else return false;
    }


    /**
     * is_plugin()
     * 
     * Check directory is plugin
     * @param String $path full path directory address
     */
    public static function is_plugin($path)
    {
        if (is_file($path . "/.plugin")) {

            return true;
        } else return false;
    }

    /**
     * getActivePlugin()
     * 
     * Get all plugin has enabled
     */
    public static function getActivePlugin()
    {
        $plugins = [];

        $conn = new CONN();
        $DB = $conn->_PDO();

        $stmt = $DB->prepare("SELECT * FROM plugin");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $value) {

            $relativePath = $value['path'];

            if (is_file($_SERVER['DOCUMENT_ROOT'] . $relativePath . "/.plugin")) {

                $plugin = new Plugin($_SERVER['DOCUMENT_ROOT'] . $relativePath);
                array_push($plugins,  $plugin);
            } else {

                $stmt = $DB->prepare("DELETE FROM `plugin` WHERE `path`=?");
                $stmt->execute([$value["path"]]);
            }
        }

        return $plugins;
    }

    /**
     * getListPlugin()
     * 
     * Get all plugin no matter enabled or disabled
     */
    public static function getListPlugin()
    {

        $directory = $_SERVER["DOCUMENT_ROOT"] . self::$relativeDirectory;
        $listDir = scandir($directory);

        $plugins = [];

        foreach ($listDir as $child) {

            $pluginPath = $directory . "/$child";

            if (Plugin::is_plugin($pluginPath)) {

                $plugin = new Plugin($pluginPath);
                if(! $plugin->is_active()) {

                    $plugin->unReg();
                } 

                array_push($plugins, $plugin);
            }
        }

        return $plugins;
    }

    static function getByRegCode($regCode) {

        $directory = $_SERVER["DOCUMENT_ROOT"] . self::$relativeDirectory;
        $listDir = scandir($directory);

        foreach ($listDir as $child) {

            $pluginCodePath = $directory . "/$child/.reg";

            $code = "";
            if (is_file($pluginCodePath)) {

                $code = file_get_contents($pluginCodePath);
            }
            if(strtolower($code) == strtolower($regCode)) {
            
                return new Plugin($directory . "/$child");
            }
        }
    }
}
