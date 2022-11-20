<?php

namespace classes;

use PDO;

class CONN
{
    public function _PDO(): PDO
    {
        global $DB;

        if (is_file($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php")) {

            /**
             * @var PDO $DB - Database
             */
            require_once($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php");
            return $DB;

        } else {

            header("Location: /mrp/install/");
        }
    }
}
