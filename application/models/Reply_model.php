<?php

class Reply_model extends CI_Model
{
    public function get_reply(int $RID)
    {
        $query = $this->db->get_where('Reply', array('RID' => $RID));
        return $query->row_array();
    }

    public function getAllReplys(int $TID)
    {
        $query = $this->db->get_where('Reply', array('TID' => $TID));
        return $query->row_array();
    }
}
