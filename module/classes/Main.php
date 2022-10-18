<?php
namespace classes;

class Main {
    
    public THEME $theme;

    function __construct() {
     
        $this->theme = new THEME();
    }
}