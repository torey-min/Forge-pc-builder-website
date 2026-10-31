<?php
declare(strict_types=1);
session_start();
$servername = 'MinProject';
$dbname = 'pc_builder';
$username = 'root';
$password = '';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $db = new mysqli($servername, $username, $password, $dbname);
    $db->set_charset('utf8mb4');
} catch (Throwable $e) {
    http_response_code(503);
    $db_error = 'The PC Builder database is not available. Check that MySQL is running and that the connection settings in config.php match your setup.';
}
function e(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function euro(mixed $price): string { return '€' . number_format((float)$price, 2); }
function categories(): array { return ['CPU'=>'cpu.php','Motherboard'=>'motherboard.php','GPU'=>'gpu.php','RAM'=>'ram.php','Storage'=>'storage.php','PSU'=>'psu.php','Case'=>'case.php']; }
function bind_values(mysqli_stmt $stmt, string $types, array $values): void { if (!$values) return; $args=[$types]; foreach($values as &$value) $args[]=&$value; call_user_func_array([$stmt,'bind_param'],$args); }
function fetch_rows(mysqli $db, string $sql, string $types='', array $values=[]): array { $stmt=$db->prepare($sql); bind_values($stmt,$types,$values); $stmt->execute(); $rows=$stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close(); return $rows; }
function spec_definitions(): array {
 return [
 'CPU'=>['table'=>'cpu_specs','filters'=>['socket'=>['Socket','select'],'cores'=>['Cores','range'],'threads'=>['Threads','range'],'base_clock_ghz'=>['Base clock (GHz)','range'],'boost_clock_ghz'=>['Boost clock (GHz)','range'],'tdp_w'=>['TDP (W)','range']],'labels'=>['socket'=>'Socket','cores'=>'Cores','threads'=>'Threads','base_clock_ghz'=>'Base clock (GHz)','boost_clock_ghz'=>'Boost clock (GHz)','tdp_w'=>'TDP (W)']],
 'GPU'=>['table'=>'gpu_specs','filters'=>['vram_gb'=>['VRAM (GB)','range'],'length_mm'=>['Maximum length (mm)','range'],'tdp_w'=>['TDP (W)','range'],'power_connectors'=>['Power connector','select']],'labels'=>['vram_gb'=>'VRAM (GB)','length_mm'=>'Length (mm)','tdp_w'=>'TDP (W)','power_connectors'=>'Power connector']],
 'Motherboard'=>['table'=>'motherboard_specs','filters'=>['socket'=>['Socket','select'],'chipset'=>['Chipset','select'],'form_factor'=>['Form factor','select'],'ram_type'=>['Memory type','select'],'ram_slots'=>['RAM slots','range'],'max_ram_gb'=>['Maximum RAM (GB)','range'],'m2_slots'=>['M.2 slots','range'],'sata_ports'=>['SATA ports','range']],'labels'=>['socket'=>'Socket','chipset'=>'Chipset','form_factor'=>'Form factor','ram_type'=>'Memory type','ram_slots'=>'RAM slots','max_ram_gb'=>'Maximum RAM (GB)','m2_slots'=>'M.2 slots','sata_ports'=>'SATA ports']],
 'RAM'=>['table'=>'ram_specs','filters'=>['ram_type'=>['Memory type','select'],'capacity_gb'=>['Capacity (GB)','range'],'modules'=>['Modules','range'],'speed_mhz'=>['Speed (MHz)','range']],'labels'=>['ram_type'=>'Memory type','capacity_gb'=>'Capacity (GB)','modules'=>'Modules','speed_mhz'=>'Speed (MHz)']],
 'Storage'=>['table'=>'storage_specs','filters'=>['storage_type'=>['Drive type','select'],'interface'=>['Interface','select'],'capacity_gb'=>['Capacity (GB)','range']],'labels'=>['storage_type'=>'Drive type','interface'=>'Interface','capacity_gb'=>'Capacity (GB)']],
 'PSU'=>['table'=>'psu_specs','filters'=>['wattage'=>['Wattage (W)','range'],'efficiency_rating'=>['Efficiency','select'],'modular'=>['Modularity','select']],'labels'=>['wattage'=>'Wattage (W)','efficiency_rating'=>'Efficiency','modular'=>'Modularity']],
 'Case'=>['table'=>null,'filters'=>[],'labels'=>[]]
 ];
}
function selected_build_rows(mysqli $db): array {
 $ids=array_values(array_filter(array_map('intval',$_SESSION['build']??[])));
 if(!$ids)return [];
 $marks=implode(',',array_fill(0,count($ids),'?'));
 return fetch_rows($db,"SELECT component_id,type,brand,name,price FROM components WHERE is_active=1 AND component_id IN ($marks)",str_repeat('i',count($ids)),$ids);
}
