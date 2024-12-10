<!-- Các hàm chung của project-->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
}
function layouts($layoutsName = 'header', $data = [])
{
    if ((_WEB_PATH_TEMPLATES . '/layout/' . $layoutsName . 'php')) {
        require_once _WEB_PATH_TEMPLATES . '/layout/' . $layoutsName . '.php';
    }
}

// Hàm gửi mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'nguyenhuutainhanit@gmail.com';                     //SMTP username
        $mail->Password = 'azfbrjdhrlpbsmis';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('nguyenhuutainhanit@gmail.com', 'Sibi');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $content;

        $mail->send();
        echo 'Mail đã được gửi thành công';
    } catch (Exception $e) {
        echo "Gửi Mail thất bại. Mailer Error: {$mail->ErrorInfo}";
    }
}

//Kiểm ta phương thức GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

//Kiểm ta phương thức POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// Hàm filter lọc dữ liệu
function filter()
{
    $filterArr = [];
    if (isGet()) {
        //Xử lý dữ liệu trước khi hiển thị ra
        //return $_GET
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $filterArr;
}

//Kiểm tra email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

//Kiểm tra số nguyên
function isNumberInt($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}

//Kiểm tra số thực Float
function isNumberFloat($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

//Kiểm tra số điện thoại
function isPhone($phone)
{
    $checkZero = false;
    // Điều kiện 1: chữ số đầu tiên là số 0
    if ($phone[0] == '0') {
        $checkZero = true;
        $phone = substr($phone, 1);
    }
    // Điều kiện 2: Sau số không sẽ có 9 chữ số
    $checkNumber = false;
    if (isNumberInt($phone) && (strlen($phone) == 9)) {
        $checkNumber = true;
    }

    if ($checkZero && $checkNumber) {
        return true;
    }
    return false;
}

// Thông báo lỗi
function getSmg($smg, $type = 'succcess')
{
    echo '<div class ="alert alert-' . $type . '">';
    echo $smg;
    echo '</div>';
}

function redirect($path = '')
{
    header("Location:$path");
    exit;
//Hàm thông báo lỗi
    function form_error($fileName, $beforeHtml= '', $afterHtml= '', $errors)
    {
        return (!empty($errors[$fileName]) ) ? '<span class ="error">'.reset($errors[$fileName]).' </span>':null;
    }
    function old($fileName, $oldData, $default = null)
    {
        return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;
    }
}



