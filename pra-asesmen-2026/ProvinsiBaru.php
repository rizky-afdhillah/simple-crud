<?php
include "Provinsi.php";
class ProvinsiBaru extends Provinsi
{
    private $provinsiAsal;
    public function setProvinsiAsal($provinsiAsal)
    {
        $this->provinsiAsal = $provinsiAsal;
    }
    public function getProvinsiAsal()
    {
        return $this->provinsiAsal;
    }

    public function print()
    {
        echo "</br></br>===  Method Print Provinsi Baru " . $this->provinsiAsal . "  ===" . '</br>';
        echo "Posisi Asal     : " . $this->provinsiAsal . '</br>';
        echo "Nama Provinsi   : " . $this->getNamaProvinsi() . '</br>';
        echo "Nama Ibu Kota   : " . $this->getNamaIbuKota() . '</br>';
        echo "Luas            : " . $this->getLuas() . '</br>';
        echo "Jumlah Penduduk : " . $this->getJumlahPenduduk() . '</br>';
        echo "===  Method Print Akhir  ===" . '</br>';
    }
}
