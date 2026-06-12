<?php
include "Produk.php";

class ProdukDigital extends Produk
{
    private $ukuranFile;

    public function __construct($idProduk, $namaProduk, $harga, $ukuranFile)
    {
        parent::__construct($idProduk, $namaProduk, $harga);
        $this->ukuranFile = $ukuranFile;
    }

    public function setUkuranFile($ukuranFile)
    {
        $this->ukuranFile = $ukuranFile;
    }
    public function getUkuranFile()
    {
        return $this->ukuranFile;
    }

    public function tampilkanInfo()
    {
        parent::tampilkanInfo();
        echo "<br>Ukuran File : " . $this->ukuranFile . 'MB';
        echo "<br>======================== <br>";
    }
}
