<?php

include 'components/MainController.php';
include 'components/Auth.php';
include 'components/websun.php'; 
include 'ini.php'; 


$auth = new Auth();
$call = new MainController();


if( isset($_POST) ){
    switch( $_POST['action'] ){
        case 'login':
            $auth->_on_login();
        break;

        case 'logout':
            $auth->_on_kill_session();
        break;

        case 'register':
            $auth->_on_new_user();
        break;

        case 'manage_db':
            if( $auth->check_session() ){
                $call->_on_manage_db();
            }
            die();
        break;

        case 'delete_panel_usr':
            $call->_on_delete_panel_usr();
            die();
        break;

        case 'toggle_rights_usr':
            $call->_on_toggle_rights_usr();
            die();
        break;

        case 'change_usr_pass':
            $call->_on_change_usr_pass();
            die();
        break;

        case 'open_settings':
            if( $auth->check_session() ){
                $call->_on_open_settings();
            }
            die();
        break;

        case 'setup_param':
            $call->_on_setup_param();
            die();
        break;

        case 'rm_param':
            $call->_on_rm_param();
            die();
        break;

        case 'add_param':
            $call->_on_add_param();
            die();
        break;
        
    }
}


$call->_r_header();


if( $auth->check_session() ){
    $call->_r_main();
}


$call->_r_footer();




?>