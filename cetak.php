<?php
require_once 'core/Database.php';
$database = new Database();

$id = isset($_GET['id']) ? $database->escape($_GET['id']) : '';

if (empty($id)) {
    header("Location: transactions.php");
    exit;
}

$tx_res = $database->query("SELECT * FROM transactions WHERE id = '$id'");
if ($tx_res->num_rows === 0) {
    header("Location: transactions.php");
    exit;
}
$transaction = $tx_res->fetch_assoc();

$details = $database->query("SELECT transaction_details.*, products.name AS product_name, products.sku FROM transaction_details JOIN products ON transaction_details.product_id = products.id WHERE transaction_details.transaction_id = '$id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota - <?php echo $transaction['invoice']; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; padding: 0; }
            .nvl-card { border: none; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="nvl-container" style="max-width: 600px; margin-top: 50px;">
        <div class="nvl-card nvl-p-3">
            <div class="nvl-card-header" style="text-align: center;">
                <h2>NOTA PEMBELIAN</h2>
                <p><?php echo $transaction['invoice']; ?></p>
            </div>
            <div class="nvl-card-body">
                <div style="margin-bottom: 20px;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr>
                            <td style="padding: 4px 0;">Tanggal</td>
                            <td style="padding: 4px 0; text-align: right;"><?php echo $transaction['created_at']; ?></td>
                        </tr>
                    </table>
                </div>

                <table class="nvl-table" style="width: 100%; margin-bottom: 20px;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $details->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['product_name']); ?></strong><br>
                                    <small style="color: #666;"><?php echo htmlspecialchars($row['sku']); ?></small>
                                </td>
                                <td style="text-align: center;"><?php echo $row['qty']; ?></td>
                                <td style="text-align: right;">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                <td style="text-align: right;">Rp <?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div style="border-top: 2px dashed #ccc; padding-top: 15px;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr>
                            <td style="padding: 4px 0;"><strong>Total Belanja</strong></td>
                            <td style="padding: 4px 0; text-align: right;"><strong>Rp <?php echo number_format($transaction['total_price'], 0, ',', '.'); ?></strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0;">Nominal Bayar</td>
                            <td style="padding: 4px 0; text-align: right;">Rp <?php echo number_format($transaction['pay_amount'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0;">Kembalian</td>
                            <td style="padding: 4px 0; text-align: right;">Rp <?php echo number_format($transaction['change_amount'], 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="no-print" style="margin-top: 30px; display: flex; gap: 10px;">
                    <button onclick="window.print()" class="nvl-btn nvl-btn-primary" style="flex: 1;">Cetak Nota</button>
                    <a href="transactions.php" class="nvl-btn nvl-btn-secondary" style="flex: 1; text-align: center;">Kembali ke Kasir</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>