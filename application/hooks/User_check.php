<?php

class User_check
{
    public function checkID()
    {
        $CI =& get_instance();

        // TODO @yjkwak : 로그인 페이지 & 로그인 시도시에는 아래 로직이 타지않도록 수정 필요

        $CI->load->library('session');
        $CI->load->helper('url');

        if(current_url() != site_url('member')) {
            if (!$CI->session->userdata('UserData')) {
                redirect('/member');
            }
        }
    }
}
