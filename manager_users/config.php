<!--Các hằng của project-->
<!--<h1>config</h1>-->
<?php
$module='home';
$action='dashboard';
const _MODULE='home';
const _ACTION='dashboard';

const _CODE = true;

//Thiết lập host
 define('_WEB_HOST','http://'.$_SERVER['HTTP_HOST'].'/sibi_php/manager_users');
 define('_WEB_HOST_TEMPLATES',_WEB_HOST.'/templates');
//Thiết lập path
define('_WEB_PATH',__DIR__);
define('_WEB_PATH_TEMPLATES',_WEB_PATH.'/templates');
//thông tin kết nối
const _HOST = 'localhost';
const _DB = 'sibi_php';
const _USER = 'root';
const _PASS = '';

