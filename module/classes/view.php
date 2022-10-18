<?php

/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

namespace classes;

class VIEW
{

    public String $html;

    function __construct(Main $main)
    {

        $path = $main->theme->path;
        $this->html = file_get_contents($path . "/" . $main->theme->params['main']);
    }

    public function render()
    {
        echo $this->html;
    }
}
