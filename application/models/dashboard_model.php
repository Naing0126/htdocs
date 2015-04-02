<?php
class Dashboard_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function gets($uid){
   $this->db->select('widget_id,widget_type,sensor.sensor_id as sid,sensor.sensor_nid as nid, sensor_name, sensor_type');
   $this->db->from('sensor');
   $this->db->join('dashboard',' dashboard.sensor_id = sensor.sensor_id and dashboard.sensor_nid = sensor.sensor_nid');
   $this->db->where('dashboard.dashboard_id',$uid);
   $query = $this->db->get();
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data['widget_type'][] = $v->widget_type;
      $data['widget_id'][] = $v->widget_id;
      $data['sensor_nid'][] = $v->nid;
      $data['sensor_id'][] = $v->sid;
      $data['sensor_name'][] = $v->sensor_name;
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
      $data['sensor_id'][] = $v->sensor_id;
    }
    return $data;
  }
}

 public function getWidgetsNid($uid){
   $this->db->select('sensor_id,sensor_nid');
   $this->db->from('dashboard');
   $this->db->where('dashboard.dashboard_id',$uid);
   $query = $this->db->get();
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data['sensor_nid'][] = $v->sensor_nid;
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
    $this->db->join('sensor','dashboard.sensor_id = sensor.sensor_id and dashboard.sensor_nid = sensor.sensor_nid');
    $this->db->where('widget_id',$data['widget_id']);
    $this->db->limit(1);
    $query = $this->db->get();
    $updated_widget = array();
    foreach ($query->result() as $widget) {

      $updated_widget['widget_type'] = $widget->widget_type;
      $updated_widget['sensor_id'] = $widget->sensor_id;
      $updated_widget['sensor_nid'] = $widget->sensor_nid;
      $updated_widget['sensor_type'] = $widget->sensor_type;

      $this->db->select(' * ');
      $this->db->from('data');
      $this->db->where('data_sid',$widget->sensor_id);
      $query = $this->db->get()->result();
     $updated_widget['cnt'] = count($query);
     for($i=0;$i<count($query);$i++){
      $updated_widget['data_stime'][$i]=$query[$i]->data_stime;
      $updated_widget['data_value'][$i]=$query[$i]->data_value;
     }

      $this->db->select('*');
     $this->db->where('data_sid',$widget->sensor_id);
     $this->db->from('data');
     $this->db->order_by('data_id', 'DESC');
     $this->db->limit(1);
     $temp = $this->db->get();
     if($temp->num_rows() == 0){
         $updated_widget['recent_data']= 'null';
     }
     foreach($temp->result() as $t){
       $updated_widget['recent_data']= $t->data_value;
      $hours = (time()-$t->data_stime) / (60*60);
      if($hours>6){
        $updated_widget['recent_data_time'][]= 'more than 6 hours ago';
      }
      else{
        $updated_widget['recent_data_time'][]= timespan($t->data_stime,time()) . ' ago';
      }
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

public function get_included_sensors($uid){
  $this->load->helper('date');
 $this->db->select('*');
 $this->db->from('dashboard');
 $this->db->join('sensor','sensor.sensor_id = dashboard.sensor_id and sensor.sensor_nid = dashboard.sensor_nid');
 $this->db->where('dashboard_id',$uid);
 $query = $this->db->get();
 if($query->num_rows() > 0){
   $cnt = 0;
   foreach($query->result() as $v){

     $data['info']['sensor_id'][]= $v->sensor_id;
     $data['info']['sensor_type'][]= $v->sensor_type;
     $data['info']['sensor_nid'][]= $v->sensor_nid;
     $data['info']['sensor_name'][]= $v->sensor_name;

     $this->db->select('*');
     $this->db->where('data_sid',$v->sensor_id);
     $this->db->from('data');
     $this->db->order_by('data_id', 'DESC');
     $this->db->limit(1);
     $temp = $this->db->get();
     if($temp->num_rows() == 0){
         $data['info']['recent_data'][]= 'null';
     }
     foreach($temp->result() as $t){
      $data['info']['recent_data'][]= $t->data_value;
      $hours = (time()-$t->data_stime) / (60*60);
      if($hours>6){
        $data['info']['recent_data_time'][]= 'more than 6 hours ago';
      }
      else{
        $data['info']['recent_data_time'][]= timespan($t->data_stime,time()) . ' ago';
      }
    }

     $this->db->select('*');
     $this->db->where('data_sid',$v->sensor_id);
     $this->db->from('data');
     $this->db->order_by('data_id', 'DESC');
     $this->db->limit(10);
     $temp2 = $this->db->get();
     if($temp2->num_rows() == 0){
         $data['data'][$cnt]= 'null';
     }
     foreach($temp2->result() as $t){
      $data['data'][$cnt]['data_stime'][]= $t->data_stime;
      $data['data'][$cnt]['data_value'][]= $t->data_value;
    }

    $data['index'][$v->widget_id] = $cnt;

    $cnt++;
  }
  return $data;
}
}

}