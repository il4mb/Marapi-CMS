<?php

namespace classes;

use Exception;

class Json {
    public $data;

    /**
     *
     * @param string $path - uri path to file json
     */
    function __construct($path) {

        if(file_exists($path) && is_file($path)) {

            $this->data = json_decode(file_get_contents($path), true);
            if(json_last_error()) {

                throw new Exception("Json Error reason file exist but file does't json");
            }
        }
    }

}