<?php

include 'db_handler.php';

class MainController extends db_handler {

    function _r_header(){
        $tpl = '../base_page/templates/header.tpl';
        $blocked_menu = true;
        $hash = $this->get_usr_hash( $_COOKIE["user_name"] );

        if ( isset($_COOKIE["online_tracker"]) && $_COOKIE["hash"] == $hash ){
            $blocked_menu = false;
        }

        $DATA['menu'] = _MAIN_MENU_;
        $DATA['menu_blocked'] = $blocked_menu;
        $html = websun_parse_template_path($DATA, $tpl); 
        echo $html; 
    }
    
    function _r_main(){

        ini_set('pcre.backtrack_limit', 1024*1024);

        $DATA = [];

        $tpl = '../base_page/templates/index.tpl';

        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html; 
    }

    function _r_footer(){
        $tpl = '../base_page/templates/footer.tpl';
        $DATA = [];
        $html = websun_parse_template_path($DATA, $tpl); 
        echo $html; 
    }

    function _on_manage_db(){
        ini_set('pcre.backtrack_limit', 1024*1024);

        $DATA = [];

        $users_table = $this->get_users_table();
    
        $tpl = '../base_page/templates/database.tpl';
        $users = [];
        while ($row = $users_table->fetch_assoc()) {
            $users[] = array(
                'id' => $row["id"], 
                'nickname' => $row["nickname"], 
                'password' => $row["password"],
                'hash' => $row["hash"],
                'is_admin' => $row["is_admin"],
                'reg_date' => $row["reg_date"],
            );
        }

        $DATA['panel_users'] = $users;

        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html;
    }

    function _on_delete_panel_usr(){
        $this-> remove_panel_user( $_POST['username'] );
        $this->_on_manage_db();
    }

    function _on_toggle_rights_usr(){
        $this-> toggle_user_rights( $_POST['username'] );
        $this->_on_manage_db();
    }

    function _on_change_usr_pass(){
        $pass = md5(md5($_POST['password']));
        $this-> update_password( $_POST['username'], $pass );
        $this->_on_manage_db();
    }

    function _on_open_settings(){
        ini_set('pcre.backtrack_limit', 1024*1024);

        $DATA = [];

        $settings = [];
        $settings_table = $this->get_settings();

        while ($row = $settings_table->fetch_assoc()) {
            $settings[] = array(
                'key' => $row["key"], 
                'value' => $row["value"]
            );
        }

        $DATA['settings'] = $settings;

        $tpl = '../base_page/templates/settings.tpl';

        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html;
    }

    function _on_setup_param(){
        $this->set_param( $_POST['key'], $_POST['value'] );
        $this->_on_open_settings();
    }

    function _on_rm_param(){
        $this->remove_setting_param( $_POST['key'] );
        $this->_on_open_settings();
    }

    function _on_add_param(){
        $this->add_setting_param( $_POST['key'], $_POST['value'] );
        $this->_on_open_settings();
    }

    function _on_rm_target(){
        $this->remove_target( $_POST['key'] );
        $this->_on_open_targets();
    }

    function _on_toggle_target(){
        $this->toggle_target( $_POST['id'] );
        $this->_on_open_targets();
    }

    function _on_add_target(){
        $token = $this->get_setting_param( 'vk_token' );
        $api_ver = $this->get_setting_param( 'vk_api_version' );
        $url = API_VK . "users.get?user_ids=".$_POST['id']."&access_token=".$token."&v=".$api_ver;
        $res = file_get_contents($url);
        $users_data = json_decode($res,true);
        $id = $users_data['response'][0]['id'];
        $f_name = $users_data['response'][0]['first_name'];
        $l_name = $users_data['response'][0]['last_name'];
        $this->add_target( $id, $f_name, $l_name );
        $this->_on_open_targets();
    }

    function _on_open_targets(){
        ini_set('pcre.backtrack_limit', 1024*1024);

        $DATA = [];

        $targets = [];
        $targets_table = $this->get_targets();

        while ($row = $targets_table->fetch_assoc()) {
            $targets[] = array(
                'vk_id' => $row["vk_id"], 
                'name_first' => $row["first_name"],
                'name_last' => $row["last_name"],
                'active' => $row["is_active"]
            );
        }

        $DATA['targets'] = $targets;

        $tpl = '../base_page/templates/targets.tpl';

        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html;
    }

    function _on_open_monitor(){
        ini_set('pcre.backtrack_limit', 1024*1024);

        $token = $this->get_setting_param( 'vk_token' );
        $api_ver = $this->get_setting_param( 'vk_api_version' );

        $DATA = [];
        // $url = API_VK . "users.get?user_ids=emilia_weimar&access_token=".$token."&v=".$api_ver;
        // $res = file_get_contents($url);
        // $users_data = json_decode($res,true);
        // echo $users_data['response'][0]['id'] ."<br/>";
        // echo $users_data['response'][0]['first_name'] ."<br/>";
        // echo $users_data['response'][0]['last_name'] ."<br/>";
        // var_dump($users_data['response']);

        $tpl = '../base_page/templates/monitor.tpl';

        $html = websun_parse_template_path($DATA, $tpl); 

        echo $html;
    }

}

?>