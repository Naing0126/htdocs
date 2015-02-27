<?php
class Topic_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets(){
        return $this->db->query('SELECT * FROM topic')->result();
    }

    public function get($topic_id){
         return $this->db->get_where('topic', array('id'=>$topic_id))->row(); // active record. 이식성이 높다
         //return $this->db->query('SELECT * FROM topic WHERE id='.$topic_id)->result();
    }
}