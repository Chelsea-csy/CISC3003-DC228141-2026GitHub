<?php
require __DIR__ . '/php/connect.php';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim((string) filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $studentYear = trim((string) filter_input(INPUT_POST, 'student_year', FILTER_SANITIZE_SPECIAL_CHARS));
    $studyMode = trim((string) filter_input(INPUT_POST, 'study_mode', FILTER_SANITIZE_SPECIAL_CHARS));
    $interests = filter_input(INPUT_POST, 'interests', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?: [];
    $comments = trim((string) filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS));

    if ($fullName === '') $errors[] = 'Full name is required.';
    if (!$email) $errors[] = 'A valid email address is required.';
    if ($studentYear === '') $errors[] = 'Please select a student year.';
    if (!in_array($studyMode, ['Full-time', 'Part-time'], true)) $errors[] = 'Please choose a study mode.';
    if ($comments === '') $errors[] = 'Comments are required.';

    $interestText = implode(',', array_map('trim', $interests));

    if (!$errors) {
        $stmt = $mysqli->prepare('INSERT INTO student_feedback (full_name, email, student_year, study_mode, interests, comments) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $fullName, $email, $studentYear, $studyMode, $interestText, $comments);
        $success = $stmt->execute();
        if (!$success) $errors[] = 'Insert failed: ' . $stmt->error;
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scenario A - Secure Form Processing</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Scenario A: PHP Form and MySQL Insert</h1>
    <nav><a href="index.php">Form</a><a href="register.php">Register</a><a href="login.php">Login</a></nav>
</header>
<main>
    <section class="panel">
        <h2>Student Feedback Form</h2>
        <?php if ($success): ?><div class="alert success">The record was inserted using a prepared statement.</div><?php endif; ?>
        <?php foreach ($errors as $error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endforeach; ?>
        <form method="post" action="index.php" data-validate="true">
            <div class="grid">
                <div><label for="full_name">Full name</label><input id="full_name" name="full_name" required maxlength="120"></div>
                <div><label for="email">Email</label><input id="email" name="email" type="email" required maxlength="160"></div>
            </div>
            <label for="student_year">Student year</label>
            <select id="student_year" name="student_year" required>
                <option value="">Choose one</option><option>Year 1</option><option>Year 2</option><option>Year 3</option><option>Year 4</option>
            </select>
            <fieldset><legend>Study mode</legend><label class="inline"><input type="radio" name="study_mode" value="Full-time" required> Full-time</label><label class="inline"><input type="radio" name="study_mode" value="Part-time"> Part-time</label></fieldset>
            <fieldset><legend>Interests</legend><label class="inline"><input type="checkbox" name="interests[]" value="HTML"> HTML</label><label class="inline"><input type="checkbox" name="interests[]" value="PHP"> PHP</label><label class="inline"><input type="checkbox" name="interests[]" value="MySQL"> MySQL</label></fieldset>
            <label for="comments">Comments</label><textarea id="comments" name="comments" required></textarea>
            <button type="submit">Submit Feedback</button>
        </form>
    </section>
</main>
<footer>CISC3003 Web Programming: CHEN SIYI + DC228141 + 2026</footer>
<script src="js/script.js"></script>
</body>
</html>
