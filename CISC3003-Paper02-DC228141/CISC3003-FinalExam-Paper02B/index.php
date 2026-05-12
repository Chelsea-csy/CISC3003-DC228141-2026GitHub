<?php
session_start();
$status = $_SESSION['contact_status'] ?? null;
unset($_SESSION['contact_status']);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Scenario B - Contact Form</title><link rel="stylesheet" href="css/styles.css"></head>
<body>
<header><h1>Scenario B: Contact Form with PHPMailer</h1><nav><a href="index.php">Contact</a><a href="register.php">Register</a><a href="login.php">Login</a></nav></header>
<main><section class="panel">
    <?php if ($status): ?><div class="alert <?= htmlspecialchars($status['type']) ?>"><?= htmlspecialchars($status['message']) ?></div><?php endif; ?>
    <form method="post" action="send_contact.php" data-validate="true">
        <div class="grid"><div><label for="name">Name</label><input id="name" name="name" required maxlength="120"></div><div><label for="email">Email</label><input id="email" name="email" type="email" required maxlength="160"></div></div>
        <label for="subject">Subject</label><input id="subject" name="subject" required maxlength="160">
        <label for="message">Message</label><textarea id="message" name="message" required minlength="10"></textarea>
        <button type="submit">Send Message</button>
    </form>
    <div class="alert info">This page uses POST / Redirect / GET through send_contact.php.</div>
</section></main>
<footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer><script src="js/script.js"></script>
</body></html>
