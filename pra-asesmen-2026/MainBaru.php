<?php
include "ProvinsiBaru.php";
$pb = new ProvinsiBaru();
$pb->setNamaProvinsi("Nusantara");
$pb->setProvinsiAsal("Kalimantan Timur");
$pb->setNamaIbuKota("IKN");
$pb->setLuas("138744");
$pb->setJumlahPenduduk("500");
$pb->print();
