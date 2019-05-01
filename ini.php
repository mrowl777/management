<?php
    $db_name = 'u76899';
    $db_host = 'localhost';
    $db_user = 'u76899';
    $db_pass = '3R3MTvbpeJNYiuq';


    $main_menu = array(
        array('title' => 'МОНИТОРИНГ', 'id' => 'monitoring'),
        array('title' => 'button2', 'id' => '2'),
        array('title' => 'ЦЕЛИ', 'id' => 'targets'), 
        array('title' => 'ПОЛЬЗОВАТЕЛИ', 'id' => 'database'),
        array('title' => 'НАСТРОЙКИ', 'id' => 'settings'),
        array('title' => 'ВЫХОД', 'id' => 'exit')
    );

    define( '_MAIN_MENU_', $main_menu );
    define( 'API_VK', 'https://api.vk.com/method/' );
