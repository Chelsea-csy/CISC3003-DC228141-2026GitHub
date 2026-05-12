<?php
require __DIR__ . '/php/connect.php';
$token = (string) ($_GET['token'] ?? '');
$message = 'Invalid activation token.';
if ($token !== '') {
    $stmt = $mysqli->prepare('UPDATE users SET is_active = 1, activation_token = NULL WHERE activation_token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    if ($stmt->affected_rows === 1) $message = 'Account activated. You can now log in.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Activate</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>Email Activation</h1></header><main><section class="panel"><div class="alert info"><?= htmlspecialchars($message) ?></div><a class="button" href="login.php">Login</a></section></main><footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer></body></html>
