<?php

class Member_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberByID(string $id)
    {
        $query = $this->db->get_where('test_db', array('ID' => $id));
        return $query->row_array();
    }

    public function setMember(string $id,array $data)
    {
        $this->db->where('ID',$id);
        return $this->db->update('test_db',$data);
    }
}
