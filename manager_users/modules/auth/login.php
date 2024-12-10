<!--Đăng nhập-->
<?php

if (!defined('_CODE')) {
    die('Access denied...');
}
$data = [
    'pageTitle' =>'Đăng nhập tài khoản',

];
layouts('header',$data);
//$kq = filter();
//echo '<pre>';
//print_r($kq);
//echo '</pre>';
$password = '123456';
//$md5 = md5($password);
//$sha1 = sha1($password);
//echo 'MD5: '.$md5.'<br>';
//echo 'SHA1: '.$sha1;
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$check_Pass = password_verify('123456', $passwordHash);
var_dump($check_Pass, $passwordHash);

?>
<div class="row"></div>
<div class="col-4" style="margin:100px auto;">
    <h2 class="text-center text-uppercase mg-form"> Đăng nhập quản lý Users</h2>
<form action="" method="post">
    <label for="">Email</label>
    <div class="form-group mg-form">
        <input name = "email" type="email" class="form-control" placeholder="Địa chỉ">
    </div>
    <div class="form-group mg-form">
        <label for="">Password</label>
        <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
    </div>
    <button type="submit" class="mg-btn btn btn-primary btn-block">Đăng nhập</button>
    <hr>
    <p class="text-center"><a href="?module=auth&action=forgotPassword">Quên mật khẩu</a></p>
    <p class="text-center"><a href="?module=auth&action=register">Đăng ký tài khoản</a></p>
</form>

<?php
    layouts('footer');
?>