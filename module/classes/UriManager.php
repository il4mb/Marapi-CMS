<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

namespace classes;

class UriManager {

    public $path, $query;

    function __construct() {

        $this->path = $_SERVER['REQUEST_URI'];
        $exploded = explode("?", $this->path);

        $this->path = array_key_exists(0, $exploded) ? $exploded[0] : null;
        $this->query = array_key_exists(1, $exploded) ? $exploded[1] : null;
    }

    public function in_array() {

        
        return array_slice(explode("/", $this->path), 1);
    }

}
