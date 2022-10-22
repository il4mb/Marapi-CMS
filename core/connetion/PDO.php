<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

try {

    $PDO = new PDO("mysql:host=localhost;dbname=marapi", 'root');
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    print $e;
    exit;
}