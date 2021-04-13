<?php

class Reply extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reply_model');
        $this->allow = array();
    }

    public function create() 
    {
        $this->load->helper('view');

        $TID = $this->input->post('TID');
        $Paragraph = $this->input->post('replyText');
        
        if(empty($Paragraph)) {
            redirect(site_url(array('posts',$TID)));
        }

        $data = array (
            'TID' => $TID,
            'ID' => $this->session->userdata('UserData'),
            'Paragraph' => $Paragraph
        );

        $this->Reply_model->createReply($data);
        alert('apply it!',site_url(array('posts',$TID)));
    }
}
