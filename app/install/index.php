<?php
/**
 * Intallation code 
 * @Author @ilh4mb 
 */

if (0 == strcmp(strtolower($_SERVER["HTTP_SEC_FETCH_MODE"]), "cors")) {

    $message = null;

    if (isset($_POST['host'], $_POST['user'], $_POST['password'])) {

        $host = filter_input(INPUT_POST, "host", FILTER_UNSAFE_RAW);
        $user = filter_input(INPUT_POST, "user", FILTER_UNSAFE_RAW);
        $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
        $database = filter_input(INPUT_POST, "db", FILTER_UNSAFE_RAW);

        try {

            $DB = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($DB) {

                $text = "<?php\n### GENERATE BY SYSTEM\n\$host = \"$host\";\n\$database = \"$database\";\n\$user = \"$user\";\n\$pass = \"$password\";\n\n\$DB = null;\ntry {\n\n\t\$DB = new PDO(\"mysql:host=\$host;dbname=\$database\", \$user, \$pass);\n\t\$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n} catch (PDOException \$e) {\n\n\techo \"<h1>ERROR CONNECTION</h1>\n\t<h4>Message :</h4>\n\t<p>\".\$e->getMessage().\"</p>\t<a href='/mrp/install'>Fix with installer</a>\";\n\texit;\n}";

                $stream = fopen($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php", "w+");
                fwrite($stream, $text);
                fclose($stream);

                $sql = file_get_contents(__DIR__ . "/marapi.sql");

                if (is_file($_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php")) {


                    require_once $_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php";
                    /**
                     * @var PDO $DB - Database
                     */

                    $stmt = $DB->prepare($sql);
                    if ($stmt->execute()) {

                        $message = "success";
                    } else {

                        $message =  "ERROR";
                    }
                } else $message =  "ERROR";
            }
        } catch (PDOException $e) {

            switch ($e->getCode()) {
                case "1045":
                    $message = "<b>Error credential</b><br/>Account not found, please check username and password !.<br/>code : " . $e->getCode();
                    break;
                case "2002":
                    $message = "<b>Host Not Found</b><br/>host is not valid or not found, please check PHPMyAdmin host server.<br/>code : " . $e->getCode();
                    break;
                default:
                    $message = $e->getMessage();
            }
        }
    }

    if (isset($_POST['username'], $_POST['password'])) {

        $username = filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW);
        $password = filter_input(INPUT_POST, "password");
        $password = password_hash($password, PASSWORD_DEFAULT);

        try {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/core/connetion/PDO.php";
            /**
             * @var PDO $DB - Database
             */
            $sql = "INSERT INTO `users` (`username`, `password`, `role`) VALUES (?, ?, ?);";
            $stmt = $DB->prepare($sql);
            if ($stmt->execute([$username, $password, 1])) {
                $message = "success";
            } else $message = "ERROR";
        } catch (Exception $e) {

            $message = $e->getMessage();
        }
    }

    echo $message;
    exit;
}

echo file_get_contents(__DIR__."/index.html");