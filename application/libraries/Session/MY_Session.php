<?php

class MY_Session extends CI_Session
{
    public function getUserData()
    {
        return $this->userdata('UserData');
    }

    public function selectUserData()
    {
        if ($this->has_userdata('UserName')) :
            return $this->userdata('UserName');
        else :
            return $this->userdata('UserData');
        endif;
    }

    public function isAdmin()
    {
        if($this->userdata('Admin') == 1) :
            return true;
        else:
            return false;
        endif;
    }
}
