<?php
class Directory_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets($uid){
     return $this->db->get_where('directory', array('directory_uid'=>$uid))->result();
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
    $condition = "did =" . "'" . $data['did'] . "'";
    $this->db->select(' * ');
    $this->db->from('directory');
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
// Query to insert directory in database
        $this->db->update('directory', $data, array('did' => $data['did']));
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