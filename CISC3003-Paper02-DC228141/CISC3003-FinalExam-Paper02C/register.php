<?php
require __DIR__ . '/php/connect.php';
$errors = [];
$registered = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim((string) filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = (string) ($_POST['password'] ?? '');
    if ($fullName === '') $errors[] = 'Full name is required.';
    if (!$email) $errors[] = 'Valid email is required.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));
        $stmt = $mysqli->prepare('INSERT INTO users (full_name, email, password_hash, activation_token) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $fullName, $email, $hash, $token);
        if ($stmt->execute()) {
            $registered = true;
            $activationLink = 'activate.php?token=' . urlencode($token);
        } else {
            $errors[] = 'Registration failed. The email may already exist.';
        }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Register</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>Create Account</h1><nav><a href="index.php">Home</a><a href="login.php">Login</a></nav></header><main><section class="panel">
<?php if ($registered): ?><div class="alert success">Account saved. For local testing, open this activation link: <a href="<?= htmlspecialchars($activationLink) ?>"><?= htmlspecialchars($activationLink) ?></a></div><?php endif; ?>
<?php foreach ($errors as $error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endforeach; ?>
<form method="post" data-validate="true"><label for="full_name">Full name</label><input id="full_name" name="full_name" required maxlength="120"><label for="email">Email</label><input id="email" name="email" type="email" required data-email-check><div data-email-message></div><label for="password">Password</label><input id="password" name="password" type="password" required minlength="8"><button type="submit">Register</button></form>
</section></main><footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer><script src="js/script.js"></script></body></html>
