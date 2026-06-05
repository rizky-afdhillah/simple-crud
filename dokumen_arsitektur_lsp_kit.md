=============================================================================
DOKUMENTASI ARSITEKTUR & ALUR KERJA: LSP KIT (PBO)
=============================================================================

1. KONSEP DASAR & STRUKTUR FOLDER
   Pendekatan utama kita adalah Server-Side Rendering (SSR) murni menggunakan PHP dengan gaya prosedural untuk logika tampilan, namun di-support penuh oleh enkapsulasi Object-Oriented Programming (OOP) pada lapisan Database. Jika saat ujian dilarang membawa library SCSS/JS eksternal, kamu hanya perlu membuat CSS Grid sederhana dan mengandalkan navigasi native PHP.

Struktur Direktori Target:
lsp-kit/
├── assets/
│ ├── css/main.css (Fokus hafalkan Flexbox Grid sederhana jika raw-coding)
│ └── js/app.js (Fokus hafalkan DOM listener hitung kembalian)
├── core/
│ └── Database.php (WAJIB HAFAL LUAR KEPALA)
├── categories.php (Master Kategori - CRUD)
├── products.php (Master Produk - CRUD + Dropdown Relasi)
├── transactions.php (Keranjang Belanja - Session + Insert)
├── checkout.php (Proses Insert Relasional & Potong Stok)
├── history.php (Read-Only Data Transaksi Induk)
├── cetak.php (Nota dengan @media print)
└── index.php (Dashboard Summary)

2. CORE ENGINE (Database.php)
   Ini adalah jantung aplikasi yang memenuhi syarat PBO. Enkapsulasi menggunakan properti `private` untuk kredensial.

- \_\_construct() : Menggunakan `new mysqli()`.
- query($sql) : Mengeksekusi string SQL mentah.
- escape($str) : Membungkus `real_escape_string` untuk mencegah SQL Injection.

3. POLA KONTROLER SATU BERKAS (Single-File Controller)
   Semua file master (categories.php, products.php) menggunakan pola ini untuk menghemat pembuatan file:

- Tangkap parameter: `$action = isset($_GET['action']) ? $_GET['action'] : '';`
- Logika POST (Create/Update): Dicegat menggunakan `if ($_SERVER['REQUEST_METHOD'] === 'POST')`. Setelah operasi `$database->query()` selesai, WAJIB diakhiri dengan `header("Location: ...")` dan `exit;` agar halaman terefresh dan form resubmission terhindari.
- Logika GET (Delete): Dicegat khusus dengan validasi `$action === 'delete'`.
- Mode Edit: Form yang sama digunakan untuk Tambah dan Edit. Bedanya ada pada pengecekan variabel `$edit_data`. Jika ada, atribut `value` pada input diisi dengan data lama.

4. LOGIKA KASIR (TRANSACTIONS & CHECKOUT)
   Ini adalah bagian paling kompleks (Sektor 2).

- Session Cart: Menggunakan `$_SESSION['cart']`. Key (indeks) dari array ini adalah ID produk (`$product_id`).
- Menambah Item: Jika `isset($_SESSION['cart'][$product_id])` bernilai true, maka cukup tambahkan qty-nya (`+=`). Jika false, buat array asosiatif baru berisi detail id, sku, name, price, qty.
- Eksekusi (checkout.php):
  1. Insert ke tabel `transactions` (induk).
  2. Ambil ID transaksi baru dengan `$database->conn->insert_id`.
  3. Lakukan `foreach ($_SESSION['cart'] as $item)` untuk insert ke `transaction_details` (anak).
  4. Di dalam loop yang sama, jalankan query UPDATE untuk memotong stok.
  5. Kosongkan cart: `$_SESSION['cart'] = [];` lalu lempar ke `cetak.php`.

5. HAFALAN PENTING JIKA LIBRARY DILARANG (CSS/JS)

- JS Hitung Kembalian: Pahami cara kerja `document.getElementById` dipadukan dengan `addEventListener("input")`. Konversi input ke integer menggunakan `parseInt()`, lakukan pengurangan, lalu tampilkan kembali.
- CSS Print: Pahami pemakaian `@media print { .no-print { display: none !important; } }` untuk menghilangkan tombol saat dialog cetak muncul.
