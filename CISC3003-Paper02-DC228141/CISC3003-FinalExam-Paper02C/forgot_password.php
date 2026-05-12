<?php
require __DIR__ . '/php/connect.php';
$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email) {
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);
        $expires = date('Y-m-d H:i:s', time() + 3600);
        $stmt = $mysqli->prepare('UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?');
        $stmt->bind_param('sss', $tokenHash, $expires, $email);
        $stmt->execute();
        $notice = 'If that email exists, use this local reset link for testing: reset_password.php?token=' . urlencode($token);
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Forgot Password</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>Password Reset</h1></header><main><section class="panel"><?php if ($notice): ?><div class="alert info"><?= htmlspecialchars($notice) ?></div><?php endif; ?><form method="post"><label for="email">Email</label><input id="email" name="email" type="email" required><button type="submit">Create Reset Link</button></form></section></main><footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer></body></html>
