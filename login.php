<?php
session_start();
require_once 'core/Database.php';
$database = new Database();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $database->escape($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
        $result = $database->query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LSP KIT</title>
    <?php
        // echo password_hash('1234', PASSWORD_BCRYPT);
    ?>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="nvl-card nvl-p-4">
            <div class="nvl-card-header" style="text-align: center; margin-bottom: 20px;">
                <h2>LSP KIT</h2>
                <p>Silakan masuk ke akun Anda</p>
            </div>
            <div class="nvl-card-body">
                <?php if (!empty($error)): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                        <?= htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="nvl-form-group" style="margin-bottom: 15px;">
                        <label>Username</label>
                        <input type="text" name="username" class="nvl-form-control" required autocomplete="off">
                    </div>
                    <div class="nvl-form-group" style="margin-bottom: 20px;">
                        <label>Password</label>
                        <input type="password" name="password" class="nvl-form-control" required>
                    </div>
                    <button type="submit" class="nvl-btn nvl-btn-primary" style="width: 100%;">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
