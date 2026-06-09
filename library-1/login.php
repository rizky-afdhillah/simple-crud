<?php
    require_once 'core/App-3.php';
    $app = new App();

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $username = $app->safe($_POST['username']);
        $password = $app->safe($_POST['password']);

        $sqlStr = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $user = $app->single($sqlStr);
        // var_dump($user);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                // header("Location: index.php");
                echo 'success';
            }else {
                echo 'Password Salah';
                // echo password_hash('1234', PASSWORD_BCRYPT);
            }
        }else {
            echo 'Username Tidak Ditemukan';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <input type="submit" value="Login">
    </form>
</body>
</html>
