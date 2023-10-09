<?php
  include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
  include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";
  //include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\agent_check.php";
  if(isset($_GET['redurl'])&&$_GET['redurl']!=''){
    $redurl = $_GET['redurl'];
  }else{
      $redurl = '/business/fnirs2023/account';
  }
  if(isset($_SESSION['fnirs_unique_id'])) {
      header('Location:'.$redurl);
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
  <title>Login - Sunrays Kingdom</title>
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
          <button class="black-banner-link-hover active" onclick="highlight_btn(this)">Login</button>
          <button class="black-banner-link-hover" onclick="highlight_btn(this)">I Forgot</button>
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
        <h1 style="font-family: 'Arial Black', sans-serif, Arial, Helvetica; font-size: var(--font-size-extra-extra-large); font-weight: 900; text-transform: uppercase; letter-spacing: -1px;">Login</h1>
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
              <div class="panel" id="login-panel">
                  <div id="admin-login-window">
                      <h2 class="underline" id="admin-login-header">Login</h2>
                      <div id="login-form-error-msg-admin" style='display: none; background: rgb(67,67,67);
background: -moz-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: -webkit-linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
background: linear-gradient(90deg, rgba(67,67,67,1) 0%, rgba(203,196,187,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#434343",endColorstr="#cbc4bb",GradientType=1); color: var(--color-1); padding: 10px; font-family: sans-serif. Arial, Helvetica; line-height: 1; margin-bottom: 10px; font-size: var(--font-size-medium); padding-right: 30%;'></div>
                      <form style="margin-bottom: 30px;" id="login_form_admin">
                          <div>
                              <input type="text" id="usr_id_admin" placeholder="Admin ID">
                          </div>
                          <div style="margin-top: 10px; margin-bottom: 10px">
                              <input type="password" id="usr_key_admin" placeholder="Password">
                          </div>
                          <div>
                              <button type="submit" class="black-banner-link-hover button" style="width: 100%;" id="admin_login_btn" onclick="admin_login(event, this)">Continue</button>
                          </div>
                          <h3 class="underline secondary-color">Or</h3>
                          <div style="margin-bottom: 15px;">
                              <button class="black-banner-link-hover button secondary" style="width: 100%;" onclick="activate_account(event)">Activate Account</button>
                          </div>
                      </form>
                      <form style="margin-bottom: 30px; display: none;" id="login_form_auth_admin">
                          <div style="margin-bottom: 10px;">
                              <input type="text" id="usr_auth_admin" placeholder="Authorization Code">
                          </div>
                          <div>
                              <button class="black-banner-link-hover button" style="width: 100%;" onclick="check_auth_code_admin(event, 'admin', this)">Continue</button>
                          </div>
                          <h3 class="underline secondary-color">Or</h3>
                          <div style="margin-bottom: 15px;">
                              <button class="black-banner-link-hover button secondary" style="width: 100%;" onclick="login_with_id_admin(event)">Login with ID</button>
                          </div>
                      </form>
                      <script>
                          function admin_login(event, obj){
                              event.preventDefault();
                              obj.innerText = 'Processing...';
                              obj.style.pointerEvents = 'none';
                              document.getElementById("login-form-error-msg-admin").style.display = "none";
                              document.getElementById("login-form-error-msg-admin").innerText = ""
                              usr_id = document.getElementById('usr_id_admin').value;
                              usr_key = document.getElementById('usr_key_admin').value;
                              if(usr_id!='' && usr_key!=''){
                                  let xhr = new XMLHttpRequest();
                                  xhr.open("POST", "/business/fnirs2023/php/member_auth.php", true);
                                  xhr.onload = () => {
                                      if (xhr.readyState === XMLHttpRequest.DONE) {
                                          if (xhr.status === 200) {
                                              let data = xhr.response;
                                              if (data === "success") {
                                                  setTimeout(function () {
                                                      obj.innerText = 'Continue';
                                                      obj.style.pointerEvents = 'all';
                                                      window.location.href = "<?php echo $redurl;?>";
                                                  }, 1000);
                                              } else {
                                                  let errorMsg = "";
                                                  if (data === "0") {
                                                      errorMsg = "Request denied.";
                                                  }
                                                  if (data === "1") {
                                                      errorMsg = "Session timeout.";
                                                  }
                                                  if (data === "3") {
                                                      errorMsg = "Something went wrong.";
                                                  }
                                                  if (data === "4") {
                                                      errorMsg = "Invalid password.";
                                                  }
                                                  if (data === "5") {
                                                      errorMsg = "Invalid ID or password.";
                                                  }
                                                  if (data === "6") {
                                                      errorMsg = "Something went wrong.";
                                                  }
                                                  if (data === "7") {
                                                      errorMsg = "Too many requests.";
                                                  }
                                                  if (data === "8") {
                                                      errorMsg = "Your account has been banned.";
                                                  }
                                                  setTimeout(function () {
                                                      document.getElementById("login-form-error-msg-admin").innerText = errorMsg;
                                                      document.getElementById("login-form-error-msg-admin").style.display = "block";
                                                      obj.innerText = 'Continue';
                                                      obj.style.pointerEvents = 'all';
                                                  }, 1000);
                                              }
                                          }
                                      }
                                  }
                                  let formData = new FormData();
                                  formData.append("usr_key", usr_key);
                                  formData.append("usr_id", usr_id);
                                  xhr.send(formData);
                              }else{
                                  document.getElementById("login-form-error-msg-admin").innerText = "Please fill in all fields.";
                                  document.getElementById("login-form-error-msg-admin").style.display = "block";
                                  document.getElementById('admin_login_btn').innerText = "Continue";
                                  document.getElementById('admin_login_btn').style.pointerEvents = 'all';
                              }
                          }

                          function activate_account(event){
                              event.preventDefault();
                              document.getElementById('admin-login-header').innerText = 'Account Activation';
                              document.getElementById('login_form_admin').style.display = 'none';
                              document.getElementById('login_form_auth_admin').style.display = 'block';
                              document.getElementById("login-form-error-msg-admin").style.display = "none";
                              document.getElementById("login-form-error-msg-admin").innerText = "";
                              document.getElementById('usr_id_admin').value = '';
                              document.getElementById('usr_key_admin').value = '';
                          }

                          function login_with_id_admin(event){
                              event.preventDefault();
                              document.getElementById('admin-login-header').innerText = 'Login';
                              document.getElementById('login_form_admin').style.display = 'block';
                              document.getElementById('login_form_auth_admin').style.display = 'none';
                              document.getElementById("login-form-error-msg-admin").style.display = "none";
                              document.getElementById("login-form-error-msg-admin").innerText = "";
                              document.getElementById('usr_auth_admin').value = '';
                          }

                          function check_auth_code_admin(event, type, obj){
                              event.preventDefault();
                              obj.innerText = 'Processing...';
                              obj.style.pointerEvents = 'none';
                              document.getElementById("login-form-error-msg-admin").style.display = "none";
                              document.getElementById("login-form-error-msg-admin").innerText = ""
                              auth_code = document.getElementById('usr_auth_admin').value;
                              if(auth_code!=''){
                                  let xhr = new XMLHttpRequest();
                                  xhr.open("POST", "https://member.sunrays.top/php/auth_lookup.php", true);
                                  xhr.onload = () => {
                                      if (xhr.readyState === XMLHttpRequest.DONE) {
                                          if (xhr.status === 200) {
                                              let data = xhr.response;
                                              if (data.startsWith("1")) {
                                                  setTimeout(function () {
                                                      obj.innerText = 'Continue';
                                                      obj.style.pointerEvents = 'all';
                                                      window.location.href = ('https://www.sunrays.top/business/fnirs2023/account/activate/?auth_type='+ data.split('+')[1] +'&auth_code=' + auth_code + '&redurl=' + '<?php echo $redurl; ?>');
                                                  }, 1000);
                                              } else {
                                                  let errorMsg = "";
                                                  if (data === "0") {
                                                      errorMsg = "Something went wrong.";
                                                  }
                                                  if (data === "-1") {
                                                      errorMsg = "Something went wrong.";
                                                  }
                                                  if (data === "-2") {
                                                      errorMsg = "Invalid authorization code.";
                                                  }
                                                  if (data === "-3") {
                                                      errorMsg = "Invalid authorization code.";
                                                  }
                                                  if (data === "Try later.") {
                                                      errorMsg = "Too many requests.";
                                                  }
                                                  setTimeout(function () {
                                                      document.getElementById("login-form-error-msg-admin").innerText = errorMsg;
                                                      document.getElementById("login-form-error-msg-admin").style.display = "block";
                                                      obj.innerText = 'Continue';
                                                      obj.style.pointerEvents = 'all';
                                                  }, 1000);
                                              }
                                          }
                                      }
                                  }
                                  let formData = new FormData();
                                  formData.append("auth_code", auth_code);
                                  formData.append("auth_type", type);
                                  xhr.send(formData);
                              }else{
                                  document.getElementById("login-form-error-msg-admin").innerText = "Please fill in all fields.";
                                  document.getElementById("login-form-error-msg-admin").style.display = "block";
                                  obj.innerText = 'Continue';
                                  obj.style.pointerEvents = 'all';
                              }
                          }
                      </script>
                  </div>
              </div>
              <div class="panel" id="i-forgot-panel" style="display: none;">
                  <h2 class="underline">Credential Recovery</h2>
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
</body>
</html>