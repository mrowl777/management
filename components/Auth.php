<?php

class Auth extends db_handler{

    function check_session(){
        if ( isset($_COOKIE["online_tracker"]) ){
            $usr = $_COOKIE["user_name"];
            $hash = $_COOKIE["hash"];
            $db_hash = $this->get_usr_hash( $usr );
            if( $db_hash == $hash ){
                return true;
            }
        }

        $this->_r_login();
    }

    function _r_login(){
        ini_set('pcre.backtrack_limit', 1024*1024);
        $DATA['menu'] = _MAIN_MENU_;
        $tpl = '../login_page/index.tpl';
        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html; 
    }

    function _on_kill_session(){
        $usr = $_COOKIE["user_name"];
        setcookie('user_name', null, -1, '/');
        setcookie('online_tracker', null, -1, '/');
        setcookie('hash', null, -1, '/');
        $this->reset_hash( $usr );
    }

    function _on_login(){
        $name = $_POST['login'];
        $password =  md5(md5($_POST['password']));
        $db_pass = $this->get_usr_password( $name );

        if( $password == $db_pass){
            $this->set_session( $name, $password );
        }else{
            die('auth_error');
        }    
    }

    function _on_new_user(){
        $name = $_POST['login'];
        $password =  md5(md5($_POST['password']));
        $free = $this->check_free_name( $name );
        if( $free ){
            $this->create_user( $name, $password );
            $this->set_session( $name , $password );
        }else{
            die('wrong_nickname');
        }
    }

    function set_session( $name , $password ){
        $nums= preg_replace ('~[^0-9]+~','', $password);
        $hash = hash('sha256', time( $nums ));
        $this->setup_hash( $hash, $name );
        setcookie( 'online_tracker', 'session', 0 );
        setcookie( 'user_name', $name, 0 );
        setcookie( 'hash', $hash, 0 );
        header('Location: http://u76899.netangels.ru/staff_management/');
    }

}

?>