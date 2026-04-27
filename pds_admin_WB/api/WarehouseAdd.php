<?php

require('../util/Connection.php');
require('../structures/Warehouse.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');
require('../util/Logger.php');

require('../util/Security.php');
require ('../util/Encryption.php');
$nonceValue = 'nonce_value';

if(!SessionCheck()){
    die("Unauthorized access. Admin login required.");
	return;
}

require('Header.php');


function formatName($name) {
	$name = preg_replace('/[^a-zA-Z0-9_ ]/', '', $name);
    $name = ucwords(strtolower($name));
    return trim($name);
}

function isValidCoordinate($value, $coordinateType) {
    // Check if the value is a number and not a string
    if (!is_numeric($value)) {
        return false;
    }
	
    // Convert the value to a float
    $coordinate = floatval($value);

    // Check if it's latitude or longitude and validate within the range
    switch ($coordinateType) {
        case 'latitude':
            return ($coordinate >= -90 && $coordinate <= 90);
        case 'longitude':
            return ($coordinate >= -180 && $coordinate <= 180);
        default:
            return false;
    }
}

function isStringNumber($stringValue) {
    return is_numeric($stringValue);
}

$person = new Login;
$person->setUsername($_POST["username"]);
$Encryption = new Encryption();
$person->setPassword($Encryption->decrypt($_POST["password"], $nonceValue));

if($_SESSION['user']!=$person->getUsername()){
	echo "User is logged in with different username and password";
	return;
}

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."'";
$result = mysqli_query($con,$query);
$row = mysqli_fetch_assoc($result);

if(!isValidCoordinate($_POST["latitude"],'latitude') or !isValidCoordinate($_POST["longitude"],'longitude')){
	echo "Error : Check Latitude and Longitude Value";
	exit();
}

if(!isStringNumber($_POST["normal_rice"])){
	echo "Error : Check Normal Rice Value";
	exit();
}

if(!isStringNumber($_POST["state_frk_rice"])){
	echo "Error : Check State FRK Rice Value";
	exit();
}

if(!isStringNumber($_POST["central_frk_rice"])){
	echo "Error : Check Central FRK Rice Value";
	exit();
}

if(isset($_POST["storage_rice"]) && $_POST["storage_rice"] != "" && !isStringNumber($_POST["storage_rice"])){
	echo "Error : Check Storage Rice Value";
	exit();
}

if(isset($_POST["storage_state_frk_rice"]) && $_POST["storage_state_frk_rice"] != "" && !isStringNumber($_POST["storage_state_frk_rice"])){
	echo "Error : Check Storage State FRK Rice Value";
	exit();
}

if(isset($_POST["storage_central_frk_rice"]) && $_POST["storage_central_frk_rice"] != "" && !isStringNumber($_POST["storage_central_frk_rice"])){
	echo "Error : Check Storage Central FRK Rice Value";
	exit();
}

if(!isValidCoordinate($_POST["latitude"],'latitude') or !isValidCoordinate($_POST["longitude"],'longitude')){
	echo "Error : Check Latitude and Longitude Value";
	exit();
}


if (
    !isValidCoordinate($_POST["latitude"], 'latitude') ||
    !isValidCoordinate($_POST["longitude"], 'longitude') ||
    $_POST["latitude"] >= 40 ||
    $_POST["longitude"] <= 65
) {
    echo "Error : Latitude must be less than 40 and Longitude must be greater than 65";
    exit();
}
$errors = [];

$val_storage_rice = (isset($_POST["storage_rice"]) && $_POST["storage_rice"] != "") ? (float)$_POST["storage_rice"] : 0;
$val_normal_rice = (isset($_POST["normal_rice"]) && $_POST["normal_rice"] != "") ? (float)$_POST["normal_rice"] : 0;
if($val_normal_rice > $val_storage_rice){
	$errors[] = "Error : normal rice (Qtl) should not be greater than storage rice(Qtl)";
}

$val_storage_state = (isset($_POST["storage_state_frk_rice"]) && $_POST["storage_state_frk_rice"] != "") ? (float)$_POST["storage_state_frk_rice"] : 0;
$val_state_rice = (isset($_POST["state_frk_rice"]) && $_POST["state_frk_rice"] != "") ? (float)$_POST["state_frk_rice"] : 0;
if($val_state_rice > $val_storage_state){
	$errors[] = "Error : state frk rice (Qtl) should not be greater than storage state frk rice(Qtl)";
}

$val_storage_central = (isset($_POST["storage_central_frk_rice"]) && $_POST["storage_central_frk_rice"] != "") ? (float)$_POST["storage_central_frk_rice"] : 0;
$val_central_rice = (isset($_POST["central_frk_rice"]) && $_POST["central_frk_rice"] != "") ? (float)$_POST["central_frk_rice"] : 0;
if($val_central_rice > $val_storage_central){
	$errors[] = "Error : central frk rice (Qtl) should not be greater than storage central frk rice(Qtl)";
}

if (!empty($errors)) {
	echo implode("</br>", $errors);
	exit();
}
$errors = [];

$dbHashedPassword = $row['password'];
if(password_verify($person->getPassword(), $dbHashedPassword)){

    $district = formatName($_POST["district"]);
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $name = formatName($_POST["name"]);
    $id = $_POST["id"];
    $type = $_POST["type"];
    $normal_rice = $_POST["normal_rice"];
    $state_frk_rice = $_POST["state_frk_rice"];
    $central_frk_rice = $_POST["central_frk_rice"];
    $storage_rice = isset($_POST["storage_rice"]) ? $_POST["storage_rice"] : "0";
    $storage_state_frk_rice = isset($_POST["storage_state_frk_rice"]) ? $_POST["storage_state_frk_rice"] : "0";
    $storage_central_frk_rice = isset($_POST["storage_central_frk_rice"]) ? $_POST["storage_central_frk_rice"] : "0";
    $warehousetype = $_POST["warehousetype"];
    $uniqueid = uniqid("WH_",);


    $Warehouse = new Warehouse;
    $Warehouse->setUniqueid(substr($uniqueid,0,15));
    $Warehouse->setDistrict($district);
    $Warehouse->setLatitude($latitude);
    $Warehouse->setLongitude($longitude);
    $Warehouse->setName($name);
    $Warehouse->setId($id);
    $Warehouse->setType($type);
    $Warehouse->setNormalRice($normal_rice);
    $Warehouse->setStateFrkRice($state_frk_rice);
    $Warehouse->setCentralFrkRice($central_frk_rice);
    $Warehouse->setStorageRice($storage_rice);
    $Warehouse->setStorageStateFrkRice($storage_state_frk_rice);
    $Warehouse->setStorageCentralFrkRice($storage_central_frk_rice);
    $Warehouse->setWarehousetype($warehousetype);
	$Warehouse->setActive("1");

    $query_insert_check = $Warehouse->checkInsert($Warehouse);
    $query_insert_result = mysqli_query($con, $query_insert_check);
    $numrows_insert = mysqli_num_rows($query_insert_result);
    if($numrows_insert==0){
        $query = $Warehouse->insert($Warehouse);
        mysqli_query($con, $query);
        mysqli_close($con);
		$filteredPost = $_POST;
		unset($filteredPost['username'], $filteredPost['password']);
		writeLog("User ->" ." Warehouse added ->". $_SESSION['user'] . "| Requested JSON -> " . json_encode($filteredPost));
        echo "<script>window.location.href = '../Warehouse.php';</script>";
    }
    else{
        echo "Error : in Insertion as Warehouse id already exist";
    }
} 
else{
    echo "Error : Password or Username is incorrect";
}


?>
<?php require('Fullui.php');  ?>