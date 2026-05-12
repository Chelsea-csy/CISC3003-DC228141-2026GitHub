<?php
session_start();
require __DIR__ . '/php/connect.php';

$name = trim((string) filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$subject = trim((string) filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS));
$message = trim((string) filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS));

if ($name === '' || !$email || $subject === '' || strlen($message) < 10) {
    $_SESSION['contact_status'] = ['type' => 'error', 'message' => 'Please complete the form with a valid email and message.'];
    header('Location: index.php');
    exit;
}

$stmt = $mysqli->prepare('INSERT INTO contact_messages (sender_name, sender_email, subject, message) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $email, $subject, $message);
$stmt->execute();
$stmt->close();

$mailSent = false;
$debugNote = 'PHPMailer is not installed yet. Run composer require phpmailer/phpmailer to enable SMTP sending.';
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
    $config = require __DIR__ . '/php/mailer_config.php';
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $config['port'];
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($config['to_email']);
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mailSent = $mail->send();
    } catch (Throwable $e) {
        $debugNote = 'Mailer error: ' . $e->getMessage();
    }
}

$_SESSION['contact_status'] = $mailSent
    ? ['type' => 'success', 'message' => 'Message sent successfully with PHPMailer.']
    : ['type' => 'info', 'message' => 'Message saved. ' . $debugNote];
header('Location: index.php');
exit;
?>
