<?php
    class App {
        public $db;

        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "db_simple_crud");
            if ($this->db->connect_error) {
                die("Koneksi Gagal");
            }
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
        public function select($sql) {
            return $this->db->query($sql);
        }
        public function single($sql) {
            $result = $this->db->query($sql);
            return $result ? $result->fetch_assoc() : null;
        }
        public function execute($sql) {
            return $this->db->query($sql);
        }
        public function safe($str) {
            return $this->db->real_escape_string($str);
        }
    }
?>
