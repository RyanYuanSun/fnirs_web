<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";

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
                if ($row_admin_user['ban'] == 1) {
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
    <title>Assignment - Sunrays Kingdom</title>
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
            <div id="sidebar-buttons" style="min-height: calc(100vh - 80px)">
                <button class="black-banner-link-hover active" onclick="highlight_btn(this)">Active Assignment</button>
                <button class="black-banner-link-hover" onclick="highlight_btn(this)">History Assignment</button>
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
                <h1 style="font-family: 'Arial Black', sans-serif, Arial, Helvetica; font-size: var(--font-size-extra-extra-large); font-weight: 900; text-transform: uppercase; letter-spacing: -1px;">Assignment</h1>
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
                        <div class="panel" id="active-assignment-panel">
                            <h2 class="underline">Active Assignment</h2>
                            <table style="margin-bottom: 50px;" id="job-list">
                                <tr>
                                    <td><b>Job ID</b></td>
                                    <td><b>Assigned By</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="panel" id="history-assignment-panel" style="display: none;">
                            <h2 class="underline">History Assignment</h2>
                            <table id="comp-job-list">
                                <tr>
                                    <td><b>Job ID</b></td>
                                    <td><b>Assigned By</b></td>
                                    <td><b>Description</b></td>
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
    function get_job(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/business/fnirs2023/php/get_job.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let dataObj = JSON.parse(data);
                    if(dataObj.length > 0){
                        let job_count = 0;
                        let comp_job_count = 0;
                        for (let i=0; i < dataObj.length; i++) {
                            let $new_line = document.createElement("tr");
                            let $new_line_id = document.createElement("td");
                            let $new_line_by = document.createElement("td");
                            let $new_line_desc = document.createElement("td");
                            let $new_line_data_hidden = document.createElement("input");
                            let $new_line_id_button = document.createElement("div");
                            $new_line_id_button.className = "black-banner-link-hover";
                            $new_line_id_button.style = "width: fit-content; padding: 10px; padding-top:0; padding-bottom:0; cursor:pointer";
                            $new_line_id_button.innerText = dataObj[i].job_id;
                            if(dataObj[i].job_status === "1"){
                                //$new_line_id_button.setAttribute("onclick", "javascript:window.location='/business/fnirs2023/run/?job-id="+dataObj[i].job_id+"'");
                                $new_line_id_button.setAttribute("onclick", "javascript:window.open('/business/fnirs2023/run/?job-id="+dataObj[i].job_id+"','Run Experiment','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no');");
                            }else{
                                $new_line_id_button.setAttribute("onclick", "javascript:window.open('/business/fnirs2023/review/?job-id="+dataObj[i].job_id+"','Run Experiment','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no');");
                            }
                            $new_line_data_hidden.setAttribute("type", "hidden");
                            $new_line_data_hidden.setAttribute("value", dataObj[i].job_data);
                            $new_line_id.appendChild($new_line_id_button);
                            $new_line_by.innerText = dataObj[i].job_by_name;
                            $new_line_desc.innerText = dataObj[i].job_desc;
                            $new_line.append($new_line_id);
                            $new_line.append($new_line_by);
                            $new_line.append($new_line_desc);
                            $new_line.append($new_line_data_hidden);
                            if(dataObj[i].job_status === "1"){
                                job_count += 1;
                                document.getElementById("job-list").append($new_line);
                            }else{
                                comp_job_count += 1;
                                document.getElementById("comp-job-list").append($new_line);
                            }
                        }
                        if(job_count === 0){
                            let no_job_line = document.createElement("tr");
                            let no_job_line_ctn = document.createElement("td");
                            no_job_line_ctn.innerText = "You have not been assigned any experimental tasks at the moment.";
                            no_job_line.append(no_job_line_ctn);
                            document.getElementById("job-list").append(no_job_line);
                        }
                        if(comp_job_count === 0){
                            let no_job_line = document.createElement("tr");
                            let no_job_line_ctn = document.createElement("td");
                            no_job_line_ctn.innerText = "You have not completed any assignment at the moment.";
                            no_job_line.append(no_job_line_ctn);
                            document.getElementById("comp-job-list").append(no_job_line);
                        }
                    }else{
                        let no_job_line = document.createElement("tr");
                        let no_job_line_ctn = document.createElement("td");
                        no_job_line_ctn.innerText = "You have not been assigned any experimental tasks at the moment.";
                        no_job_line.append(no_job_line_ctn);
                        document.getElementById("job-list").append(no_job_line);

                        let no_job_line_his = document.createElement("tr");
                        let no_job_line_his_ctn = document.createElement("td");
                        no_job_line_his_ctn.innerText = "You have not completed any assignment at the moment.";
                        no_job_line_his.append(no_job_line_his_ctn);
                        document.getElementById("comp-job-list").append(no_job_line_his);
                    }
                }
            }
        }
        xhr.send();
    }

    get_job();
</script>
</body>
</html>