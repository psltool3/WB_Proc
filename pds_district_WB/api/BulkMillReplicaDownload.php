<?php
require('../util/Connection.php');
require('../structures/MillReplica.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');
require('../util/Security.php');
require ('../util/Encryption.php');
require('../util/Logger.php');
$nonceValue = 'nonce_value';

if(!SessionCheck()){
	return;
}

$mapData = [
    "District" => "district",
    "Name of Mill Inter" => "name",
    "Mill Inter ID" => "id",
    "Mill Inter Type" => "type",
    "Latitude" => "latitude",
    "Longitude" => "longitude",
    "Incoming Minimum of Mota" => "incoming_min_mota",
    "Incoming Minimum of Patla" => "incoming_min_patla",
    "Incoming Minimum of Saran" => "incoming_min_saran",
    "Total Normal Rice (Qtl) Inventory" => "outgoing_min_mota",
    "Total State FRK Rice (Qtl) Inventory" => "outgoing_min_patla",
    "Total Central FRK Rice(Qtl) Inventory" => "outgoing_min_saran",
    "Milling Capacity Mota" => "milling_capacity",
    "Milling Capacity Patla" => "milling_capacity1",
    "Milling Capacity Saran" => "milling_capacity2",
	"Active/Not-Active" => "active"
];

// Reverse mapping
$reverseMapData = array_flip($mapData);

// Excel file name for download 
$fileName = "MillReplicaTemplate_" . date('d-m-Y') . ".csv"; 

// Headers for download 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0'); // no cache

// Display column names as first row 
echo implode(",", array_keys($mapData)) . "\n";

exit();
?>
