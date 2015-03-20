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

    $contents = $sensor->sensor_id . " , " . $sensor->sensor_type;
    $included_sensors[$sensor->sensor_id] = $contents;
  }
  return $included_sensors;
}

function get_included_sensor_list($nodes){
  $sensor_list = array();
  foreach($nodes as $node){
    $nid = $node;
    $this->db->select('*');
    $this->db->from('sensor');
    $this->db->where('sensor_nid',$nid);
    $query = $this->db->get();
    if($query->num_rows() == '0'){
      $sensor_list[$nid]['type'][0] = 'null';
    }
    foreach ($query->result() as $sensor) {
      $contents = $sensor->sensor_id . " , " . $sensor->sensor_type;
      $sensor_list[$nid]['type'][] = $sensor->sensor_type;
      $sensor_list[$nid]['sid'][] = $sensor->sensor_id;
    }
  }

  return $sensor_list;
}
public function insert_sensor($data) {

 $condition = "sensor_nid =" . "'" . $data->sensor_nid . "' and sensor_id=" . "'" . $data->sensor_id . "'";
 $this->db->select('*');
 $this->db->from('sensor');
 $this->db->where($condition);
 $temp = $this->db->get();

$result['cnt'] = $temp->num_rows();
 if($result['cnt'] == 0){
  // connect with exist node
  $this->db->insert('sensor',$data);
 }

 return $result;
}
}