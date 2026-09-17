<?php
declare(strict_types=1);

require_once 'RekeningBank.php';

echo "Jumlah rekening di awal: " . RekeningBank::getJumlahRekening() . "\n";

$rek1 = new RekeningBank("111", "Ani", 1_000_000);
$rek2 = new RekeningBank("222", "Budi");
$rek3 = new RekeningBank("333", "Citra", 250_000);

echo $rek1 . "\n";
echo $rek2 . "\n";
echo $rek3 . "\n";
echo "Jumlah rekening sekarang: " . RekeningBank::getJumlahRekening() . "   (seharusnya 3)\n\n";

echo "=== Operasi ===\n";
$rek1->setor(500_000);
echo "Setelah setor 500.000 -> " . $rek1 . "\n";

try {
    $rek1->tarik(6_000_000);
} catch (InvalidArgumentException $e) {
    echo "Ditolak: " . $e->getMessage() . "\n";
}

$rek2->potongBiayaAdmin();
echo "Budi setelah potong admin: " . $rek2 . "   (saldo tidak boleh negatif)\n";

$bungaAni = "Rp" . number_format(RekeningBank::bungaSetahun($rek1->getSaldo()), 2, ',', '.');
echo "Bunga setahun dari saldo Ani: " . $bungaAni . "\n";