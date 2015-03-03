<?php
class Node_model extends CI_Model{
    function  __construct(){
        parent::__construct();
    }

    public function gets($uid){
        $this->db->select('*');
        $this->db->from('node');
        $this->db->where('node_uid',$uid);
        $query = $this->db->get();
        $data['#'] = 'Select Sensor Node';
         if($query->num_rows() > 0){
            foreach($query->result() as $v){
                $data[$v->nid] = $v->nid;
            }
            return $data;
        }
    }


}