<!--Kết nối với database-->
<?php
if(!defined('_CODE')){
    die('Access denied...');
}
try {
    if (class_exists('PDO')) {
        $dsn = 'mysql:dbname='._DB.';host='._HOST;
        $options = [
                PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',// Set utf8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Tạo thông báo ra ngoại lệ khi gặp lỗi
        ];
        $connect = new PDO($dsn, _USER, _PASS,$options);
        if($connect){
            echo 'Kết nối thành công';
        }
    }
}catch(Exception $e){
    echo '<div style ="color : red;padding: 5px 15px; border: 1px solid red; ">';
    echo $e->getMessage().'<br>';
    echo '<div>';
    die();
}
