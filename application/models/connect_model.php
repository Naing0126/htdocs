<?php
class connect_model extends CI_Model{
  function  __construct(){
    parent::__construct();
  }

  public function get_connected_nodes($uid){
   $this->db->select('node.nid');
   $this->db->from('connect');
   $this->db->join('node','node.nid = connect.nid');
   $this->db->where('uid',$uid);
   $query = $this->db->get();
   $data['#'] = 'Select Sensor Node';
   if($query->num_rows() > 0){
    foreach($query->result() as $v){
      $data[$v->nid] = $v->nid;
    }
    return $data;
  }
}

public function insert_node($data) {

 $this->db->select('*');
 $this->db->from('node');
 $this->db->where('nid',$data->nid);
 $temp = $this->db->get();

 $result['cnt'] = $temp->num_rows();
 if($result['cnt'] > 0){
  // connect with exist node
  $this->db->insert('connect',$data);
}else{
  // register new node
  $node['nid'] = $data->nid;
  $this->db->insert('node', $node);
  $this->db->insert('connect',$data);
}

$result['nid'] = $data->nid;
return $result;
}

public function disconnect_node($data) {

 $condition = "uid =" . "'" . $data['uid'] . "' and nid=" . "'" . $data['nid'] . "'";
 $this->db->select('*');
 $this->db->from('connect');
 $this->db->where($condition);
 $query = $this->db->get();
 if ($query->num_rows() > 0) {

// Query to insert directory in database
  $this->db->delete('connect', $data);
  if ($this->db->affected_rows() > 0) {
    return true;
  }
}
return false;
}
}