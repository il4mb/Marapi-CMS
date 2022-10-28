<?php

namespace classes;

class THEME
{

    public string $name, $author, $description;
    public array $params;

    public string $path;

    function __construct($rawText)
    {
        if ($rawText) {

            $rawText = explode("\r\n", $rawText);
            $rawText = array_values(array_filter($rawText,  function ($E) {
                return $E !== "" || $E != null;
            }));

            foreach ($rawText as $key => $val) {

                $param = explode("=", $val);

                if (str_contains($param[0], "#")) {

                    $this->params[preg_replace("/[^a-z@]+/i", "", $param[0])] = str_replace(' ', '', $param[1]);
                } else $this->params[preg_replace("/[^a-z@]+/i", "", $param[0])] = $param[1];
            }
        }
        // print_r($this->params);
    }

    /**
     * getActiveTheme()
     *
     * @return THEME - will return active THEME object
     */
    public static function getActiveTheme(): THEME
    {
        $conf_path = $_SERVER['DOCUMENT_ROOT'] . "/conf-data.json";

        $json = new Json($conf_path);

        $pathActive = $_SERVER['DOCUMENT_ROOT'] . $json->data['theme'];

        if (file_exists($pathActive . "/.theme") && is_file($pathActive . "/.theme")) {

            $theme = new THEME(file_get_contents($pathActive . "/.theme"));
            $theme->path = $_SERVER['DOCUMENT_ROOT'] . $json->data['theme'];
            return $theme;
        }
    }

    function getList(): array
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
                $listTheme[$key]->path = $this->path . "/$val";
            }
        }

        return $listTheme;
    }
}
