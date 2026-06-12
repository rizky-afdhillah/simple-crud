<?php

class Produk
{
    private $idProduk;
    private $namaProduk;
    private $harga;

    public function __construct($idProduk, $namaProduk, $harga)
    {
        $this->idProduk = $idProduk;
        $this->namaProduk = $namaProduk;
        $this->harga = $harga;

        echo 'Sistem: Produk Berhasil Ditambahkan<br>';
    }

    public function setIdProduk($idProduk)
    {
        $this->idProduk = $idProduk;
    }
    public function setNamaProduk($namaProduk)
    {
        $this->namaProduk = $namaProduk;
    }
    public function setHarga($harga)
    {
        $this->harga = $harga;
    }

    public function getIdProduk()
    {
        return $this->idProduk;
    }
    public function getNamaProduk()
    {
        return $this->namaProduk;
    }
    public function getHarga()
    {
        return $this->harga;
    }

    public function tampilkanInfo()
    {
        echo "<br>=== INFORMASI Produk === <br>";
        echo "<br>ID Produk : " . $this->idProduk;
        echo "<br>Nama Produk : " . $this->namaProduk;
        echo "<br>Harga : " . $this->harga;
    }
}
