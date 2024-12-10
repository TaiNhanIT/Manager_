<!--Đăng nhập-->
<?php

if (!defined('_CODE')) {
    die('Access denied...');
}
require_once './includes/database.php';

$data = [
    'id' => '3',
    'fullname' => 'sontungmtp',
    'email' => 'hahahhahahah@gmail.com',
    'phone' => '0909099999',
];
//$kq = getRows(' SELECT * FROM `users` ');
//echo '<pre>';
//print_r('Số dòng là'.' '.$kq);
//echo '</pre>';
//insert('users', $data);
//update('users',$data,'id=3');
//delete('users','id=');
//select('users',$data,'id=');
//$kq = isNumberFloat(12.4);
//var_dump ($kq);

if (isPost()) {
    $filterAll = filter();

//    echo '<pre>';
//    print_r($filterAll);
//    echo'</pre>';

    $errors = []; // Mảng chứa các lỗi

    //Validate fullname : Bắt buộc phải nhập, min 5 ký tự
    if (empty ($filterAll['fullname'])) {
        $errors ['fullname']['required'] = 'Bạn chưa nhập họ và tên';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors ['fullname']['min'] = 'họ và tên phải có ít nhất 5 ký tự';
        }
    }
    //Validate Email :Bắt buộc phải nhập, đúng định dạng, Kiểm tra email đã tồn tại trong csdl chưa
    if (empty ($filterAll['email'])) {
        $errors ['email']['required'] = 'Bạn chưa nhập email';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if (getRows($sql) > 0) {
            $errors['email']['unique'] = 'email đã tồn tại';
        }
    }
    //validate số điện thoại : Bắt buộc phải nhập, đúng định dạng số diện thoại
    if (empty($filterAll['phone'])) {
        $errors ['phone']['required'] = 'Bạn chưa nhập số điện thoại';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors ['phone']['isPhone'] = 'số điện thoại không hợp lệ';
        }
    }
    if (empty($filterAll['password'])) {
        $errors ['password']['required'] = 'Bạn chưa nhập mật khẩu';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors ['password']['min'] = 'mật khẩu phải lớn hơn hoặc bằng 8 ký tự';
        }
    }

    //Validate password_confirm : giống mật khẩu
    if (empty($filterAll['password_confirm'])) {
        $errors ['password_confirm']['required'] = 'Bạn chưa nhập lại mật khẩu';
    } else {
        if (($filterAll['password']) != $filterAll['password_confirm']) {
            $errors ['password_confirm']['match'] = 'Nhập lại mật khẩu không đúng';
        }
    }
    if (empty($errors)) {
        //Xử lý errors
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'],PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('users', $dataInsert);
        if($insertStatus){
            setFlashData('smg','Bạn đã đăng ký thành công!!!');
            setFlashData('smg_type','success');
        }
        redirect("?module=auth&action=register");
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu của bạn!!!');
        setFlashData('smg_type', 'Danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect("?module=auth&action=register");
    }
}
layouts('header', $data);

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
echo '<pre>';
print_r($errors);
echo '</pre>';
?>

<div class="row"></div>
<div class="col-4" style="margin:100px auto;">
    <h2 class="text-center text-uppercase mg-form"> Đăng ký tài khoản Users</h2>
    <?php
    if (!empty($smg)) {
        getSmg($smg, $smg_type);
    }
    ?>
    <form action="" method="post">
        <div class="form-group mg-form">
            <label for=""> Họ và tên </label>
            <input name='fullname' type="text" class="form-control" placeholder="Họ và tên" value="<?php
            echo (!empty($old['fullname'])) ? $old['fullname'] : null;
            ?>">
            <?php
            echo (!empty($errors['fullname'])) ? '<span class ="error"> ' . reset($errors['fullname']) . ' </span>' : null;
            ?>
        </div>
        <div class="form-group mg-form">
            <label for="">Email</label>
            <input name="email" type="email" class="form-control" placeholder="Địa chỉ email" value="<?php
            echo (!empty($old['email'])) ? $old['email'] : null;
            ?>">
            <?php
            echo (!empty($errors['email'])) ? '<span class ="error"> ' . reset($errors['email']) . ' </span>' : null;
            ?>
        </div>
        <div class="form-group mg-form">
            <label for="">Số điện thoại</label>
            <input name="phone" type="text" class="form-control" placeholder="Số điện thoại" value="<?php
            echo (!empty($old['phone'])) ? $old['phone'] : null;
            ?>">
            <?php
            echo (!empty($errors['phone'])) ? '<span class ="error"> ' . reset($errors['phone']) . ' </span>' : null;
            ?>
        </div>
        <div class="form-group mg-form">
            <label for="">Password</label>
            <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
            <?php
            echo (!empty($errors['password'])) ? '<span class ="error"> ' . reset($errors['password']) . ' </span>' : null;
            ?>
        </div>
        <div class="form-group mg-form">
            <label for="">Nhập lại mật khẩu</label>
            <input name="password_confirm" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
            <?php
            echo (!empty($errors['password_confirm'])) ? '<span class ="error"> ' . reset($errors['password_confirm']) . ' </span>' : null;
            ?>
        </div>
        <button type="submit" class="mg-btn btn btn-primary btn-block">Đăng ký</button>
        <hr>
        <p class="text-center"><a href="?module=auth&action=login">Đăng nhập tài khoản</a></p>
    </form>
<?php
layouts('footer');
?>