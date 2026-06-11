<?php
class Provinsi
{
    // public $namaProvinsi;
    // public $namaIbuKota;
    // public $luas;
    // public $jumlahPenduduk;
    // Semua Atribute harus Private
    private $namaProvinsi;
    private $namaIbuKota;
    private $luas;
    private $jumlahPenduduk;


    // Method Automatis Berjalan
    public function __construct()
    {
        echo "<br>=== Ini Method Constructor Awal ===";
        echo "<br>=== Objek dipanggil, Konstruksi Berjalan ===";
        echo "<br>=== Ini Method Constructor Akhir ===<br>";
    }


    // Method setter
    public function setNamaProvinsi($namaProvinsi)
    {
        $this->namaProvinsi = $namaProvinsi;
    }
    public function setNamaIbuKota($namaIbuKota)
    {
        $this->namaIbuKota = $namaIbuKota;
    }
    public function setLuas($luas)
    {
        $this->luas = $luas;
    }
    public function setJumlahPenduduk($jumlahPenduduk)
    {
        $this->jumlahPenduduk = $jumlahPenduduk;
    }

    // method getter
    public function getNamaProvinsi()
    {
        return $this->namaProvinsi;
    }
    public function getNamaIbuKota()
    {
        return $this->namaIbuKota;
    }
    public function getLuas()
    {
        return $this->luas;
    }
    public function getJumlahPenduduk()
    {
        return $this->jumlahPenduduk;
    }



    public function print()
    { // membuat method print
        echo "</br></br>===  Method Print Awal " . $this->namaProvinsi . "  ===" . '</br>';
        echo "Nama Provinsi   : " . $this->namaProvinsi . '</br>';
        echo "Nama Ibu Kota   : " . $this->namaIbuKota . '</br>';
        echo "Luas            : " . $this->luas . '</br>';
        echo "Jumlah Penduduk : " . $this->jumlahPenduduk . '</br>';
        echo "===  Method Print Akhir  ===" . '</br>';
    }

    public function create()
    {
        echo "<br>" . "INSERT INTO provinsi VALUES(
                '$this->namaProvinsi',
                '$this->namaIbuKota',
                '$this->luas',
                '$this->jumlahPenduduk',
            )";
    }
    public function read()
    {
        echo "<br>" . "SELECT * FROM provinsi";
    }
    public function update()
    {
        echo "<br>" . "UPDATE provinsi SET namaIbuKota = '$this->namaIbuKota',
                luas = $this->luas,
                jumlahPenduduk = $this->jumlahPenduduk
                WHERE namaProvinsi = '$this->namaProvinsi',
            ";
    }
    public function delete($namaProvinsi)
    {
        echo "<br>" . "DELETE FROM provinsi WHERE namaProvinsi = '$namaProvinsi'";
    }
}
