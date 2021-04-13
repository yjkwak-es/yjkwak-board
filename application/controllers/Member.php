<?php

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
        $this->allow = array('login','logout');
    }

    public function login()
    {
        $this->load->library('form_validation');

        $data['title'] = 'Login';

        $this->form_validation->set_rules('ID','ID','required');
        $this->form_validation->set_rules('PW','PW','required');

        if($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('member/login');
            $this->load->view('templates/footer');
        }
        else {
            $ID = $this->input->post('ID');
            $PW = $this->input->post('PW');
            $data['member_item'] = $this->Member_model->get_member($ID);

            if (empty($data['member_item']) || ($data['member_item']['PW'] !== $PW)) {
                show_404();
            }

            $this->session->set_userdata('UserData', $ID);
            redirect('/posts');
        }
    }

    public function logout() 
    {
        $this->session->sess_destroy();
        
        alert('logouted', '/member');
    }
}
