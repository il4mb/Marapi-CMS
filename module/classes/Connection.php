<?php

namespace classes;

use PDO, PDOException;

class CONN
{

    public PDO $DB;
    public function PDO(): PDO
    {

        if (is_file($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php")) {
            try {
                require_once $_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php";
                /**
                 * @var PDO $DB - Database connection
                 */
                $this->DB = $DB;
                return $this->DB;
            } catch (PDOException $e) {

                print $e;
                exit;
            }
        } else {
            
            header("Location: /mrp/install/");
        }
    }
}
