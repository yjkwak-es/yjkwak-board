<?php

use App\EReply;

class Reply_model extends CI_Model
{
    public function getReply(int $RID): EReply
    {
        $query = $this->db->get_where('Reply', array('RID' => $RID));
        return $query->row(0,EReply::class);
    }

    public function getAllReplys(int $TID): array
    {
        $query = $this->db->select()->from('Reply')->where('TID', $TID);
        $cnt = $this->db->count_all_results('', FALSE);

        return [
            'result' => $query->get()->result(EReply::class),
            'totalCount' => $cnt
        ];
    }

    public function createReply(EReply $data)
    {
        return $this->db->insert('Reply',$data);
    }

    public function setReply(int $RID, string $paragraph)
    {
        $this->db->where('RID',$RID);
        return $this->db->update('Reply',array('Paragraph',$paragraph));
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
