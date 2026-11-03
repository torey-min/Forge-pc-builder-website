<?php
require 'config.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($db)) {
    http_response_code(503);
    exit('Database unavailable.');
}

$parts = selected_build_rows($db);
if (!$parts) {
    header('Location: builder.php');
    exit;
}

$name = trim($_POST['name'] ?? 'My PC Build');
if ($name === '') {
    $name = 'My PC Build';
}
$userId = (int) $_SESSION['user_id'];

try {
    $db->begin_transaction();

    $buildStatement = $db->prepare('INSERT INTO builds (user_id, name) VALUES (?, ?)');
    $buildStatement->bind_param('is', $userId, $name);
    $buildStatement->execute();
    $buildId = $db->insert_id;

    $componentStatement = $db->prepare(
        'INSERT INTO build_components (build_id, component_id, quantity) VALUES (?, ?, 1)'
    );
    foreach ($parts as $part) {
        $componentId = (int) $part['component_id'];
        $componentStatement->bind_param('ii', $buildId, $componentId);
        $componentStatement->execute();
    }

    $db->commit();
    $_SESSION['build'] = [];
    header('Location: my_builds.php?saved=1');
    exit;
} catch (Throwable $e) {
    $db->rollback();
    http_response_code(500);
    exit('The build could not be saved. Please try again.');
}
?>
