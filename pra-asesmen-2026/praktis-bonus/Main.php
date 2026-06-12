<?php
include_once "ProdukDigital.php";

$ProdukDigital = new ProdukDigital(1, 'Komputer', 15000000, 5);

$ProdukDigital->setNamaProduk('Leptop Gaming');
$ProdukDigital->setHarga(13000000);
$ProdukDigital->tampilkanInfo();
// Done 15 Menit