<?php

use App\EPost;

define("PAGESIZE", 5); //Number of Posts in 1 page
define("PAGEDIV", 3); //Number of pages in 1 Division
define('UPLOADPATH', FCPATH . 'uploads'); //filePath

class Posts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->model('Reply_model');
        $this->load->helper('view');

        $config['upload_path']          = UPLOADPATH;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5242880;

        $this->load->library('upload', $config);
        $this->load->model('File_model');

        $this->allow = array();
    }

    /**
     * 메인 게시판
     */

    public function index()
    {
        $keyword = $this->input->get('keyword', true);
        $opt = $this->input->get('opt', true);
        $page = $this->input->get('page', true);

        //검색 키워드 설정
        if (empty($keyword)) {
            $keyword = '';
            $opt = '';
            $url = current_url() . "?page=";
        } else {
            $url = current_url() . "?opt=" . $opt . "&keyword=" . $keyword . "&page=";
        }

        //현재 페이지 설정
        if (empty($page) || $page <= 0) {
            $page = 1;
        }
        $start = ($page - 1) * PAGESIZE;

        //검색 조회
        $tmpRow = $this->Posts_model->findPosts($start, PAGESIZE, $keyword, $opt);
        $maxPage = $tmpRow['totalCount'] % PAGESIZE == 0 ? $tmpRow['totalCount'] / PAGESIZE : (int)($tmpRow['totalCount'] / PAGESIZE) + 1;

        if ($page > $maxPage) {
            $page = $maxPage;
            $start = ($page - 1) * PAGESIZE;
            $tmpRow = $this->Posts_model->findPosts($start, PAGESIZE, $keyword, $opt);
        }

        //페이징 설정
        $divStart = (int)(($page - 1) / PAGEDIV);
        $divStart = $divStart * PAGEDIV + 1; //Find div starting page

        $divEnd = $divStart + PAGEDIV - 1;
        $divEnd = $divEnd > $maxPage ?  $maxPage : $divEnd; //Find div Ending page

        //view에 변수 전달
        $data['posts'] = $tmpRow['result'];
        $data['postNum'] = $tmpRow['totalCount'] - $start; //Post Number`s start value;
        $data['page'] = $page;
        $data['maxPage'] = $maxPage;
        $data['divStart'] = $divStart;
        $data['divEnd'] = $divEnd;
        $data['url'] = $url;

        $data['title'] = 'Posts archive';

        //VIEW
        $this->load->view('templates/header');
        $this->load->view('templates/mainMenu', $data);
        $this->load->view('posts/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * 게시글 보기
     */

    public function view($TID = NULL)
    {
        $TID = $this->security->xss_clean($TID);
        $this->load->model('File_model');

        $data['posts_item'] = $this->Posts_model->getPostById($TID);
        $tempRow = $this->Reply_model->getAllReplys($TID);

        if (isset($data['posts_item']->FileID)) :
            $data['file'] = $this->File_model->getFile($data['posts_item']->FileID);
        endif;

        $data['replies'] = $tempRow['result'];
        $data['replyCnt'] = $tempRow['totalCount'];

        if (empty($data['posts_item'])) {
            show_404();
        }

        $data['title'] = $data['posts_item']->Title;

        $this->load->view('templates/header');
        $this->load->view('templates/mainMenu', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    /**
     * 게시글 게제
     */

    public function create()
    {
        $data['title'] = 'Create Posts';

        $title = $this->input->post('title', true);

        //have it title? none -> goto view
        if (empty($title)) :
            $post = EPost::createEmpty();

            $data['posts_item'] = $post;
            $data['mod'] = 'posts/create';

            $this->load->view('templates/header');
            $this->load->view('templates/mainMenu', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        else :
            $fileID = null;
            //is uploaded file?
            if (isset($_FILES['upFile']) && $_FILES['upFile']['name'] != "") :
                $file = $_FILES['upFile'];
                $fileID = $this->uploadFile($file);
            endif;

            $newPost = EPost::newPost($this->session->getUserData(), $title, $this->input->post('text', true), $fileID);
            if ($this->Posts_model->createPost($newPost)) :
                alert('The post created!', site_url('posts'));
            else :
                alert('err', site_url('posts'));
            endif;
        endif;
    }

    /**
     * 게시글 수정
     */

    public function set($TID = null)
    {
        $TID = $this->security->xss_clean($TID);
        $data['title'] = 'Update Posts';

        $title = $this->input->post('title', true);

        //have it title? none -> goto view
        if (empty($title)) :
            $post = $this->Posts_model->getPostById($TID);

            if ($post->ID !== $this->session->getUserData()) :
                redirect('posts/create');
            endif;

            $data['posts_item'] = $post;
            $data['mod'] = 'posts/set';

            $this->load->view('templates/header');
            $this->load->view('templates/mainMenu', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        else :
            $fileID = null;
            //is uploaded file?
            if (isset($_FILES['upFile']) && $_FILES['upFile']['name'] != "") :
                $file = $_FILES['upFile'];

                $fileID = $this->uploadFile($file);
            endif;

            $newPost = EPost::newPost($this->session->getUserData(), $title, $this->input->post('text', true), $fileID);

            if ($this->Posts_model->setPost($this->input->post('TID'), $newPost)) :
                alert('The post updated!', site_url('posts'));
            else :
                alert('err', site_url('posts'));
            endif;
        endif;
    }

    /**
     * 게시글 삭제
     */

    public function deletePosts()
    {
        $TID = $this->input->post('TID', true);
        $post = $this->Posts_model->getPostById($TID);

        if (empty($TID) || ($this->session->userdata('UserData') !== $post->ID)) :
            redirect('posts');
        endif;

        if (!empty($post->FileID)) :
            $this->clearFile($post->TID);
        endif;

        $cnt = ($this->Reply_model->getAllReplys($TID))['totalCount'];
        if ($cnt != 0) :
            $this->Reply_model->deleteReplyAll($TID);
        endif;

        if ($this->Posts_model->deletePost($TID)) :
            alert('deleted!', site_url('posts'));
        else :
            alert('error in server!', site_url(array('posts')));
        endif;
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
