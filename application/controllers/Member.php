<?php

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
        $this->allow = array('login', 'logout');
    }

    public function login()
    {
        $data['title'] = 'Login';

        $ID = $this->input->post('ID');
        $PW = $this->input->post('PW');

        if (empty($ID) || empty($PW)) :
            //View 로그인
            $this->load->view('templates/header', $data);
            $this->load->view('member/login');
            $this->load->view('templates/footer');
        else :
            $data['member_item'] = $this->Member_model->get_member($ID);

            if (empty($data['member_item']) || ($data['member_item']['PW'] !== $PW)) {
                show_404();
            }

            $this->session->set_userdata('UserData', $ID);
            redirect('/posts');
        endif;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        alert('logouted', '/member');
    }
}
