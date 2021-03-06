<?php
class Data_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($sid){
   $this->db->select('data_stime,data_value');
   $this->db->from('data');
   $this->db->where('data.data_sid',$sid);
   $query = $this->db->get();
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data[][] = $v->data_date;
      $data['data_stime'][] = $v->data_stime;
      $data['data_value'][] = $v->data_value;
    }
    return $data;
  }
}

public function getValue($widgets_sid,$widgets_nid){
 $cnt = count($widgets_sid);
 $data = null;
  for($i=0;$i<$cnt;$i++){
     $sid = $widgets_sid['sensor_id'][$i];
     $nid = $widgets_nid['sensor_nid'][$i];

     $condition = "data_sid =" . "'" . $sid . "' and data_nid =" . "'" . $nid . "'";
      $this->db->select(' * ');
      $this->db->from('data');
      $this->db->where($condition);
      $query = $this->db->get()->result();
      $data['cnt'][$sid][$nid] = count($query);
      for($j=0;$j<count($query);$j++){
        $data[$sid][$nid][$j]=$query[$j]->data_value;
      }
  }
   return $data;
}

public function getTime($widgets_sid,$widgets_nid){
 $cnt = count($widgets_sid);
 $data = null;
  for($i=0;$i<$cnt;$i++){
    $sid = $widgets_sid['sensor_id'][$i];
     $nid = $widgets_nid['sensor_nid'][$i];

     $condition = "data_sid =" . "'" . $sid . "' and data_nid =" . "'" . $nid . "'";
      $this->db->select(' * ');
      $this->db->from('data');
      $this->db->where($condition);
      $query = $this->db->get()->result();
      $data['cnt'][$sid][$nid] = count($query);
      for($j=0;$j<count($query);$j++){
        $data[$sid][$nid][$j]=$query[$j]->data_stime;
      }
  }
   return $data;
}

function new_widget($data){
    // save to dashboard database with dashboard_id, widget_type, sensor_id. (widget_id : cnt widgets in dashboard)
  $this->db->insert('dashboard', $data);
  if ($this->db->affected_rows() > 0) {
    $this->db->select_max('widget_id');
    $query = $this->db->get('dashboard')->result_array();
    $data['widget_id'] = $query[0]['widget_id'];
    return $data;
  }
}

function update_widget($data){

 $condition = "widget_id =" . "'" . $data['widget_id'] . "'";
 $this->db->select(' * ');
 $this->db->from('dashboard');
 $this->db->where($condition);
 $this->db->limit(1);
 $query = $this->db->get();
 if ($query->num_rows() > 0) {
// Query to insert directory in database
  $this->db->update('dashboard', $data, array('widget_id' => $data['widget_id']));
  if ($this->db->affected_rows() > 0) {
    $this->db->select(' * ');
    $this->db->from('dashboard');
    $this->db->join('sensor','dashboard.sensor_id = sensor.sid');
    $this->db->where('widget_id',$data['widget_id']);
    $this->db->limit(1);
    $query = $this->db->get();
    $updated_widget = array();
    foreach ($query->result() as $widget) {
      if($widget->sensor_type === '1')
        $type = 'temperature';
      else if($widget->sensor_type === '2')
        $type = 'humidity';
      $updated_widget['widget_type'] = $widget->widget_type;
      $updated_widget['sid'] = $widget->sid;
      $updated_widget['sensor_gid'] = $widget->sensor_gid;
      $updated_widget['sensor_model'] = $widget->sensor_model;
      $updated_widget['sensor_type'] = $type;

      $this->db->select(' * ');
      $this->db->from('data');
      $this->db->where('data_sid',$widget->sid);
      $query = $this->db->get()->result();
      $updated_widget['cnt'] = count($query);
      for($i=0;$i<count($query);$i++){
        $updated_widget['data_date'][$i]=$query[$i]->data_date;
        $updated_widget['data_value'][$i]=$query[$i]->data_value;
      }
    }
    return $updated_widget;
  }
}
}

function new_widget_($data){
    // save to dashboard database with dashboard_id, widget_type, sensor_id. (widget_id : cnt widgets in dashboard)
  $this->db->insert('dashboard', $data);
  if ($this->db->affected_rows() > 0) {
    $this->db->select_max('widget_id');
    $query = $this->db->get('dashboard')->result_array();
    $data['widget_id'] = $query[0]['widget_id'];
    $this->db->select(' * ');
    $this->db->from('dashboard');
    $this->db->join('sensor','dashboard.sensor_id = sensor.sid');
    $this->db->where('widget_id',$data['widget_id']);
    $this->db->limit(1);
    $query = $this->db->get();
    $added_widget = array();
    foreach ($query->result() as $widget) {
      if($widget->sensor_type === '1')
        $type = 'temperature';
      else if($widget->sensor_type === '2')
        $type = 'humidity';
      $added_widget['widget_id'] = $widget->widget_id;
      $added_widget['sid'] = $widget->sid;
      $added_widget['sensor_gid'] = $widget->sensor_gid;
      $added_widget['sensor_model'] = $widget->sensor_model;
      $added_widget['sensor_type'] = $type;
    }
    return $added_widget;
  }
}

function delete_widget($data) {

// Query to check whether directory name already exist or not
 $condition = "dashboard_id =" . "'" . $data['dashboard_id'] . "' and widget_id=" . "'" . $data['widget_id'] . "'";
 $this->db->select(' * ');
 $this->db->from('dashboard');
 $this->db->where($condition);
 $this->db->limit(1);
 $query = $this->db->get();
 if ($query->num_rows() == 1) {
// Query to insert directory in database
  $this->db->delete('dashboard', $data);
  if ($this->db->affected_rows() > 0) {
    return true;
  }
} else {
  return false;
}
}

}