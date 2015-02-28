<?php
class Gateway_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets($uid){
        $this->db->select('*');
        $this->db->from('gateway');
        $this->db->where('gateway_uid',$uid);
        $query = $this->db->get();
        $data['#'] = 'Select Gateway';
         if($query->num_rows() > 0){
            foreach($query->result() as $v){
                $data[$v->gid] = $v->gateway_name;
            }
            return $data;
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