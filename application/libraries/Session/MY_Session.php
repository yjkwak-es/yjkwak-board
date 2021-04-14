<?php

class MY_Session extends CI_Session
{
    public function getUserData()
    {
        return $this->userdata('UserData');
    }
}
