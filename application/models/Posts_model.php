<?php

class Posts_model extends CI_Model
{

    public function findPosts(): array
    {
        $query = $this->db->order_by('CreatedDate','DESC')
        ->get('board');
        return $query->result_array();
    }

    public function getPostById($TID)
    {
        $query = $this->db->get_where('board', array('TID' => $TID));
        return $query->row_array();
    }

    public function createPost()
    {
        $data = array(
            'ID' => $this->input->post('ID'),
            'Title' => $this->input->post('title'),
            'Paragraph' => $this->input->post('text'),
            'FileID' => null
        );

        return $this->db->insert('board', $data);
    }

    public function deletePost(int $TID)
    {
        return $this->db->delete('board',array('TID' => $TID));
    }
}
