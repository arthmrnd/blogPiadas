<?php

    class DB_Connection {

        private $conn;

        protected function connect() {

            $host = "127.0.0.1";
            $user = "root";
            $password = "";
            $dbname = "pdo";

            $dsn = 'mysql:host=' .  $host . ';dbname=' . $dbname;

            try {
                $this->conn = new PDO($dsn, $user, $password);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;
            } catch (PDOExeception $e) {
                echo "Conexão falha: " . $e->getMessage();
            }
        }
    }

?>
