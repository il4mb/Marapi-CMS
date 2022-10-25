<?php

namespace classes;

class DOCUMENT
{

    public string $html, $head, $body;
    function __construct($html) {

        $this->html = $html;
        if (preg_match('/(?:<head[^>]*>)(.*)<\/head>/isU', $this->html, $match)) $this->head = $match[1];
        if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $this->html, $match)) $this->body = $match[1];
    }

    function getHead() {

        return $this->head;
    }

    function getBody() {

        return $this->body;
    }

    function setControler($php) {

        if(is_file($php)) {
            
            include_once $php;
        }
    }

    /**
     * render new html document
     *
     * @return string final HTML
     */
    function render() {
        return "<!DOCTYPE html>\r\n<html>\n  <head>\n".$this->head."\n  </head>\n  <body>\n".$this->body."\n  </body>\n</html>";
    }
}
