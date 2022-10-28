<?php
namespace classes;

class Main {
    
    public THEME $theme;

    function __construct() {
     
        $this->theme = THEME::getActiveTheme();

        $view = new VIEW($this);
        $view->brand("TOKO MINYAK");
        $view->render();
    }
}