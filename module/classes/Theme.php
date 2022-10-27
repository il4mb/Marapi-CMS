<?php

namespace classes;

class THEME
{

    public string $name, $author, $description;
    public array $params;

    public string $path;

    function __construct($rawText)
    {
        if (! $rawText) {

          //  $this->path = $_SERVER['DOCUMENT_ROOT'] . "/app/theme";
          //  $this->params = [];
            //$rawText = file_get_contents($this->path . "/.theme");

        }

        $rawText = explode("\r\n", $rawText);
        $rawText = array_values(array_filter($rawText,  function ($E) {
            return $E !== "" || $E != null;
        }));

        foreach ($rawText as $key => $val) {

            $param = explode("=", $val);
            $this->params[preg_replace("/[^a-z@]+/i", "", $param[0])] = $param[1];
        }
        // print_r($this->params);
    }

    function getActiveTheme()
    {
        
    }

    function getList() : array
    {

        $listTheme = [];

        $this->path = $_SERVER['DOCUMENT_ROOT'] . "/app/theme";
        $path = $this->path;

        if (file_exists($this->path)) {

            $list = scandir($this->path);
            $list = array_values(array_filter($list, function ($value) use ($path) {
                return file_exists($path . "/" . $value . "/.theme") && is_file($path . "/" . $value . "/.theme");
            }));

            foreach ($list as $key => $val) {

                $rawText = file_get_contents($this->path . "/$val/.theme");

                $listTheme[$key] = new THEME($rawText);
            }
        }

        return $listTheme;
    }
}
