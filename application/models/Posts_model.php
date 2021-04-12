<?php

class Posts_model extends CI_Model
{

    public function findPosts() : array
    {
        return [];
    }

    public function getPostById($TID)
    {
        return $query->row_array();
    }

    public function get_posts($TID = FALSE)
    {
        if ($TID === FALSE) {
            $query = $this->db->get('board');
            return $query->result_array();
        }

        $query = $this->db->get_where('board', array('TID' => $TID));
        return $query->row_array();
    }

    public function create_posts()
    {
        $data = array (
            'ID' => $this->input->post('ID'),
            'Title' => $this->input->post('title'),
            'Paragraph' => $this->input->post('text'),
            'FileID' => null
        );

        return $this->db->insert('board',$data);
    }
}
