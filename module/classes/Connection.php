<?php
namespace classes;
use PDO, PDOException;
class CONN {

    public PDO $BD;
    public function PDO() : PDO {
        try {

            return new PDO("mysql:host=localhost;dbname=marapi", 'root');
            
        
        } catch (PDOException $e) {
        
            print $e;
            exit;
        }
    }
}