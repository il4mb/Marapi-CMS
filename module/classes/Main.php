<?php
namespace classes;

class Main {
    
    public THEME $theme;

    function __construct() {
     
        $this->theme = new THEME(null);
        $this->theme->getActiveTheme();

        $view = new VIEW($this);
        $view->brand("TOKO MINYAK");
        $view->render();
    }
}