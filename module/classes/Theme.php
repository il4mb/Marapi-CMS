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
        $conf_path = $_SERVER['SELF_ROOT'] . "/conf-data.json";

        $json = new Json($conf_path);
        $pathActive = $_SERVER['SELF_ROOT'] . $json->data['theme'];
        
        return self::getThemeFromPath($pathActive);
        
    }

    function getList(): array
    {

        $listTheme = [];

        $this->path = $_SERVER['SELF_ROOT'] . "/app/theme";
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
