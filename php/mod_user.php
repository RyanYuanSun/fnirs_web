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
include_once 'C:\Users\Administrator\Desktop\sunrays\web\php\rate_limit.php';
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\mal_ip_record.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    echo -1;
    exit();
} else{
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

if(!isset($_POST['action'])){
    echo -6;
    exit();
}else{
    $action = mysqli_real_escape_string($conn, $_POST['action']);
}

if(!isset($_POST['target_id'])){
    echo -7;
    exit();
}else{
    $target_id = mysqli_real_escape_string($conn, $_POST['target_id']);
}

$user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
if($user_admin_lookup) {
    if (mysqli_num_rows($user_admin_lookup) > 0) {
        while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
            if ($row_admin_user['type'] !== 'Admin' || $row_admin_user['ban'] == 1) {
                echo -4;
                exit();
            }elseif ($row_admin_user['identifier'] == $target_id){
                echo -8;
                exit();
            }else{
                $target_id_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1");
                if($target_id_lookup){
                    if (mysqli_num_rows($target_id_lookup) > 0) {
                        while ($row_target_user = mysqli_fetch_assoc($target_id_lookup)) {
                            $query_string = "";
                            if($action == "del"){
                                $query_string = "DELETE FROM fnirs_user WHERE (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1";
                            }elseif ($action == "ban"){
                                $query_string = "UPDATE fnirs_user SET ban = 1 WHERE (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1";
                            }elseif ($action == "de-ban"){
                                $query_string = "UPDATE fnirs_user SET ban = 0 WHERE (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1";
                            }elseif ($action == "admin"){
                                $query_string = "UPDATE fnirs_user SET type = 'Admin' WHERE (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1";
                            }elseif ($action == "de-admin"){
                                $query_string = "UPDATE fnirs_user SET type = 'Participant' WHERE (identifier = '{$target_id}') ORDER BY id ASC LIMIT 1";
                            }else{
                                echo -5;
                                exit();
                            }
                            $action_query = mysqli_query($conn, $query_string);
                            if($action_query){
                                $ip = getRealIp();
                                $ua = $_SERVER['HTTP_USER_AGENT'];
                                $record_query = mysqli_query($conn, "INSERT INTO fnirs_user_mod (identifier, operator, action, ip, ua) VALUES ('{$target_id}', '{$unique_id}', '{$action}', '{$ip}', '{$ua}')");
                                if($record_query){
                                    $result = [array("success" => 1)];
                                    echo json_encode($result);
                                    exit();
                                }else{
                                    echo -9;
                                    exit();
                                }
                            }else{
                                echo -10;
                                exit();
                            }
                        }
                    }else{
                        echo -11;
                        exit();
                    }
                }else{
                    echo -12;
                    exit();
                }
            }
        }
    }else{
        echo -2;
        exit();
    }
}else{
    echo -3;
    exit();
}