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

        $ID = $this->input->post('ID',true);
        $PW = $this->input->post('PW',true);

        if (empty($ID) || empty($PW)) :
            //View 로그인
            $this->load->view('templates/header', $data);
            $this->load->view('member/login');
            $this->load->view('templates/footer');
        else :
            $data['member_item'] = $this->Member_model->getMemberByID($ID);

            if (empty($data['member_item']) || ($data['member_item']['PW'] !== $PW)) {
                show_404();
            }

            $this->session->set_userdata('UserData', $ID);

            if(isset($data['member_item']['name'])) :
                $this->seession->set_userdata('UserName',$data['member_item']['name']);
            endif;
            
            redirect('/posts');
        endif;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        alert('logouted', '/member');
    }

    public function setInfo()
    {
        $this->load->library('session');
        $this->load->helper('view');
        $name = $this->input->post('name',true);
        
        if(empty($name)) {
            $data['member'] = array(
                'name' => '',
                'age' => '',
                'gender' => ''
            );

            $data['member'] = $this->Member_model->getMemberByID($this->session->getUserData());
            $this->load->view('member/userInfo',$data);
        }
        else {
            $data = array(
                'name' => $name,
                'age' => $this->input->post('age'),
                'gender' => $this->input->post('gender')
            );
    
            $result = $this->Member_model->setMember($this->session->getUserData(),$data);
            if($result) :
                alert('Saved!');
            else:
                alert('Err');
            endif;
        }
    }
}
