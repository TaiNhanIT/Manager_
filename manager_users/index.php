<?php
//session_start();
require_once ('config.php');
require_once ('./includes/connect.php');
//thư viện php mailer
require_once ('./includes/phpmailer/Exception.php');
require_once ('./includes/phpmailer/PHPMailer.php');
require_once ('./includes/phpmailer/SMTP.php');

require_once ('./includes/functions.php');
require_once ('./includes/database.php');
require_once ('./includes/session.php');
//setFlashData('sibi','deptrai');
//echo getFlashData('sibi');

//sendMail('nguyenhuutainhan21003@gmail.com','Test send Mail','Nội dung của email');

$module = _MODULE;
$action = _ACTION;

if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}
if (!empty($_GET['module'])){
    if (is_string ($_GET['module'])){
        $module = trim($_GET['module']);
    }
}

$path = 'modules/' . $module . '/' . $action. '.php';

if(file_exists($path)){
    require_once($path);
}else{
    require_once'modules/error/404.php';
}

