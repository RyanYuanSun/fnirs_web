<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";
//include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\agent_check.php";
if(!isset($_SESSION['fnirs_unique_id'])){
    header('Location:/business/fnirs2023/account/login?redurl='.$_SERVER['REQUEST_URI']);
    exit();
}else{
    include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);

    $user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
    if ($user_admin_lookup) {
        if (mysqli_num_rows($user_admin_lookup) > 0) {
            while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
                if ($row_admin_user['ban'] == 1 || $row_admin_user['type'] !== "Admin") {
                    header("HTTP/1.1 403 Forbidden");
                    exit();
                }else{
                    $user_name = $row_admin_user['fname']." ".$row_admin_user['lname'];
                    $user_type = $row_admin_user['type'];
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
                    <div style="font-size: var(--font-size-large); font-weight: 600;">'. $user_name .'</div>
                    <div>'. $user_type .'</div>
                </div>
            </a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>Admin Panel - Sunrays Kingdom</title>
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
<?php include_once "C:\Users\Administrator\Desktop\sunrays\web\com/fullpage-loader.php"?>
<div class="overall-warpper">
    <div class="fix-sidebar">
        <div class="title-banner-sidebar">
            <?php echo $user_banner_html; ?>
        </div>
        <div class="content-sidebar">
            <div id="sidebar-buttons" style="min-height: calc(100vh - 80px);">
                <button class="black-banner-link-hover active" onclick="highlight_btn(this)">User Management</button>
                <button class="black-banner-link-hover" onclick="highlight_btn(this)">Data Management</button>
                <button class="black-banner-link-hover" onclick="highlight_btn(this)">Pipeline Management</button>
                <button class="black-banner-link-hover" onclick="highlight_btn(this)">Session Management</button>
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
                        <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\copyright-notice.php"?>
                        <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cc-notice.php"?>
                        <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\server_footer.php"?>
                    </div>
                    <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cn-reg.php"?>
                </div>
            </footer>
        </div>
    </div>
    <?php include_once "C:\Users\Administrator\Desktop\sunrays\web\com\inset-shadow-layer.php"?>
    <div class="main-page" id="main_page" style="display: none;">
        <div class="title-banner">
            <div style="line-height: 1;">
                <h1 style="font-family: 'Arial Black', sans-serif, Arial, Helvetica; font-size: var(--font-size-extra-extra-large); font-weight: 900; text-transform: uppercase; letter-spacing: -1px;">Admin Panel</h1>
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
                        <div class="panel" id="user-management-panel">
                            <h2 class="underline">User Management</h2>
                            <div style="margin-bottom: 30px;">
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">User List</h4>
                                <table id="user-list">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Username</b></td>
                                        <td><b>Type</b></td>
                                    </tr>
                                </table>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">User Operations</h4>
                                <input type="text" placeholder="Search user by username" id="user-search-input">
                                <div class="black-banner-div" style="display: none" id="user-search-result-div">
                                    <div style="display: none;" id="user-search-result-none-div">
                                        <p style="color: var(--color-5); text-shadow: none; margin: 0">No match found.</p>
                                    </div>
                                    <div style="display: none;" id="user-search-result-true-div">
                                        <input type="hidden" id="user-search-result-username">
                                        <input type="hidden" id="user-search-result-is-self">
                                        <input type="hidden" id="user-search-result-is-ban">
                                        <h2 style="color: var(--color-1); text-shadow:none;" class="no-bot-margin" id="user-search-result-name"></h2>
                                        <p style="color: var(--color-5); text-shadow: none; margin: 0"><b>Unique ID</b>: <span id="user-search-result-unique-id"></span></p>
                                        <p style="color: var(--color-5); text-shadow: none; margin: 0"><b>Gender</b>: <span id="user-search-result-gender"></span></p>
                                        <p style="color: var(--color-5); text-shadow: none; margin: 0"><b>Account Type</b>: <span id="user-search-result-type"></span></p>
                                        <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin-top: 15px;">
                                            <div id="del-user-btn" style="margin-right: 10px; margin-bottom: 10px;" class="light-btn-1" onclick="mod_user('del')">
                                                Delete User
                                            </div>
                                            <div id="ban-user-btn" style="margin-right: 10px; margin-bottom: 10px;" class="light-btn-1">
                                                Ban User
                                            </div>
                                            <div id="switch-type-btn" style="margin-right: 10px; margin-bottom: 10px;" class="light-btn-1">
                                                Switch Account Type
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Add User</h4>
                            <table id="auth-list" style="margin-bottom: 10px;">
                                <tr>
                                    <td><b>Auth Code</b></td>
                                    <td><b>Type</b></td>
                                </tr>
                            </table>
                            <div style="margin-bottom: 10px;">
                                <select id="gen_auth_type">
                                    <option>Admin</option>
                                    <option>Participant</option>
                                </select>
                                <div onclick="gen_auth()" class="black-banner-link-hover">Generate Code</div>
                            </div>
                        </div>
                        <div class="panel" id="data-management-panel" style="display: none;">
                            <h2 class="underline">Data Management</h2>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">File Upload</h4>
                            <input type="file" name="fileToUpload" id="fileToUpload" style="margin-bottom: 5px;">
                            <input id="file_desc" type="text" placeholder="Description" style="margin-bottom: 5px;">
                            <select id="file_type" style="margin-bottom: 5px; margin-top: 0;" data-placeholder="File Type">
                                <option>Audio</option>
                                <option>Image</option>
                                <option>Record</option>
                            </select>
                            <button class="black-banner-link-hover" type="submit" name="submit">Upload File</button>
                            <h4 class="no-bot-margin" style="padding-left: 5px; margin-top: 50px; padding-bottom: 5px;">File Explorer</h4>
                            <h5 class="no-bot-margin no-top-margin" style="padding-left: 5px; padding-bottom: 5px; margin-top: 5px;">Overview</h5>
                            <table>
                                <tr>
                                    <td><b>Type</b></td>
                                    <td><b>Quantity</b></td>
                                </tr>
                                <tr>
                                    <td>Audio</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>Record</td>
                                    <td>2</td>
                                </tr>
                            </table>
                            <h5 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Audio</h5>
                            <table>
                                <tr>
                                    <td><b>File Name</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                                <tr>
                                    <td>audio-check-beep.mp3</td>
                                    <td>Beep sound for audio check</td>
                                </tr>
                                <tr>
                                    <td>zhong1.mp3</td>
                                    <td>Tone: Zhong1</td>
                                </tr>
                            </table>
                            <h5 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Image</h5>
                            <table>
                                <tr>
                                    <td><b>File Name</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                                <tr>
                                    <td>pear_image_1</td>
                                    <td>Pear: li2</td>
                                </tr>
                                <tr>
                                    <td>clock_img_1.jpg</td>
                                    <td>Clock: zhong1</td>
                                </tr>
                            </table>
                            <h5 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Record</h5>
                            <table>
                                <tr>
                                    <td><b>Participant</b></td>
                                    <td><b>Job ID</b></td>
                                    <td><b>Date</b></td>
                                </tr>
                                <tr>
                                    <td>Tai Yuan</td>
                                    <td>2</td>
                                    <td>15 Sep, 2023</td>
                                </tr>
                            </table>
                        </div>
                        <div class="panel" id="pipeline-management-panel" style="display: none;">
                            <style>
                                .data-pipe-design-preview-wrapper{
                                    display: flex;
                                    flex-wrap: wrap;
                                    flex-direction: column;
                                }

                                .data-pipe-design-preview-wrapper button{
                                    margin-right: 20px;
                                    border-bottom: 2px dashed var(--color-5);
                                    display: flex;
                                    flex-direction: row;
                                    flex-wrap: wrap;
                                    align-content: space-between;
                                }

                                .data-pipe-design-preview-wrapper button img{
                                    max-height: 105px;
                                    width: auto;
                                    height: 100%;
                                    margin-right: 20px;
                                }

                                .data-pipe-design-preview-wrapper button.edit{
                                    background: var(--color-1);
                                    color: var(--color-2);
                                    width: 100%;
                                    border: 2px solid var(--color-2);
                                    cursor: auto;
                                    margin-bottom: 10px;
                                }

                                .data-pipe-design-preview-wrapper button.edit img{
                                    max-width: 100%;
                                    width: 100%;
                                    height: auto;
                                    max-height: 100%;
                                }

                                .data-pipe-design-preview-wrapper button input, select, textarea{
                                    width: 100%;
                                    margin-bottom: 10px;
                                    margin-top: 5px;
                                }

                                .data-pipe-design-preview-wrapper button label{
                                    text-shadow: none;
                                }

                                .data-pipe-design-preview-wrapper .action-box{
                                    display: flex;
                                    flex-direction: row;
                                    flex-wrap: wrap;
                                    margin-top: 20px;
                                    border-top: 1px dashed var(--color-5);
                                }

                                .action-box .black-banner-link-hover{
                                    margin-right: 10px;
                                    margin-top: 10px;
                                    flex: 1;
                                    text-align: center;
                                }
                            </style>
                            <div class="data-pipe-design-preview-wrapper">
                                <button class="black-banner-link-hover" style="width: fit-content;" onclick="edit_scene(this)">
                                    <input type="hidden" value="1">
                                    <img src="/business/fnirs2023/data/img/pear_img_1.jpeg">
                                    <div id="edit-box-1" style="display: none; margin-top: 10px;">
                                        <label for="edit-box-1-page-type">Page Type</label>
                                        <select id="edit-box-1-page-type">
                                            <option value="1">Fixation</option>
                                            <option value="2">Blank</option>
                                            <option value="3">Prime</option>
                                            <option value="4">Target Picture</option>
                                        </select>
                                        <label for="edit-box-1-prime-character">Prime Word</label>
                                        <input id="edit-box-1-prime-character" type="text" value="厘">
                                        <label for="edit-box-1-prime-audio">Prime Audio</label>
                                        <input id="edit-box-1-prime-audio" type="text" value="li2-1.mp3">
                                        <label for="edit-box-1-target-img">Target Picture</label>
                                        <input id="edit-box-1-target-img" type="text" value="pear_img_1.jpeg">
                                        <label for="edit-box-1-duration">Duration</label>
                                        <input id="edit-box-1-duration" type="number" value="500">
                                        <div class="action-box">
                                            <div class="black-banner-link-hover">
                                                Save
                                            </div>
                                            <div class="black-banner-link-hover">
                                                Preview
                                            </div>
                                            <div class="black-banner-link-hover">
                                                Cancel
                                            </div>
                                            <div class="black-banner-link-hover">
                                                Delete
                                            </div>
                                        </div>
                                    </div>
                                    <div id="data-display-box-1">
                                        <span style="height: 50px; line-height: 50px;">Fixation</span><br>
                                        <span style="height: 50px; line-height: 50px;">500ms</span><br>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="panel" id="session-management-panel" style="display: none;">
                            <h2 class="underline">Session Management</h2>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">Pending Session</h4>
                            <table style="margin-bottom: 50px;" id="job-list">
                                <tr>
                                    <td><b>Job ID</b></td>
                                    <td><b>Participant</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                                <tr>
                                    <td>Tai Yuan</td>
                                    <td>3</td>
                                    <td style="display: flex; flex-direction: row; flex-wrap: nowrap;"><div class="black-banner-link-hover" style="margin-right: 5px; text-align: center; padding-top: 0px; padding-bottom: 0px;">✓</div><div style="text-align: center; padding-top: 0px; padding-bottom: 0px;" class="black-banner-link-hover">X</div></td>
                                </tr>
                            </table>
                            <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">History Session</h4>
                            <table style="margin-bottom: 50px;" id="job-list">
                                <tr>
                                    <td><b>Job ID</b></td>
                                    <td><b>Participant</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                                <tr>
                                    <td>Tai Yuan</td>
                                    <td>2</td>
                                    <td>Authorized</td>
                                </tr>
                                <tr>
                                    <td>John Doe</td>
                                    <td>4</td>
                                    <td>Rejected</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </main>
        <footer class="hide-mobile" style="display: none;">
            <div class="footer-copyright">
                <div style="padding-right: 10px; overflow: hidden;">
                    <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\server_footer.php"?>
                </div>
                <?php include "C:\Users\Administrator\Desktop\sunrays\web\com\cn-reg.php"?>
            </div>
        </footer>
    </div>
</div>
<script src="/js/menu.js"></script>
<script>
    let typingTimer;
    let doneTypingInterval = 400;
    let user_search_input = document.getElementById("user-search-input");

    user_search_input.addEventListener("keyup", (event) => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    user_search_input.addEventListener("keydown", (event) => {
        clearTimeout(typingTimer);
    });

    function doneTyping () {
        search_user();
    }

    function search_user(){
        document.getElementById('user-search-result-div').style.display = "none";
        document.getElementById("user-search-result-none-div").style.display = "none";
        document.getElementById("user-search-result-true-div").style.display = "none";
        if(user_search_input.value.trim()!==''){
            let search_term = user_search_input.value.trim();
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/business/fnirs2023/php/lookup_user.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        let dataObj = JSON.parse(data);
                        if(dataObj.length > 0){
                            document.getElementById("user-search-result-name").innerText = dataObj[0].fname + " " + dataObj[0].lname;
                            document.getElementById("user-search-result-unique-id").innerText = dataObj[0].unique_id;
                            document.getElementById("user-search-result-gender").innerText = dataObj[0].gender;
                            document.getElementById("user-search-result-type").innerText = dataObj[0].type;
                            document.getElementById("user-search-result-username").value = dataObj[0].username;
                            document.getElementById("user-search-result-is-ban").value = dataObj[0].ban;
                            document.getElementById("user-search-result-is-self").value = dataObj[0].is_self;

                            if(dataObj[0].ban === "1"){
                                document.getElementById("ban-user-btn").innerText = "Lift Ban"
                                document.getElementById("ban-user-btn").setAttribute("onclick", "mod_user('de-ban')");
                            }else{
                                document.getElementById("ban-user-btn").innerText = "Ban"
                                document.getElementById("ban-user-btn").setAttribute("onclick", "mod_user('ban')");
                            }

                            if(dataObj[0].type !== "Admin"){
                                document.getElementById("switch-type-btn").innerText = "Set Admin"
                                document.getElementById("switch-type-btn").setAttribute("onclick", "mod_user('admin')");
                            }else{
                                document.getElementById("switch-type-btn").innerText = "Remove Admin"
                                document.getElementById("switch-type-btn").setAttribute("onclick", "mod_user('de-admin')");
                            }

                            document.getElementById('user-search-result-div').style.display = "block";
                            document.getElementById("user-search-result-true-div").style.display = "block";
                            document.getElementById("user-search-result-none-div").style.display = "none";
                        }else{
                            document.getElementById('user-search-result-div').style.display = "block";
                            document.getElementById("user-search-result-true-div").style.display = "none";
                            document.getElementById("user-search-result-none-div").style.display = "block";
                        }
                    }
                }
            }
            let formData = new FormData();
            formData.append("username", search_term);
            xhr.send(formData);
        }else{
            document.getElementById('user-search-result-div').style.display = "none";
            document.getElementById("user-search-result-none-div").style.display = "none";
            document.getElementById("user-search-result-true-div").style.display = "none";
        }
    }

    function get_user_listing(){
        let $user_list = document.getElementById("user-list");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/business/fnirs2023/php/get_all_users.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let dataObj = JSON.parse(data);
                    if(dataObj.length > 0){
                        for (let i=0; i < dataObj.length; i++) {
                            let $new_line = document.createElement("tr");
                            let $new_line_name = document.createElement("td");
                            let $new_line_username = document.createElement("td");
                            let $new_line_type = document.createElement("td");
                            $new_line_name.innerText = dataObj[i].fname + " " + dataObj[i].lname;
                            $new_line_username.innerText = dataObj[i].username;
                            $new_line_type.innerText = dataObj[i].type;
                            $new_line.append($new_line_name);
                            $new_line.append($new_line_username);
                            $new_line.append($new_line_type);
                            $user_list.append($new_line)
                        }
                    }else{
                    }
                }
            }
        }
        xhr.send();
    }

    function get_auth_listing(){
        let $user_list = document.getElementById("auth-list");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/business/fnirs2023/php/get_all_auth.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let dataObj = JSON.parse(data);
                    if(dataObj.length > 0){
                        for (let i=0; i < dataObj.length; i++) {
                            let $new_line = document.createElement("tr");
                            let $new_line_auth = document.createElement("td");
                            let $new_line_type = document.createElement("td")
                            $new_line_auth.innerText = dataObj[i].auth;
                            $new_line_type.innerText = dataObj[i].type;
                            $new_line.append($new_line_auth);
                            $new_line.append($new_line_type);
                            $user_list.append($new_line)
                        }
                    }else{
                        let $new_line = document.createElement("tr");
                        let $new_line_none = document.createElement("td");
                        $new_line_none.innerText = "No auth code available.";
                        $new_line.append($new_line_none);
                        $user_list.append($new_line)
                    }
                }
            }
        }
        xhr.send();
    }

    setTimeout(function (){
        get_user_listing();
        get_auth_listing();
    }, 0)

    function mod_user(action){
        let target_id = document.getElementById('user-search-result-unique-id').innerText;
        if(target_id!==''&&action!==''){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/business/fnirs2023/php/mod_user.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if(data === "Try Later."){

                        }else{
                            let dataObj = JSON.parse(data);
                            if(dataObj.length > 0){
                                location.reload();
                            }else{
                            }
                        }
                    }
                }
            }
            let formData = new FormData();
            formData.append("target_id", target_id);
            formData.append("action", action);
            xhr.send(formData);
        }
    }

    function gen_auth() {
        let type = document.getElementById('gen_auth_type').value;
        if (type === 'Admin' || type === 'Participant') {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/business/fnirs2023/php/gen_auth.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data === "Try Later.") {

                        } else {
                            let dataObj = JSON.parse(data);
                            if (dataObj.length > 0) {
                                location.reload();
                            } else {
                            }
                        }
                    }
                }
            }
            let formData = new FormData();
            formData.append("type", type);
            xhr.send(formData);
        }
    }

    function switch_tab(tab_id, obj){
        let tab_dom = document.getElementById(tab_id);
        console.log(tab_dom);
        tab_dom.style.display = "block";
        obj.style.border = "2px solid var(--color-1)";
    }

    function edit_scene(obj){
        obj.classList.add("edit");
        let scene_id = obj.firstElementChild.value;
        document.getElementById('edit-box-'+scene_id).style.display="block";
        document.getElementById('data-display-box-'+scene_id).style.display="none";
    }
</script>
<script>
    function request_serial(){
        console.log("requesting serial port permissions...")
        navigator.serial.requestPort();
    }
</script>
</body>
</html>