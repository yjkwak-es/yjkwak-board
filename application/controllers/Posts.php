<?php

use App\EPost;

define("PAGESIZE", 3); //Number of Posts in 1 page
define("PAGEDIV", 3); //Number of pages in 1 Division

class Posts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->model('Reply_model');
        $this->load->helper('view');
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
        $this->load->view('templates/header', $data);
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

        $this->load->view('templates/header', $data);
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

        if (empty($title)) :
            $post = new EPost();
            $post->emptyPost();

            $data['posts_item'] = $post;
            $data['mod'] = 'posts/create';

            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        else :
            $newPost = new EPost;
            $newPost->newPost($this->session->getUserData(), $title, $this->input->post('text', true));

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

        $title = $this->input->post('title',true);

        if (empty($title)) :
            $post = $this->Posts_model->getPostById($TID);

            if ($post->ID !== $this->session->getUserData()) :
                redirect('posts/create');
            endif;

            $data['posts_item'] = $post;
            $data['mod'] = 'posts/set';

            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        else :
            $newPost = new EPost();
            $newPost->newPost($this->session->getUserData(), $title, $this->input->post('text', true));

            if ($this->Posts_model->setPost($this->input->post('TID'),$newPost)) :
                alert('The post updated!', site_url('posts'));
            else :
                alert('err', site_url('posts'));
            endif;
        endif;
    }

    /**
     * 게시글 삭제
     */
    
    public function deletePosts($TID)
    {
        $TID = $this->security->xss_clean($TID);

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
}
