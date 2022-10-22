<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

try {

    $DB = new PDO("mysql:host=localhost;dbname=marapi", 'root');
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    print $e;
    exit;
}