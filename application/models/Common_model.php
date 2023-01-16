<?php 

class Common_model extends CI_Model{
    public function getAll($table){
        return $this->db->get($table)->result();
    }
    public function getProduct($where,$table){
        return $this->db->where($where)->get($table)->row();
    }
}