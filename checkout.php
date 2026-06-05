<?php
session_start();
require_once 'core/Database.php';
$database = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $invoice = $database->escape($_POST['invoice']);
    $total_price = (int)$_POST['total_price'];
    $pay_amount = (int)$_POST['pay_amount'];
    $change_amount = $pay_amount - $total_price;

    $database->query("INSERT INTO transactions (invoice, total_price, pay_amount, change_amount) VALUES ('$invoice', '$total_price', '$pay_amount', '$change_amount')");
    $transaction_id = $database->conn->insert_id;

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $database->escape($item['id']);
        $qty = (int)$item['qty'];
        $price = (int)$item['price'];
        $subtotal = $qty * $price;

        $database->query("INSERT INTO transaction_details (transaction_id, product_id, qty, price, subtotal) VALUES ('$transaction_id', '$product_id', '$qty', '$price', '$subtotal')");
        $database->query("UPDATE products SET stock = stock - $qty WHERE id = '$product_id'");
    }

    $_SESSION['cart'] = [];
    header("Location: cetak.php?id=" . $transaction_id);
    exit;
} else {
    header("Location: transactions.php");
    exit;
}