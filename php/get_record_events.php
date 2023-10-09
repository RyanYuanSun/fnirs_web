<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.sunrays.top") {
        header("Access-Control-Allow-Origin: $http_origin");
        header('Access-Control-Allow-Methods: POST');
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
} else {
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

if(isset($_POST['job_id'])){
    $jobId = intval($_POST['job_id']);
}else{
    echo -2;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT participant FROM fnirs_job WHERE id = ?");
    $stmt->bind_param("i", $jobId);

    if ($stmt->execute()) {
        $stmt->bind_result($participant);
        $stmt->fetch();
        $stmt->close();

        if ($participant === $unique_id) {
            $stmt = $conn->prepare("SELECT data FROM fnirs_web_record WHERE job_id = ?");
            $stmt->bind_param("i", $jobId); // "i" indicates that $jobId is an integer
            if ($stmt->execute()) {
                $stmt->bind_result($eventsData);
                $stmt->fetch();
                $stmt->close();
                echo $eventsData;
                exit();
            } else {
                echo -8;
                exit();
            }
        } else {
            $stmt = $conn->prepare("SELECT identifier, ban, type FROM fnirs_user WHERE identifier = ?");
            $stmt->bind_param("s", $unique_id); // Assuming 'identifier' is a string

            if ($stmt->execute()) {
                $stmt->bind_result($userIdentifier, $ban, $userType);
                $stmt->fetch();
                $stmt->close();

                if ($ban == 1) {
                    echo -7;
                    exit();
                } elseif ($userType === "Admin") {
                    $stmt = $conn->prepare("SELECT data FROM fnirs_web_record WHERE job_id = ?");
                    $stmt->bind_param("i", $jobId); // "i" indicates that $jobId is an integer
                    if ($stmt->execute()) {
                        $stmt->bind_result($eventsData);
                        $stmt->fetch();
                        $stmt->close();
                        echo $eventsData;
                        exit();
                    } else {
                        echo -9;
                        exit();
                    }
                } else {
                    echo -6;
                    exit();
                }
            } else {
                echo -4;
                exit();
            }
        }
    } else {
        echo -5;
        exit();
    }
    $conn->close();
} else {
    echo -3;
    exit();
}
?>