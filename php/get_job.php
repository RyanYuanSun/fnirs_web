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
            if($row_admin_user['ban']==1){
                echo -4;
                exit();
            }
        }
    }else{
        echo -3;
        exit();
    }
}else{
    echo -2;
    exit();
}

$result = [];
$job_lookup = mysqli_query($conn, "SELECT * FROM fnirs_job where (participant = '{$unique_id}') ORDER BY id ASC");
if($job_lookup){
    if (mysqli_num_rows($job_lookup) > 0) {
        while ($row_job = mysqli_fetch_assoc($job_lookup)) {
            $by_name  = 'Unknown';
            $operator_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$row_job['operator']}') ORDER BY id ASC LIMIT 1");
            if($operator_lookup){
                if(mysqli_num_rows($operator_lookup)>0){
                    while($row_operator = mysqli_fetch_assoc($operator_lookup)){
                        $by_name = $row_operator['fname']." ".$row_operator['lname'];
                    }
                }
            }
            array_push($result, array("job_id" => $row_job['id'], "job_by_id" => $row_job['operator'], "job_by_name" => $by_name, "participant" => $row_job['participant'], "job_time" => $row_job['add_time'], "job_data" => $row_job['data_id'], "job_status" => $row_job['status'], "job_desc" => $row_job['desc']));
        }
        echo json_encode($result);
        exit();
    }else{
        echo json_encode($result);
        exit();
    }
}else{
    echo -5;
    exit();
}