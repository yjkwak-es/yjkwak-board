<?php

class File_model extends CI_Model
{
    public function createFile(array $newFile)
    {
        return $this->db->insert('file',$newFile);
    }

    public function getFile(string $FileID)
    {
        $query = $this->db->get_where('file',array('FileID'=> $FileID));
        return $query->row_array();
    }

    public function deleteFile(string $FileID)
    {
        return $this->db->delete('file',array('FileID'=> $FileID));
    }
}
