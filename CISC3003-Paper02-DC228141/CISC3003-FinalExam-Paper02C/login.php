<?php
session_start();
require __DIR__ . '/php/connect.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = (string) ($_POST['password'] ?? '');
    if ($email && $password !== '') {
        $stmt = $mysqli->prepare('SELECT id, full_name, password_hash, is_active, created_at FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user && password_verify($password, $user['password_hash'])) {
            if ((int) $user['is_active'] !== 1) {
                $error = 'Please activate your email before login.';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['created_at'] = $user['created_at'];
                header('Location: dashboard.php');
                exit;
            }
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Email and password are required.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>Login</h1><nav><a href="index.php">Home</a><a href="register.php">Register</a></nav></header><main><section class="panel"><?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" data-validate="true"><label for="email">Email</label><input id="email" name="email" type="email" required><label for="password">Password</label><input id="password" name="password" type="password" required><button type="submit">Login</button></form><p><a href="forgot_password.php">Forgot password?</a></p></section></main><footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer><script src="js/script.js"></script></body></html>
