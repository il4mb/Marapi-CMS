<?php
namespace classes;

class THEME {

    public string $name, $author, $description;
    public array $params;

    public string $path;

    function __construct() {

        $this->path = $_SERVER['DOCUMENT_ROOT']."/app/theme/default";
        $this->params = [];
        $rawText = file_get_contents($this->path."/.theme");

        $rawText = explode("\r\n", $rawText);
        $rawText = array_values(array_filter($rawText,  function ($E) { return $E !== "" || $E != null; }));
        
        foreach( $rawText AS $key => $val ) {

            $param = explode("=", $val);
            $this->params[preg_replace("/[^a-z@]+/i", "", $param[0])] = preg_replace("/\s+/i", "", $param[1]);
        }

       // print_r($this->params);
    }

    function getActiveTheme() {

    }
}