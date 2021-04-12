<?php

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
        $data['posts'] = $this->Posts_model->findPosts();

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
        }
        else {
            $data['posts_item'] = array(
                'TID' => '',
                'Title' => '',
                'Paragraph' => '',
            );
            if($this->input->post('TID')) {
                $data['posts_item'] = $this->posts_model->getPostById($this->input->post('TID'));
            }
            $this->Posts_model->createPosts();
            $this->load->view('posts/success');
        }
    }

    public function set()
    {
        
    }
}
