<?php

class Posts_model extends CI_Model
{
    public function findPosts(int $start, int $offset, string $keyword = '',string $type = ''): array
    {
        $this->db->select()->from('board');
        switch ($type) {
            case 'all':
                $this->db
                ->or_like('Title',$keyword,'both')
                ->or_like('Paragraph',$keyword,'both');
                break;
            case 'Paragraph':
                $this->db
                ->like('Paragraph',$keyword,'both');
                break;
            case 'Title':
                $this->db
                ->like('Title',$keyword,'both');
                break;
        }
        $this->db->order_by('CreatedDate','DESC');
        $cnt = $this->db->count_all_results('',false);
        $query = $this->db->limit($offset,$start)->get();
        
        return [
            'result' => $query->result_array(),
            'totalCount' => $cnt
        ];
    }

    public function getPostById($TID)
    {
        $query = $this->db->get_where('board', array('TID' => $TID));
        return $query->row_array();
    }

    public function createPost(array $data)
    {
        return $this->db->insert('board', $data);
    }

    public function deletePost(int $TID)
    {
        return $this->db->delete('board',array('TID' => $TID));
    }

    public function setPost(int $TID, array $data)
    {
        $this->db->where('TID',$TID);
        return $this->db->update('board',$data);
    }
}
