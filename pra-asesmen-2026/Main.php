<?php
include 'Provinsi.php'; // Pangggil File Provinsi
include 'Handphone.php'; // Pangggil File Provinsi

// Class Handphone
$handphoneKu = new Handphone();
$handphoneMu = new Handphone();

$handphoneKu->merk = "Xiaomi 14T";
$handphoneKu->ram = 12;
$handphoneKu->kapasitasBaterai = 5500;
$handphoneKu->sistemOperasi = "HyperOS 10.3";

// Class Provinsi (definisi)
$kalimantanSelatan = new Provinsi(); // Definisikan Object Kalse   dari class Provinsi
$kalimantanTengah = new Provinsi(); //  Definisikan Object Kalteng dari class Provinsi

// Object Kalteng
$kalimantanSelatan->setNamaProvinsi("Kalimantan Selatan");
$kalimantanSelatan->setNamaIbuKota("Kota Banjarbaru");
$kalimantanSelatan->setLuas("38744");
$kalimantanSelatan->setJumlahPenduduk("4205816");

// Menjalankan Method Kalsel
$kalimantanSelatan->print();
$kalimantanSelatan->create();
$kalimantanSelatan->read();
$kalimantanSelatan->update();
$kalimantanSelatan->delete("Kalimantan Selatan");

// Object Kalteng
$kalimantanTengah->setNamaProvinsi("Kalimantan Tengah");
$kalimantanTengah->setNamaIbuKota("Kota Palangka Raya");
$kalimantanTengah->setLuas("153564.50");
$kalimantanTengah->setJumlahPenduduk("2741100");

// Menjalankan Method Kalteng
$kalimantanTengah->print();
$kalimantanTengah->create();
$kalimantanTengah->read();
$kalimantanTengah->update();
$kalimantanTengah->delete("Kalimantan Tengah");
