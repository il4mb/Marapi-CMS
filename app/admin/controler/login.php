<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

use classes\AUTH;
use Module\classes\ENCH;

require_once $_SERVER['DOCUMENT_ROOT']."/module/init.php";

if(isset($_POST['email'], $_POST['password'])) {

    $AUTH = new AUTH();
    $AUTH->email = filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW);
    $AUTH->password = $_POST['password'];

    try {

        $login = $AUTH->Login();

        if($login) {

            $ench = new ENCH($login);
            setcookie('user', $ench->encrypt(), time() + (86400 * 30), '/');

            header("Location: /mrp/dashboard/");
        }

    } catch (Exception $e) {

        print $e->getMessage();
    }
}
