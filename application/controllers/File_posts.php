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

    /**
     * 게시글 게제
     */

    public function create()
    {
        if (isset($_FILES['upFile']) && $_FILES['upFile']['name'] != "") :
            $file = $_FILES['upFile'];

            $fileID = $this->uploadFile($file);

            $newPost = new EPost();
            $newPost->newPost($this->session->getUserData(), $this->input->post('title'), $this->input->post('text'), $fileID);

            if ($this->Posts_model->createPost($newPost)) :

                alert('The post created!', site_url('posts'));
            else :
                alert('err', site_url('posts'));

            endif;
        else :
            parent::create();
        endif;
    }

    /**
     * 게시글 수정
     */

    public function set($TID = null)
    {
        $TID = $this->security->xss_clean($TID);

        if (isset($_FILES['upFile']) && $_FILES['upFile']['name'] != "") :
            $file = $_FILES['upFile'];

            $fileID = $this->uploadFile($file);

            $newPost = new EPost();
            $newPost->newPost($this->session->getUserData(), $this->input->post('title'), $this->input->post('text'), $fileID);
            
            if ($this->Posts_model->setPost($this->input->post('TID'),$newPost)) :

                alert('The post updated!', site_url('posts'));
            else :
                alert('err', site_url('posts'));

            endif;
        else :
            parent::set($TID);
        endif;
    }

    /**
     * 게시글 삭제
     */
    
    public function delete()
    {
        $TID = $this->input->post('TID');
        $post = $this->Posts_model->getPostById($TID);

        if (empty($TID) || ($this->session->userdata('UserData') !== $post->ID)) :
            redirect('posts');
        endif;

        if (!empty($post->FileID)) :
            $this->clearFile($post->TID);
        endif;

        $this->deletePosts($TID);
    }

    /**
     * 첨부파일 삭제
     */

    public function clearFile(int $TID)
    {
        $TID = $this->security->xss_clean($TID);

        $filePost = $this->Posts_model->getPostById($TID);
        $file = $this->File_model->getFile($filePost->FileID);

        unlink(UPLOADPATH . '\\' . $file['name_save']);

        $fileID = $filePost->FileID;
        $filePost->FileID = null;

        $this->Posts_model->setPost($filePost->TID, $filePost);
        $this->File_model->deleteFile($fileID);
    }

    /**
     * 파일 다운로드
     */

    public function downloadfile(string $FileID = null)
    {
        $FileID = $this->security->xss_clean($FileID);

        if (empty($FileID)) :
            redirect('posts');
        endif;

        $this->load->helper('download');
        $file = $this->File_model->getFile($FileID);
        $data = file_get_contents(UPLOADPATH . '\\' . $file['name_save']);

        force_download($file['name_orig'], $data);
    }

    /**
     * 파일 업로드
     */

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
