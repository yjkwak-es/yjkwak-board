<?php

class User_check
{
    public function checkID()
    {
        $CI =& get_instance();

        $CI->load->library('session');
        $CI->load->helper('url');
        
        // TODO @yjkwak : 로그인 페이지 & 로그인 시도시에는 아래 로직이 타지않도록 수정 필요
        if(isset($CI->allow) && (is_array($CI->allow) === false OR in_array($CI->router->method, $CI->allow) === false)){
            if (!$CI->session->userdata('UserData')) {
                redirect('/member');
            }
        }


        // if(current_url() != site_url('member')) {
        //     if (!$CI->session->userdata('UserData')) {
        //         redirect('/member');
        //     }
        // }
    }
}
