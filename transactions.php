<?php
session_start();
require_once 'core/Database.php';
$database = new Database();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_item') {
    $product_id = isset($_POST['product_id']) ? $database->escape($_POST['product_id']) : '';
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if (!empty($product_id) && $qty > 0) {
        $res = $database->query("SELECT * FROM products WHERE id = '$product_id'");
        if ($res->num_rows > 0) {
            $product = $res->fetch_assoc();
            
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['qty'] += $qty;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'id' => $product['id'],
                    'sku' => $product['sku'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => $qty
                ];
            }
        }
    }
    header("Location: transactions.php");
    exit;
}

if ($action === 'remove_item') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: transactions.php");
    exit;
}

if ($action === 'clear_cart') {
    $_SESSION['cart'] = [];
    header("Location: transactions.php");
    exit;
}

$products = $database->query("SELECT * FROM products WHERE stock > 0 ORDER BY name ASC");

$invoice = "INV-" . date("Ymd") . "-" . strtoupper(substr(md5(time()), 0, 5));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Kasir</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="nvl-container">
        <div class="nvl-row">
            <div class="nvl-col-12">
                <nav class="nvl-navbar">
                    <span class="nvl-nav-brand nvl-me-3">LSP KIT</span>
                    <div class="nvl-nav-links">
                        <a href="index.php">Dashboard</a>
                        <a href="categories.php">Kategori</a>
                        <a href="products.php">Produk</a>
                        <a href="transactions.php" class="is-active">Transaksi</a>
                        <a href="history.php">Riwayat</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="nvl-row" style="margin-top: 30px;">
            <div class="nvl-col-4">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3>Pilih Produk</h3>
                    </div>
                    <div class="nvl-card-body">
                        <form action="transactions.php?action=add_item" method="POST">
                            <div class="nvl-form-group">
                                <label>Produk</label>
                                <select name="product_id" class="nvl-form-control" required>
                                    <option value="">Pilih Produk</option>
                                    <?php while ($prod = $products->fetch_assoc()): ?>
                                        <option value="<?= $prod['id']; ?>">
                                            <?= htmlspecialchars($prod['name']); ?> (Stok: <?= $prod['stock']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="nvl-form-group">
                                <label>Jumlah (Qty)</label>
                                <input type="number" name="qty" class="nvl-form-control" value="1" min="1" required>
                            </div>
                            <button type="submit" class="nvl-btn nvl-btn-primary">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="nvl-col-8">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3>Keranjang Belanja (<?= $invoice; ?>)</h3>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <a href="transactions.php?action=clear_cart" class="nvl-btn nvl-btn-sm nvl-btn-danger">Kosongkan</a>
                        <?php endif; ?>
                    </div>
                    <div class="nvl-card-body">
                        <div class="nvl-table-responsive">
                            <table class="nvl-table">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_price = 0;
                                    if (empty($_SESSION['cart'])): 
                                    ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center;">Keranjang masih kosong</td>
                                        </tr>
                                    <?php 
                                    else:
                                        foreach ($_SESSION['cart'] as $item): 
                                            $subtotal = $item['price'] * $item['qty'];
                                            $total_price += $subtotal;
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['sku']); ?></td>
                                            <td><?= htmlspecialchars($item['name']); ?></td>
                                            <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                            <td><?= $item['qty']; ?></td>
                                            <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="transactions.php?action=remove_item&id=<?= $item['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach; 
                                    endif; 
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (!empty($_SESSION['cart'])): ?>
                            <form action="checkout.php" method="POST" style="margin-top: 20px;">
                                <input type="hidden" name="invoice" value="<?= $invoice; ?>">
                                <input type="hidden" name="total_price" id="total_price" value="<?= $total_price; ?>">
                                
                                <div class="nvl-row">
                                    <div class="nvl-col-12" style="text-align: right; margin-bottom: 15px;">
                                        <h2>Total: Rp <?= number_format($total_price, 0, ',', '.'); ?></h2>
                                    </div>
                                    <div class="nvl-col-6">
                                        <div class="nvl-form-group">
                                            <label>Nominal Bayar</label>
                                            <input type="number" name="pay_amount" id="pay_amount" class="nvl-form-control" min="<?= $total_price; ?>" required>
                                        </div>
                                    </div>
                                    <div class="nvl-col-6">
                                        <div class="nvl-form-group">
                                            <label>Uang Kembalian</label>
                                            <input type="text" id="change_amount_display" class="nvl-form-control" value="Rp 0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="nvl-btn nvl-btn-success" style="width: 100%;">Proses & Simpan Transaksi</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/forge.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>