<?php
class Trigger_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets($uid){
       return $this->db->get_where('triggers', array('uid'=>$uid))->result();
   }

     // Insert directory data in database
public function insert_trigger($data) {

    $this->db->insert('triggers', $data);
    if ($this->db->affected_rows() > 0) {
     $this->db->select('*');
     $this->db->from('triggers');
     $this->db->order_by('tid', 'DESC');
     $this->db->limit(1);
     $temp = $this->db->get();
     if($temp->num_rows() == 0){
       $result['tid']= 'null';
   }
   foreach($temp->result() as $t){
      $result['tid']= $t->tid;
  }
}
return $result;
}

function update_trigger($data,$tid) {
// Query to check whether directory name already exist or not
     $condition = "tid =" . "'" . $tid['tid']  . "'";
    $this->db->select(' * ');
    $this->db->from('triggers');
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() == 1) {

// Query to insert directory in database
        $this->db->update('triggers', $data, array('tid' => $tid['tid']));
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    } else {
        return false;
    }
}
function delete_trigger($data) {

// Query to check whether directory name already exist or not
    $condition = "tid =" . "'" . $data['tid']  . "'";
    $this->db->select(' * ');
    $this->db->from('triggers');
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() == 1) {

// Query to insert directory in database
        $this->db->delete('triggers', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    } else {
        return false;
    }
}

}