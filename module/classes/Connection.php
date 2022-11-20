<?php
namespace classes;
use PDO, PDOException;
class CONN {

    public PDO $DB;
    public function PDO() : PDO {
        try {

            require_once $_SERVER['DOCUMENT_ROOT']."/core/connetion/PDO.php";
            /**
             * @var PDO $DB - Database connection
             */
            $this->DB = $DB;
            return $this->DB;
            
        
        } catch (PDOException $e) {
        
            print $e;
            exit;
        }
    }
}