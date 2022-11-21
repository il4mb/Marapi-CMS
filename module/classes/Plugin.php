<?php

/**
 * @author @ilh4mb
 */

namespace classes;

use Exception;
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

    /**
     * module()
     * - call theme module
     * @return PluginInterface of plugin module
     */
    public function module()
    {

        if ($this->path && is_file($this->path . "/module.php")) {

            return include_once($this->path . "/module.php");
        } else {

            echo "Error: Cant call plugin module";
        }
    }

    /**
     * callOnPanel()
     * - call this plugin on admin panel
     */
    public function callOnPanel()
    {

        $this->module()->onPanel();
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

                array_push($plugins, $plugin);
            }
        }

        return $plugins;
    }
}
