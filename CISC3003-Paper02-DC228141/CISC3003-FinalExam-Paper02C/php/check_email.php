<?php
require __DIR__ . '/connect.php';
header('Content-Type: application/json');
$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo json_encode(['available' => false, 'message' => 'Please enter a valid email.']);
    exit;
}
$stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
echo json_encode($result->num_rows === 0 ? ['available' => true, 'message' => 'Email is available.'] : ['available' => false, 'message' => 'Email is already registered.']);
?>
