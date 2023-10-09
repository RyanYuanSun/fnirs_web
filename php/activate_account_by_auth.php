<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
if (isset($_SERVER['HTTP_ORIGIN'])){
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.sunrays.top" || $http_origin == "https://member.sunrays.top" || $http_origin == "https://lib.sunrays.top" || $http_origin == "https://store.sunrays.top")
    {
        header("Access-Control-Allow-Origin: $http_origin");
        header('Access-Control-Allow-Methods:POST');
    }
} else{
    echo "Unauthorized request.";
    exit();
}
header("Content-Type: application/json;charset=utf-8");
include_once 'C:\Users\Administrator\Desktop\sunrays\web\php\rate_limit.php';
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\mal_ip_record.php";

if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['fname'])&&isset($_POST['lname'])&&isset($_POST['auth-type'])&&isset($_POST['auth-code'])&&isset($_POST['birthday'])&&isset($_POST['gender'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $auth_type =mysqli_real_escape_string($conn, $_POST['auth-type']);
    $auth_code = mysqli_real_escape_string($conn, $_POST['auth-code']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
}else{
    echo 0;
    exit();
}

if($fname==''||$lname==''){
    echo -11;
    exit();
}

if (empty($birthday)) {
    echo -12;
    exit();
} else {
    $birthdayDate = date_create($birthday);

    if ($birthdayDate === false) {
        echo -13;
        exit();
    } else {
        $currentDate = date_create();
        if ($birthdayDate > $currentDate) {
            echo -14;
            exit();
        }
    }
}

if($gender===''||($gender!='Male'&&$gender!='Female'&&$gender!='Other')){
    echo -17;
    exit();
}

if($auth_type!='Admin'&&$auth_type!='Participant'){
    echo -1;
    exit();
}
$auth_lookup = mysqli_query($conn, "SELECT * FROM fnirs_auth WHERE (auth = '{$auth_code}' AND type = '{$auth_type}' AND status = 1)");
if($auth_lookup){
    if(mysqli_num_rows($auth_lookup) <= 0){
        echo -1;
        exit();
    }
}else{
    echo -5;
    exit();
}

if (strlen($username) < 4 || strlen($username) > 20) {
    echo -2;
    exit();
}

elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    echo -3;
    exit();
}
else{
    $username_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user WHERE username = '{$username}' ORDER BY id DESC LIMIT 1");
    if($username_lookup){
        if(mysqli_num_rows($username_lookup) > 0){
            echo -6;
            exit();
        }
    }else{
        echo -4;
    }
}

if (strlen($password) < 8 || strlen($password) > 20) {
    echo -7;
}
elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&!*_])[A-Za-z\d@#$%^&!*_]+$/', $password)) {
    echo -8;
}
elseif (in_array(strtolower($password), ["password", "123456", "qwerty"])) {
    echo -9;
}
elseif ($password == $username) {
    echo -10;
}
else{
    $password_enc = md5($password);
    $user_activate = mysqli_query($conn, "INSERT INTO fnirs_user (fname, lname, username, password, type, identifier, birthday, gender) VALUES ('{$fname}', '{$lname}', '{$username}', '{$password_enc}', '{$auth_type}', '{$auth_code}', '{$birthday}', '{$gender}')");
    if($user_activate){
        $auth_code_deactivate = mysqli_query($conn, "UPDATE fnirs_auth SET status = 0, act_time = (NOW()) WHERE auth = '{$auth_code}' ORDER BY id DESC LIMIT 1");
        if($auth_code_deactivate){
            echo 1;
            exit();
        }else{
            echo -16;
            exit();
        }
    }else{
        echo -15;
        exit();
    }
}