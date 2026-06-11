<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "db_lsp_kit";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal");
        }
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function escape($str)
    {
        return $this->conn->real_escape_string($str);
    }
}
