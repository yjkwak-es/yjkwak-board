<?php
require_once __DIR__ . '/Posts.php';

use App\EPost;

define('UPLOADPATH', FCPATH . 'uploads');

class File_posts extends Posts
{
    public function __construct()
    {
        parent::__construct();

        $config['upload_path']          = UPLOADPATH;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5242880;

        $this->load->library('upload', $config);
        $this->load->model('File_model');
    }

    public function create($TID = null)
    {
        if (isset($_FILES['upFile']) && $_FILES['upFile']['name'] != "") :
            $file = $_FILES['upFile'];
            $fileID = $this->uploadFile($file);

            $newPost = new EPost();
            $newPost->newPost($this->session->getUserData(), $this->input->post('title'), $this->input->post('text'), $fileID);

            if ($this->input->post('TID') != 0) :
                $this->Posts_model->setPost($this->input->post('TID'), $newPost);

                $updatedUrl = array('posts', $this->input->post('TID'));
                alert('The post updated!', site_url($updatedUrl));
            else :
                $this->Posts_model->createPost($newPost);
                alert('The post created!', site_url('posts'));
            endif;
        else :
            parent::create($TID);
        endif;
    }

    public function delete()
    {
        $TID = $this->input->post('TID');
        $post = $this->Posts_model->getPostById($TID);

        if (empty($TID) || ($this->session->userdata('UserData') !== $post->ID)) :
            redirect('posts');
        endif;

        if(!empty($post->FileID)) :
            $this->clearFile($post->TID);
        endif;

        $this->deletePosts($TID);
    }

    public function clearFile(int $TID)
    {
        $filePost = $this->Posts_model->getPostById($TID);
        $file = $this->File_model->getFile($filePost->FileID);

        unlink(UPLOADPATH .'\\'. $file['name_save']);
        
        $fileID = $filePost->FileID;
        $filePost->FileID = null;

        $this->Posts_model->setPost($filePost->TID, $filePost);
        $this->File_model->deleteFile($fileID);
    }

    private function uploadFile(array $file)
    {
        $ext = substr($file['name'], strrpos($file['name'], '.') + 1); //확장자 추출

        $path = md5(microtime()) . '.' . $ext;

        $config['file_name'] = $path; // 파일이름변경
        $this->upload->initialize($config, false);

        $file_id = md5(uniqid(rand(), true));

        $newFile = array(
            'FileID' => $file_id,
            'name_orig' => $file['name'],
            'name_save' => $path,
            'reg_time' => date('Y-m-d H:i:s')
        );

        if (!$this->upload->do_upload('upFile')) :
            $error = $this->upload->display_errors();
            alert($error);

            return null;
        else :
            $this->File_model->createFile($newFile);

            $config['file_name'] = '';
            return $file_id;
        endif;
    }
}
