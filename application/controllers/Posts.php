<?php
define("PAGESIZE", 3); //Number of Posts in 1 page
define("PAGEDIV", 3); //Number of pages in 1 Division

class Posts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Posts_model');
        $this->allow = array();
    }

    public function index()
    {
        $keyword = $this->input->get('keyword');
        $opt = $this->input->get('opt');
        $page = $this->input->get('page');

        if (empty($keyword)) {
            $keyword = '';
            $opt = '';
            $url = current_url()."?page=";
        }
        else {
            $url = current_url()."?opt=".$opt."&keyword=".$keyword."&page=";
        }

        if (empty($page) || $page <= 0) {
            $page = 1;
        }
        $start = ($page - 1) * PAGESIZE;

        $tmpRow = $this->Posts_model->findPosts($start, PAGESIZE, $keyword, $opt);
        $maxPage = $tmpRow['totalCount'] % PAGESIZE == 0 ? $tmpRow['totalCount'] / PAGESIZE : (int)($tmpRow['totalCount'] / PAGESIZE) + 1;

        if ($page > $maxPage) {
            $page = $maxPage;
            $start = ($page - 1) * PAGESIZE;
            $tmpRow = $this->Posts_model->findPosts($start, PAGESIZE, $keyword, $opt);
        }

        $divStart = (int)(($page - 1) / PAGEDIV);
        $divStart = $divStart * PAGEDIV + 1; //Find div starting page

        $divEnd = $divStart + PAGEDIV - 1;
        $divEnd = $divEnd > $maxPage ?  $maxPage : $divEnd; //Find div Ending page

        $data['posts'] = $tmpRow['result'];
        $data['postNum'] = $tmpRow['totalCount'] - $start; //Post Number`s start value;
        $data['page'] = $page;
        $data['maxPage'] = $maxPage;
        $data['divStart'] = $divStart;
        $data['divEnd'] = $divEnd;
        $data['url'] = $url;

        $data['title'] = 'Posts archive';

        $this->load->view('templates/header', $data);
        $this->load->view('posts/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($TID = NULL)
    {
        $data['posts_item'] = $this->Posts_model->getPostById($TID);

        if (empty($data['posts_item'])) {
            show_404();
        }

        $data['title'] = $data['posts_item']['Title'];

        $this->load->view('templates/header', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->library('form_validation');

        $data['title'] = 'Create Posts';



        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('text', 'text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');
        } else {
            $data['posts_item'] = array(
                'TID' => '',
                'Title' => '',
                'Paragraph' => '',
            );
            if ($this->input->post('TID')) {
                $data['posts_item'] = $this->posts_model->getPostById($this->input->post('TID'));
            }
            $this->Posts_model->createPosts();
            $this->load->view('posts/success');
        }
    }
}
