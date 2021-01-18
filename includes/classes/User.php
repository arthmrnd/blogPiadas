<?php

    class User extends DB_Connection {

        private $conn;
        private $loginErrorArray;
        private $registerErrorArray;

        public function __construct() {
            $this->conn = $this->connect();
            $this->loginErrorArray = array();
            $this->registerErrorArray = array();
        }
        //Passa info do login para a db
        public function login($email, $password) {

            $password = md5($password);
            $sql = "SELECT id, name, surname, email FROM users where email = ? and password = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch();

            if ($user == null) {
                array_push($this->loginErrorArray, "O email ou senha são inválidos");
            }

            return $user;

        }

        public function register($name, $surname, $email, $password) {
            $this->validateFirstName($name);
            $this->validateLastName($surname);
            $this->validateEmail($email);
            $this->validatePassword($password);
            
            if (empty($this->registerErrorArray) == true) {
                return $this->insertUserDetails($name, $surname, $email, $password);
            } else {
                return null;
            }
        }

        public function insertUserDetails($name, $surname, $email, $password) {
            //Encriptar a senha
            $password = md5($password);

            $sql = "INSERT INTO users(name, surname, email, password) values(?,?,?,?)";
            $stmt = $this->conn->prepare($sql);

            try {
                $stmt->execute([$name, $surname, $email, $password]);
                $last_id = $this->conn->lastInsertId();
                $user = new stdClass(); 
                $user->id = $last_id;
                $user->name = $name;
                $user->surname = $surname;
                $user->email = $email;
                //$user->password = $password;

                return $user;

            } catch (Exception $ex) {
                return null;
            }

        }

        //valida os registros inseridos
        public function validateFirstName($name) {
            if (strlen($name) < 4 || strlen($name) > 25) {
                array_push($this->registerErrorArray, "O nome deve estar entre 4 e 25 caracteres.");
                return;
            }
        }

        public function validateLastName($surname) {
            if (strlen($surname) < 4 || strlen($surname) > 25) {
                array_push($this->registerErrorArray, "O sobrenome deve estar entre 4 e 25 caracteres.");
                return;
            }
        }

        public function validateEmail($email) { //VALIDAR O EMAIL
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($this->registerErrorArray, "Deve informar um email valido.");
                return;
            }

            $sql = "SELECT email FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetch();

            if ($result != null) {
                array_push($this->registerErrorArray, "Este email já esta cadastrado");
                return;
            }
        }

        public function validatePassword($password) {
            if (strlen($password) < 8 || strlen($surname) > 30) {
                array_push($this->registerErrorArray, "A senha deve conter entre 8 e 30 caracteres.");
                return;
            }
        }


        public function getLoginErrors() {

            //Checando se existe algo em $loginErrorArray
            if (!empty($this->loginErrorArray)) {
                $error = $this->loginErrorArray[0];
            return "<div class='alert alert-danger' role='alert'>$error</div>";
            }
        }

        public function getRegisterErrors() {
            return $this->registerErrorArray;
        }

        public function getName($user_id) {
            $sql = "SELECT name FROM users where id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            if ($user == null) {
                return null;
            }

            return $user->name;
        }

    }

?>