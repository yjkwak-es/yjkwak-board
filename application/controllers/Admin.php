<?php
require_once __DIR__ . "/Member.php";

class Admin extends Member
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Admin_model');
    }

    public function members()
    {
        if (!$this->session->isAdmin()) {
            redirect('posts');
        }

        $tmpRow = $this->Admin_model->getAllMember();
        $data['members'] = $tmpRow['result'];
        $data['totalCount'] = $tmpRow['cnt'];

        $this->load->view('templates/header');
        $this->load->view('admin/allInfo', $data);
        $this->load->view('templates/footer');
    }
}
