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

if(!isset($_POST['username'])){
    echo -2;
    exit();
}

try {
    $request_username = mysqli_real_escape_string($conn, $_POST['username']);
} catch (Exception $e){
    echo -3;
    exit();
}

$user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
if($user_admin_lookup){
    if (mysqli_num_rows($user_admin_lookup) > 0) {
        while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
            if($row_admin_user['type']!=='Admin'||$row_admin_user['ban']==1){
                echo -4;
                exit();
            }else{
                $result = [];
                if($row_admin_user['username']==$request_username){
                    array_push($result, array("is_self" => 1, "fname" => $row_admin_user['fname'], "lname" => $row_admin_user['lname'], "username" => $row_admin_user['username'], "unique_id" => $row_admin_user['identifier'], "gender" => $row_admin_user['gender'], "type" => $row_admin_user['type'], "ban" => $row_admin_user['ban']));
                    echo json_encode($result);
                    exit();
                }else{
                    $user_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (username = '{$request_username}') ORDER BY id ASC LIMIT 1");
                    if($user_lookup) {
                        if (mysqli_num_rows($user_lookup) > 0) {
                            while ($row_user = mysqli_fetch_assoc($user_lookup)) {
                                array_push($result, array("is_self" => 0, "fname" => $row_user['fname'], "lname" => $row_user['lname'], "username" => $row_user['username'], "unique_id" => $row_user['identifier'], "gender" => $row_user['gender'], "type" => $row_user['type'], "ban" => $row_user['ban']));
                                echo json_encode($result);
                                exit();
                            }
                        }else{
                            echo -6;
                            exit();
                        }
                    }else{
                        echo -5;
                        exit();
                    }
                }
            }
        }
    }else{
        echo -7;
        exit();
    }
}else{
    echo -8;
    exit();
}