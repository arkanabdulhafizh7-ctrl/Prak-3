<?php
declare(strict_types=1);

/**
 * Sesi 3 — RekeningBank (PHP)
 */
class RekeningBank {

    // Konstanta
    public const BUNGA_TAHUNAN = 0.025;
    public const BIAYA_ADMIN = 5000;
    public const BATAS_PENARIKAN = 5_000_000;

    // Property statis
    private static int $jumlahRekening = 0;

    // Property instance
    private string $nomor;
    private string $pemilik;
    private float $saldo;

    /**
     * Constructor (menggunakan default parameter untuk saldo awal = 0)
     */
    public function __construct(string $nomor, string $pemilik, float $saldoAwal = 0.0) {
        if (trim($nomor) === '') {
            throw new InvalidArgumentException("Nomor rekening tidak boleh kosong");
        }
        if ($saldoAwal < 0) {
            throw new InvalidArgumentException("Saldo awal tidak boleh negatif");
        }

        $this->nomor = $nomor;
        $this->pemilik = $pemilik;
        $this->saldo = $saldoAwal;

        self::$jumlahRekening++;
    }

    public function setor(float $jumlah): void {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah setoran harus lebih dari 0");
        }
        $this->saldo += $jumlah;
    }

    public function tarik(float $jumlah): void {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah penarikan harus lebih dari 0");
        }
        if ($jumlah > self::BATAS_PENARIKAN) {
            throw new InvalidArgumentException("Melebihi batas penarikan sekali transaksi");
        }
        if ($jumlah > $this->saldo) {
            throw new InvalidArgumentException("Saldo tidak mencukupi");
        }
        $this->saldo -= $jumlah;
    }

    public function potongBiayaAdmin(): void {
        // Menggunakan 0.0 agar nilai kembalian tetap float
        $this->saldo = max(0.0, $this->saldo - self::BIAYA_ADMIN);
    }

    public static function getJumlahRekening(): int {
        return self::$jumlahRekening;
    }

    public static function bungaSetahun(float $pokok): float {
        return $pokok * self::BUNGA_TAHUNAN;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getNomor(): string {
        return $this->nomor;
    }

    public function __toString(): string {
        $formattedSaldo = "Rp" . number_format($this->saldo, 2, '.', ',');
        return sprintf("Rekening[%s] %-14s %s", $this->nomor, $this->pemilik, $formattedSaldo);
    }
}

// KODE EKSEKUSI PROGRAM
echo "Jumlah rekening di awal: " . RekeningBank::getJumlahRekening() . "\n";

$rek1 = new RekeningBank("111", "Ani", 1_000_000);
$rek2 = new RekeningBank("222", "Budi");
$rek3 = new RekeningBank("333", "Citra", 250_000);

echo $rek1 . "\n";
echo $rek2 . "\n";
echo $rek3 . "\n";
echo "Jumlah rekening sekarang: " . RekeningBank::getJumlahRekening() . "   (seharusnya 3, bukan 4)\n\n";

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

$bungaAni = "Rp" . number_format(RekeningBank::bungaSetahun($rek1->getSaldo()), 2, '.', ',');
echo "Bunga setahun dari saldo Ani: " . $bungaAni . "\n";