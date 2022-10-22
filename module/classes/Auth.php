<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */

namespace classes;

use PDO;

class AUTH {

    /**
     * Undocumented variable
     *
     * @var string $email - email account
     * @var string $password - password account
     */
    public string $email, $password;
    private PDO $DB;

    function __construct() {

        $conn = new CONN();
        $this->DB = $conn->PDO();
    }

    public function Login() {

        $stmt = $this->DB->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$this->email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {

            if(password_verify($this->password, $result['password'])) {

                return true;
            }
        }
    }
    public function Register() {

    }
    public function LostPassword() {

    }
    public function LostAccount() {

    }
}