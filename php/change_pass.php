<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.sunrays.top") {
        header("Access-Control-Allow-Origin: $http_origin");
        header('Access-Control-Allow-Methods:POST');
    }
} else {
    echo "Unauthorized request.";
    exit();
}

header("Content-Type: application/json;charset=utf-8");
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\mal_ip_record.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    echo -1;
    exit();
} else {
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

if (!isset($_POST['old_pass'])||!isset($_POST['new_pass'])) {
    echo -2;
    exit();
} else {
    $old_pass = mysqli_real_escape_string($conn, $_POST['old_pass']);
    $old_pass_enc = md5($old_pass);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    if($old_pass === $new_pass){
        echo -11;
        exit();
    }
    elseif (strlen($new_pass) < 8 || strlen($new_pass) > 20) {
        echo -7;
        exit();
    }
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&!*_])[A-Za-z\d@#$%^&!*_]+$/', $new_pass)) {
        echo -8;
        exit();
    }
    elseif (in_array(strtolower($new_pass), ["password", "123456", "qwerty"])) {
        echo -9;
        exit();
    }
}


    $user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user WHERE identifier = '{$unique_id}' AND ban = 0 ORDER BY id ASC LIMIT 1");
    if ($user_admin_lookup) {
        if (mysqli_num_rows($user_admin_lookup) > 0) {
            while($row_user = mysqli_fetch_assoc($user_admin_lookup)){
                if($old_pass_enc!==$row_user['password']){
                    echo -4;
                    exit();
                }else{
                    if ($new_pass == $row_user['username']) {
                        echo -10;
                        exit();
                    }
                    else {
                        $password_enc = md5($new_pass);
                        $password_update = mysqli_query($conn, "UPDATE fnirs_user SET password = '{$password_enc}' WHERE (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
                        if($password_update){
                            unset($_SESSION['fnirs_unique_id']);
                            echo 1;
                            exit();
                        }else{
                            echo -12;
                            exit();
                        }
                    }
                }
            }
        }else{
            echo -6;
            exit();
        }
    }else{
        echo -5;
        exit();
    }
