<?php

use App\EReply;

class Reply extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reply_model');
        $this->allow = array();
    }

    public function create()
    {
        /**
         * PascalCase           # Class, Namespace, Trait, Interface ... => PSR-12
         * camelCase            # variable, member field, Function Name => PSR-12
         * snake_case (lower)   # Database Table Name
         * SNAKE_CASE (UPPER)   # variable, member field, Table Column Name
         * kebob-case           # html tag, attribute, url parameter
         */

        $TID = $this->input->post('TID', true);
        $Paragraph = $this->input->post('replyText', true);

        if (empty($Paragraph)) {
            redirect(site_url(array('posts', $TID)));
        }

        $data = EReply::newReply($TID, $this->session->getUserData(), $Paragraph);

        $this->Reply_model->createReply($data);
        alert('apply it!', site_url(array('posts', $TID)));
    }

    public function delete()
    {
        $RID = $this->input->post('RID', true);

        if (empty($RID)) {
            redirect(site_url('posts'));
        }

        $this->Reply_model->deleteReplyByID($RID);
        alert('deleted!');
    }

    public function set()
    {
        $RID = $this->input->post('RID', true);
        $Paragraph = $this->input->post('Paragraph');

        if (empty($Paragraph) || empty($RID)) {
            alert('none!');
        } else {
            $this->Reply_model->setReply($RID, $Paragraph);
            alert('apply it!');
        }
    }
}
