<?php

class Mill {
    public $district;
    public $name;
    public $id;
    public $type;
    public $latitude;
    public $longitude;
    public $incoming_min_mota;
    public $incoming_min_patla;
    public $incoming_min_saran;
    public $outgoing_min_mota;
    public $outgoing_min_patla;
    public $outgoing_min_saran;
    public $milling_capacity;
    public $milling_capacity1;
    public $milling_capacity2;
    public $uniqueid;
    public $active;

    // Getter methods

    public function getDistrict() {
        return $this->district;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getIncomingMinMota() {
        return $this->incoming_min_mota;
    }

    public function getIncomingMinPatla() {
        return $this->incoming_min_patla;
    }

    public function getIncomingMinSaran() {
        return $this->incoming_min_saran;
    }

    public function getOutgoingMinMota() {
        return $this->outgoing_min_mota;
    }

    public function getOutgoingMinPatla() {
        return $this->outgoing_min_patla;
    }

    public function getOutgoingMinSaran() {
        return $this->outgoing_min_saran;
    }

    public function getMillingCapacity() {
        return $this->milling_capacity;
    }

    public function getMillingCapacity1() {
        return $this->milling_capacity1;
    }

    public function getMillingCapacity2() {
        return $this->milling_capacity2;
    }

    public function getUniqueid() {
        return $this->uniqueid;
    }

    public function getActive() {
        return $this->active;
    }


    // Setter methods

    public function setDistrict($district) {
        $this->district = $district;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setIncomingMinMota($incoming_min_mota) {
        $this->incoming_min_mota = $incoming_min_mota;
    }

    public function setIncomingMinPatla($incoming_min_patla) {
        $this->incoming_min_patla = $incoming_min_patla;
    }

    public function setIncomingMinSaran($incoming_min_saran) {
        $this->incoming_min_saran = $incoming_min_saran;
    }

    public function setOutgoingMinMota($outgoing_min_mota) {
        $this->outgoing_min_mota = $outgoing_min_mota;
    }

    public function setOutgoingMinPatla($outgoing_min_patla) {
        $this->outgoing_min_patla = $outgoing_min_patla;
    }

    public function setOutgoingMinSaran($outgoing_min_saran) {
        $this->outgoing_min_saran = $outgoing_min_saran;
    }

    public function setMillingCapacity($milling_capacity) {
        $this->milling_capacity = $milling_capacity;
    }

    public function setMillingCapacity1($milling_capacity1) {
        $this->milling_capacity1 = $milling_capacity1;
    }

    public function setMillingCapacity2($milling_capacity2) {
        $this->milling_capacity2 = $milling_capacity2;
    }

    public function setUniqueid($uniqueid) {
        $this->uniqueid = $uniqueid;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    function insert(Mill $mill){
        return "INSERT INTO mill (district, name, id, type, latitude, longitude, incoming_min_mota, incoming_min_patla, incoming_min_saran, outgoing_min_mota, outgoing_min_patla, outgoing_min_saran, milling_capacity, milling_capacity1, milling_capacity2, uniqueid, active) VALUES ('".$mill->getDistrict()."','".$mill->getName()."','".$mill->getId()."','".$mill->getType()."','".$mill->getLatitude()."','".$mill->getLongitude()."','".$mill->getIncomingMinMota()."','".$mill->getIncomingMinPatla()."','".$mill->getIncomingMinSaran()."','".$mill->getOutgoingMinMota()."','".$mill->getOutgoingMinPatla()."','".$mill->getOutgoingMinSaran()."','".$mill->getMillingCapacity()."','".$mill->getMillingCapacity1()."','".$mill->getMillingCapacity2()."','".$mill->getUniqueid()."','".$mill->getActive()."')";
    }

    function delete(Mill $mill){
        return "DELETE FROM mill WHERE uniqueid='".$mill->getUniqueid()."'";
    }

    function deleteall(Mill $mill){
        return "DELETE FROM mill WHERE 1";
    }

    function logname(Mill $mill){
        return "SELECT name FROM mill WHERE uniqueid='".$mill->getUniqueid()."'";
    }

    function check(Mill $mill){
        return "SELECT * FROM mill WHERE uniqueid='".$mill->getUniqueid()."'";
    }

    function checkInsert(Mill $mill){
        return "SELECT * FROM mill WHERE LOWER(id)=LOWER('".$mill->getId()."')";
    }

    function checkEdit(Mill $mill){
        return "SELECT * FROM mill WHERE LOWER(id)=LOWER('".$mill->getId()."')";
    }

    function update(Mill $mill){
        return "UPDATE mill SET district = '".$mill->getDistrict()."',name = '".$mill->getName()."',id = '".$mill->getId()."',type = '".$mill->getType()."',latitude = '".$mill->getLatitude()."',longitude = '".$mill->getLongitude()."',incoming_min_mota = '".$mill->getIncomingMinMota()."',incoming_min_patla = '".$mill->getIncomingMinPatla()."',incoming_min_saran = '".$mill->getIncomingMinSaran()."',outgoing_min_mota = '".$mill->getOutgoingMinMota()."',outgoing_min_patla = '".$mill->getOutgoingMinPatla()."',outgoing_min_saran = '".$mill->getOutgoingMinSaran()."',milling_capacity = '".$mill->getMillingCapacity()."',milling_capacity1 = '".$mill->getMillingCapacity1()."',milling_capacity2 = '".$mill->getMillingCapacity2()."',active = '".$mill->getActive()."' WHERE uniqueid = '".$mill->getUniqueid()."'";
    }

    function updateEdit(Mill $mill){
        return "UPDATE mill SET district = '".$mill->getDistrict()."',name = '".$mill->getName()."',type = '".$mill->getType()."',latitude = '".$mill->getLatitude()."',longitude = '".$mill->getLongitude()."',incoming_min_mota = '".$mill->getIncomingMinMota()."',incoming_min_patla = '".$mill->getIncomingMinPatla()."',incoming_min_saran = '".$mill->getIncomingMinSaran()."',outgoing_min_mota = '".$mill->getOutgoingMinMota()."',outgoing_min_patla = '".$mill->getOutgoingMinPatla()."',outgoing_min_saran = '".$mill->getOutgoingMinSaran()."',milling_capacity = '".$mill->getMillingCapacity()."',milling_capacity1 = '".$mill->getMillingCapacity1()."',milling_capacity2 = '".$mill->getMillingCapacity2()."',active = '".$mill->getActive()."' WHERE id = '".$mill->getId()."'";
    }
}

?>
