<?php
require 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($db)) {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = fetch_rows(
        $db,
        'SELECT user_id, username, email, password_hash
         FROM users
         WHERE username = ? OR email = ?
         LIMIT 1',
        'ss',
        [$login, $login]
    );

    if ($users && password_verify($password, $users[0]['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $users[0]['user_id'];
        $_SESSION['username'] = $users[0]['username'];
        header('Location: builder.php');
        exit;
    }

    $error = 'Those login details did not match an account.';
}

$page_title = 'Log in';
$active_page = '';
require 'header.php';
?>
<section class="panel formbox">
    <div class="eyebrow">FORGE account</div>
    <h1>Log in</h1>
    <p>Log in to save and revisit builds.</p>

    <?php if ($error): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="login">Username or email</label>
        <input id="login" name="login" required>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        <button class="primary" type="submit">Log in</button>
    </form>
    <p>New here? <a href="register.php" style="color:var(--blue)">Create an account</a></p>
</section>
<?php require 'footer.php'; ?>
