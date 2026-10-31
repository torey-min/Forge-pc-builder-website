<!DOCTYPE html>
<html>
<head>
    <title>Creating PC Builder Database</title>
</head>
<body>

<?php

$servername = "MinProject"; 
$username = "root";
$password = "";
$dbname = "pc_builder";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dbname = "pc_builder";

// Create database if it does not already exist.
// This avoids deleting existing data every time the script is run.
$sql = "CREATE DATABASE IF NOT EXISTS $dbname
        CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->close();

// Connect to the PC Builder database
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "users table created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create components table
$sql = "CREATE TABLE IF NOT EXISTS components (
    component_id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('CPU', 'GPU', 'Motherboard', 'RAM', 'Storage', 'PSU', 'Case') NOT NULL,
    brand VARCHAR(60) NOT NULL,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    image_url VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "components table created successfully<br>";
} else {
    echo "Error creating components table: " . $conn->error . "<br>";
}

// Create cpu_specs table
$sql = "CREATE TABLE IF NOT EXISTS cpu_specs (
    component_id INT PRIMARY KEY,
    socket VARCHAR(20) NOT NULL,
    cores TINYINT NOT NULL,
    threads TINYINT NOT NULL,
    base_clock_ghz DECIMAL(3,1) NOT NULL,
    boost_clock_ghz DECIMAL(3,1) NOT NULL,
    tdp_w SMALLINT NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "cpu_specs table created successfully<br>";
} else {
    echo "Error creating cpu_specs table: " . $conn->error . "<br>";
}

// Create gpu_specs table
$sql = "CREATE TABLE IF NOT EXISTS gpu_specs (
    component_id INT PRIMARY KEY,
    vram_gb TINYINT NOT NULL,
    length_mm SMALLINT NOT NULL,
    tdp_w SMALLINT NOT NULL,
    power_connectors VARCHAR(40) NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "gpu_specs table created successfully<br>";
} else {
    echo "Error creating gpu_specs table: " . $conn->error . "<br>";
}

// Create motherboard_specs table
$sql = "CREATE TABLE IF NOT EXISTS motherboard_specs (
    component_id INT PRIMARY KEY,
    socket VARCHAR(20) NOT NULL,
    chipset VARCHAR(30) NOT NULL,
    form_factor ENUM('ATX', 'Micro-ATX', 'Mini-ITX', 'E-ATX', 'Other') NOT NULL,
    ram_type ENUM('DDR4', 'DDR5') NOT NULL,
    ram_slots TINYINT NOT NULL,
    max_ram_gb SMALLINT NOT NULL,
    m2_slots TINYINT NOT NULL,
    sata_ports TINYINT NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "motherboard_specs table created successfully<br>";
} else {
    echo "Error creating motherboard_specs table: " . $conn->error . "<br>";
}

// Create ram_specs table
$sql = "CREATE TABLE IF NOT EXISTS ram_specs (
    component_id INT PRIMARY KEY,
    ram_type ENUM('DDR4', 'DDR5') NOT NULL,
    capacity_gb SMALLINT NOT NULL,
    modules TINYINT NOT NULL,
    speed_mhz SMALLINT NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "ram_specs table created successfully<br>";
} else {
    echo "Error creating ram_specs table: " . $conn->error . "<br>";
}

// Create storage_specs table
$sql = "CREATE TABLE IF NOT EXISTS storage_specs (
    component_id INT PRIMARY KEY,
    storage_type ENUM('HDD', 'SSD', 'NVMe SSD') NOT NULL,
    interface ENUM('M.2', 'SATA') NOT NULL,
    capacity_gb INT NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "storage_specs table created successfully<br>";
} else {
    echo "Error creating storage_specs table: " . $conn->error . "<br>";
}

// Create psu_specs table
$sql = "CREATE TABLE IF NOT EXISTS psu_specs (
    component_id INT PRIMARY KEY,
    wattage SMALLINT NOT NULL,
    efficiency_rating ENUM('80+', '80+ Bronze', '80+ Silver', '80+ Gold', '80+ Platinum', '80+ Titanium') NOT NULL,
    modular ENUM('Non-modular', 'Semi-modular', 'Fully modular') NOT NULL,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "psu_specs table created successfully<br>";
} else {
    echo "Error creating psu_specs table: " . $conn->error . "<br>";
}

// Create builds table
$sql = "CREATE TABLE IF NOT EXISTS builds (
    build_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    notes TEXT,
    is_public TINYINT(1) DEFAULT 0,
    share_token CHAR(32) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "builds table created successfully<br>";
} else {
    echo "Error creating builds table: " . $conn->error . "<br>";
}

// Create build_components table
$sql = "CREATE TABLE IF NOT EXISTS build_components (
    build_id INT NOT NULL,
    component_id INT NOT NULL,
    quantity TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY (build_id, component_id),
    FOREIGN KEY (build_id) REFERENCES builds(build_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (component_id) REFERENCES components(component_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "build_components table created successfully<br>";
} else {
    echo "Error creating build_components table: " . $conn->error . "<br>";
}

$conn->close();
?>

</body>
</html>
