<?php
require 'config.php';

$page_title = 'Build your next PC';
$active_page = 'home';
require 'header.php';
?>
<section class="hero">
    <div>
        <div class="eyebrow">PC parts · your build</div>
        <h1>Build your next PC.</h1>
        <p>Browse components, compare the specifications that matter, and put together a build that fits your plans. Each category has its own page and database-backed filters.</p>
        <a class="button" href="builder.php">Start building →</a>
    </div>
    <div class="hero-panel">
        <strong>Build checklist</strong>
        <?php foreach (categories() as $name => $url): ?>
            <div><?= e($name) ?> <span style="float:right;color:#8a9198">Browse →</span></div>
        <?php endforeach; ?>
    </div>
</section>

<h2 style="margin-top:26px">Choose a category</h2>
<div class="tiles">
    <?php foreach (categories() as $name => $url): ?>
        <a class="tile" href="<?= e($url) ?>">
            <strong><?= e($name) ?> <span style="float:right;color:var(--orange)">→</span></strong>
            <p>Browse and filter <?= e(strtolower($name)) ?> parts</p>
        </a>
    <?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>
