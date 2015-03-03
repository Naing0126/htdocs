<?php
class User_model extends CI_Model{
    function  __construct(){
        parent::__construct();
        $this->load->database();
    }

 // Insert registration data in database
    public function registration_insert($data) {

// Query to check whether username already exist or not
        $condition = "user_id =" . "'" . $data['user_id'] . "'";
        $this->db->select(' * ');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {

// Query to insert data in database
            $this->db->insert('user', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

// Read data using username and password
    public function login($data) {

        $condition = "user_id =" . "'" . $data['user_id'] . "' AND " . "user_pw =" . "'" . $data['user_pw'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

// Read data from database to show data in admin page
    public function read_user_information($sess_array) {

        $condition = "user_id =" . "'" . $sess_array['user_id'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function utc(){
        $utc = 1425263955;
        $str = 'test';
//$query = "INSERT INTO utc (utc) VALUE ($utc,'$str')";
//$this->db->query($query);
//$this->db->query('INSERT INTO utc (utc,string) VALUE (1425263953,"test")');
 //       $this->db->query('INSERT INTO utc (utc,string) VALUE ('+$utc+',"'+$str+'")');
     /*
       $this->db->select('utc');
        $this->db->from('utc');
        $this->db->order_by('utc', 'DESC');
     $this->db->limit(1);
        $query = $this->db->get();
         $utc2=  $query->result();
        */
         $utc = 1425263952;
         $result = 'test';
        $result = $this->db->query('SELECT from_unixtime(1425263952)');
        return $result;
    }

}

?>