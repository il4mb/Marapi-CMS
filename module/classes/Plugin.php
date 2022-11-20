<?php
namespace classes;

class Plugin {

    public $path = null;
    private static $relativeDirectory = "/app/plugin";


    function __construct($path) {

        
        if(is_file($path."/.plugin")) {

            $metaText = file_get_contents($path."/.plugin");
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

    public function module() {

        if($this->path && is_file($this->path."/module.php")) {

            return include_once($this->path."/module.php");

        } else {

            echo "Error: Cant call plugin module";
        }
    }

    public function callOnPanel() {

        $this->module()->onPanel();
    }

    public function callOnFront(Main $main) {
        
        $this->module()->onFront($main);
    }

    

    public static function is_plugin($path) {
        if(is_file($path."/.plugin")) {

            return true;

        } else return false;
    }

    public static function getListPlugin() {

        $directory = $_SERVER["DOCUMENT_ROOT"].self::$relativeDirectory;
        $listDir = scandir($directory);

        $plugins = [];

        foreach($listDir AS $child) {

            $pluginPath = $directory."/$child";
        
            if (Plugin::is_plugin($pluginPath)) {
                
                $plugin = new Plugin($pluginPath);

                array_push($plugins, $plugin);
        
            }
            
        }

        return $plugins;
    }
}