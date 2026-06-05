<?php
require_once 'core/Database.php';
$database = new Database();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $database->escape($_GET['id']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $database->escape($_POST['name']) : '';
    $slug = strtolower(str_replace(' ', '-', $name));

    if ($action === 'create') {
        $database->query("INSERT INTO categories (name, slug) VALUES ('$name', '$slug')");
    } elseif ($action === 'update' && !empty($id)) {
        $database->query("UPDATE categories SET name = '$name', slug = '$slug' WHERE id = '$id'");
    }
    header("Location: categories.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'delete' && !empty($id)) {
    $database->query("DELETE FROM categories WHERE id = '$id'");
    header("Location: categories.php");
    exit;
}

$edit_data = null;
if ($action === 'edit' && !empty($id)) {
    $res = $database->query("SELECT * FROM categories WHERE id = '$id'");
    $edit_data = $res->fetch_assoc();
}

$categories = $database->query("SELECT * FROM categories ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
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
                        <a href="categories.php" class="is-active">Kategori</a>
                        <a href="products.php">Produk</a>
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
                        <h3><?= $edit_data ? 'Edit Kategori' : 'Tambah Kategori'; ?></h3>
                    </div>
                    <div class="nvl-card-body">
                        <form action="categories.php?action=<?= $edit_data ? 'update&id='.$edit_data['id'] : 'create'; ?>" method="POST" id="form-category">
                            <div class="nvl-form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="name" class="nvl-form-control" value="<?= $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>" required>
                            </div>
                            <button type="submit" class="nvl-btn nvl-btn-primary"><?= $edit_data ? 'Perbarui' : 'Simpan'; ?></button>
                            <?php if ($edit_data): ?>
                                <a href="categories.php" class="nvl-btn nvl-btn-secondary">Batal</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="nvl-col-8">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3>Daftar Kategori</h3>
                    </div>
                    <div class="nvl-card-body">
                        <div class="nvl-table-responsive">
                            <table class="nvl-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    while ($row = $categories->fetch_assoc()): 
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['name']); ?></td>
                                            <td><?= htmlspecialchars($row['slug']); ?></td>
                                            <td>
                                                <a href="categories.php?action=edit&id=<?= $row['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-warning">Edit</a>
                                                <a href="categories.php?action=delete&id=<?= $row['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-danger btn-delete">Hapus</a>
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