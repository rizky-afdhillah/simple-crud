<?php
    class Provinsi {
        public $namaProvinsi;
        public $namaIbuKota;
        public $luas;
        public $jumlahPenduduk;
        // private $namaProvinsi;
        // private $namaIbuKota;
        // private $luas;
        // private $jumlahPenduduk;

        public function print() { // membuat method print
            echo "</br></br>===  Method Print Awal ". $this->namaProvinsi . "  ===" . '</br>';
            echo "Nama Provinsi   : " . $this->namaProvinsi . '</br>';
            echo "Nama Ibu Kota   : " . $this->namaIbuKota . '</br>';
            echo "Luas            : " . $this->luas . '</br>';
            echo "Jumlah Penduduk : " . $this->jumlahPenduduk . '</br>';
            echo "===  Method Print Akhir  ===" . '</br>';
        }
        
        public function create() {
            echo "<br>"."INSERT INTO provinsi VALUES(
                '$this->namaProvinsi',
                '$this->namaIbuKota',
                '$this->luas',
                '$this->jumlahPenduduk',
            )";
        }
        public function read() {
            echo "<br>"."SELECT * FROM provinsi";
        }
        public function update() {
            echo "<br>"."UPDATE provinsi SET namaIbuKota = '$this->namaIbuKota',
                luas = $this->luas,
                jumlahPenduduk = $this->jumlahPenduduk
                WHERE namaProvinsi = '$this->namaProvinsi',
            ";
        }
        public function delete($namaProvinsi) {
            echo "<br>" . "DELETE FROM provinsi WHERE namaProvinsi = '$namaProvinsi'";
        }
    }
?>