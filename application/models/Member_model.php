<?php

use App\EMember;
use App\EUser;

class Member_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberByID(string $id)
    {
        $query = $this->db->get_where('test_db', array('ID' => $id));
        return $query->row(0,EMember::class);
    }

    public function setMember(string $id, EMember $data)
    {
        $this->db->where('ID', $id);
        $array = array(
            'name' => $data->name,
            'age' => $data->age,
            'gender' => $data->gender
        );
        
        return $this->db->update('test_db', $array);
    }
}
