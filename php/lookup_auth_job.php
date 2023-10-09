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

if (!isset($_POST['job_id'])) {
    echo -2;
    exit();
} else {
    $job_id = intval($_POST['job_id']);
}

$user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user WHERE identifier = '{$unique_id}' AND ban = 0 ORDER BY id ASC LIMIT 1");

if ($user_admin_lookup) {
    if (mysqli_num_rows($user_admin_lookup) > 0) {
        $job_lookup = mysqli_query($conn, "SELECT * FROM fnirs_job WHERE (id = {$job_id} AND status = 1 AND participant = '{$unique_id}') ORDER BY id ASC LIMIT 1");

        if ($job_lookup) {
            if (mysqli_num_rows($job_lookup) > 0) {
                while($row_job = mysqli_fetch_assoc($job_lookup)){
                    if($row_job['auth_state']==="2"){
                        echo json_encode([["success" => 1]]);
                        exit();
                    }elseif($row_job['auth_state']==="3"){
                        echo json_encode([["success" => 0]]);
                        exit();
                    }else{
                        echo -6;
                        exit();
                    }
                }
            } else {
                echo -4;
                exit();
            }
        } else {
            echo -5;
            exit();
        }
    }
}
