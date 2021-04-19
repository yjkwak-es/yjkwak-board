<?php

use App\EMember;
use App\EUser;

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
        $this->load->model('Admin_model');
        $this->allow = array('login', 'logout', 'createMember');
    }

    public function login()
    {
        $data['title'] = 'Login';

        $ID = $this->input->post('ID', true);
        $PW = $this->input->post('PW', true);

        if (empty($ID) || empty($PW)) {
            //View 로그인
            $this->load->view('templates/header');
            $this->load->view('member/login');
            $this->load->view('templates/footer');
        } else {
            $member = $this->Member_model->getMemberByID($ID);

            if (empty($member) || ($member->PW !== $PW)) {
                show_404();
            }

            $this->session->set_userdata('UserData', $ID);
            $admin = $this->Admin_model->memberCheck($member->PID);

            $this->session->set_userdata('admin', $admin);
            if (isset($member->name)) {
                $this->session->set_userdata('UserName', $member->name);
            }

            redirect('/posts');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        alert('logouted', '/member');
    }

    public function setInfo()
    {
        $name = $this->input->post('name', true);

        if (empty($name)) {
            $data['member'] = $this->Member_model->getMemberByID($this->session->getUserData());

            $this->load->view('member/userInfo', $data);
        } else {
            $data = EMember::setInfo($name, $this->input->post('age', true), $this->input->post('gender', true));
            $result = $this->Member_model->setMember($this->session->getUserData(), $data);

            if ($result) {
                $this->session->set_userdata('UserName', $name);
                close();
            } else {
                alert('Err');
            }
        }
    }

    public function createMember()
    {
        $newMember = EMember::setID($this->input->post('ID'), $this->input->post('PW'));

        if ($this->Member_model->getMemberByID($newMember->ID)) {
            $ret = false;

            header('Content-type: application/json');
            echo json_encode($ret);
            exit;
        }

        $ret = $this->Member_model->createMember($newMember);
        header('Content-type: application/json');
        echo json_encode($ret);
    }

    public function infotest()
    {
        $data = EMember::setInfo($this->input->post('name', true), $this->input->post('age', true), $this->input->post('gender', true));
        $result = $this->Member_model->setMember($this->session->getUserData(), $data);

        if ($result) {
            $this->session->set_userdata('UserName', $this->input->post('name', true));
        }

        header('Content-type: application/json');
        echo json_encode($result);
    }

    public function getInfo()
    {
        $member = $this->Member_model->getMemberByID($this->session->getUserData());

        header('Content-type: application/json');
        echo json_encode($member);
    }
}
