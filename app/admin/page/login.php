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

        $AUTH->Login();
    } catch (Exception $e) {

        print $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/admin/asset/css/style.css">
    <title>Login Marapi</title>
</head>

<body>
    <div class="container align-center">

        <img class="mrp-logo" src="/core/assets/svg/Marapi-logo.svg"/>
        <h1>Login to panel</h1>

        <form data-width="100" method="POST">

            <input name="email" type="text" placeholder="Enter email address" required />
            <input name="password" type="password" placeholder="Enter password" required />
            <input type="submit" value="login"/>

        </form>
    </div>
</body>

</html>