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

        
    }

    public static function getThemeFromPath($path) {

        if (file_exists($path . "/.theme") && is_file($path . "/.theme")) {

            $theme = new THEME(file_get_contents($path . "/.theme"));
            $theme->path = $path;
            return $theme;

        } else echo "path does't containt Theme";

    }

    /**
     * getActiveTheme()
     *
     * @return THEME - will return active THEME object
     */
    public static function getActiveTheme()
    {
        $conf_path = $_SERVER['DOCUMENT_ROOT'] . "/conf-data.json";

        $json = new Json($conf_path);
        $pathActive = $_SERVER['DOCUMENT_ROOT'] . $json->data['theme'];
        
        return self::getThemeFromPath($pathActive);
        
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

            $active = THEME::getActiveTheme();

            foreach ($list as $key => $val) {

                $rawText = file_get_contents($this->path . "/$val/.theme");

                $listTheme[$key] = new THEME($rawText);
                $listTheme[$key]->path = $path . "/$val";
                if($active && 0 == strcmp(strtolower($active->path), strtolower($listTheme[$key]->path))) {
                    $listTheme[$key]->active = true;
                } else $listTheme[$key]->active = false;

            }
        }

        return $listTheme;
    }
}
