<?php
/**
 * Intallation code 
 * @Author @ilh4mb 
 */

$html = file_get_contents("./index.html");

if(isset($_POST['host'], $_POST['user'], $_POST['password'])) {

    $host = filter_input(INPUT_POST, "host", FILTER_UNSAFE_RAW);
    $user = filter_input(INPUT_POST, "user", FILTER_UNSAFE_RAW);
    $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);

    try {

        $DB = new PDO("mysql:host=$host;dbname=marapi", $user, $password);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($DB) {

            $text = "<?php\n### GENERATE BY SYSTEM\n\$host = \"$host\";\n\$user = \"$user\";\n\$pass = \"$password\";\n\ntry {\n\n\t\$DB = new PDO(\"mysql:host=\$host;dbname=marapi\", \$user, \$pass);\n\t\$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n} catch (PDOException \$e) {\n\n\tprint \$e->getMessage();\n\texit;\n}";

            $stream = fopen($_SERVER['DOCUMENT_ROOT']."/core/connetion/PDO.php", "w+");
            fwrite($stream, $text);
            fclose($stream);
        }
    
    } catch (PDOException $e) {

        switch($e->getCode()) {
            case "1045" :
                $message = "<b>Error credential</b><br/>Account not found, please check username and password !.<br/>code : " . $e->getCode();
                break;
            case "2002": 
                $message = "<b>Host Not Found</b><br/>host is not valid or not found, please check PHPMyAdmin host server.<br/>code : " . $e->getCode();
                break;
            default: 
        }

        $html = str_replace("{MESSAGE}", textResponse($message, "danger"), $html);
    }

}





$html = str_replace("{MESSAGE}", "", $html);
echo $html;



function textResponse($txt, $class) {

    return "<div class='alert-$class'>$txt</div>";
}
