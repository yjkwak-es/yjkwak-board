<?php
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
        $keyword = $this->input->get('keyword');
        $opt = $this->input->get('opt');
        $page = $this->input->get('page');

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
        $data['posts_item'] = $this->Posts_model->getPostById($TID);
        $tempRow = $this->Reply_model->getAllReplys($TID);

        $data['replys'] = $tempRow['result'];
        $data['replyCnt'] = $tempRow['totalCount'];

        if (empty($data['posts_item'])) {
            show_404();
        }

        $data['title'] = $data['posts_item']['Title'];

        $this->load->view('templates/header', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    /**
     * 게시글 게제
     */
    public function create($TID = null)
    {
        $this->load->library('form_validation');

        $data['title'] = 'Create Posts';

        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('text', 'text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['posts_item'] = array(
                'TID' => '',
                'Title' => '',
                'Paragraph' => '',
            );
            if ($TID) {
                $data['posts_item'] = $this->Posts_model->getPostById($TID);
                if ($data['posts_item']['ID'] !== $this->session->userdata('UserData')) {
                    redirect('posts/create');
                }
            }

            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'ID' => $this->session->userdata('UserData'),
                'Title' => $this->input->post('title'),
                'Paragraph' => $this->input->post('text'),
                'FileID' => null
            );

            if ($this->input->post('TID')) {
                $this->Posts_model->setPost($this->input->post('TID'), $data);
                alert('The post updated!', site_url(array('posts', $this->input->post('TID'))));
            } else {
                $this->Posts_model->createPost($data);
                alert('The post created!', site_url('posts'));
            }
        }
    }

    /**
     * 게시글 삭제
     */
    public function delete()
    {
        $TID = $this->input->post('TID');
        $post = $this->Posts_model->getPostById($TID);

        if (empty($TID) || ($this->session->userdata('UserData') !== $post['ID'])) {
            redirect('posts');
        }

        $cnt = ($this->Reply_model->getAllReplys($TID))['totalCount'];
        if ($cnt != 0) {
            $this->Reply_model->deleteReplyAll($TID);
        }

        if ($this->Posts_model->deletePost($TID)) {
            alert('delted!', site_url('posts'));
        } else {
            alert('error in server!', site_url(array('posts', $TID)));
        }
    }
}
