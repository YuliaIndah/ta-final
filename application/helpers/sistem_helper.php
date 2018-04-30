<?php 
if ( ! function_exists('in_access')){
    function in_access(){
        $ci=& get_instance();
        if($ci->session->userdata('logged_in') != TRUE){
            redirect('LoginC/logout');
        }
    }
}

if ( ! function_exists('redirect_back')){ //untuk redirect kembali ke halaman sebelumnya
    function redirect_back(){
        if(isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        exit;
    }
}