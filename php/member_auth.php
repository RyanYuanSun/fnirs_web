<?php
  include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
  if(isset($_SESSION['fnirs_unique_id'])){
    echo 3;
    exit();
  }
  if (isset($_SERVER['HTTP_ORIGIN'])){
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if ($http_origin == "https://www.sunrays.top")
    {
      header("Access-Control-Allow-Origin: $http_origin");
      header('Access-Control-Allow-Methods:POST');
    }
  } else{
    echo "Unauthorized request.";
    exit();
  }
  
  if (isset($_POST['usr_id'])&&isset($_POST['usr_key'])){
    $url = 'https://lightlancer.sunrays.top/php/id_auth_project.php';
    $data = array(
      'usr_id' => $_POST['usr_id'],
      'usr_key' => $_POST['usr_key']
    );
    
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
      )
    );
    
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
      echo "3";
      exit();
    }
    else{
      $resultObj = json_decode($result, true);
      if ($resultObj['auth_res'] === 2){
        $_SESSION['fnirs_unique_id'] = $resultObj['unique_id'];
        echo "success";
        exit();
      }else{
        echo $resultObj['auth_res'];
        exit();
      }
    }
  }else{
    echo "Request denied.";
    exit();
  }
