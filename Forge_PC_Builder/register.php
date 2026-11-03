<?php
require 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($db)) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (strlen($password) < 8) {
        $error = 'Choose a password with at least 8 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } else {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $db->prepare(
                'INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)'
            );
            $statement->bind_param('sss', $username, $email, $passwordHash);
            $statement->execute();

            $_SESSION['user_id'] = $statement->insert_id;
            $_SESSION['username'] = $username;
            session_regenerate_id(true);
            header('Location: builder.php');
            exit;
        } catch (Throwable $e) {
            $error = 'That username or email may already be registered.';
        }
    }
}

$page_title = 'Create account';
$active_page = '';
require 'header.php';
?>
<section class="panel formbox">
    <div class="eyebrow">FORGE account</div>
    <h1>Create account</h1>
    <p>Account details</p>

    <?php if ($error): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username</label>
        <input id="username" name="username" maxlength="50" required>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" maxlength="255" required>

        <label for="password">Password (at least 8 characters)</label>
        <input id="password" type="password" name="password" required minlength="8">

        <button class="primary" type="submit">Create account</button>
    </form>
</section>
<?php require 'footer.php'; ?>
