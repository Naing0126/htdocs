<?php
class User extends CI_Model{
    function  __construct(){
        parent::__construct();
        $this->load->database();
    }

    function login($user_id, $user_pw)
     {
       $this -> db -> select('user_name');
       $this -> db -> from('user');
       $this -> db -> where('user_id', 'test');
       $this -> db -> where('user_pw', 'test');
       $this -> db -> limit(1);

       $query = $this -> db -> get();

       if($query -> num_rows() == 1)
       {
         return $query->result();
       }
       else
       {
         return false;
       }
     }
}
?>