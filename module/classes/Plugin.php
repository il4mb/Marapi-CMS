<?php

namespace classes;

use PDO;

class Plugin
{

    public $path = null;
    private static $relativeDirectory = "/app/plugin";


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

    public function module()
    {

        if ($this->path && is_file($this->path . "/module.php")) {

            return include_once($this->path . "/module.php");
        } else {

            echo "Error: Cant call plugin module";
        }
    }

    public function callOnPanel()
    {

        $this->module()->onPanel();
    }

    public function callOnFront(Main $main)
    {

        $this->module()->onFront($main);
    }
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



    public static function is_plugin($path)
    {
        if (is_file($path . "/.plugin")) {

            return true;
        } else return false;
    }

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
            }
        }

        return $plugins;
    }

    public static function getListPlugin()
    {

        $directory = $_SERVER["DOCUMENT_ROOT"] . self::$relativeDirectory;
        $listDir = scandir($directory);

        $plugins = [];

        foreach ($listDir as $child) {

            $pluginPath = $directory . "/$child";

            if (Plugin::is_plugin($pluginPath)) {

                $plugin = new Plugin($pluginPath);

                array_push($plugins, $plugin);
            }
        }

        return $plugins;
    }
}
