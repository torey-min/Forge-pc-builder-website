<?php
declare(strict_types=1);

// Demo catalog for the PC Builder coursework.
// Prices are illustrative EUR values. Verify component specifications against
// manufacturer pages before using this catalog outside a classroom demo.

$servername = 'MinProject';
$username = 'root';
$password = '';
$dbname = 'pc_builder';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$catalog = [
    'CPU' => [
        ['AMD', 'Ryzen 5 3600', 89.00, ['AM4', 6, 12, 3.6, 4.2, 65]],
        ['AMD', 'Ryzen 5 5600', 109.00, ['AM4', 6, 12, 3.5, 4.4, 65]],
        ['AMD', 'Ryzen 7 5700X', 159.00, ['AM4', 8, 16, 3.4, 4.6, 65]],
        ['AMD', 'Ryzen 7 5800X3D', 249.00, ['AM4', 8, 16, 3.4, 4.5, 105]],
        ['AMD', 'Ryzen 5 7600', 189.00, ['AM5', 6, 12, 3.8, 5.1, 65]],
        ['AMD', 'Ryzen 5 7600X', 209.00, ['AM5', 6, 12, 4.7, 5.3, 105]],
        ['AMD', 'Ryzen 7 7700', 269.00, ['AM5', 8, 16, 3.8, 5.3, 65]],
        ['AMD', 'Ryzen 7 7800X3D', 349.00, ['AM5', 8, 16, 4.2, 5.0, 120]],
        ['AMD', 'Ryzen 9 7900', 329.00, ['AM5', 12, 24, 3.7, 5.4, 65]],
        ['AMD', 'Ryzen 9 7950X', 499.00, ['AM5', 16, 32, 4.5, 5.7, 170]],
        ['AMD', 'Ryzen 5 8600G', 169.00, ['AM5', 6, 12, 4.3, 5.0, 65]],
        ['AMD', 'Ryzen 7 8700G', 249.00, ['AM5', 8, 16, 4.2, 5.1, 65]],
        ['AMD', 'Ryzen 5 9600X', 249.00, ['AM5', 6, 12, 3.9, 5.4, 65]],
        ['AMD', 'Ryzen 7 9700X', 329.00, ['AM5', 8, 16, 3.8, 5.5, 65]],
        ['AMD', 'Ryzen 7 9800X3D', 479.00, ['AM5', 8, 16, 4.7, 5.2, 120]],
        ['Intel', 'Core i5-12400F', 119.00, ['LGA1700', 6, 12, 2.5, 4.4, 65]],
        ['Intel', 'Core i5-12600K', 189.00, ['LGA1700', 10, 16, 3.7, 4.9, 125]],
        ['Intel', 'Core i5-13400F', 169.00, ['LGA1700', 10, 16, 2.5, 4.6, 65]],
        ['Intel', 'Core i5-14400', 199.00, ['LGA1700', 10, 16, 2.5, 4.7, 65]],
        ['Intel', 'Core i5-14600K', 279.00, ['LGA1700', 14, 20, 3.5, 5.3, 125]],
    ],
    'GPU' => [
        ['NVIDIA', 'GeForce RTX 3060 12GB', 279.00, [12, 242, 170, '1 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3060 Ti 8GB', 329.00, [8, 242, 200, '1 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3070 8GB', 379.00, [8, 242, 220, '2 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3070 Ti 8GB', 419.00, [8, 267, 290, '2 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3080 10GB', 499.00, [10, 285, 320, '2 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3080 Ti 12GB', 599.00, [12, 285, 350, '2 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 3090 24GB', 799.00, [24, 313, 350, '2 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 4060 8GB', 289.00, [8, 240, 115, '1 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 4060 Ti 8GB', 349.00, [8, 244, 160, '1 x 8-pin']],
        ['NVIDIA', 'GeForce RTX 4070 12GB', 499.00, [12, 244, 200, '16-pin']],
        ['NVIDIA', 'GeForce RTX 4070 SUPER 12GB', 549.00, [12, 244, 220, '16-pin']],
        ['NVIDIA', 'GeForce RTX 4070 Ti SUPER 16GB', 699.00, [16, 285, 285, '16-pin']],
        ['NVIDIA', 'GeForce RTX 4080 SUPER 16GB', 899.00, [16, 304, 320, '16-pin']],
        ['NVIDIA', 'GeForce RTX 4090 24GB', 1699.00, [24, 304, 450, '16-pin']],
        ['NVIDIA', 'GeForce RTX 5070 Founders Edition', 649.00, [12, 242, 250, '16-pin']],
        ['AMD', 'Radeon RX 6600 8GB', 229.00, [8, 237, 132, '1 x 8-pin']],
        ['AMD', 'Radeon RX 6700 XT 12GB', 329.00, [12, 267, 230, '1 x 8-pin + 1 x 6-pin']],
        ['AMD', 'Radeon RX 7600 8GB', 269.00, [8, 204, 165, '1 x 8-pin']],
        ['AMD', 'Radeon RX 7700 XT 12GB', 419.00, [12, 267, 245, '2 x 8-pin']],
        ['AMD', 'Radeon RX 7800 XT 16GB', 499.00, [16, 267, 263, '2 x 8-pin']],
    ],
    'Motherboard' => [
        ['ASUS', 'TUF GAMING B550-PLUS WIFI', 139.00, ['AM4', 'B550', 'ATX', 'DDR4', 4, 128, 2, 8]],
        ['MSI', 'MAG B550 TOMAHAWK', 149.00, ['AM4', 'B550', 'ATX', 'DDR4', 4, 128, 2, 6]],
        ['Gigabyte', 'B550 AORUS ELITE V2', 139.00, ['AM4', 'B550', 'ATX', 'DDR4', 4, 128, 2, 4]],
        ['ASRock', 'B550 Steel Legend', 149.00, ['AM4', 'B550', 'ATX', 'DDR4', 4, 128, 2, 8]],
        ['ASUS', 'ROG STRIX B550-F GAMING WIFI II', 169.00, ['AM4', 'B550', 'ATX', 'DDR4', 4, 128, 2, 6]],
        ['MSI', 'MAG X570S TOMAHAWK MAX WIFI', 199.00, ['AM4', 'X570', 'ATX', 'DDR4', 4, 128, 3, 8]],
        ['ASUS', 'PRIME B550M-A WIFI II', 109.00, ['AM4', 'B550', 'Micro-ATX', 'DDR4', 4, 128, 2, 4]],
        ['MSI', 'B550M PRO-VDH WIFI', 99.00, ['AM4', 'B550', 'Micro-ATX', 'DDR4', 4, 128, 2, 4]],
        ['ASUS', 'TUF GAMING B650-PLUS WIFI', 179.00, ['AM5', 'B650', 'ATX', 'DDR5', 4, 192, 3, 4]],
        ['MSI', 'MAG B650 TOMAHAWK WIFI', 199.00, ['AM5', 'B650', 'ATX', 'DDR5', 4, 256, 3, 6]],
        ['Gigabyte', 'B650 AORUS ELITE AX', 189.00, ['AM5', 'B650', 'ATX', 'DDR5', 4, 192, 3, 4]],
        ['ASRock', 'B650E Steel Legend WiFi', 229.00, ['AM5', 'B650E', 'ATX', 'DDR5', 4, 256, 3, 4]],
        ['MSI', 'MAG X670E TOMAHAWK WIFI', 279.00, ['AM5', 'X670E', 'ATX', 'DDR5', 4, 256, 4, 6]],
        ['ASUS', 'TUF GAMING X670E-PLUS WIFI', 279.00, ['AM5', 'X670E', 'ATX', 'DDR5', 4, 128, 4, 4]],
        ['ASUS', 'PRIME B650M-A WIFI', 159.00, ['AM5', 'B650', 'Micro-ATX', 'DDR5', 4, 128, 2, 4]],
        ['MSI', 'PRO B650M-A WIFI', 149.00, ['AM5', 'B650', 'Micro-ATX', 'DDR5', 4, 128, 2, 4]],
        ['MSI', 'PRO B760M-A WIFI DDR4', 129.00, ['LGA1700', 'B760', 'Micro-ATX', 'DDR4', 4, 128, 2, 4]],
        ['ASUS', 'TUF GAMING B760-PLUS WIFI D4', 169.00, ['LGA1700', 'B760', 'ATX', 'DDR4', 4, 128, 3, 4]],
        ['MSI', 'MAG B760 TOMAHAWK WIFI', 189.00, ['LGA1700', 'B760', 'ATX', 'DDR5', 4, 192, 3, 4]],
        ['MSI', 'MAG Z790 TOMAHAWK WIFI', 259.00, ['LGA1700', 'Z790', 'ATX', 'DDR5', 4, 192, 4, 7]],
    ],
    'RAM' => [
        ['Kingston', 'FURY Beast DDR5 32GB (2x16GB) 6000MT/s', 99.00, ['DDR5', 32, 2, 6000]],
        ['Corsair', 'Vengeance DDR4 32GB (2x16GB) 3200MT/s', 64.00, ['DDR4', 32, 2, 3200]],
        ['Corsair', 'Vengeance LPX DDR4 16GB (2x8GB) 3200MT/s', 39.00, ['DDR4', 16, 2, 3200]],
        ['Corsair', 'Vengeance LPX DDR4 64GB (2x32GB) 3600MT/s', 129.00, ['DDR4', 64, 2, 3600]],
        ['Kingston', 'FURY Beast DDR4 16GB (2x8GB) 3600MT/s', 42.00, ['DDR4', 16, 2, 3600]],
        ['Kingston', 'FURY Beast DDR5 16GB (2x8GB) 5200MT/s', 54.00, ['DDR5', 16, 2, 5200]],
        ['Kingston', 'FURY Beast DDR5 64GB (2x32GB) 6000MT/s', 179.00, ['DDR5', 64, 2, 6000]],
        ['G.Skill', 'Ripjaws V DDR4 32GB (2x16GB) 3600MT/s', 69.00, ['DDR4', 32, 2, 3600]],
        ['G.Skill', 'Trident Z Neo DDR4 32GB (2x16GB) 3600MT/s', 89.00, ['DDR4', 32, 2, 3600]],
        ['G.Skill', 'Ripjaws S5 DDR5 32GB (2x16GB) 6000MT/s', 99.00, ['DDR5', 32, 2, 6000]],
        ['G.Skill', 'Flare X5 DDR5 32GB (2x16GB) 6000MT/s', 99.00, ['DDR5', 32, 2, 6000]],
        ['G.Skill', 'Trident Z5 Neo RGB DDR5 32GB (2x16GB) 6000MT/s', 119.00, ['DDR5', 32, 2, 6000]],
        ['Crucial', 'Pro DDR4 32GB (2x16GB) 3200MT/s', 59.00, ['DDR4', 32, 2, 3200]],
        ['Crucial', 'Pro DDR5 32GB (2x16GB) 5600MT/s', 89.00, ['DDR5', 32, 2, 5600]],
        ['Crucial', 'Pro DDR5 64GB (2x32GB) 5600MT/s', 159.00, ['DDR5', 64, 2, 5600]],
        ['TeamGroup', 'T-Force Vulcan Z DDR4 16GB (2x8GB) 3200MT/s', 35.00, ['DDR4', 16, 2, 3200]],
        ['TeamGroup', 'T-Force Vulcan DDR5 32GB (2x16GB) 6000MT/s', 84.00, ['DDR5', 32, 2, 6000]],
        ['Patriot', 'Viper Steel DDR4 32GB (2x16GB) 3600MT/s', 64.00, ['DDR4', 32, 2, 3600]],
        ['Silicon Power', 'XPOWER Zenith DDR5 32GB (2x16GB) 6000MT/s', 79.00, ['DDR5', 32, 2, 6000]],
        ['Corsair', 'Vengeance DDR5 32GB (2x16GB) 6400MT/s', 109.00, ['DDR5', 32, 2, 6400]],
    ],
    'Storage' => [
        ['Samsung', '990 EVO Plus 1TB NVMe SSD', 89.00, ['NVMe SSD', 'M.2', 1000]],
        ['Samsung', '870 EVO 1TB SATA SSD', 85.00, ['SSD', 'SATA', 1000]],
        ['Samsung', '990 PRO 1TB NVMe SSD', 109.00, ['NVMe SSD', 'M.2', 1000]],
        ['Samsung', '990 PRO 2TB NVMe SSD', 169.00, ['NVMe SSD', 'M.2', 2000]],
        ['Samsung', '980 PRO 1TB NVMe SSD', 99.00, ['NVMe SSD', 'M.2', 1000]],
        ['Samsung', '870 EVO 2TB SATA SSD', 149.00, ['SSD', 'SATA', 2000]],
        ['Samsung', '870 QVO 2TB SATA SSD', 119.00, ['SSD', 'SATA', 2000]],
        ['Western Digital', 'WD_BLACK SN850X 1TB NVMe SSD', 99.00, ['NVMe SSD', 'M.2', 1000]],
        ['Western Digital', 'WD_BLACK SN850X 2TB NVMe SSD', 159.00, ['NVMe SSD', 'M.2', 2000]],
        ['Western Digital', 'WD Blue SN580 1TB NVMe SSD', 69.00, ['NVMe SSD', 'M.2', 1000]],
        ['Western Digital', 'WD Blue SN580 2TB NVMe SSD', 119.00, ['NVMe SSD', 'M.2', 2000]],
        ['Crucial', 'P3 Plus 1TB NVMe SSD', 69.00, ['NVMe SSD', 'M.2', 1000]],
        ['Crucial', 'T500 2TB NVMe SSD', 149.00, ['NVMe SSD', 'M.2', 2000]],
        ['Crucial', 'MX500 1TB SATA SSD', 69.00, ['SSD', 'SATA', 1000]],
        ['Crucial', 'MX500 2TB SATA SSD', 119.00, ['SSD', 'SATA', 2000]],
        ['Kingston', 'KC3000 1TB NVMe SSD', 99.00, ['NVMe SSD', 'M.2', 1000]],
        ['Kingston', 'NV2 2TB NVMe SSD', 109.00, ['NVMe SSD', 'M.2', 2000]],
        ['Seagate', 'BarraCuda 2TB HDD', 59.00, ['HDD', 'SATA', 2000]],
        ['Seagate', 'BarraCuda 4TB HDD', 89.00, ['HDD', 'SATA', 4000]],
        ['Western Digital', 'WD Blue 4TB HDD', 99.00, ['HDD', 'SATA', 4000]],
    ],
    'PSU' => [
        ['Corsair', 'RM750e 750W 80 PLUS Gold', 109.00, [750, '80+ Gold', 'Fully modular']],
        ['Corsair', 'CX650M 650W 80 PLUS Bronze', 69.00, [650, '80+ Bronze', 'Semi-modular']],
        ['Corsair', 'RM650x 650W 80 PLUS Gold', 99.00, [650, '80+ Gold', 'Fully modular']],
        ['Corsair', 'RM850x 850W 80 PLUS Gold', 139.00, [850, '80+ Gold', 'Fully modular']],
        ['Corsair', 'RM1000x 1000W 80 PLUS Gold', 189.00, [1000, '80+ Gold', 'Fully modular']],
        ['Corsair', 'RM850e 850W 80 PLUS Gold', 129.00, [850, '80+ Gold', 'Fully modular']],
        ['be quiet!', 'Pure Power 12 M 750W 80 PLUS Gold', 119.00, [750, '80+ Gold', 'Fully modular']],
        ['be quiet!', 'Pure Power 12 M 850W 80 PLUS Gold', 139.00, [850, '80+ Gold', 'Fully modular']],
        ['be quiet!', 'Pure Power 12 M 1000W 80 PLUS Gold', 179.00, [1000, '80+ Gold', 'Fully modular']],
        ['MSI', 'MAG A650BN 650W 80 PLUS Bronze', 59.00, [650, '80+ Bronze', 'Non-modular']],
        ['MSI', 'MAG A750GL PCIE5 750W 80 PLUS Gold', 109.00, [750, '80+ Gold', 'Fully modular']],
        ['MSI', 'MAG A850GL PCIE5 850W 80 PLUS Gold', 129.00, [850, '80+ Gold', 'Fully modular']],
        ['Seasonic', 'FOCUS GX-750 750W 80 PLUS Gold', 119.00, [750, '80+ Gold', 'Fully modular']],
        ['Seasonic', 'FOCUS GX-850 850W 80 PLUS Gold', 139.00, [850, '80+ Gold', 'Fully modular']],
        ['EVGA', 'SuperNOVA 750 GT 750W 80 PLUS Gold', 109.00, [750, '80+ Gold', 'Fully modular']],
        ['NZXT', 'C750 Gold 750W 80 PLUS Gold', 119.00, [750, '80+ Gold', 'Fully modular']],
        ['Thermaltake', 'Toughpower GF A3 850W 80 PLUS Gold', 129.00, [850, '80+ Gold', 'Fully modular']],
        ['Cooler Master', 'MWE Gold 850 V2 850W 80 PLUS Gold', 119.00, [850, '80+ Gold', 'Fully modular']],
        ['Fractal Design', 'Ion Gold 750W 80 PLUS Gold', 119.00, [750, '80+ Gold', 'Fully modular']],
        ['SilverStone', 'FAR 750W 80 PLUS Gold', 109.00, [750, '80+ Gold', 'Fully modular']],
    ],
    'Case' => [
        ['Generic', 'Sample ATX Mid-Tower Case', 89.00],
        ['Fractal Design', 'Pop Air', 99.00],
        ['Fractal Design', 'North', 149.00],
        ['Fractal Design', 'Meshify 2 Compact', 129.00],
        ['Fractal Design', 'Torrent Compact', 159.00],
        ['NZXT', 'H5 Flow', 99.00],
        ['NZXT', 'H7 Flow', 139.00],
        ['Corsair', '4000D Airflow', 109.00],
        ['Corsair', '5000D Airflow', 179.00],
        ['Corsair', '4000X RGB', 149.00],
        ['Cooler Master', 'MasterBox NR600', 89.00],
        ['Cooler Master', 'TD500 Mesh V2', 119.00],
        ['Lian Li', 'LANCOOL 216', 119.00],
        ['Lian Li', 'O11 Dynamic EVO', 169.00],
        ['Lian Li', 'LANCOOL 205 Mesh', 99.00],
        ['Phanteks', 'Eclipse G360A', 99.00],
        ['Phanteks', 'Eclipse P400A', 99.00],
        ['Antec', 'NX410', 89.00],
        ['be quiet!', 'Pure Base 500DX', 129.00],
        ['Montech', 'Air 903 Max', 89.00],
    ],
];

$specUpserts = [
    'CPU' => [
        'sql' => 'INSERT INTO cpu_specs (component_id, socket, cores, threads, base_clock_ghz, boost_clock_ghz, tdp_w) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE socket=VALUES(socket), cores=VALUES(cores), threads=VALUES(threads), base_clock_ghz=VALUES(base_clock_ghz), boost_clock_ghz=VALUES(boost_clock_ghz), tdp_w=VALUES(tdp_w)',
        'types' => 'isiiddi',
    ],
    'GPU' => [
        'sql' => 'INSERT INTO gpu_specs (component_id, vram_gb, length_mm, tdp_w, power_connectors) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE vram_gb=VALUES(vram_gb), length_mm=VALUES(length_mm), tdp_w=VALUES(tdp_w), power_connectors=VALUES(power_connectors)',
        'types' => 'iiiis',
    ],
    'Motherboard' => [
        'sql' => 'INSERT INTO motherboard_specs (component_id, socket, chipset, form_factor, ram_type, ram_slots, max_ram_gb, m2_slots, sata_ports) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE socket=VALUES(socket), chipset=VALUES(chipset), form_factor=VALUES(form_factor), ram_type=VALUES(ram_type), ram_slots=VALUES(ram_slots), max_ram_gb=VALUES(max_ram_gb), m2_slots=VALUES(m2_slots), sata_ports=VALUES(sata_ports)',
        'types' => 'issssiiii',
    ],
    'RAM' => [
        'sql' => 'INSERT INTO ram_specs (component_id, ram_type, capacity_gb, modules, speed_mhz) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE ram_type=VALUES(ram_type), capacity_gb=VALUES(capacity_gb), modules=VALUES(modules), speed_mhz=VALUES(speed_mhz)',
        'types' => 'isiii',
    ],
    'Storage' => [
        'sql' => 'INSERT INTO storage_specs (component_id, storage_type, interface, capacity_gb) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE storage_type=VALUES(storage_type), interface=VALUES(interface), capacity_gb=VALUES(capacity_gb)',
        'types' => 'issi',
    ],
    'PSU' => [
        'sql' => 'INSERT INTO psu_specs (component_id, wattage, efficiency_rating, modular) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE wattage=VALUES(wattage), efficiency_rating=VALUES(efficiency_rating), modular=VALUES(modular)',
        'types' => 'iiss',
    ],
];

function bindAndExecute(mysqli_stmt $statement, string $types, array $values): void
{
    $arguments = [$types];
    foreach ($values as &$value) {
        $arguments[] = &$value;
    }
    call_user_func_array([$statement, 'bind_param'], $arguments);
    $statement->execute();
}

$connection = null;
try {
    $connection = new mysqli($servername, $username, $password, $dbname);
    $connection->set_charset('utf8mb4');
    $connection->begin_transaction();

    $findComponent = $connection->prepare(
        'SELECT component_id FROM components WHERE type = ? AND brand = ? AND name = ? LIMIT 1'
    );
    $insertComponent = $connection->prepare(
        'INSERT INTO components (type, brand, name, price, image_url, is_active) VALUES (?, ?, ?, ?, NULL, 1)'
    );
    $updateComponent = $connection->prepare(
        'UPDATE components SET price = ?, is_active = 1 WHERE component_id = ?'
    );
    $componentId = 0;
    $findComponent->bind_param('sss', $type, $brand, $name);
    $findComponent->bind_result($componentId);

    $preparedSpecs = [];
    foreach ($specUpserts as $typeName => $definition) {
        $preparedSpecs[$typeName] = $connection->prepare($definition['sql']);
    }

    foreach ($catalog as $type => $items) {
        foreach ($items as $item) {
            [$brand, $name, $price, $specs] = array_pad($item, 4, null);
            $findComponent->free_result();
            $findComponent->execute();
            $found = $findComponent->fetch();
            $findComponent->free_result();

            if ($found) {
                bindAndExecute($updateComponent, 'di', [$price, $componentId]);
            } else {
                bindAndExecute($insertComponent, 'sssd', [$type, $brand, $name, $price]);
                $componentId = (int) $connection->insert_id;
            }

            if (isset($specUpserts[$type])) {
                $definition = $specUpserts[$type];
                bindAndExecute($preparedSpecs[$type], $definition['types'], array_merge([$componentId], $specs));
            }
        }
    }

    $connection->commit();
    echo '<h1>Sample catalog is ready</h1>';
    echo '<p>20 components were added or updated in each of the seven categories (140 total).</p>';
    echo '<p>Sample prices are illustrative EUR values. Case listings use the existing components table; no case_specs table was added.</p>';
    echo '<p>For security, remove or restrict access to this setup script after running it.</p>';
} catch (Throwable $exception) {
    if ($connection instanceof mysqli) {
        try {
            $connection->rollback();
        } catch (Throwable $ignored) {
            // The connection may not have reached the transaction stage.
        }
    }
    http_response_code(500);
    error_log($exception->getMessage());
    echo '<h1>Sample catalog could not be loaded</h1>';
    echo '<p>Check the MySQL service, connection settings, and database tables.</p>';
}

if ($connection instanceof mysqli) {
    $connection->close();
}
?>