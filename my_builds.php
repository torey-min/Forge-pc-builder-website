<?php
require 'config.php';
$page_title = 'My Builds';
$active_page = 'builds';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require 'header.php';

if (empty($_SESSION['user_id'])):
?>
    <section class="panel">
        <h1>My Builds</h1>
        <p>Log in to see the builds saved to your account.</p>
        <a class="button" href="login.php">Log in</a>
    </section>
<?php
    require 'footer.php';
    exit;
endif;

if (!isset($db)) {
    require 'footer.php';
    exit;
}

$userId = (int)$_SESSION['user_id'];
$builds = fetch_rows(
    $db,
    'SELECT build_id, name, created_at FROM builds WHERE user_id = ? ORDER BY updated_at DESC',
    'i',
    [$userId]
);
?>
<div class="eyebrow">Saved parts</div>
<h1>My Builds</h1>

<?php if (isset($_GET['saved'])): ?>
    <div class="alert success">Your build has been saved.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="alert success">The build was deleted.</div>
<?php endif; ?>
<?php if (isset($_GET['delete_error'])): ?>
    <div class="alert error">The build could not be deleted. Refresh the page and try again.</div>
<?php endif; ?>

<?php if (!$builds): ?>
    <div class="empty">You have not saved a build yet.
        <a href="builder.php" style="color:var(--blue)">Start building →</a>
    </div>
<?php endif; ?>

<?php foreach ($builds as $build):
    $buildId = (int)$build['build_id'];
    $items = fetch_rows(
        $db,
        'SELECT c.type, c.brand, c.name, c.price, bc.quantity
         FROM build_components bc
         JOIN components c ON c.component_id = bc.component_id
         WHERE bc.build_id = ?
         ORDER BY c.type',
        'i',
        [$buildId]
    );
    $total = array_sum(array_map(
        fn($item) => (float)$item['price'] * (int)$item['quantity'],
        $items
    ));
?>
    <section class="panel saved-build">
        <div class="saved-build-heading">
            <div>
                <h2><?= e($build['name']) ?></h2>
                <p>Saved <?= e($build['created_at']) ?></p>
            </div>
            <!-- How to delete a build /Min -->
            <form method="post" action="delete_build.php"
                  onsubmit="return confirm('Delete this saved build? This cannot be undone.');">
                <input type="hidden" name="build_id" value="<?= $buildId ?>">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                <button class="danger-button" type="submit">Delete build</button>
            </form>
        </div>
        <?php if ($items): ?>
            <table class="table">
                <thead><tr><th>Category</th><th>Component</th><th>Price</th></tr></thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item['type']) ?></td>
                        <td><?= e($item['brand'].' '.$item['name']) ?></td>
                        <td><?= euro((float)$item['price'] * (int)$item['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="note">This saved build has no components.</p>
        <?php endif; ?>
        <p><strong>Total: <?= euro($total) ?></strong></p>
    </section>
<?php endforeach; ?>
<?php require 'footer.php'; ?>
