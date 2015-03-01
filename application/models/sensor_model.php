<?php
class Sensor_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets($gid){
     return $this->db->get_where('sensor', array('sensor_gid'=>$gid))->result();
 }
  function get_included_sensors($gid){
    $this->db->select('sid, sensor_model, sensor_type');
    $this->db->from('sensor');
     if(!is_null($gid)){
          $this->db->where('sensor_gid',$gid);
      }
      $query = $this->db->get();
      $included_sensors = array();
          foreach ($query->result() as $sensor) {
            if($sensor->sensor_type === '1')
              $type = 'temperature';
            else if($sensor->sensor_type === '2')
              $type = 'humidity';
              $contents = $sensor->sensor_model . " , " . $type;
               $included_sensors[$sensor->sid] = $contents;
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