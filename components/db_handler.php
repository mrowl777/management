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
        $query = "SELECT * FROM `staff_data`";
        $panel_users = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $panel_users;
    }

    function get_staffs(){
        $db_helper = $this->connect_db();
        $query = "SELECT `id`, `is_active`, `start_date` FROM `staff_data` WHERE 1";
        $staff_data = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $staff_data;
    }


    function get_times_table(){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM `work_types`";
        $panel_users = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        return $panel_users;
    }

    function remove_panel_user( $id ){
        $db_helper = $this->connect_db();
        $query = "UPDATE `staff_data` SET `is_active`= '0' WHERE `id` = '".$id."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function set_active( $id ){
        $db_helper = $this->connect_db();
        $query = "UPDATE `staff_data` SET `is_active`= '1', `start_date` = CURRENT_TIMESTAMP WHERE `id` = '".$id."'";
        $db_helper->query( $query );
        $this->close_connection( $db_helper );
    }

    function add_staff( $first_name, $last_name, $surname, $time = '', $username, $pass ){
        $db_helper = $this->connect_db();
        /** заполняем данные сотрудника */
        $query = "INSERT INTO `staff_data`(`id`, `first_name`, `last_name`, `surname`, `is_active`, `start_date`, `work_time_type`) VALUES ('','" . $first_name . "','" . $last_name . "', '".$surname."' , '1', CURRENT_TIMESTAMP, '".$time."')";
        $result = $db_helper->query( $query );
       
        /** проверяем доступность логина */
        if(!$this->check_free_name( $username )){
            $username = $username . "_" . rand(0, 100);
            $is_exist = $this->check_free_name( $username );
        }
        /**генерим пароль */
        $pass_md = md5(md5($pass)); 
         /**заводим ему учетку  */
        $query = "INSERT INTO `panel_users`(`id`, `nickname`, `password`, `hash`, `is_admin`, `reg_date`) VALUES ( '','".$username."','".$pass_md."','','0', CURRENT_TIMESTAMP )";
        $result = $db_helper->query( $query );
        $this->close_connection( $db_helper );
        /** возвращаем логин и пароль сотрудника   */
        return array( $username, $pass );
    }

    function get_user_rights( $name ){
        $db_helper = $this->connect_db();
        $query = "SELECT is_admin FROM `panel_users` WHERE `nickname` = '".$name."'";
        $rights = $db_helper->query( $query );
        $rights = $rights->fetch_assoc();
        $this->close_connection( $db_helper );

        return $rights['is_admin'];
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

    function get_timetable(){
        $db_helper = $this->connect_db();
        $query = "SELECT * FROM `timetable`";
        $timetable = $db_helper->query( $query );
        $this->close_connection( $db_helper );

        $count = mysqli_num_rows( $timetable ) !== 0;

        if( $count ){
            return $timetable;
        }

        return false;
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
}
?>