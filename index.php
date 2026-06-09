<?php
session_start();
require_once 'core/Database.php';
$database = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

$count_categories = $database->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];
$count_products = $database->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$count_transactions = $database->query("SELECT COUNT(*) as total FROM transactions")->fetch_assoc()['total'];
$sum_revenue = $database->query("SELECT SUM(total_price) as total FROM transactions")->fetch_assoc()['total'] ?? 0;

$recent_transactions = $database->query("SELECT * FROM transactions ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LSP KIT</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .stat-card h4 {
            margin: 0 0 10px 0;
            color: #666;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="nvl-container">
        <div class="nvl-row">
            <div class="nvl-col-12">
                <nav class="nvl-navbar" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <span class="nvl-nav-brand nvl-me-3">LSP KIT</span>
                        <div class="nvl-nav-links">
                            <a href="index.php" class="is-active">Dashboard</a>
                            <a href="categories.php">Kategori</a>
                            <a href="products.php">Produk</a>
                            <a href="transactions.php">Transaksi</a>
                            <a href="history.php">Riwayat</a>
                        </div>
                    </div>
                    <div>
                        <span style="margin-right: 15px; color: #555;">Halo, <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
                        <a href="index.php?action=logout" class="nvl-btn nvl-btn-sm nvl-btn-danger">Keluar</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h4>Total Kategori</h4>
                <div class="value"><?= $count_categories; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Produk</h4>
                <div class="value"><?= $count_products; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Transaksi</h4>
                <div class="value"><?= $count_transactions; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Pendapatan</h4>
                <div class="value">Rp <?= number_format($sum_revenue, 0, ',', '.'); ?></div>
            </div>
        </div>

        <div class="nvl-row" style="margin-top: 30px;">
            <div class="nvl-col-12">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3>Transaksi Terbaru</h3>
                    </div>
                    <div class="nvl-card-body">
                        <div class="nvl-table-responsive">
                            <table class="nvl-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nomor Invoice</th>
                                        <th>Total Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = $recent_transactions->fetch_assoc()):
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                                            <td><?= htmlspecialchars($row['invoice_number']); ?></td>
                                            <td>Rp <?= number_format($row['total_price'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="cetak.php?id=<?= $row['id']; ?>" target="_blank" class="nvl-btn nvl-btn-sm nvl-btn-primary">Cetak Nota</a>
                                            </td>
                                        </tr>
                                    <?php
                                    endwhile;
                                    if ($no === 1):
                                    ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: #888;">Belum ada data transaksi.</td>
                                        </tr>
                                    <?php endif; ?>
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
