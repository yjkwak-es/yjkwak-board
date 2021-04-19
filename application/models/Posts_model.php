<?php

use App\EPost;

class Posts_model extends CI_Model
{
    public function findPosts(int $start, int $offset, string $keyword = '', string $type = ''): array
    {
        $this->db->select()->from('board');
        switch ($type) {
            case 'all':
                $this->db
                    ->or_like('Title', $keyword, 'both')
                    ->or_like('Paragraph', $keyword, 'both');
                break;
            case 'Paragraph':
                $this->db
                    ->like('Paragraph', $keyword, 'both');
                break;
            case 'Title':
                $this->db
                    ->like('Title', $keyword, 'both');
                break;
            default:
                break;
        }
        $this->db->order_by('CreatedDate', 'DESC');
        $cnt = $this->db->count_all_results('', false);
        $query = $this->db->limit($offset, $start)->get();

        return [
            'result' => $query->result(EPost::class),
            'totalCount' => $cnt
        ];
    }

    public function getPostById($TID): EPost
    {
        $query = $this->db->get_where('board', array('TID' => $TID));
        $query->result();
        return $query->row(0, EPost::class);
    }

    public function createPost(EPost $newPost): bool
    {
        return $this->db->insert('board', $newPost);
    }

    public function deletePost(int $TID)
    {
        return $this->db->delete('board', array('TID' => $TID));
    }

    public function setPost(int $TID, EPost $newPost): bool
    {
        $this->db->where('TID', $TID);
        return $this->db->update('board', $newPost);
    }
}
