<?php

namespace classes;

use DOTNET;

class DOCUMENT
{

    private $html, $head, $body, $menu = [];
    function __construct($html)
    {

        $this->setDocument($html);
    }

    function setDocument($html) {

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

            include_once $php;
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

        return "<!DOCTYPE html>\r\n<html>\n  <head>\n" . $this->head . "\n  </head>\n  <body>\n" . $this->body . "\n  </body>\n</html>";
    }
}
