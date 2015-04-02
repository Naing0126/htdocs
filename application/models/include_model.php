<?php
class Include_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($did){
    $this->db->select('sensor_id,sensor_nid, sensor_name, sensor_type');
    $this->db->from('sensor');
    $this->db->join('include','include.sid = sensor.sensor_id and include.nid = sensor.sensor_nid');
    $this->db->where('include.did',$did);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      foreach($query->result() as $v){
        $data['sensor_nid'][] = $v->sensor_nid;
        $data['sensor_id'][] = $v->sensor_id;
        $data['sensor_name'][] = $v->sensor_name;
        $data['sensor_type'][] = $v->sensor_type;
      }
      return $data;
    }
  }

  function new_include($data){
   $condition = "did =" . "'" . $data['did'] . "' and sid=" . "'" . $data['sid'] . "' and nid=" . "'" . $data['nid'] . "'";
   $this->db->select(' * ');
   $this->db->from('sensor');
   $this->db->join('include','include.sid = sensor.sensor_id and include.nid = sensor.sensor_nid');
   $this->db->where($condition);
   $this->db->limit(1);
   $query = $this->db->get();
   if ($query->num_rows() == 0) {
// Query to insert in database
    $this->db->insert('include', $data);
    if ($this->db->affected_rows() > 0) {
      $condition = "did =" . "'" . $data['did'] . "' and sid=" . "'" . $data['sid'] . "' and nid=" . "'" . $data['nid'] . "'";
      $this->db->select(' * ');
      $this->db->from('sensor');
      $this->db->join('include','include.sid = sensor.sensor_id and include.nid = sensor.sensor_nid');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      $added_sensor = array();
      foreach ($query->result() as $sensor) {
        $added_sensor['sensor_nid'] = $sensor->sensor_nid;
        $added_sensor['sensor_id'] = $sensor->sensor_id;
        $added_sensor['sensor_type'] = $sensor->sensor_type;

        $condition2 = "data_sid =" . "'" . $data['sid'] . "' and data_nid=" . "'" . $data['nid'] . "'";
        $this->db->select('*');
        $this->db->where($condition2);
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
 $condition = "did =" . "'" . $data['did'] . "' and sid=" . "'" . $data['sid'] . "' and nid=" . "'" . $data['nid'] . "'";
 $this->db->select(' * ');
 $this->db->from('include');
 $this->db->join('sensor','sensor.sensor_id = include.sid and sensor.sensor_nid = include.nid');
 $this->db->where($condition);
 $this->db->limit(1);
 $query = $this->db->get();
 if ($query->num_rows() == 1) {
// Query to insert directory in database
   foreach($query->result() as $v){
    $sensor_type = $v->sensor_type;
    $this->db->delete('include', $data);
    if ($this->db->affected_rows() > 0) {
      $condition = "did =" . "'" . $data['did'] ."' and sensor_type=" . "'" . $sensor_type . "'";
      $this->db->select('*');
      $this->db->from('include');
      $this->db->join('sensor','sensor.sensor_id = include.sid and sensor.sensor_nid = include.nid');
      $this->db->where($condition);
      $query = $this->db->get();
      $cnt = $query->num_rows();
      $data['cnt'] = $cnt;
      return $data;
    }
  }
}
}

public function get_included_sensors($did){
 $this->db->select('*');
 $this->db->from('include');
 $this->db->join('sensor','sensor.sensor_id = include.sid and sensor.sensor_nid = include.nid');
 $this->db->where('did',$did);
 $query = $this->db->get();
 if($query->num_rows() > 0){
   $cnt = 0;
   foreach($query->result() as $v){

     $data['info']['sensor_id'][]= $v->sensor_id;
     $data['info']['sensor_type'][]= $v->sensor_type;
     $data['info']['sensor_nid'][]= $v->sensor_nid;
     $data['info']['sensor_name'][]= $v->sensor_name;

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
      /*
      $hours = (time()-$t->data_stime) / (60*60);
      if($hours>6){
        $data['info']['recent_data_time'][]= 'more than 6 hours ago';
      }
      else{
        $data['info']['recent_data_time'][]= timespan($t->data_stime,time()) . ' ago';
      }
      */
      $data['info']['recent_data_time'][]= timespan($t->data_stime,time()) . ' ago';
    }

    $data['index'][$v->sid][$v->nid] = $cnt;

    $cnt++;
  }
  return $data;
}
}
}