<?php
<<<<<<< HEAD
class Database
=======
class Database 
>>>>>>> a4072cd983b289ffe41b0c21180963848299e333
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
<<<<<<< HEAD
    private $db   = "db_simple_crud";
    public $conn;

    public function __construct()
=======
    private $db   = "db_lsp_kit";
    public $conn;

    public function __construct() 
>>>>>>> a4072cd983b289ffe41b0c21180963848299e333
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal");
        }
    }

<<<<<<< HEAD
    public function query($sql)
=======
    public function query($sql) 
>>>>>>> a4072cd983b289ffe41b0c21180963848299e333
    {
        return $this->conn->query($sql);
    }

<<<<<<< HEAD
    public function escape($str)
    {
        return $this->conn->real_escape_string($str);
    }
}
=======
    public function escape($str) 
    {
        return $this->conn->real_escape_string($str);
    }
}
>>>>>>> a4072cd983b289ffe41b0c21180963848299e333
