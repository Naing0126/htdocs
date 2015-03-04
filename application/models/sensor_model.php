<?php
class Sensor_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($gid){
   return $this->db->get_where('sensor', array('sensor_gid'=>$gid))->result();
 }
 function get_included_sensors($nid){
  $this->db->select('sensor_id, sensor_type');
  $this->db->from('sensor');
  if(!is_null($nid)){
    $this->db->where('sensor_nid',$nid);
  }
  $query = $this->db->get();
  $included_sensors = array();
  foreach ($query->result() as $sensor) {
    if($sensor->sensor_type === '0')
      $type = 'temperature';
    else if($sensor->sensor_type === '1')
      $type = 'humidity';
    else if($sensor->sensor_type === '2')
      $type = 'co2';
      else if($sensor->sensor_type === '3')
      $type = 'door';
      else if($sensor->sensor_type === '4')
      $type = 'airCleaner';
      else if($sensor->sensor_type === '5')
      $type = 'warningLight';


    $contents = $sensor->sensor_id . " , " . $type;
    $included_sensors[$sensor->sensor_id] = $contents;
  }
  return $included_sensors;
}

     // Insert directory data in database
public function directory_insert($data) {

// Query to check whether directory name already exist or not
  $condition = "directory_uid =" . "'" . $data['directory_uid'] . "' and directory_name=" . "'" . $data['directory_name'] . "'";
  $this->db->select(' * ');
  $this->db->from('directory');
  $this->db->where($condition);
  $this->db->limit(1);
  $query = $this->db->get();
  if ($query->num_rows() == 0) {

// Query to insert directory in database
    $this->db->insert('directory', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }
  } else {
    return false;
  }
}

public function directory_update($data) {

// Query to check whether directory name already exist or not
  $condition = "directory_uid =" . "'" . $data['directory_uid'] . "' and directory_name=" . "'" . $data['directory_name'] . "'";
  $this->db->select(' * ');
  $this->db->from('directory');
  $this->db->where($condition);
  $this->db->limit(1);
  $query = $this->db->get();
  if ($query->num_rows() == 0) {

// Query to insert directory in database
    $this->db->insert('directory', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }
  } else {
    return false;
  }
}

public function directory_delete($data) {

// Query to check whether directory name already exist or not
  $condition = "did =" . "'" . $data['did']  . "'";
  $this->db->select(' * ');
  $this->db->from('directory');
  $this->db->where($condition);
  $this->db->limit(1);
  $query = $this->db->get();
  if ($query->num_rows() == 1) {

// Query to insert directory in database
    $this->db->delete('directory', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }
  } else {
    return false;
  }
}

}