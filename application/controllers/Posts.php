<?php

class Posts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Posts_model');
    }

    public function index()
    {
        $data['posts'] = $this->Posts_model->get_posts();

        $data['title'] = 'Posts archive';

        $this->load->view('templates/header', $data);
        $this->load->view('posts/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($TID = NULL)
    {
        $data['posts_item'] = $this->Posts_model->get_posts($TID);

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
        }
        else {
            $this->Posts_model->create_posts();
            $this->load->view('posts/success');
        }
    }
}
