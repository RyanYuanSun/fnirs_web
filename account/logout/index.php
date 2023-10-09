<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    header('Location:/business/fnirs2023/account/');
    exit();
}else {
    unset($_SESSION['fnirs_unique_id']);
    header('Location:/business/fnirs2023/account/');
}