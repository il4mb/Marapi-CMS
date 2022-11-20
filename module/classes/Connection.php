<?php

namespace classes;

use PDO;

class CONN
{
    public function _PDO()
    {
        global $DB;
        /**
         * @var PDO $DB
         */

        if (is_file($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php")) {

            if(require_once($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php"))
                return $DB;
            else 
                echo "unable to call database";

        } else {

            header("Location: /mrp/install/");
        }
    }
}
