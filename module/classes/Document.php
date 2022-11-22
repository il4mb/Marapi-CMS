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

class DOCUMENT
{

    private $html, $head, $body, $menu = [], $container= "";
    function __construct($html)
    {

        if ($html != null)
            $this->setDocument($html);
    }

    function setDocument($html)
    {

        $this->html = $html;
        if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $this->html, $match)) $this->head = $match[1];
        if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $this->html, $match)) $this->body = $match[1];
    }

    function setMenu($menu)
    {
        $this->menu = $menu;
    }
    function getMenu()
    {
        return $this->menu;
    }

    function setHead($html)
    {
        $this->head = $html;
    }
    function getHead()
    {

        return $this->head;
    }

    function setBody($html)
    {
        $this->body = $html;
    }
    function getBody()
    {

        return $this->body;
    }

    function setControler($php)
    {

        if (is_file($php)) {

            $this->container = include_once $php;
        }
    }

    /**
     * render new html document
     *
     * @return string final HTML
     */
    function render()
    {
       
        $this->body = str_replace("[{MENUS}]", implode("\n", $this->menu), $this->body);
        $this->body = str_replace("[{CONTAINER}]", $this->container, $this->body);

        if(strlen($this->body) > 0 && strlen($this->head) > 0) {
            
            return "<!DOCTYPE html>\r\n<html>\n  <head>\n" . $this->head . "\n  </head>\n  <body>\n" . $this->body . "\n  </body>\n</html>";
        } else if(strlen($this->container) > 0) return $this->container; 
    }
}
