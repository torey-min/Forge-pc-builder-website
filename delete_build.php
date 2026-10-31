<?php
require 'config.php';

// Only a logged-in user may delete, and only by submitting the My Builds form.
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Please use the delete button on My Builds.');
}
if (!isset($db)) {
    header('Location: my_builds.php?delete_error=1');
    exit;
}

$sentToken = (string)($_POST['csrf_token'] ?? '');
$sessionToken = (string)($_SESSION['csrf_token'] ?? '');
if ($sessionToken === '' || !hash_equals($sessionToken, $sentToken)) {
    header('Location: my_builds.php?delete_error=1');
    exit;
}

$buildId = filter_input(INPUT_POST, 'build_id', FILTER_VALIDATE_INT);
if (!$buildId || $buildId < 1) {
    header('Location: my_builds.php?delete_error=1');
    exit;
}

// Including user_id prevents deleting a build that belongs to another account. delete handler--Min
$userId = (int)$_SESSION['user_id'];
$statement = $db->prepare('DELETE FROM builds WHERE build_id = ? AND user_id = ?');
$statement->bind_param('ii', $buildId, $userId);
$statement->execute();
$deleted = $statement->affected_rows === 1;
$statement->close();

header('Location: my_builds.php?'.($deleted ? 'deleted=1' : 'delete_error=1'));
exit;
?>
