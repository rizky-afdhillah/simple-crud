<?php
require_once 'core/Database.php';
$database = new Database();

$history = $database->query("SELECT * FROM transactions ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
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
                        <a href="transactions.php">Transaksi</a>
                        <a href="history.php" class="is-active">Riwayat</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="nvl-row" style="margin-top: 30px; margin-bottom: 50px;">
            <div class="nvl-col-12">
                <div class="nvl-card nvl-p-3">
                    <div class="nvl-card-header">
                        <h3>Riwayat Transaksi Terpaku (Read-Only)</h3>
                    </div>
                    <div class="nvl-card-body">
                        <div class="nvl-table-responsive">
                            <table class="nvl-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal/Waktu</th>
                                        <th>No. Invoice</th>
                                        <th>Total Belanja</th>
                                        <th>Nominal Bayar</th>
                                        <th>Kembalian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no_hist = 1;
                                    if ($history->num_rows === 0):
                                    ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center;">Belum ada riwayat transaksi</td>
                                        </tr>
                                    <?php 
                                    else:
                                        while ($row_hist = $history->fetch_assoc()): 
                                    ?>
                                        <tr>
                                            <td><?php echo $no_hist++; ?></td>
                                            <td><?php echo $row_hist['created_at']; ?></td>
                                            <td><strong><?php echo htmlspecialchars($row_hist['invoice']); ?></strong></td>
                                            <td>Rp <?php echo number_format($row_hist['total_price'], 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($row_hist['pay_amount'], 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($row_hist['change_amount'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="cetak.php?id=<?php echo $row_hist['id']; ?>" class="nvl-btn nvl-btn-sm nvl-btn-primary">Lihat Nota</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endwhile;
                                    endif; 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>