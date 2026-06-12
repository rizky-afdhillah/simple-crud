<?php
class Karyawan
{
    private $nik;
    private $nama;
    private $jabatan;
    private $gajiPokok;

    public function __construct($nik, $nama, $jabatan, $gajiPokok)
    {
        $this->nik = $nik;
        $this->nama = $nama;
        $this->jabatan = $jabatan;
        $this->gajiPokok = $gajiPokok;

        echo "Objek Karyawan Berhasil <br>";
    }

    public function setNik($nik)
    {
        $this->nik = $nik;
    }
    public function setNama($nama)
    {
        $this->nama = $nama;
    }
    public function setJabatan($jabatan)
    {
        $this->jabatan = $jabatan;
    }
    public function setgajiPokok($gajiPokok)
    {
        $this->gajiPokok = $gajiPokok;
    }

    public function getNik()
    {
        return $this->nik;
    }
    public function getNama()
    {
        return $this->nama;
    }
    public function getJabatan()
    {
        return $this->jabatan;
    }
    public function getgajiPokok()
    {
        return $this->gajiPokok;
    }

    public function cetakSlipGaji()
    {
        echo "<br>=== Cetak Slip Gaji ===<br>";
        echo "<br> Nik Karyawan : " . $this->nik;
        echo "<br> Nama Karyawan : " . $this->nama;
        echo "<br> Jabatan Karyawan : " . $this->jabatan;
        echo "<br> Gaji Pokok Karyawan : " . $this->gajiPokok;
        echo "<br>===  ===<br>";
    }
}
