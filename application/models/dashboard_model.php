<?php
class Dashboard_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($uid){
   $this->db->select('widget_id,widget_type,sid,sensor_gid, sensor_model, sensor_type');
   $this->db->from('sensor');
   $this->db->join('dashboard','dashboard.sensor_id = sensor.sid');
   $this->db->where('dashboard.dashboard_id',$uid);
   $query = $this->db->get();
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data['widget_type'][] = $v->widget_type;
      $data['widget_id'][] = $v->widget_id;
      $data['sid'][] = $v->sid;
      $data['sensor_gid'][] = $v->sensor_gid;
      $data['sensor_model'][] = $v->sensor_model;
      $data['sensor_type'][] = $v->sensor_type;

    }
    return $data;
  }
}

  public function getWidgetsSid($uid){
   $this->db->select('sensor_id');
   $this->db->from('dashboard');
   $this->db->where('dashboard.dashboard_id',$uid);
   $query = $this->db->get();
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data[] = $v->sensor_id;
    }
    return $data;
  }
}

public function getName($did){
  $this->db->select('*');
  $this->db->from('directory');
  $this->db->where('did',$did);
  $query = $this->db->get();
  if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $dname = $v->directory_name;
    }
    return $dname;
  }
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