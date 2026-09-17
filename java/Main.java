import java.util.Locale;

public class Main {
    public static void main(String[] args) {
        System.out.println("Jumlah rekening di awal: " + RekeningBank.getJumlahRekening());

        RekeningBank rek1 = new RekeningBank("111", "Ani", 1_000_000);
        RekeningBank rek2 = new RekeningBank("222", "Budi");
        RekeningBank rek3 = new RekeningBank("333", "Citra", 250_000);

        System.out.println(rek1);
        System.out.println(rek2);
        System.out.println(rek3);
        System.out.println("Jumlah rekening sekarang: " + RekeningBank.getJumlahRekening() + "   (seharusnya 3, bukan 4)");

        System.out.println("\n=== Operasi ===");
        rek1.setor(500_000);
        System.out.println("Setelah setor 500.000 -> " + rek1);

        try {
            rek1.tarik(6_000_000);
        } catch (IllegalArgumentException e) {
            System.out.println("Ditolak: " + e.getMessage());
        }

        rek2.potongBiayaAdmin();
        System.out.println("Budi setelah potong admin: " + rek2 + "   (saldo tidak boleh negatif)");

        System.out.printf(Locale.US, "Bunga setahun dari saldo Ani: Rp%,.2f\n", RekeningBank.bungaSetahun(rek1.getSaldo()));
    }
}