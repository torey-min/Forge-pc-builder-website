<?php
require 'config.php';

$category = $category ?? 'CPU';
$definition = spec_definitions()[$category];
$table = $definition['table'];
$join = $table
    ? " LEFT JOIN `$table` s ON s.component_id = c.component_id"
    : '';

$page_title = $category . ' components';
$active_page = '';
require 'header.php';

if (!isset($db)) {
    require 'footer.php';
    exit;
}

// Load the available brands for this category.
$brandRows = fetch_rows(
    $db,
    'SELECT DISTINCT brand
     FROM components
     WHERE type = ? AND is_active = 1
     ORDER BY brand',
    's',
    [$category]
);
$allBrands = array_column($brandRows, 'brand');
$selectedBrands = $_GET['brand'] ?? $allBrands;

if (!is_array($selectedBrands)) {
    $selectedBrands = [];
}
$selectedBrands = array_values(array_intersect(
    $allBrands,
    array_map('strval', $selectedBrands)
));

// Build a safe WHERE clause from the category's allowed filters.
$where = ['c.type = ?', 'c.is_active = 1'];
$types = 's';
$values = [$category];

if (count($selectedBrands) < count($allBrands)) {
    if (!$selectedBrands) {
        $where[] = '1 = 0';
    } else {
        $placeholders = implode(',', array_fill(0, count($selectedBrands), '?'));
        $where[] = "c.brand IN ($placeholders)";
        $types .= str_repeat('s', count($selectedBrands));
        array_push($values, ...$selectedBrands);
    }
}

foreach ($definition['filters'] as $field => $filter) {
    if ($filter[1] === 'select' && !empty($_GET[$field])) {
        $where[] = "s.`$field` = ?";
        $types .= 's';
        $values[] = (string) $_GET[$field];
    }

    $minimum = $_GET['min_' . $field] ?? null;
    if (
        $filter[1] === 'range'
        && $minimum !== null
        && is_numeric($minimum)
        && (float) $minimum > 0
    ) {
        $where[] = "s.`$field` >= ?";
        $types .= 'd';
        $values[] = (float) $minimum;
    }
}

if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $where[] = 'c.price <= ?';
    $types .= 'd';
    $values[] = (float) $_GET['max_price'];
}

$sort = $_GET['sort'] ?? '';
$order = match ($sort) {
    'low' => 'c.price ASC',
    'high' => 'c.price DESC',
    default => 'c.brand ASC, c.name ASC',
};

$select = 'c.component_id, c.type, c.brand, c.name, c.price, c.image_url';
if ($table) {
    foreach (array_keys($definition['labels']) as $field) {
        $select .= ", s.`$field`";
    }
}

$sql = "SELECT $select
        FROM components c$join
        WHERE " . implode(' AND ', $where) . "
        ORDER BY $order";
$items = fetch_rows($db, $sql, $types, $values);

// Build dropdown choices from the specification values already in the database.
$options = [];
foreach ($definition['filters'] as $field => $filter) {
    if ($filter[1] !== 'select') {
        continue;
    }

    $options[$field] = fetch_rows(
        $db,
        "SELECT DISTINCT s.`$field` AS value
         FROM `$table` s
         JOIN components c ON c.component_id = s.component_id
         WHERE c.type = ? AND c.is_active = 1
         ORDER BY value",
        's',
        [$category]
    );
}
?>
<div class="layout">
    <aside class="sidebar">
        <div class="eyebrow" style="padding:5px 9px">Categories</div>
        <nav>
            <?php foreach (categories() as $name => $url): ?>
                <a class="<?= $name === $category ? 'active' : '' ?>"
                   href="<?= e($url) ?>">
                    <?= e($name) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <section>
        <div class="catalog-head">
            <div>
                <div class="eyebrow">Components / <?= e($category) ?></div>
                <h1><?= e($category) ?></h1>
                <p>Filters and specifications are read from the existing <?= e($table ?? 'components') ?> table.</p>
            </div>
            <a class="button small" href="builder.php">
                Current build (<?= count($_SESSION['build'] ?? []) ?>)
            </a>
        </div>

        <form class="filter-box" method="get">
            <div class="filters">
                <div class="filter">
                    <label>Brand</label>
                    <div class="brand-checks">
                        <?php foreach ($allBrands as $brand): ?>
                            <label>
                                <input type="checkbox" name="brand[]" value="<?= e($brand) ?>"
                                    <?= in_array($brand, $selectedBrands, true) ? 'checked' : '' ?>>
                                <?= e($brand) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php foreach ($definition['filters'] as $field => $filter): ?>
                    <?php [$label, $kind] = $filter; ?>

                    <?php if ($kind === 'select'): ?>
                        <div class="filter">
                            <label for="f_<?= e($field) ?>"><?= e($label) ?></label>
                            <select id="f_<?= e($field) ?>" name="<?= e($field) ?>">
                                <option value="">Any</option>
                                <?php foreach ($options[$field] as $option): ?>
                                    <option value="<?= e($option['value']) ?>"
                                        <?= (($_GET[$field] ?? '') === $option['value']) ? 'selected' : '' ?>>
                                        <?= e($option['value']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <?php
                        $maximum = fetch_rows(
                            $db,
                            "SELECT MAX(s.`$field`) AS maximum
                             FROM `$table` s
                             JOIN components c ON c.component_id = s.component_id
                             WHERE c.type = ? AND c.is_active = 1",
                            's',
                            [$category]
                        )[0]['maximum'] ?? 100;
                        $maximum = max((float) $maximum, 1);
                        $value = isset($_GET['min_' . $field]) && is_numeric($_GET['min_' . $field])
                            ? (float) $_GET['min_' . $field]
                            : 0;
                        $step = str_contains($field, 'clock') ? '0.1' : ($maximum > 100 ? 5 : 1);
                        ?>
                        <div class="filter">
                            <label for="f_<?= e($field) ?>">
                                <?= e($label) ?>
                                <span class="range-value" id="v_<?= e($field) ?>"><?= e($value) ?></span>
                            </label>
                            <input type="range"
                                   id="f_<?= e($field) ?>"
                                   name="min_<?= e($field) ?>"
                                   min="0"
                                   max="<?= e($maximum) ?>"
                                   step="<?= e($step) ?>"
                                   value="<?= e(min($value, $maximum)) ?>"
                                   oninput="document.getElementById('v_<?= e($field) ?>').textContent = this.value">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="filter">
                    <label for="max_price">Maximum price (€)</label>
                    <input type="number" id="max_price" name="max_price"
                           min="0" step="10" value="<?= e($_GET['max_price'] ?? '') ?>"
                           placeholder="Any">
                </div>
                <div class="filter">
                    <label for="sort">Sort results</label>
                    <select id="sort" name="sort">
                        <option value="">Recommended</option>
                        <option value="low" <?= $sort === 'low' ? 'selected' : '' ?>>Price: low to high</option>
                        <option value="high" <?= $sort === 'high' ? 'selected' : '' ?>>Price: high to low</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <button class="primary" type="submit">Apply filters</button>
                <a href="<?= e(basename($_SERVER['PHP_SELF'])) ?>">Reset filters</a>
            </div>
        </form>

        <div class="results">
            <strong><?= e($category) ?> options</strong>
            <span><?= count($items) ?> result<?= count($items) === 1 ? '' : 's' ?></span>
        </div>

        <div class="product-grid">
            <?php if (!$items): ?>
                <div class="empty">
                    No components match. Try changing the filters<?= !$allBrands ? ' or run the sample catalog loader first' : '' ?>.
                </div>
            <?php endif; ?>

            <?php foreach ($items as $item): ?>
                <?php
                $specText = [];
                foreach ($definition['labels'] as $field => $label) {
                    if (isset($item[$field])) {
                        $specText[] = $label . ': ' . $item[$field];
                    }
                }
                ?>
                <article class="product">
                    <div>
                        <h3><?= e($item['brand'] . ' ' . $item['name']) ?></h3>
                        <p>
                            <?= e($item['type']) ?> ·
                            <span class="specs"><?= e(implode(' · ', $specText) ?: 'General component listing') ?></span>
                        </p>
                    </div>
                    <div class="price">
                        <?= euro($item['price']) ?>
                        <form method="post" action="builder.php">
                            <input type="hidden" name="component_id" value="<?= (int) $item['component_id'] ?>">
                            <button class="primary" type="submit">Add to build</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($category === 'Case'): ?>
            <p class="note" style="margin-top:12px">
                Case listings use the shared components table. The current database has no case-specific specifications, so filters are Brand and Price.
            </p>
        <?php endif; ?>
    </section>
</div>

<script>
    document.querySelectorAll('input[type=range]').forEach((input) => {
        input.dispatchEvent(new Event('input'));
    });
</script>
<?php require 'footer.php'; ?>
