<?php
/**
 * Copyright 2022 Ilham B
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace classes;

use Exception;
use PDO;

class AUTH {

    /**
     * Undocumented variable
     *
     * @var string $email - username or email account
     * @var string $password - password account
     */
    public string $email, $password;
    private PDO $DB;

    function __construct() {

        $conn = new CONN();
        $this->DB = $conn->_PDO();
    }

    public function Login() {

        $stmt = $this->DB->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute([$this->email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {

            if(password_verify($this->password, $result['password'])) {

                return $result;

            } else throw new Exception("Wrong password!!", 0);

        } else throw new Exception("Account not found!!", 0);
    }

    public function Register() {

    }

    public function LostPassword() {

    }
    
    public function LostAccount() {

    }
}