<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

use classes\AUTH;

require_once $_SERVER['DOCUMENT_ROOT']."/module/init.php";

if(isset($_POST['email'], $_POST['password'])) {

    $AUTH = new AUTH();
    $AUTH->email = filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW);
    $AUTH->password = $_POST['password'];

    try {

        if($AUTH->Login()) {

            header("Location: /mrp/dashboard/");
        }

    } catch (Exception $e) {

        print $e->getMessage();
    }
}

?>
<!DOCTYPE html>
