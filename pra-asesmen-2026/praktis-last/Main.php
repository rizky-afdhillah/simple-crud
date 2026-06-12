<?php

include 'KaryawanKontrak.php';
$karyawanKontrak = new KaryawanKontrak('6371042702010007', 'Rizky Afdhillah', 'IT Programmer', 10000000, 5);

$karyawanKontrak->setNama('Jokowi');
$karyawanKontrak->setJabatan('Presiden');
$karyawanKontrak->cetakSlipGaji();
// 21 Menit