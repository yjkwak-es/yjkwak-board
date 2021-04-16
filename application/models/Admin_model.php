<?php

use App\EMember;

class Admin_model extends CI_Model
{
    public function memberCheck(int $PID)
    {
        $this->db->select('admin')->where('PID', $PID);
        $query = $this->db->get('test_db');
        $row = $query->row_array(0);
        
        
        return $row['admin'];
    }

    public function getAllMember()
    {
        // $this->db->where('admin', 0);
        $query = $this->db->get_where('test_db', array('admin' => 0));
        $cnt = $this->db->count_all_results('', FALSE);

        return [
            'result' => $query->result(EMember::class),
            'cnt' => $cnt
        ];
    }
}
