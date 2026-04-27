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

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

// Excel file name for download 
$fileName = "MillReplicaData_" . date('d-m-Y') . ".csv"; 

$columns = array();

$query = "SHOW COLUMNS FROM mill_replica";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);
if($numrows>0){
	while($row = mysqli_fetch_array($result)){
		if($row['Field']!="uniqueid"){
			array_push($columns,$reverseMapData[$row['Field']]);
		}
	}
}


// Headers for download 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Display column names as first row 
$excelDataColumns = implode(",", array_values($columns)) . "\n";

// Render excel data 
echo $excelDataColumns;

$query = "SELECT * FROM mill_replica WHERE 1";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);
if($numrows>0){
	while($row = mysqli_fetch_array($result)){
		for($i=0;$i<count($columns);$i++){
			if ($columns[$i] !== "uniqueid") {
				filterData($row[$mapData[$columns[$i]]]);
				echo '"' . $row[$mapData[$columns[$i]]] . '",';
            }
        }
		echo "\n";
	}
}

exit();

?>
