<?php
  include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
  include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";
  //include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\agent_check.php";

if(!isset($_SESSION['fnirs_unique_id'])){
    $user_banner_html = '<style>
                .title-banner-sidebar{
                    display: block;
                    padding: 0;
                    margin: 0;
                }

                .fix-sidebar .black-banner-link-hover{
                    box-shadow: none;
                    border: 2px solid transparent;
                }

                .fix-sidebar .black-banner-link-hover:hover{
                    border: 2px solid transparent;
                }

                .fix-sidebar .black-banner-link-hover.active{
                    background: var(--color-1);
                    color: var(--color-2);
                    text-shadow: 0 0 1.2px var(--color-2);
                    width: 100%;
                    cursor: auto;
                    border-top: 2px solid var(--color-2);
                    border-bottom: 2px solid var(--color-2);
                }
            </style>
            <a href="/business/fnirs2023/account/login?redurl=/business/fnirs2023">
                <div class="black-banner-link-hover" style="border: none; max-height: 80px;">
                    <div style="font-size: var(--font-size-large); font-weight: 600;">Login</div>
                    <div>You are not logged in</div>
                </div>
            </a>';
}else{
    header("Location:/business/fnirs2023/account");
    exit();
}

  if(isset($_GET['redurl'])&&$_GET['redurl']!=''){
    $redurl = $_GET['redurl'];
  }else{
    $redurl = '/business/fnirs2023/account';
  }
  if (isset($_GET['auth_type']) && $_GET['auth_type'] != '') {
    $auth_type = $_GET['auth_type'];
    if ($auth_type === 'Admin') {
      $auth_type_admin = 'selected';
      $auth_type_part = '';
    } elseif ($auth_type === 'Participant') {
      $auth_type_admin = '';
      $auth_type_part = 'selected';
    } else {
      $auth_type_admin = '';
      $auth_type_part = '';
    }
  } else {
    $auth_type = '';
  $auth_type_admin = '';
  $auth_type_part = '';
  }
  if (isset($_GET['auth_code']) && $_GET['auth_code'] != '') {
    $auth_code = $_GET['auth_code'];
  } else {
    $auth_code = '';
  }
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>Account Activation - Sunrays Kingdom</title>
    <meta name="description" content="The official website of Sunrays Kingdom. Glory to the King in the highest.">
    <meta name="keywords" content="Sun, Sunrays, Kingdom, Sunrays Kingdom">
    <link rel="shortcut icon" href="/img/coa-200.png">
    <meta name="author" content="Ryan Alloriadonis">
    <meta property="og:url" content="https://www.sunrays.top/">
    <meta property="og:site_name" content="Sunrays Kingdom">
    <meta property="og:title" content="Sunrays Kingdom">
    <meta property="og:description"
          content="The official website of Sunrays Kingdom. Glory to the King in the highest.">
    <meta property="og:title" content="Sunrays Kingdom">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/img/coa-200.png">
    <meta property="og:image:width" content="50">
    <meta property="og:image:height" content="50">
    <meta name="theme-color" content="#cbc4bb">
    <link rel="stylesheet" href="/stylesheet/lds_ring_mini.css">
    <link rel="stylesheet" href="/stylesheet/lds_ring_extra_mini.css">
    <link href="/stylesheet/universal.css" rel="stylesheet">
    <link rel="stylesheet" href="/stylesheet/post.css">
    <link rel="stylesheet" href="/fonts/linux_libertine.css">
    <script>
        function loaded() {
            document.getElementById("main_page").style.display = "block";
            document.getElementById("loading_div").classList.add("loaded");
        }
    </script>
</head>
<body onload="loaded()">
<?php include_once "C:\Users\Administrator\Desktop\sunrays\web\com/fullpage-loader.php" ?>
<div class="overall-warpper">
    <div class="fix-sidebar">
        <div class="title-banner-sidebar">
            <?php echo $user_banner_html; ?>
        </div>
        <div id="sidebar-buttons" class="content-sidebar">
            <div style="min-height: calc(100vh - 80px)">
                <button class="black-banner-link-hover active" onclick="highlight_btn(this)">Account Activation</button>
                <script>
                    function deselect_other_side_button(intext){
                        let all_buttons = document.getElementById("sidebar-buttons").getElementsByTagName("button");
                        for(let i = 0; i < all_buttons.length; i++){
                            if(all_buttons[i].innerText !== intext){
                                if(all_buttons[i].classList.contains("active")){
                                    all_buttons[i].classList.remove("active");
                                }
                            }
                        }
                    }

                    function switch_panel(intext){
                        let panelID = "";
                        for(let i=0;i<intext.toLowerCase().split(" ").length;i++){
                            panelID += intext.toLowerCase().split(" ")[i]+"-"
                        }
                        panelID += "panel";
                        document.getElementById(panelID).style.display = "block";
                        let all_panels = document.getElementsByClassName("panel");
                        for(let i =0; i<all_panels.length;i++){
                            if(all_panels[i].id !== panelID){
                                all_panels[i].style.display = "none";
                            }
                        }
                    }

                    function highlight_btn(obj){
                        if(!obj.classList.contains("active")){
                            obj.classList.add("active");
                        }
                        deselect_other_side_button(obj.innerText);
                        switch_panel(obj.innerText);
                    }
                </script>
            </div>
            <footer style="display: none">
                <div class="footer-copyright">
                    <div style="padding-right: 10px; overflow: hidden;">
                      <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\copyright-notice.php" ?>
                      <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cc-notice.php" ?>
                      <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\server_footer.php" ?>
                    </div>
                  <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cn-reg.php" ?>
                </div>
            </footer>
        </div>
    </div>
  <?php include_once "C:\Users\Administrator\Desktop\sunrays\web\com\inset-shadow-layer.php" ?>
    <div class="main-page" id="main_page" style="display: none;">
        <div class="title-banner">
            <div style="line-height: 1;">
                <h1 style="font-family: 'Arial Black', sans-serif, Arial, Helvetica; font-size: var(--font-size-extra-extra-large); font-weight: 900; text-transform: uppercase; letter-spacing: -1px;">
                    Account Activation</h1>
            </div>
        </div>
        <header id="header" class="header loading">
            <div class="banner-top loading" id="banner-top">
                <div class="index">
                    <div class="iconspan"></div>
                    <div class="iconspanmiddle"></div>
                    <div class="iconspan"></div>
                    <div class="iconspanhide"></div>
                </div>
                <div class="index-menu">

                </div>
            </div>
        </header>
        <main id="main">
            <article class="post-wrapper">
                <div class="post-date" style="display: none;">
                </div>
                <div class="post-main-content">
                    <div class="post-main-content-chunk">
                        <div class="panel" id="account-activation-panel">
                            <h2 class="underline">Account Activation</h2>
                            <div id="activate-form-error-msg" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                            <form id="account-activation-form">
                                <table style="margin-bottom: 15px;">
                                    <tr>
                                        <td><label for="auth-code">Authorization Code</label></td>
                                        <td><input type="text" id="auth-code" value="<?php echo $auth_code; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="auth-type">Account Type</label></td>
                                        <td>
                                            <select id="auth-type">
                                                <option <?php echo $auth_type_admin; ?>>Admin</option>
                                                <option <?php echo $auth_type_part; ?>>Participant</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="fname">First Name</label></td>
                                        <td><input type="text" id="fname" placeholder="First Name"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="lname">Last Name</label></td>
                                        <td><input type="text" id="lname" placeholder="Last Name"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="birthday">Date of Birth</label></td>
                                        <td><input type="date" id="birthday" placeholder="Date of Birth"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="gender">Gender</label></td>
                                        <td>
                                            <select id="gender">
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="username">Set Username</label></td>
                                        <td><input type="text" id="username" placeholder="Username" autocomplete="off"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="password">Set Password</label></td>
                                        <td><input type="password" id="password" placeholder="Password"
                                                   autocomplete="new-password"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="password-confirm">Confirm Password</label></td>
                                        <td><input type="password" id="password-confirm" placeholder="Confirm Password">
                                        </td>
                                    </tr>
                                </table>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);"
                                   class="underline">By proceeding with activation, I hereby express my complete agreement
                                    with the privacy policy of the fnirs project as well as the terms and privacy policy of
                                    the Sunrays Kingdom website.</p>
                                <div>
                                    <button class="black-banner-link-hover button" onclick="activate_account(event, this)"
                                            style="width: 100%">Activate
                                    </button>
                                </div>
                            </form>
                            <div id="activation-suc-div" style="display: none;">
                                <p>Your account has been activated!</p>
                                <div>
                                    <button onclick="javascript:window.location.href='../login?redurl=<?php echo $redurl;?>';" class="black-banner-link-hover button" style="width: 100%;">Login Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </main>
        <footer class="hide-mobile" style="display: none;">
            <div class="footer-copyright">
                <div style="padding-right: 10px; overflow: hidden;">
                  <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\server_footer.php" ?>
                </div>
              <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cn-reg.php" ?>
            </div>
        </footer>
    </div>
</div>
<script src="/js/menu.js"></script>
<script>
    function activate_account(event, obj) {
        event.preventDefault();
        obj.innerText = "Processing...";
        obj.style.pointerEvents = "none";
        fname = document.getElementById("fname").value;
        lname = document.getElementById("lname").value;
        birthday = document.getElementById("birthday").value;
        username = document.getElementById("username").value;
        password = document.getElementById("password").value;
        password_con = document.getElementById("password-confirm").value;
        auth_type = document.getElementById("auth-type").value;
        auth_code = document.getElementById("auth-code").value;
        gender = document.getElementById("gender").value;
        error_div = document.getElementById("activate-form-error-msg");
        error_div.style.display = "none";
        error_div.innerText = "";
        if (fname != "" && lname != "" && birthday != "" && username != "" && password != "" && password_con != "" && auth_type != "" && auth_code != "" && gender != "") {
            if (password != password_con) {
                error_div.innerText = "The two entered passwords do not match.";
                error_div.style.display = "block";
                obj.innerText = "Activate";
                obj.style.pointerEvents = "all";
            } else {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/business/fnirs2023/php/activate_account_by_auth.php", true);
                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            let data = xhr.response;
                            console.log(data);
                            if (data === "1") {
                                setTimeout(function () {
                                    document.getElementById("account-activation-form").style.display = "none";
                                    document.getElementById("activation-suc-div").style.display = "block";
                                    obj.innerText = "Activate";
                                    obj.style.pointerEvents = "all";
                                }, 1000);
                            } else {
                                let errorMsg = "";
                                if (data === "0") {
                                    errorMsg = "Something went wrong.";
                                }
                                if (data === "-1") {
                                    errorMsg = "Invalid authorization code or type.";
                                }
                                if (data === "-2") {
                                    errorMsg = "Username length must be between 4 and 20 characters.";
                                }
                                if (data === "-3") {
                                    errorMsg = "Username can only contain letters, numbers and underlines.";
                                }
                                if (data === "-4") {
                                    errorMsg = "Something went wrong.";
                                }
                                if (data === "-5") {
                                    errorMsg = "Something went wrong.";
                                }
                                if (data === "-6") {
                                    errorMsg = "Username already taken.";
                                }
                                if (data === "-7") {
                                    errorMsg = "Password length must be between 8 and 20 characters.";
                                }
                                if (data === "-8") {
                                    errorMsg = "Password must contain uppercase letters, lowercase letters, numbers, and special characters.";
                                }
                                if (data === "-9") {
                                    errorMsg = "Please avoid using common passwords.";
                                }
                                if (data === "-10") {
                                    errorMsg = "Password cannot be the same as the username.";
                                }
                                if (data === "-11") {
                                    errorMsg = "Invalid name.";
                                }
                                if (data === "-12"||data === "-13"||data === "-14") {
                                    errorMsg = "Invalid birthday.";
                                }
                                if (data === "-15"||data === "-16") {
                                    errorMsg = "Something went wrong.";
                                }
                                if (data === "-17") {
                                    errorMsg = "Invalid gender.";
                                }
                                if (data === "Try later.") {
                                    errorMsg = "Too many requests.";
                                }
                                setTimeout(function () {
                                    error_div.innerText = errorMsg;
                                    error_div.style.display = "block";
                                    obj.innerText = "Activate";
                                    obj.style.pointerEvents = "all";
                                }, 1000);
                            }
                        }
                    }
                }
                let formData = new FormData();
                formData.append("fname", fname);
                formData.append("lname", lname);
                formData.append("birthday", birthday);
                formData.append("username", username);
                formData.append("password", password);
                formData.append("auth-type", auth_type);
                formData.append("auth-code", auth_code);
                formData.append("gender", gender);
                xhr.send(formData);
            }
        } else {
            error_div.innerText = "Please fill in all fields.";
            error_div.style.display = "block";
            obj.innerText = "Activate";
            obj.style.pointerEvents = "all";
        }
    }
</script>
</body>
</html>