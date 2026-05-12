<?php
require __DIR__ . '/php/connect.php';
$token = (string) ($_GET['token'] ?? $_POST['token'] ?? '');
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    if (strlen($password) >= 8 && $token !== '') {
        $tokenHash = hash('sha256', $token);
        $stmt = $mysqli->prepare('SELECT id FROM users WHERE reset_token_hash = ? AND reset_token_expires_at > NOW() LIMIT 1');
        $stmt->bind_param('s', $tokenHash);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $clear = null;
            $stmt = $mysqli->prepare('UPDATE users SET password_hash = ?, reset_token_hash = ?, reset_token_expires_at = NULL WHERE id = ?');
            $stmt->bind_param('ssi', $hash, $clear, $user['id']);
            $stmt->execute();
            $message = 'Password updated. You can log in.';
        } else {
            $message = 'Reset token is invalid or expired.';
        }
    } else {
        $message = 'Password must be at least 8 characters.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Reset Password</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>Set New Password</h1></header><main><section class="panel"><?php if ($message): ?><div class="alert info"><?= htmlspecialchars($message) ?></div><?php endif; ?><form method="post"><input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>"><label for="password">New password</label><input id="password" name="password" type="password" required minlength="8"><button type="submit">Save Password</button></form></section></main><footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer></body></html>
