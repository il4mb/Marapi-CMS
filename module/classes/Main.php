<?php
namespace classes;

class Main {
    
    public THEME $theme;

    function __construct() {
     
        $this->theme = new THEME();
        $this->theme->getActiveTheme();

        $view = new VIEW($this);
        $view->render();
    }
}