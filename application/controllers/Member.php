<?php

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
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
            $data['member_item'] = $this->Member_model->get_member();

            if (empty($data['member_item']) || ($data['member_item']['PW'] !== $this->input->post('PW'))) {
                show_404();
            }

            $this->session->set_userdata('UserData','ID');
            redirect('/posts');
        }
    }

    public function logout() 
    {
        $this->session->sess_destroy();
        $l = 'logouted!';
        alert($l, '/member');
    }

    public function testred()
    {
        // redirect('/member?name=123');
        alert('test', '/member');
    }
}
