<?php

class Reply extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('view');
        $this->load->model('Reply_model');
        $this->allow = array();
    }

    public function create()
    {
        $TID = $this->input->post('TID');
        $Paragraph = $this->input->post('replyText');

        if (empty($Paragraph)) {
            redirect(site_url(array('posts', $TID)));
        }

        $data = array(
            'TID' => $TID,
            'ID' => $this->session->userdata('UserData'),
            'Paragraph' => $Paragraph
        );

        $this->Reply_model->createReply($data);
        alert('apply it!', site_url(array('posts', $TID)));
    }

    public function delete()
    {
        $RID = $this->input->post('RID');

        if (empty($RID)) {
            redirect(site_url('posts'));
        }

        $this->Reply_model->deleteReplyByID($RID);
        alert('deleted!');
    }

    public function set()
    {
        $RID = $this->input->post('RID');
        $Paragraph = $this->input->post('Paragraph');

        if (empty($Paragraph) || empty($RID)) {
            alert('none!');
        } else {
            $this->Reply_model->setReply($RID, $Paragraph);
            alert('apply it!');
        }
    }
}
