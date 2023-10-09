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
//include_once 'C:\Users\Administrator\Desktop\sunrays\web\php\rate_limit.php';
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\mal_ip_record.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    echo -1;
    exit();
} else{
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

$user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
if($user_admin_lookup) {
    if (mysqli_num_rows($user_admin_lookup) > 0) {
        while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
            if ($row_admin_user['type'] !== 'Admin' || $row_admin_user['ban'] == 1) {
                echo -4;
                exit();
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

$result = [];
$all_auth_lookup = mysqli_query($conn, "SELECT * FROM fnirs_auth WHERE (status = 1) ORDER BY id ASC");
if($all_auth_lookup){
    if (mysqli_num_rows($all_auth_lookup) > 0) {
        while ($row_auth = mysqli_fetch_assoc($all_auth_lookup)) {
            array_push($result, array("auth" => $row_auth['auth'], "type" => $row_auth['type'], "gen_by" => $row_auth['gen_by'], "gen_time" => $row_auth['gen_time']));
        }
        echo json_encode($result);
        exit();
    }else{
        echo -6;
        exit();
    }
}else{
    echo -5;
    exit();
}