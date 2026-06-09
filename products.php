<?php
require_once 'core/Database.php';
$database = new Database();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $database->escape($_GET['id']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = isset($_POST['category_id']) ? $database->escape($_POST['category_id']) : '';
    $sku = isset($_POST['sku']) ? $database->escape($_POST['sku']) : '';
    $name = isset($_POST['name']) ? $database->escape($_POST['name']) : '';
    $price = isset($_POST['price']) ? $database->escape($_POST['price']) : '';
    $stock = isset($_POST['stock']) ? $database->escape($_POST['stock']) : '';

    if ($action === 'create') {
        $database->query("INSERT INTO products (category_id, sku, name, price, stock) VALUES ('$category_id', '$sku', '$name', '$price', '$stock')");
    } elseif ($action === 'update' && !empty($id)) {
        $database->query("UPDATE products SET category_id = '$category_id', sku = '$sku', name = '$name', price = '$price', stock = '$stock' WHERE id = '$id'");
    }
    header("Location: products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'delete' && !empty($id)) {
    $database->query("DELETE FROM products WHERE id = '$id'");
    header("Location: products.php");
    exit;
}

$edit_data = null;
if ($action === 'edit' && !empty($id)) {
    $res = $database->query("SELECT * FROM products WHERE id = '$id'");
    $edit_data = $res->fetch_assoc();
}

$categories = $database->query("SELECT * FROM categories ORDER BY name ASC");
$products = $database->query("SELECT products.*, categories.name AS category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
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
                        <a href="products.php" class="is-active">Produk</a>
                        <a href="transactions.php">Transaksi</a>
                        <a href="history.php">Riwayat</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="nvl-row" style="margin-top: 30px;">
            <div class="nvl-col-4">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3><?= $edit_data ? 'Edit Produk' : 'Tambah Produk'; ?></h3>
                    </div>
                    <div class="nvl-card-body">
                        <form action="products.php?action=<?= $edit_data ? 'update&id='.$edit_data['id'] : 'create'; ?>" method="POST">
                            <div class="nvl-form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="nvl-form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php while ($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?= $cat['id']; ?>" <?= ($edit_data && $edit_data['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="nvl-form-group">
                                <label>SKU Produk</label>
                                <input type="text" name="sku" class="nvl-form-control" value="<?= $edit_data ? htmlspecialchars($edit_data['sku']) : ''; ?>" required>
                            </div>
                            <div class="nvl-form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="name" class="nvl-form-control" value="<?= $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>" required>
                            </div>
                            <div class="nvl-form-group">
                                <label>Harga</label>
                                <input type="number" name="price" class="nvl-form-control" value="<?= $edit_data ? htmlspecialchars($edit_data['price']) : ''; ?>" required>
                            </div>
                            <div class="nvl-form-group">
                                <label>Stok</label>
                                <input type="number" name="stock" class="nvl-form-control" value="<?= $edit_data ? htmlspecialchars($edit_data['stock']) : ''; ?>" required>
                            </div>
                            <button type="submit" class="nvl-btn nvl-btn-primary"><?= $edit_data ? 'Perbarui' : 'Simpan'; ?></button>
                            <?php if ($edit_data): ?>
                                <a href="products.php" class="nvl-btn nvl-btn-secondary">Batal</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="nvl-col-8">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3>Daftar Produk</h3>
                    </div>
                    <div class="nvl-card-body">
                        <div class="nvl-table-responsive">
                            <table class="nvl-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SKU</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    while ($row = $products->fetch_assoc()): 
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['sku']); ?></td>
                                            <td><?= htmlspecialchars($row['name']); ?></td>
                                            <td><?= htmlspecialchars($row['category_name']); ?></td>
                                            <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                            <td><?= htmlspecialchars($row['stock']); ?></td>
                                            <td>
                                                <a href="products.php?action=edit&id=<?= $row['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-warning">Edit</a>
                                                <a href="products.php?action=delete&id=<?= $row['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-danger btn-delete">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/forge.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>