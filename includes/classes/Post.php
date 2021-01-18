<?php

    class Post extends DB_Connection {

        private $conn;
        private $errorArray;

        public function __construct() {
            $this->conn = $this->connect();
            $this->errorArray = array();
        }

        public function getAllPosts() {
            $sql = "SELECT * FROM posts";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([]);
            $result = $stmt->fetchAll();

            return $result;
        }

        //função para postar
        public function insertPost($user, $title, $details) {

            //user_id, title, detalhes, data
            $date = date("Y-m-d"); // formato YYYY-mm-dd

            $sql = "INSERT INTO posts(title, details, user_id, created_at) VALUES(?,?,?,?)";
            $stmt = $this->conn->prepare($sql);

            try {
                $stmt->execute([$title, $details, $user, $date]);
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
        //função para apagar
        public function deletePost($post_id) {
            $sql = "DELETE FROM posts where id = ?";
            $stmt = $this->conn->prepare($sql);

            try {
                $stmt->execute([$post_id]);
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
    }
?>