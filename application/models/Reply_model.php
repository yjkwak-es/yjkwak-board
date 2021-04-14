<?php

class Reply_model extends CI_Model
{
    public function get_reply(int $RID): array
    {
        $query = $this->db->get_where('Reply', array('RID' => $RID));
        return $query->row_array();
    }

    public function getAllReplys(int $TID): array
    {
        $query = $this->db->select()->from('Reply')->where('TID', $TID);
        $cnt = $this->db->count_all_results('', FALSE);

        return [
            'result' => $query->get()->result_array(),
            'totalCount' => $cnt
        ];
    }

    public function createReply(array $data)
    {
        return $this->db->insert('Reply',$data);
    }

    public function setReply(int $RID, string $paragraph)
    {
        $this->db->where('RID',$RID);
        $this->db->set('Paragraph',$paragraph);
        return $this->db->update('Reply');
    }

    public function deleteReplyByID(int $RID)
    {
        return $this->db->delete('Reply',array('RID' => $RID));
    }

    public function deleteReplyAll(int $TID)
    {
        return $this->db->delete('Reply',array('TID' => $TID));
    }
}
