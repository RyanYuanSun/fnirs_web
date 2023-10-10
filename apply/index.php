<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";

if (isset($_SESSION['fnirs_unique_id'])) {
    header('Location:/business/fnirs2023/account/');
    exit();
}
if (isset($_GET['inquiry'])){
    $inquiry_ref = $_GET['inquiry'];
    $side_menu_select_new = '';
    $side_menu_select_inquiry = 'active';
    $main_new_div_display = 'display:none;';
    $main_inquiry_div_display = 'display:block;';
}else{
    $inquiry_ref = '';
    $side_menu_select_new = 'active';
    $side_menu_select_inquiry = '';
    $main_new_div_display = 'display:block;';
    $main_inquiry_div_display = 'display:none;';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>Participant Application - Sunrays Kingdom</title>
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

        function displayNextDiv(event,obj){
            event.preventDefault();
            obj.parentElement.parentElement.style.display = 'none';
            obj.parentElement.parentElement.nextElementSibling.style.display = 'block';
        }

        function displayPrevDiv(event,obj){
            event.preventDefault();
            obj.parentElement.parentElement.style.display = 'none';
            obj.parentElement.parentElement.previousElementSibling.style.display = 'block';
        }
    </script>
</head>
<body onload="loaded()">
<?php include_once "C:\Users\Administrator\Desktop\sunrays\web\com/fullpage-loader.php" ?>
<div class="overall-warpper">
    <div class="fix-sidebar">
        <div class="title-banner-sidebar">
            <style>
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
            </a>
        </div>
        <div id="sidebar-buttons" class="content-sidebar">
            <div style="min-height: calc(100vh - 80px)">
                <button class="black-banner-link-hover <?php echo $side_menu_select_new;?>" onclick="highlight_btn(this)" id="side-new-application-btn">New Application</button>
                <button class="black-banner-link-hover <?php echo $side_menu_select_inquiry;?>" onclick="highlight_btn(this)" id="side-application-inquiry-btn">Application Inquiry</button>
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
                    Participant Application</h1>
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
                        <div class="panel" id="application-inquiry-panel" style="<?php echo $main_inquiry_div_display;?>">
                            <div style="margin-bottom: 30px;" id="app-inquiry-div">
                                <h2 class="underline">Application Inquiry</h2>
                                <div id="inquiry-div">
                                    <div id="app-error-msg" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                    <input id="app-ref-num" type="text" placeholder="Application Ref No." value="<?php echo $inquiry_ref;?>">
                                    <div>
                                        <button class="black-banner-link-hover" style="flex: 1; margin-bottom: 10px; margin-top: 10px; text-align: center;" onclick="inquire_app(event,this);">Confirm</button>
                                    </div>
                                </div>
                                <div id="inquiry-result-div" style="display: none;" >
                                    <div style="background: var(--color-2); color: var(--color-1); padding: 20px; margin-bottom: 15px; font-family: sans-serif, Arial, Helvetica; box-shadow: 0 4px 3px rgba(0,0,0,0.4),0 8px 13px rgba(0,0,0,0.1),0 18px 23px rgba(0,0,0,0.1);">
                                        <div class="underline">Status: <span style="font-size: 30px; font-weight: 900;" id="inquiry-status"></span></div>
                                    </div>
                                    <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);" id="inquiry-status-desc"></p>
                                    <div>
                                        <button class="black-banner-link-hover" style="flex: 1; margin-bottom: 10px; margin-top: 10px; text-align: center;" onclick="window.location.href='https://www.sunrays.top/business/fnirs2023/apply/?inquiry'">New Inquiry</button>
                                    </div>
                                </div>
                                <h3 class="underline secondary-color">Or</h3>
                                <div style="margin-bottom: 15px;">
                                    <button class="black-banner-link-hover button secondary" style="width: 100%;" onclick="document.getElementById('side-new-application-btn').click();">New Application</button>
                                </div>
                                <script>
                                    function inquire_app(event,obj){
                                        event.preventDefault();
                                        obj.innerText = 'Processing...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("app-error-msg").style.display = "none";
                                        document.getElementById("app-error-msg").innerText = ""
                                        let app_ref_num = document.getElementById('app-ref-num').value;
                                        if(app_ref_num!==''){
                                            let xhr = new XMLHttpRequest();
                                            xhr.open("POST", "https://www.sunrays.top/business/fnirs2023/php/application_inquiry.php", true);
                                            xhr.onload = () => {
                                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                                    if (xhr.status === 200) {
                                                        let data = xhr.response;
                                                        if(data==="0") {
                                                            document.getElementById("app-error-msg").innerText = "Invalid Ref!";
                                                            document.getElementById("app-error-msg").style.display = "block";
                                                            obj.innerText = 'Confirm';
                                                            obj.style.pointerEvents = 'all';
                                                        }else {
                                                            if(data==="Try Later.") {
                                                                document.getElementById("app-error-msg").innerText = "Too many requests! Try later.";
                                                                document.getElementById("app-error-msg").style.display = "block";
                                                                obj.innerText = 'Confirm';
                                                                obj.style.pointerEvents = 'all';
                                                            }else {
                                                                let dataObj = JSON.parse(data);
                                                                document.getElementById('inquiry-div').style.display = 'none';
                                                                let status_span = document.getElementById('inquiry-status');
                                                                let status_desc = document.getElementById('inquiry-status-desc');
                                                                if(dataObj.status==="0"){
                                                                    status_span.innerText = 'Pending';
                                                                    status_desc.innerText = 'Your application has been submitted to our system. Your application is important to us, and we are working diligently to process it. We will contact you as soon as the processing is complete.';
                                                                }else{
                                                                    if(dataObj.status==="1"){
                                                                        status_span.innerText = 'Approved';
                                                                        status_desc.innerText = 'Congratulations! Your application has been approved. Please check your email for a confirmation message and click to confirm as soon as possible. Once confirmed, we will proceed to create your participant system account and provide you with access.';
                                                                    }else{
                                                                        if(dataObj.status==="2"){
                                                                            status_span.innerText = 'Rejected';
                                                                            status_desc.innerText = 'We appreciate your application. However, we regret to inform you that your request has not been accepted at this time. We want to assure you that your personal information provided in this application has been promptly removed from our records. Thank you for considering us.';
                                                                        }else{
                                                                            status_span.innerText = 'Unknown';
                                                                            status_desc.innerText = 'Your application status is currently unknown. Our team is diligently reviewing your submission, and we appreciate your patience during this process.';
                                                                        }
                                                                    }
                                                                }
                                                                document.getElementById('inquiry-result-div').style.display = 'block';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            let formData = new FormData();
                                            formData.append("ref", app_ref_num);
                                            xhr.send(formData);
                                        }else{
                                            document.getElementById("app-error-msg").innerText = "Please fill in all fields.";
                                            document.getElementById("app-error-msg").style.display = "block";
                                            obj.innerText = 'Confirm';
                                            obj.style.pointerEvents = 'all';
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="panel" id="new-application-panel" style="<?php echo $main_new_div_display;?>">
                            <div style="margin-bottom: 30px;">
                                <h2 class="underline">有关此次试验</h2>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">功能性近红外光谱 (fNIRS) </h4>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);"
                                   class="underline">功能性近红外光谱 (fNIRS) 是一种<b>无创的</b>，<b>非侵入性的</b>光学成像技术。<br><br>
                                    通过安置在受试头皮表面的光源和光探头来探测大脑皮层中由于血液氧合状态改变造成的对光的吸收的变化。<br><br>
                                    简单来讲，你可以将光源想象为手机的闪光灯，将光探头想象为你的眼睛，当你用闪光灯照射你的手部时，你能够看到手另一侧的透过的微弱红光。当你的血液流过的时候，透过的光的强度等属性会发生变化，这种变化肉眼无法清晰地分辨，但会被灵敏的光探头检测出来。
                                    <br><br>我们仪器使用的光源有760nm及850nm两个波段，属于近红外光。不同于紫外光、X射线等高能波束，红外光在安全照射强度内不会对生物组织造成辐射损伤。<br><br>
                                    <img src="https://images.squarespace-cdn.com/content/v1/54e7b27de4b0b080e1552803/1455743535138-BNJPVL8Z170U29OBBNCS/NIRScap+-+NIRS+%2B+EEG+integrated+multi-modal+neuroimaging+-+NIRx">
                                </p>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">试验相关</h4>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);"
                                   class="underline">此次试验的任务内容为在佩戴fNIRS仪器的情况下做图片命名，时常约两个小时，其中仪器的佩戴需要约1小时，图片命名任务约1小时。<br><br>
                                    参与者应以<b>普通话为母语</b>，且普通话<b>口音标准</b>。
                                </p>
                                <div>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px; text-align: center; margin-top: 20px;" onclick="displayNextDiv(event,this)">了解</button>
                                </div>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <h2 class="underline">基本信息采集</h2>
                                <div id="new-app-error-msg" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <table style="margin-bottom: 15px;">
                                    <tr>
                                        <td><label for="fname">名</label></td>
                                        <td><input type="text" id="app-fname" placeholder="名"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="lname">姓</label></td>
                                        <td><input type="text" id="app-lname" placeholder="姓"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="birthday">出生年月日</label></td>
                                        <td><input type="date" id="app-birthday" placeholder="出生年月日"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="gender">性别</label></td>
                                        <td>
                                            <select id="app-gender">
                                                <option value="Male">男</option>
                                                <option value="Female">女</option>
                                                <option value="Other">其他</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="gender">电子邮箱</label></td>
                                        <td>
                                            <input type="text" id="app-email" placeholder="电子邮箱">
                                        </td>
                                    </tr>
                                </table>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);"
                                   class="underline">上述收集的个人信息仅作为我们内部工作人员审查您的申请之用，若您的申请被拒绝，我们将即时从数据库中移除您的信息。</p>
                                <div>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px; text-align: center;" onclick="check_app_basic_info(event,this)">确认</button>
                                </div>
                                <script>
                                    function check_app_basic_info(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg").style.display = "none";
                                        document.getElementById("new-app-error-msg").innerText = ""
                                        let app_fname = document.getElementById("app-fname").value;
                                        let app_lname = document.getElementById("app-lname").value;
                                        let app_birthday = document.getElementById("app-birthday").value;
                                        let app_gender = document.getElementById("app-gender").value;
                                        let app_email = document.getElementById("app-email").value;
                                        if((app_fname == null || app_fname === "") || (app_lname == null || app_lname === "") || (app_birthday == null || app_birthday === "") || (app_gender == null || app_gender === "") || (app_email == null || app_email === "")){
                                            document.getElementById("new-app-error-msg").style.display = "block";
                                            document.getElementById("new-app-error-msg").innerText = "请填写所有条目！";
                                            obj.innerText = '确认';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            obj.innerText = '确认';
                                            obj.style.pointerEvents = 'all';
                                            displayNextDiv(event, obj);
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;" id="lang-b47-div">
                                <h2 class="underline">语言习惯调查</h2>
                                <div id="new-app-error-msg-1" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">请问您7岁前使用的语言？（勾选符合的复选框，若选择其他，请写下相应的语言，<b>包括方言</b>）</h4>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-before-7-english" style="flex: 1; cursor: pointer;">
                                    <label for="ques-lang-before-7-english" style="flex: 5; padding-left: 10px;">英语</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-before-7-mandarin" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-before-7-mandarin" style="flex: 5; padding-left: 10px;">普通话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-before-7-cantonese" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-before-7-cantonese" style="flex: 5; padding-left: 10px;">广东话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-before-7-other" onclick="javascript:if(this.checked==true){this.parentElement.nextElementSibling.style.display='flex'}else{this.parentElement.nextElementSibling.style.display='none'}" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-before-7-other" style="flex: 5; padding-left: 10px;">其他</label>
                                </div>
                                <div style="display: none; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="text" id="ques-lang-before-7-other-input" style="flex: 1;" placeholder="在此填写您的语言">
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_1(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_1(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-1").style.display = "none";
                                        document.getElementById("new-app-error-msg-1").innerText = ""
                                        let app_lang_b47_eng = document.getElementById("ques-lang-before-7-english").checked;
                                        let app_lang_b47_man = document.getElementById("ques-lang-before-7-mandarin").checked;
                                        let app_lang_b47_can = document.getElementById("ques-lang-before-7-cantonese").checked;
                                        let app_lang_b47_other = document.getElementById("ques-lang-before-7-other").checked;
                                        let app_lang_b47_other_input = document.getElementById("ques-lang-before-7-other-input").value;
                                        if(app_lang_b47_eng==false&&app_lang_b47_man==false&&app_lang_b47_can==false&&app_lang_b47_other==false){
                                            document.getElementById("new-app-error-msg-1").style.display = "block";
                                            document.getElementById("new-app-error-msg-1").innerText = "请至少选择一个选项！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            if(app_lang_b47_other==true&&(app_lang_b47_other_input==null||app_lang_b47_other_input=="")){
                                                document.getElementById("new-app-error-msg-1").style.display = "block";
                                                document.getElementById("new-app-error-msg-1").innerText = "请填写其他语言！";
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                            }else{
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                                displayNextDiv(event, obj);
                                            }
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;" id="lang-div">
                                <h2 class="underline">语言习惯调查</h2>
                                <div id="new-app-error-msg-2" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">您会使用的语言？（勾选符合的复选框，若选择其他，请写下相应的语言，<b>包括方言</b>）</h4>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-english" style="flex: 1; cursor: pointer;">
                                    <label for="ques-lang-english" style="flex: 5; padding-left: 10px;">英语</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-mandarin" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-mandarin" style="flex: 5; padding-left: 10px;">普通话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-cantonese" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-cantonese" style="flex: 5; padding-left: 10px;">广东话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-other" onclick="javascript:if(this.checked==true){this.parentElement.nextElementSibling.style.display='flex'}else{this.parentElement.nextElementSibling.style.display='none'}" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-other" style="flex: 5; padding-left: 10px;">其他</label>
                                </div>
                                <div style="display: none; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="text" id="ques-lang-other-input" style="flex: 1;" placeholder="在此填写您的语言">
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_2(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_2(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-2").style.display = "none";
                                        document.getElementById("new-app-error-msg-2").innerText = ""
                                        let app_lang_eng = document.getElementById("ques-lang-english").checked;
                                        let app_lang_man = document.getElementById("ques-lang-mandarin").checked;
                                        let app_lang_can = document.getElementById("ques-lang-cantonese").checked;
                                        let app_lang_other = document.getElementById("ques-lang-other").checked;
                                        let app_lang_other_input = document.getElementById("ques-lang-other-input").value;
                                        if(app_lang_eng==false&&app_lang_man==false&&app_lang_can==false&&app_lang_other==false){
                                            document.getElementById("new-app-error-msg-2").style.display = "block";
                                            document.getElementById("new-app-error-msg-2").innerText = "请至少选择一个选项！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            if(app_lang_other==true&&(app_lang_other_input==null||app_lang_other_input=="")){
                                                document.getElementById("new-app-error-msg-2").style.display = "block";
                                                document.getElementById("new-app-error-msg-2").innerText = "请填写其他语言！";
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                            }else{
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                                displayNextDiv(event, obj);
                                            }
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;" id="lang-wc-div">
                                <h2 class="underline">语言习惯调查</h2>
                                <div id="new-app-error-msg-3" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">您与同学交流的语言？（勾选符合的复选框，若选择其他，请写下相应的语言，<b>包括方言</b>）</h4>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-classmate-english" style="flex: 1; cursor: pointer;">
                                    <label for="ques-lang-with-classmate-english" style="flex: 5; padding-left: 10px;">英语</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-classmate-mandarin" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-classmate-mandarin" style="flex: 5; padding-left: 10px;">普通话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-classmate-cantonese" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-classmate-cantonese" style="flex: 5; padding-left: 10px;">广东话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-classmate-other" onclick="javascript:if(this.checked==true){this.parentElement.nextElementSibling.style.display='flex'}else{this.parentElement.nextElementSibling.style.display='none'}" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-classmate-other" style="flex: 5; padding-left: 10px;">其他</label>
                                </div>
                                <div style="display: none; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="text" id="ques-lang-with-classmate-other-input" style="flex: 1;" placeholder="在此填写您的语言">
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_3(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_3(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-3").style.display = "none";
                                        document.getElementById("new-app-error-msg-3").innerText = ""
                                        let app_lang_wc_eng = document.getElementById("ques-lang-with-classmate-english").checked;
                                        let app_lang_wc_man = document.getElementById("ques-lang-with-classmate-mandarin").checked;
                                        let app_lang_wc_can = document.getElementById("ques-lang-with-classmate-cantonese").checked;
                                        let app_lang_wc_other = document.getElementById("ques-lang-with-classmate-other").checked;
                                        let app_lang_wc_other_input = document.getElementById("ques-lang-with-classmate-other-input").value;
                                        if(app_lang_wc_eng==false&&app_lang_wc_man==false&&app_lang_wc_can==false&&app_lang_wc_other==false){
                                            document.getElementById("new-app-error-msg-3").style.display = "block";
                                            document.getElementById("new-app-error-msg-3").innerText = "请至少选择一个选项！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            if(app_lang_wc_other==true&&(app_lang_wc_other_input==null||app_lang_wc_other_input=="")){
                                                document.getElementById("new-app-error-msg-3").style.display = "block";
                                                document.getElementById("new-app-error-msg-3").innerText = "请填写其他语言！";
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                            }else{
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                                displayNextDiv(event, obj);
                                            }
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;" id="lang-wf-div">
                                <h2 class="underline">语言习惯调查</h2>
                                <div id="new-app-error-msg-4" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">您与父母/家人交流使用的语言？（勾选符合的复选框，若选择其他，请写下相应的语言，<b>包括方言</b>）</h4>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-family-english" style="flex: 1; cursor: pointer;">
                                    <label for="ques-lang-with-family-english" style="flex: 5; padding-left: 10px;">英语</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-family-mandarin" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-family-mandarin" style="flex: 5; padding-left: 10px;">普通话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-family-cantonese" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-family-cantonese" style="flex: 5; padding-left: 10px;">广东话</label>
                                </div>
                                <div style="display: flex; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="checkbox" id="ques-lang-with-family-other" onclick="javascript:if(this.checked==true){this.parentElement.nextElementSibling.style.display='flex'}else{this.parentElement.nextElementSibling.style.display='none'}" style="flex: 1; cursor: pointer">
                                    <label for="ques-lang-with-family-other" style="flex: 5; padding-left: 10px;">其他</label>
                                </div>
                                <div style="display: none; margin-top: 20px; justify-content: space-between; align-items: center;">
                                    <input type="text" id="ques-lang-with-family-other-input" style="flex: 1;" placeholder="在此填写您的语言">
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_4(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_4(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-4").style.display = "none";
                                        document.getElementById("new-app-error-msg-4").innerText = ""
                                        let app_lang_wf_eng = document.getElementById("ques-lang-with-family-english").checked;
                                        let app_lang_wf_man = document.getElementById("ques-lang-with-family-mandarin").checked;
                                        let app_lang_wf_can = document.getElementById("ques-lang-with-family-cantonese").checked;
                                        let app_lang_wf_other = document.getElementById("ques-lang-with-family-other").checked;
                                        let app_lang_wf_other_input = document.getElementById("ques-lang-with-family-other-input").value;
                                        if(app_lang_wf_eng==false&&app_lang_wf_man==false&&app_lang_wf_can==false&&app_lang_wf_other==false){
                                            document.getElementById("new-app-error-msg-4").style.display = "block";
                                            document.getElementById("new-app-error-msg-4").innerText = "请至少选择一个选项！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            if(app_lang_wf_other==true&&(app_lang_wf_other_input==null||app_lang_wf_other_input=="")){
                                                document.getElementById("new-app-error-msg-4").style.display = "block";
                                                document.getElementById("new-app-error-msg-4").innerText = "请填写其他语言！";
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                            }else{
                                                obj.innerText = '下一个';
                                                obj.style.pointerEvents = 'all';
                                                displayNextDiv(event, obj);
                                            }
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <style>
                                    .black-banner-link-hover.sel{
                                        cursor: auto;
                                        border-color: var(--color-2);
                                        color: var(--color-2);
                                        font-weight: 900;
                                        background: var(--color-1) !important;
                                        pointer-events: none;
                                    }
                                </style>
                                <h2 class="underline" style="margin-top: 0;">其他习惯调查</h2>
                                <div id="new-app-error-msg-5" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">现在住在学校还是和父母同住（最近两年）?</h4>
                                <input hidden id="ques-live-with" value>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 20px;">
                                    <button class="black-banner-link-hover button secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">学校</button>
                                    <button class="black-banner-link-hover button  secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">家里</button>
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_5(event,this)">下一个</button>
                                </div>
                                <script>
                                    function select_this(event,obj){
                                        event.preventDefault();
                                        obj.disable = true;
                                        obj.classList.add("sel");
                                        let all_buttons = obj.parentElement.getElementsByTagName("button");
                                        for (let i = 0; i < all_buttons.length; i++) {
                                            if(all_buttons[i]!==obj){
                                                all_buttons[i].disabled = false;
                                                all_buttons[i].classList.remove("sel");
                                            }else{
                                                let idx = (i+1);
                                                obj.parentElement.parentElement.getElementsByTagName("input")[0].setAttribute("value", idx.toString());
                                            }
                                        }
                                    }

                                    function check_5(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-5").style.display = "none";
                                        document.getElementById("new-app-error-msg-5").innerText = ""
                                        let app_life_live_with = document.getElementById("ques-live-with").value;
                                        if(app_life_live_with==null||app_life_live_with==""){
                                            document.getElementById("new-app-error-msg-5").style.display = "block";
                                            document.getElementById("new-app-error-msg-5").innerText = "请做出选择！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                            displayNextDiv(event, obj);
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <h2 class="underline" style="margin-top: 0;">其他习惯调查</h2>
                                <div id="new-app-error-msg-6" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">12岁以前是否曾接受过至少连续5年的声乐或乐器训练?</h4>
                                <input hidden id="ques-music-b412" value>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 20px;">
                                    <button class="black-banner-link-hover button secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">是</button>
                                    <button class="black-banner-link-hover button  secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">否</button>
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_6(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_6(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-6").style.display = "none";
                                        document.getElementById("new-app-error-msg-6").innerText = ""
                                        let app_music_b412 = document.getElementById("ques-music-b412").value;
                                        if(app_music_b412==null||app_music_b412==""){
                                            document.getElementById("new-app-error-msg-6").style.display = "block";
                                            document.getElementById("new-app-error-msg-6").innerText = "请做出选择！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                            displayNextDiv(event, obj);
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <h2 class="underline" style="margin-top: 0;">其他习惯调查</h2>
                                <div id="new-app-error-msg-7" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <h4 class="no-bot-margin" style="padding-left: 5px; padding-bottom: 5px;">过去两年是否连续练习某种乐器?</h4>
                                <input hidden id="ques-inst" value>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 20px;">
                                    <button class="black-banner-link-hover button secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">是</button>
                                    <button class="black-banner-link-hover button  secondary" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="select_this(event,this)">否</button>
                                </div>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_7(event,this)">下一个</button>
                                </div>
                                <script>
                                    function check_7(event,obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-7").style.display = "none";
                                        document.getElementById("new-app-error-msg-7").innerText = ""
                                        let app_inst = document.getElementById("ques-inst").value;
                                        if(app_inst==null||app_inst==""){
                                            document.getElementById("new-app-error-msg-7").style.display = "block";
                                            document.getElementById("new-app-error-msg-7").innerText = "请做出选择！";
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                        }else{
                                            obj.innerText = '下一个';
                                            obj.style.pointerEvents = 'all';
                                            displayNextDiv(event, obj);
                                        }
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <h2 class="underline" style="margin-top: 0;">惯用侧调查</h2>
                                <div id="new-app-error-msg-8" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);"
                                   class="underline">在下面的表格中，根据您的习惯选择您做某种动作时的常用手/脚/眼。<br><br>
                                    有一些动作需要双手，在这些动作中，请填写括号中条件下的用手习惯。<br><br>
                                    （“总是”：表示除非强迫情况下始终为该侧。“有时”：表示两只手没有区别。“从不”：表示除非强迫情况下始终不用该侧。“没有做过此动作”：表示没有完成过该任务。）
                                </p>
                                <table id="left-right-table">
                                    <tr>
                                        <td>写字</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="write-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="write-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>绘画</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="paint-left" selectedIndex="1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="paint-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>投掷</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="throw-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="throw-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>使用剪刀</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="scissors-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="scissors-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>使用牙刷</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="toothbrush-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="toothbrush-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>使用刀(不与叉同用的情况下)</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="knife-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="knife-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>使用勺子</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="spoon-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="spoon-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>使用扫把(放在上面的那只手)</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="broom-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="broom-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>划火柴(拿火柴的那只手)</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="match-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="match-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>开箱子(拿盖子的那只手)</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左手</label>
                                                    <select id="unbox-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右手</label>
                                                    <select id="unbox-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>踢东西的时候习惯用哪只脚？</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左腿</label>
                                                    <select id="kick-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右腿</label>
                                                    <select id="kick-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>只用一只眼睛看东西的时候习惯哪一只?</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <div>
                                                    <label>左眼</label>
                                                    <select id="eye-left" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label>右眼</label>
                                                    <select id="eye-right" selectedIndex="-1">
                                                        <option value="" selected disabled hidden>请选择</option>
                                                        <option value="1">总是</option>
                                                        <option value="2">有时</option>
                                                        <option value="3">从不</option>
                                                        <option value="4">没有做过此动作</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="displayPrevDiv(event,this)">上一个</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="check_8(event,this)">提交申请</button>
                                </div>
                                <script>
                                    const selects = document.getElementById('left-right-table').querySelectorAll('select');
                                    selects.forEach(select => {
                                        select.addEventListener('change', () => {
                                            const selectedValue = select.value;
                                            const selectedId = select.id;
                                            const otherId = selectedId.endsWith('-left') ? selectedId.replace('-left', '-right') : selectedId.replace('-right', '-left');
                                            const otherSelect = document.getElementById(otherId);
                                            switch (selectedValue) {
                                                case '1':
                                                    otherSelect.value = '3';
                                                    break;
                                                case '2':
                                                    otherSelect.value = '2';
                                                    break;
                                                case '3':
                                                    otherSelect.value = '1';
                                                    break;
                                                case '4':
                                                    otherSelect.value = '4';
                                                    break;
                                            }
                                        });
                                    });

                                    function check_8(event, obj){
                                        event.preventDefault();
                                        obj.innerText = '处理中...';
                                        obj.style.pointerEvents = 'none';
                                        document.getElementById("new-app-error-msg-8").style.display = "none";
                                        document.getElementById("new-app-error-msg-8").innerText = "";
                                        let allSelected = true;
                                        selects.forEach(select => {
                                            if (!select.value) {
                                                allSelected = false;
                                                return;
                                            }
                                        });
                                        if (allSelected) {
                                            submit_application(event,obj);
                                        } else {
                                            obj.innerText = '提交申请';
                                            obj.style.pointerEvents = 'all';
                                            document.getElementById("new-app-error-msg-8").style.display = "block";
                                            document.getElementById("new-app-error-msg-8").innerText = "请填写所有条目！";
                                        }
                                    }

                                    function submit_application(event, obj){
                                        let fname = document.getElementById('app-fname').value;
                                        let lname = document.getElementById('app-lname').value;
                                        let gender = document.getElementById('app-gender').value;
                                        let birthday = document.getElementById('app-birthday').value;
                                        let email = document.getElementById('app-email').value;
                                        let lang_b47 = "";
                                        const checkboxes_b47 = document.getElementById('lang-b47-div').querySelectorAll('input[type="checkbox"]');
                                        checkboxes_b47.forEach(checkbox => {
                                            if (checkbox.checked) {
                                                lang_b47 += '1';
                                            } else {
                                                lang_b47 += '0';
                                            }
                                        });
                                        if(lang_b47.endsWith("1")) {
                                            lang_b47 += document.getElementById('ques-lang-before-7-other-input').value;
                                        }
                                        let lang = "";
                                        const checkboxes = document.getElementById('lang-div').querySelectorAll('input[type="checkbox"]');
                                        checkboxes.forEach(checkbox => {
                                            if (checkbox.checked) {
                                                lang += '1';
                                            } else {
                                                lang += '0';
                                            }
                                        });
                                        if(lang.endsWith("1")) {
                                            lang += document.getElementById('ques-lang-other-input').value;
                                        }
                                        let lang_wc = "";
                                        const checkboxes_wc = document.getElementById('lang-wc-div').querySelectorAll('input[type="checkbox"]');
                                        checkboxes_wc.forEach(checkbox => {
                                            if (checkbox.checked) {
                                                lang_wc += '1';
                                            } else {
                                                lang_wc += '0';
                                            }
                                        });
                                        if(lang_wc.endsWith("1")) {
                                            lang_wc += document.getElementById('ques-lang-with-classmate-other-input').value;
                                        }
                                        let lang_wf = "";
                                        const checkboxes_wf = document.getElementById('lang-wf-div').querySelectorAll('input[type="checkbox"]');
                                        checkboxes_wf.forEach(checkbox => {
                                            if (checkbox.checked) {
                                                lang_wf += '1';
                                            } else {
                                                lang_wf += '0';
                                            }
                                        });
                                        if(lang_wf.endsWith("1")) {
                                            lang_wf += document.getElementById('ques-lang-with-family-other-input').value;
                                        }
                                        let live_with = document.getElementById('ques-live-with').value;
                                        let music = document.getElementById('ques-music-b412').value;
                                        let inst = document.getElementById('ques-inst').value;
                                        let write_left = document.getElementById('write-left').value;
                                        let paint_left = document.getElementById('paint-left').value;
                                        let throw_left = document.getElementById('throw-left').value;
                                        let scissors_left = document.getElementById('scissors-left').value;
                                        let toothbrush_left = document.getElementById('toothbrush-left').value;
                                        let knife_left = document.getElementById('knife-left').value;
                                        let spoon_left = document.getElementById('spoon-left').value;
                                        let broom_left = document.getElementById('broom-left').value;
                                        let match_left = document.getElementById('match-left').value;
                                        let unbox_left = document.getElementById('unbox-left').value;
                                        let kick_left = document.getElementById('kick-left').value;
                                        let eye_left = document.getElementById('eye-left').value;

                                        let xhr = new XMLHttpRequest();
                                        xhr.open("POST", "https://www.sunrays.top/business/fnirs2023/php/submit_application.php", true);
                                        xhr.onload = () => {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    let data = xhr.response;
                                                    if(data==="1"){
                                                        displayNextDiv(event, obj);
                                                    }else{
                                                        if(data==="-3"){
                                                            obj.innerText = '提交申请';
                                                            obj.style.pointerEvents = 'all';
                                                            document.getElementById("new-app-error-msg-8").style.display = "block";
                                                            document.getElementById("new-app-error-msg-8").innerText = "无法向您的邮箱发送确认邮件！请返回检查您的邮箱！";
                                                            alert("无法向您的邮箱发送确认邮件！请返回检查您的邮箱！");
                                                        }else{
                                                            obj.innerText = '提交申请';
                                                            obj.style.pointerEvents = 'all';
                                                            document.getElementById("new-app-error-msg-8").style.display = "block";
                                                            document.getElementById("new-app-error-msg-8").innerText = "在递交申请时出错！";
                                                            alert("在递交申请时出错！");
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        let formData = new FormData();
                                        formData.append("fname", fname);
                                        formData.append("lname", lname);
                                        formData.append("gender", gender);
                                        formData.append("birthday", birthday);
                                        formData.append("email", email);
                                        formData.append("lang_b47", lang_b47);
                                        formData.append("lang", lang);
                                        formData.append("lang_wc", lang_wc);
                                        formData.append("lang_wf", lang_wf);
                                        formData.append("live_with", live_with);
                                        formData.append("music", music);
                                        formData.append("inst", inst);
                                        formData.append("write-left", write_left);
                                        formData.append("paint-left", paint_left);
                                        formData.append("throw-left", throw_left);
                                        formData.append("scissors-left", scissors_left);
                                        formData.append("toothbrush-left", toothbrush_left);
                                        formData.append("knife-left", knife_left);
                                        formData.append("spoon-left", spoon_left);
                                        formData.append("broom-left", broom_left);
                                        formData.append("match-left", match_left);
                                        formData.append("unbox-left", unbox_left);
                                        formData.append("kick-left", kick_left);
                                        formData.append("eye-left", eye_left);
                                        xhr.send(formData);
                                    }
                                </script>
                            </div>
                            <div style="margin-bottom: 30px; display: none;">
                                <h2 class="underline" style="margin-top: 0;">感谢您的申请</h2>
                                <p style="font-family: sans-serif, Arial, Helvetica; margin-bottom: 0; padding: 10px; font-size: var(--font-size-medium); text-align: left; color: var(--color-2); text-shadow: 0 0 1.2px var(--color-2); font-weight: 200; border: 1px solid var(--color-5);">您的申请已经成功提交！随后会有一封附有申请查询码的邮件发送至您的邮箱，您可以使用该查询码自主查询您的申请状态。另外当您的申请状态更新时，我们也会以邮件形式通知您。</p>
                                <div style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="location.reload()">新的申请</button>
                                    <button class="black-banner-link-hover" style="flex: 1; margin-right: 5px; margin-bottom: 5px;" onclick="document.getElementById('side-application-inquiry-btn').click();">查询申请进度</button>
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
</body>
</html>