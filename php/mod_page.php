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

if(!isset($_POST['page_content'])){
    echo -2;
    exit();
}else{
    $htmlContent = $_POST['page_content'];
}

$saveDirectory = 'C:\Users\Administrator\Desktop\sunrays/wwwroot/business/fnirs2023/data/page/';

if (!file_exists($saveDirectory)) {
    mkdir($saveDirectory, 0777, true);
}

// Generate a unique filename for the HTML file
$filename = uniqid('html_content_') . '.html';

// Save the HTML content to the specified directory as an HTML file
$filePath = $saveDirectory . $filename;

if (file_put_contents($filePath, $htmlContent) !== false) {
    echo 'HTML content has been saved as ' . $filename;
} else {
    echo 'Error saving HTML content.';
}
