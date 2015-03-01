<?php
class Include_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($did){
    $this->db->select('sid,sensor_gid, sensor_model, sensor_type');
    $this->db->from('sensor');
    $this->db->join('include','include.sensor_id = sensor.sid');
    $this->db->where('include.directory_id',$did);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      foreach($query->result() as $v){
        $data['sid'][] = $v->sid;
        $data['sensor_gid'][] = $v->sensor_gid;
        $data['sensor_model'][] = $v->sensor_model;
        $data['sensor_type'][] = $v->sensor_type;
      }
      return $data;
    }
  }

  function new_include($data){
   $condition = "directory_id =" . "'" . $data['directory_id'] . "' and sensor_id=" . "'" . $data['sensor_id'] . "'";
   $this->db->select(' * ');
   $this->db->from('sensor');
   $this->db->join('include','include.sensor_id = sensor.sid');
   $this->db->where($condition);
   $this->db->limit(1);
   $query = $this->db->get();
   if ($query->num_rows() == 0) {
// Query to insert in database
    $this->db->insert('include', $data);
    if ($this->db->affected_rows() > 0) {
      $condition = "directory_id =" . "'" . $data['directory_id'] . "' and sensor_id=" . "'" . $data['sensor_id'] . "'";
      $this->db->select(' * ');
      $this->db->from('sensor');
      $this->db->join('include','include.sensor_id = sensor.sid');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      $added_sensor = array();
      foreach ($query->result() as $sensor) {
        if($sensor->sensor_type === '1')
          $type = 'temperature';
        else if($sensor->sensor_type === '2')
          $type = 'humidity';
        $added_sensors['sid'] = $sensor->sid;
        $added_sensor['sensor_gid'] = $sensor->sensor_gid;
        $added_sensor['sensor_model'] = $sensor->sensor_model;
        $added_sensor['sensor_type'] = $type;

           $this->db->select('*');
     $this->db->where('data_sid', $sensor->sid);
     $this->db->from('data');
     $this->db->order_by('data_id', 'DESC');
     $this->db->limit(1);
     $temp = $this->db->get();
     if($temp->num_rows() == 0){
         $added_sensor['recent_data']= 'null';
     }
     foreach($temp->result() as $t){
      $added_sensor['recent_data']= $t->data_value;
    }

      }
      return $added_sensor;
    }
  }

}

function delete_include($data) {

// Query to check whether directory name already exist or not
 $condition = "directory_id =" . "'" . $data['directory_id'] . "' and sensor_id=" . "'" . $data['sensor_id'] . "'";
 $this->db->select(' * ');
 $this->db->from('include');
 $this->db->where($condition);
 $this->db->limit(1);
 $query = $this->db->get();
 if ($query->num_rows() == 1) {
// Query to insert directory in database
  $this->db->delete('include', $data);
  if ($this->db->affected_rows() > 0) {
    return true;
  }
} else {
  return false;
}
}

public function get_included_sensors($did){
 $this->db->select('*');
 $this->db->from('include');
 $this->db->join('sensor','sensor.sid = include.sensor_id');
 $this->db->where('directory_id',$did);
 $query = $this->db->get();
 if($query->num_rows() > 0){
   $cnt = 0;
   foreach($query->result() as $v){

     $data['info']['sensor_model'][]= $v->sensor_model;
     $data['info']['sensor_type'][]= $v->sensor_type;
     $data['info']['sensor_gid'][]= $v->sensor_gid;

     $this->db->select('*');
     $this->db->where('data_sid',$v->sid);
     $this->db->from('data');
     $this->db->order_by('data_id', 'DESC');
     $this->db->limit(1);
     $temp = $this->db->get();
     if($temp->num_rows() == 0){
         $data['info']['recent_data'][]= 'null';
     }
     foreach($temp->result() as $t){
      $data['info']['recent_data'][]= $t->data_value;
    }

    $data['index'][$v->sid] = $cnt;

    $cnt++;
  }
  return $data;
}
}
}