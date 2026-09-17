/**
 * Sesi 3 — constructor berdelegasi, anggota statis, dan konstanta.
 *
 * Invariant:
 *   1. saldo tidak pernah negatif
 *   2. nomor rekening tidak berubah setelah objek dibuat
 *   3. setoran dan penarikan selalu bernilai positif
 */
public class RekeningBank {

    // TODO 1 -> konstanta bernama (selesai)
    public static final double BUNGA_TAHUNAN = 0.025;
    public static final double BIAYA_ADMIN = 5000;
    public static final double BATAS_PENARIKAN = 5_000_000;

    // TODO 2 -> penghitung jumlah rekening (selesai)
    private static int jumlahRekening = 0;

    private final String nomor;
    private final String pemilik;
    private double saldo;

    /**
     * Constructor ringkas.
     * TODO 3 -> delegasi ke constructor lengkap (selesai)
     */
    public RekeningBank(String nomor, String pemilik) {
        this(nomor, pemilik, 0);   // delegasi: validasi & increment counter cukup di constructor lengkap
    }

    /** Constructor lengkap — SATU-SATUNYA tempat validasi berada. */
    public RekeningBank(String nomor, String pemilik, double saldoAwal) {
        // TODO 4 -> validasi (selesai)
        if (nomor == null || nomor.isBlank()) {
            throw new IllegalArgumentException("Nomor rekening tidak boleh kosong");
        }
        if (saldoAwal < 0) {
            throw new IllegalArgumentException("Saldo awal tidak boleh negatif");
        }

        this.nomor = nomor;
        this.pemilik = pemilik;
        this.saldo = saldoAwal;

        // TODO 5 -> naikkan counter DI SINI SAJA (selesai)
        jumlahRekening++;
    }

    public void setor(double jumlah) {
        // TODO 6 -> selesai
        if (jumlah <= 0) {
            throw new IllegalArgumentException("Jumlah setoran harus lebih dari 0");
        }
        this.saldo += jumlah;
    }

    public void tarik(double jumlah) {
        // TODO 7 -> selesai
        if (jumlah <= 0) {
            throw new IllegalArgumentException("Jumlah penarikan harus lebih dari 0");
        }
        if (jumlah > BATAS_PENARIKAN) {
            throw new IllegalArgumentException("Melebihi batas penarikan sekali transaksi");
        }
        if (jumlah > saldo) {
            throw new IllegalArgumentException("Saldo tidak mencukupi");
        }
        this.saldo -= jumlah;
    }

    /** TODO 8 -> selesai */
    public void potongBiayaAdmin() {
        this.saldo = Math.max(0, this.saldo - BIAYA_ADMIN);
    }

    /** TODO 9 -> selesai */
    public static int getJumlahRekening() {
        return jumlahRekening;
    }

    /** TODO 10 -> selesai (murni pakai parameter, tidak baca state objek -> pantas static) */
    public static double bungaSetahun(double pokok) {
        return pokok * BUNGA_TAHUNAN;
    }

    public double getSaldo()  { return saldo; }
    public String getNomor()  { return nomor; }

    @Override
    public String toString() {
        return String.format(java.util.Locale.US, "Rekening[%s] %-14s Rp%,.2f", nomor, pemilik, saldo);
    }
}