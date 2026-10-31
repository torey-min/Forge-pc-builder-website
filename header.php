<?php
$page_title = $page_title ?? 'FORGE PC Builder';
$active_page = $active_page ?? '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title) ?> · FORGE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="index.php">F<span>O</span>RGE<small>PC BUILD STUDIO</small></a>
        <nav>
            <a class="<?= $active_page === 'home' ? 'active' : '' ?>" href="index.php">Home</a>
            <a class="<?= $active_page === 'builder' ? 'active' : '' ?>" href="builder.php">Builder</a>
            <a class="<?= $active_page === 'builds' ? 'active' : '' ?>" href="my_builds.php">My Builds</a>
        </nav>
        <div class="account">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <span><?= e($_SESSION['username']) ?></span>
                <a class="button small" href="logout.php">Log out</a>
            <?php else: ?>
                <a class="button small" href="login.php">Log in</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="wrap">
        <?php if (isset($db_error)): ?>
            <div class="alert error">
                <strong>Database connection needed</strong><br>
                <?= e($db_error) ?><br>
                <small>Connection settings are in config.php. Pages query your existing MySQL tables when the server is reachable.</small>
            </div>
        <?php endif; ?>
