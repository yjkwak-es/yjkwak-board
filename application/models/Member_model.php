<?php

class Member_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_member()
    {
        $id = $this->input->post('ID');
        $query = $this->db->get_where('test_db', array('ID' => $id));
        return $query->row_array();
    }
}
