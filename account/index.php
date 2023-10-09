<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    header('Location:/business/fnirs2023/account/login?redurl=' . $_SERVER['REQUEST_URI']);
    exit();
} else {
    include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);

    $user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
    if ($user_admin_lookup) {
        if (mysqli_num_rows($user_admin_lookup) > 0) {
            while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
                if ($row_admin_user['ban'] == 1) {
                    header("HTTP/1.1 403 Forbidden");
                    exit();
                } else {
                    $user_name = $row_admin_user['fname'] . " " . $row_admin_user['lname'];
                    $user_type = $row_admin_user['type'];
                    $user_username = $row_admin_user['username'];
                    $user_gender = $row_admin_user['gender'];
                    $user_id = $row_admin_user['identifier'];
                    $user_birthday = $row_admin_user['birthday'];
                    if ($user_type === "Admin") {
                        $side_admin_btn_html = '<button class="black-banner-link-hover" onclick="highlight_btn(this)">Admin Action</button>';
                        $admin_panel_html = '<div class="panel" id="admin-action-panel" style="display: none;">
                            <h2 class="underline">Admin Action</h2>
                            <div style="margin-bottom: 15px;">
                                <a href="https://www.sunrays.top/business/fnirs2023/manage"><div class="black-banner-link-hover">Admin Panel</div></a>
                            </div>
                        </div>';
                    } else {
                        $side_admin_btn_html = '';
                        $admin_panel_html = '';
                    }
                }
            }
        } else {
            header("HTTP/1.1 403 Forbidden");
            exit();
        }
    } else {
        header("HTTP/1.1 403 Forbidden");
        exit();
    }

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
            <a href="/business/fnirs2023/account">
                <div class="black-banner-link-hover" style="border: none; max-height: 80px;">
                    <div style="font-size: var(--font-size-large); font-weight: 600;">' . $user_name . '</div>
                    <div>' . $user_type . '</div>
                </div>
            </a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>Account - Sunrays Kingdom</title>
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
                <button class="black-banner-link-hover active" onclick="highlight_btn(this)">Basic Action</button>
                <?php echo $side_admin_btn_html; ?>
                <button class="black-banner-link-hover" onclick="highlight_btn(this)">Assignment</button>
                <button class="black-banner-link-hover" onclick="javascript:window.location.href = '/business/fnirs2023/analysis';">Analysis</button>
                <script>
                    function deselect_other_side_button(intext) {
                        let all_buttons = document.getElementById("sidebar-buttons").getElementsByTagName("button");
                        for (let i = 0; i < all_buttons.length; i++) {
                            if (all_buttons[i].innerText !== intext) {
                                if (all_buttons[i].classList.contains("active")) {
                                    all_buttons[i].classList.remove("active");
                                }
                            }
                        }
                    }

                    function switch_panel(intext) {
                        let panelID = "";
                        for (let i = 0; i < intext.toLowerCase().split(" ").length; i++) {
                            panelID += intext.toLowerCase().split(" ")[i] + "-"
                        }
                        panelID += "panel";
                        document.getElementById(panelID).style.display = "block";
                        let all_panels = document.getElementsByClassName("panel");
                        for (let i = 0; i < all_panels.length; i++) {
                            if (all_panels[i].id !== panelID) {
                                all_panels[i].style.display = "none";
                            }
                        }
                    }

                    function highlight_btn(obj) {
                        if (!obj.classList.contains("active")) {
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
                    Analysis</h1>
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
                        <div class="panel" id="basic-action-panel">
                            <h2 class="underline">Basic Action</h2>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Profile</h4>
                            <table>
                                <tr>
                                    <td><i>Name</i></td>
                                    <td><?php echo $user_name; ?></td>
                                </tr>
                                <tr>
                                    <td><i>Username</i></td>
                                    <td><?php echo $user_username; ?></td>
                                </tr>
                                <tr>
                                    <td><i>Gender</i></td>
                                    <td><?php echo $user_gender; ?></td>
                                </tr>
                                <tr>
                                    <td><i>ID</i></td>
                                    <td><?php echo $user_id; ?></td>
                                </tr>
                                <tr>
                                    <td><i>Type</i></td>
                                    <td><?php echo $user_type; ?></td>
                                </tr>
                                <tr>
                                    <td><i>Birthday</i></td>
                                    <td><?php echo $user_birthday; ?></td>
                                </tr>
                            </table>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Change
                                Password</h4>
                            <div id="change-pass-error-msg" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                            <input id="old_password" type="password" autocomplete="off" placeholder="Old password"
                                   style="margin-bottom: 5px;">
                            <input id="new_password" type="password" autocomplete="off" placeholder="New password"
                                   style="margin-bottom: 5px;">
                            <input id="new_password_con" type="password" autocomplete="off"
                                   placeholder="Retype new password" style="margin-bottom: 5px;">
                            <button class="black-banner-link-hover" onclick="change_pass(event, this)">Confirm</button>
                            <script>
                                function change_pass(event, obj) {
                                    obj.innerText = "Processing...";
                                    obj.style.pointerEvents = "none";
                                    event.preventDefault();
                                    let error_div = document.getElementById("change-pass-error-msg");
                                    error_div.style.display = "none";
                                    error_div.innerText = '';
                                    let old_pass = document.getElementById("old_password").value;
                                    let new_pass = document.getElementById("new_password").value;
                                    let con_pass = document.getElementById("new_password_con").value;
                                    if (old_pass !== '' && new_pass !== '' && con_pass !== '') {
                                        if (old_pass === new_pass) {
                                            error_div.innerText = "New password must be different from the old one."
                                            error_div.style.display = "block";
                                        } else {
                                            if (new_pass !== con_pass) {
                                                error_div.innerText = "The two entered passwords do not match."
                                                error_div.style.display = "block";
                                            } else {
                                                let xhr = new XMLHttpRequest();
                                                xhr.open("POST", "/business/fnirs2023/php/change_pass.php", true);
                                                xhr.onload = () => {
                                                    let errorMsg = "";
                                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                                        if (xhr.status === 200) {
                                                            let data = xhr.response;
                                                            if (data === "1") {
                                                                window.location.reload();
                                                            }else{
                                                                errorMsg = "Something went wrong."
                                                                if(data === "-4"){
                                                                    errorMsg = "Invalid old password."
                                                                }
                                                                if(data === "-7")
                                                                {
                                                                    errorMsg = "Password length must be between 8 and 20 characters.";
                                                                }
                                                                if(data === "-8")
                                                                {
                                                                    errorMsg = "Password must contain uppercase letters, lowercase letters, numbers, and special characters.";
                                                                }
                                                                if(data === "-9")
                                                                {
                                                                    errorMsg = "Please avoid using common passwords.";
                                                                }
                                                                if(data === "-10")
                                                                {
                                                                    errorMsg = "Password cannot be the same as the username.";
                                                                }
                                                                if(data === "-11")
                                                                {
                                                                    errorMsg = "New password must be different from the old one.";
                                                                }
                                                            }
                                                        }else{
                                                            errorMsg = "Something went wrong.";
                                                        }
                                                        if(errorMsg !== ""){
                                                            error_div.innerText = errorMsg;
                                                            error_div.style.display = "block";
                                                            obj.innerText = "Confirm";
                                                            obj.style.pointerEvents = "all";
                                                        }
                                                    }
                                                }
                                                let formData = new FormData();
                                                formData.append("old_pass", old_pass);
                                                formData.append("new_pass", new_pass);
                                                xhr.send(formData);
                                            }
                                        }
                                    } else {
                                        error_div.innerText = "Please fill in all fields."
                                        error_div.style.display = "block";
                                        obj.innerText = "Confirm";
                                        obj.style.pointerEvents = "all";
                                    }
                                }
                            </script>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Logout</h4>
                            <div style="margin-bottom: 15px;">
                                <a href="https://www.sunrays.top/business/fnirs2023/account/logout">
                                    <div class="black-banner-link-hover">Logout</div>
                                </a>
                            </div>
                        </div>
                        <?php echo $admin_panel_html; ?>
                        <div class="panel" id="assignment-panel" style="display: none;">
                            <h2 class="underline">Assignment</h2>
                            <div style="margin-bottom: 15px;">
                                <a href="https://www.sunrays.top/business/fnirs2023/account/job">
                                    <div class="black-banner-link-hover">View Assignment</div>
                                </a>
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
</body>
</html>