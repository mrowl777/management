<?php

class db_handler {
    

    function connect_db(){
        include __DIR__ . '/../ini.php';
        
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        return $mysqli;
    }

    function close_connection( $mysqli ){
        mysqli_close( $mysqli );
    }

    function get_usr_hash( $usr ){
        $db_helper = $this->connect_db();
        $query = "SELECT hash FROM panel_users WHERE nickname = '" . $usr . "'";
        $db_hash = $db_helper->query( $query );
        $db_hash = $db_hash->fetch_assoc();
        $this->close_connection( $db_helper );

        return $db_hash['hash'];
    }

    function get_usr_password( $name ){
        $db_helper = $this->connect_db();
        $query = "SELECT password FROM panel_users WHERE nickname = '" . $name . "'";
        $db_pass = $db_helper->query( $query );
        $db_pass = $db_pass->fetch_assoc();
        $this->close_connection( $db_helper );

        return $db_pass['password'];
    }

    function setup_hash(  $hash, $name ){
        $db_helper = $this->connect_db();
        $query = "UPDATE panel_users SET hash = '" . $hash . "' WHERE nickname = '" . $name . "'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function reset_hash( $name ){
        $db_helper = $this->connect_db();
        $query = "UPDATE panel_users SET hash = '' WHERE nickname = '" . $name . "'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function check_free_name( $name ){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM panel_users WHERE nickname = '" . $name . "'";
        $result = $db_helper->query( $query );
        $this->close_connection( $db_helper );
        $count = mysqli_num_rows( $result ) === 0;
        return $count;
    }

    function create_user( $name, $password ){
        $db_helper = $this->connect_db();
        $query = "INSERT INTO `panel_users`(`id`, `nickname`, `password`, `hash`, `is_admin`, `reg_date`) VALUES ('','" . $name . "','" . $password . "','','0', CURRENT_TIMESTAMP)";
        $result = $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function get_users_table(){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM `panel_users`";
        $panel_users = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $panel_users;
    }

    function remove_panel_user( $name ){
        $db_helper = $this->connect_db();
        $query = "DELETE FROM `panel_users` WHERE `nickname` = '".$name."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function toggle_user_rights( $name ){
        $db_helper = $this->connect_db();
        $query = "SELECT is_admin FROM `panel_users` WHERE `nickname` = '".$name."'";
        $rights = $db_helper->query( $query );
        $rights = $rights->fetch_assoc();
        $rights = $rights['is_admin'];
        $is_admin = $rights === '1' ? 'is_admin = "0"' : 'is_admin = "1"';
        $query = "UPDATE panel_users SET ".$is_admin." WHERE nickname = '" . $name . "'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function update_password( $name, $password ){
        $db_helper = $this->connect_db();
        $query = "UPDATE panel_users SET password = '".$password."' WHERE nickname = '" . $name . "'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }


    function set_param( $k, $v ){
        $db_helper = $this->connect_db();
        $query = "UPDATE settings SET `value` = '".$v."' WHERE `key` = '".$k."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function get_settings(){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM `settings`";
        $settings = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $settings;
    }

    function remove_setting_param( $key ){
        $db_helper = $this->connect_db();
        $query = "DELETE FROM `settings` WHERE `key` = '".$key."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function add_setting_param( $key, $value ){
        $db_helper = $this->connect_db();
        $query = "INSERT INTO `settings`(`id`, `key`, `value`) VALUES ('','".$key."','".$value."')";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function get_setting_param( $param ){
        $db_helper = $this->connect_db();
        $query = "SELECT `value` FROM `settings` WHERE `key` ='" . $param . "'" ;
        $result = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        $result = $result->fetch_assoc();

        return $result['value'];
    }

    function get_targets(){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM `targets`";
        $targets = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $targets;
    }

    function remove_target( $key ){
        $db_helper = $this->connect_db();
        $query = "DELETE FROM `targets` WHERE `vk_id` = '".$key."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function add_target( $id, $f_name, $l_name ){
        $db_helper = $this->connect_db();
        $query = "INSERT INTO `targets`(`id`, `vk_id`, `first_name`, `last_name`, `is_active`) VALUES ('','".$id."','".$f_name."','".$l_name."','1')";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function toggle_target( $id ){
        $db_helper = $this->connect_db();
        $query = "SELECT is_active FROM `targets` WHERE `vk_id` = '".$id."'";
        $rights = $db_helper->query( $query );
        $rights = $rights->fetch_assoc();
        $rights = $rights['is_active'];
        $is_admin = $rights === '1' ? 'is_active = "0"' : 'is_active = "1"';
        $query = "UPDATE targets SET ".$is_admin." WHERE vk_id = '" . $id . "'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }
}
?>