<?php

include 'Karyawan.php';

class KaryawanKontrak extends Karyawan
{
    private $durasiKontrak;

    public function __construct($nik, $nama, $jabatan, $gajiPokok, $durasiKontrak)
    {
        parent::__construct($nik, $nama, $jabatan, $gajiPokok);
        $this->durasiKontrak = $durasiKontrak;
    }

    public function setDurasiKontrak($durasiKontrak)
    {
        $this->durasiKontrak = $durasiKontrak;
    }

    public function getDurasiKontrak()
    {
        return $this->durasiKontrak;
    }

    public function cetakSlipGaji()
    {
        parent::cetakSlipGaji();
        echo "<br> Durasi Kerja Karyawan : " . $this->durasiKontrak;
        echo "<br>===  ===<br>";
    }
}
