<?php
//namespace classes;

class UriManager {

    public string $path, $query;

    function __construct() {

        $this->path = $_SERVER['REQUEST_URI'];
        $exploded = explode("?", $this->path);

        $path = array_key_exists(0, $exploded) ? $exploded[0] : null;
        $query = array_key_exists(1, $exploded) ? $exploded[1] : null;
    }

    public function in_array() {

        return explode("/", $this->path);
    }

}
