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

    function _on_manage_db( $username = '', $pass = '' ){
        ini_set('pcre.backtrack_limit', 1024*1024);

        $DATA = [];

        $users_table = $this->get_users_table();
        $times_table = $this->get_times_table();
    
        $tpl = '../base_page/templates/database.tpl';
        $users = [];
        $time_var = [];
        while ($row = $times_table->fetch_assoc()) {
            $time_var[$row['type']]=$row['time'];
        }
        while ($row = $users_table->fetch_assoc()) {
            $users[] = array(
                'id' => $row["id"], 
                'first_name' => $row["first_name"], 
                'last_name' => $row["last_name"],
                'surname' => $row["surname"],
                'is_active' => $row["is_active"],
                'work_time_type' => $time_var[$row["work_time_type"]],
            );
        }

        $DATA['staffs'] = $users;
        $DATA['times'] = $time_var;

        $html = websun_parse_template_path($DATA, $tpl); 

        if($username !== ''){
            echo $username . "<br/>";
            echo $pass . "<br/>";
        }

        echo $html;
    }

    function _on_delete_panel_usr(){
        $this-> remove_panel_user( $_POST['username'] );
        $this->_on_manage_db();
    }

    function _on_set_worker(){
        $this-> set_active( $_POST['username'] );
        $this->_on_manage_db();
    }

    function _on_add_staff(){
        $f_name = $_POST['first_name'];
        $l_name = $_POST['last_name'];
        $s_name = $_POST['surname'];
        $time = $_POST['time'];
        $username = $this->str2url($l_name);
        $pass = $this->generate_password();
        list ($setted_up_u_name, $setted_up_password) = $this-> add_staff( $f_name, $l_name, $s_name, $time, $username, $pass );
        $this->_on_manage_db($username, $pass);   
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


    /**generating username & password */
    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    function str2url($str) {
        // переводим в транслит
        $str = rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    function generate_password(){
        return rand(11111111, 99999999);
    }

}

?>