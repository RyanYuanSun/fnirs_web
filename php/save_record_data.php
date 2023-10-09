<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.sunrays.top") {
        header("Access-Control-Allow-Origin: $http_origin");
        header('Access-Control-Allow-Methods:POST');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    exit();
}

include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\mal_ip_record.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    header("HTTP/1.1 403 Forbidden");
    exit();
} else{
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $postData = json_decode($data, true);

    if (isset($postData['events']) && isset($postData['job_id']) && isset($postData['ip'])) {
        $events = $postData['events'];
        $jobId = intval($postData['job_id']);
        $ip = mysqli_real_escape_string($conn ,$postData['ip']);

        $user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
        if($user_admin_lookup) {
            if (mysqli_num_rows($user_admin_lookup) > 0) {
                while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
                    if ($row_admin_user['ban'] == 1) {
                        header("HTTP/1.1 403 Forbidden");
                        exit();
                    }else{
                        $job_lookup = mysqli_query($conn, "SELECT * FROM fnirs_job where (participant = '{$unique_id}' AND id = {$jobId} AND status = 0) ORDER BY id ASC LIMIT 1");
                        if($job_lookup) {
                            if (mysqli_num_rows($job_lookup) > 0) {
                                while($row_job = mysqli_fetch_assoc($job_lookup)){
                                    $reg_time = strtotime($row_job['complete_time']);
                                    if ((time() - $reg_time) > 3600){
                                        header("HTTP/1.1 403 Forbidden");
                                        exit();
                                    }
                                }
                            }else{
                                header("HTTP/1.1 403 Forbidden");
                                exit();
                            }
                        }else{
                            header("HTTP/1.1 403 Forbidden");
                            exit();
                        }
                    }
                }
            }else{
                header("HTTP/1.1 403 Forbidden");
                exit();
            }
        }else{
            header("HTTP/1.1 403 Forbidden");
            exit();
        }

        $postEvent = json_decode($events);
        if ($postEvent !== null) {
            $stmt = $conn->prepare("INSERT INTO fnirs_web_record (data, ua, job_id, ip) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $events, $userAgent, $jobId, $ip);

            if ($stmt->execute()) {
                echo 1;
            } else {
                echo -1;
            }
            $stmt->close();
            $conn->close();
        } else {
            echo -2;
        }
    }else{
        echo -3;
    }

} else {
    echo -4;
}
?>