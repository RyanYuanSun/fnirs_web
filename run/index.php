<?php
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\session\session_ini.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php/traffic_log.php";
include_once "C:\Users\Administrator\Desktop\sunrays\web\php\database_config.php";

if (!isset($_SESSION['fnirs_unique_id'])) {
    header('Location:/business/fnirs2023/account/login?redurl=' . $_SERVER['REQUEST_URI']);
    exit();
} else {
    $unique_id = mysqli_real_escape_string($conn, $_SESSION['fnirs_unique_id']);
}

if (!isset($_GET['job-id'])) {
    header("HTTP/1.1 403 Forbidden");
    exit();
} else {
    $job_id = intval($_GET['job-id']);
}

$user_admin_lookup = mysqli_query($conn, "SELECT * FROM fnirs_user where (identifier = '{$unique_id}') ORDER BY id ASC LIMIT 1");
if ($user_admin_lookup) {
    if (mysqli_num_rows($user_admin_lookup) > 0) {
        while ($row_admin_user = mysqli_fetch_assoc($user_admin_lookup)) {
            if ($row_admin_user['ban'] == 1) {
                header("HTTP/1.1 403 Forbidden");
                exit();
            } else {
                $job_lookup = mysqli_query($conn, "SELECT * FROM fnirs_job where (id = {$job_id} AND status = 1 AND participant = '{$unique_id}') ORDER BY id ASC LIMIT 1");
                if ($job_lookup) {
                    if (mysqli_num_rows($job_lookup) > 0) {
                        while ($row_job = mysqli_fetch_assoc($job_lookup)) {
                            $data_id = $row_job['data_id'];
                        }
                    } else {
                        header("HTTP/1.1 403 Forbidden");
                        exit();
                    }
                } else {
                    header("HTTP/1.1 500 Internal Server Error");
                    exit();
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

$data_lookup = mysqli_query($conn, "SELECT * FROM fnirs_data WHERE (id = {$data_id}) ORDER BY id DESC LIMIT 1");
if ($data_lookup) {
    if (mysqli_num_rows($data_lookup) > 0) {
        while ($row_data = mysqli_fetch_assoc($data_lookup)) {
            $data_sequence_raw = $row_data['sequence'];
            $data_sequence_json = json_decode($data_sequence_raw);
            if ($data_sequence_json === null && json_last_error() !== JSON_ERROR_NONE) {
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            } else {
                $section_list = $data_sequence_json->sequence;
                $final_sequence = [];
                foreach ($section_list as $section) {
                    $section_lookup = mysqli_query($conn, "SELECT * FROM fnirs_data_section WHERE (id = {$section}) ORDER BY id DESC LIMIT 1");
                    if ($section_lookup) {
                        if (mysqli_num_rows($section_lookup) > 0) {
                            while ($row_section = mysqli_fetch_assoc($section_lookup)) {
                                $section_sequence_raw = $row_section['section_sequence'];
                                $section_sequence_json = json_decode($section_sequence_raw);
                                if ($section_sequence_json === null && json_last_error() !== JSON_ERROR_NONE) {
                                    header("HTTP/1.1 500 Internal Server Error");
                                    exit();
                                } else {
                                    foreach ($section_sequence_json as $page) {
                                        if ($page->type === 1) {
                                            array_push($final_sequence, array("fixation.html", $page->duration));
                                        } elseif ($page->type === 2) {
                                            array_push($final_sequence, array("blank.html", $page->duration));
                                        } elseif ($page->type === 3) {
                                            array_push($final_sequence, array("prime.html", $page->duration, $page->prime_chr, $page->prime_audio));
                                        } else {
                                            array_push($final_sequence, array("target_pic.html", $page->duration, $page->tar_img));
                                        }
                                    }
                                }
                            }
                        } else {
                            header("HTTP/1.1 500 Internal Server Error");
                            exit();
                        }
                    } else {
                        header("HTTP/1.1 500 Internal Server Error");
                        exit();
                    }
                }
            }
        }
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        exit();
    }
} else {
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        function time_mil() {
            var currentDate = new Date();
            var hours = currentDate.getHours();
            var minutes = currentDate.getMinutes();
            var seconds = currentDate.getSeconds();
            var milliseconds = currentDate.getMilliseconds();
            var formattedTime = hours + ":" + minutes + ":" + seconds + "." + milliseconds;
            return formattedTime;
        }

        console.log("[System @ " + time_mil() + "] Loading resources...");

        function handle_critical_session_error(msg) {
            critical_error = 1;
            console.error("[System @ " + time_mil() + "] " + msg);
            if(typeof check_auth_interval !== 'undefined'){
                clearInterval(check_auth_interval);
            }
            if(typeof save_records_interval !== 'undefined'){
                clearInterval(save_records_interval);
            }
            if(typeof intervalAudio !== 'undefined') {
                clearInterval(intervalAudio);
            }
            document.getElementById("main-wrapper").style.display = "none";
            document.getElementById("critical_error_msg").innerText = msg;
            document.getElementById("pre-fail-div").style.display = "flex";
            document.body.style.pointerEvents = "all";
            document.body.style.cursor = "auto";

            end_all_listener();
        }

        function end_all_listener(){
            end_fullscreen_listener();
            var element = document.body;
            var newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
        }

        function loaded() {
            console.log("[System @ " + time_mil() + "] Resources loaded.")
            console.log("[System @ " + time_mil() + "] Participant ID: " + "<?php echo $unique_id; ?>");
            console.log("[System @ " + time_mil() + "] Job ID: " + "<?php echo $job_id; ?>")
            setTimeout(function () {
                document.getElementById("caching-div").style.display = "none";
                document.getElementById("serial-div").style.display = "flex";
                console.log("[System @ " + time_mil() + "] Requesting serial port permission...")
            }, 2000)
        }

        function exit_program(){
            if(registered === 1 && events.length > 0){
                save_records("exit");
            }else{
                console.log("[System @ " + time_mil() + "] Terminating session...")
                window.close();
            }
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="viewport-fit=cover width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>Run Experiment - Sunrays Kingdom</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rrweb@latest/dist/rrweb.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/rrweb@latest/dist/rrweb.min.js"></script>
    <style>
        html {
            height: 100%;
            width: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }

        .html-content {
            display: none;
        }

        .scene-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
        }

        .character-container, .image-container {
            max-height: 300px;
        }

        .character-container h1 {
            font-family: "Arial Black", Arial, sans-serif, Helvetica;
            font-size: 90px;
            font-weight: bold;
        }

        .fixation-cross {
            display: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .fixation-cross {
            background-color: white; /* Change the color to your preference */
            position: relative;
        }

        .cross-horizontal,
        .cross-vertical {
            position: absolute;
            background-color: black;
        }

        .cross-horizontal {
            width: 100%;
            height: 4px;
            top: 50%;
            transform: translateY(-50%);
        }

        .cross-vertical {
            width: 4px;
            height: 100%;
            left: 50%;
            transform: translateX(-50%);
        }

        .image-container img {
            height: 300px;
            width: auto;
        }
    </style>
</head>
<body onload="loaded()">
<div id="main-wrapper"
     style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; width: 100%;">
    <div id="content-container"
         style="display: flex; flex-direction: column; align-items: center; justify-content: center; display: none;">
        <?php
        $sequences = $final_sequence;

        foreach ($sequences as $index => $page) {

            $filePath = 'C:\Users\Administrator\Desktop\sunrays/wwwroot/business/fnirs2023/data/page/' . $page[0]; // Assuming the HTML files are in the same directory as this script

            if (file_exists($filePath)) {
                echo "<div class='html-content'>";
                $file_content = file_get_contents($filePath);
                if ($page[0] === 'fixation.html' || $page[0] === 'blank.html') {
                    echo str_replace('id="duration"', 'id="duration-' . $index . '" value="' . $page[1] . '"', str_replace('id="scene"', 'id="scene-' . $index . '"', $file_content));
                } elseif ($page[0] === 'prime.html') {
                    echo str_replace('<source src="">', '<source src="/business/fnirs2023/data/audio/'.$page[3].'"', str_replace('id="duration"', 'id="duration-' . $index . '" value="' . $page[1] . '"', str_replace('id="scene"', 'id="scene-' . $index . '"', str_replace('<h1></h1>', '<h1>' . $page[2] . '</h1>', $file_content))));
                } else {
                    echo str_replace('id="duration"', 'id="duration-' . $index . '" value="' . $page[1] . '"', str_replace('id="scene"', 'id="scene-' . $index . '"', str_replace('/business/fnirs2023/data/img/', '/business/fnirs2023/data/img/' . $page[2], $file_content)));
                }
                echo '</div>';
            } else {
                echo "<p>File $page[0] not found.</p>";
            }
        }
        ?>
    </div>
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; height: 100%; font-family: sans-serif, Arial, Helvetica;"
         id="pre-check">
        <div id="caching-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <div><b>Caching Resources</b></div>
            <div style="max-width: 70%;">Please hold on momentarily as our system prepares to cache the necessary documents...</div>
        </div>
        <div id="serial-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>Connect Trigger Port</b></div>
            <div style="text-decoration: underline; cursor: pointer;" onclick="request_serial();">Connect ></div>
        </div>
        <div id="fullscreen-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>Enter Fullscreen</b></div>
            <div style="text-decoration: underline; cursor: pointer;" onclick="enter_fullscreen();">Click here ></div>
        </div>
        <div id="audio-check-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>Audio Check</b></div>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;"
                 id="headset-check">
                <div>Kindly put on your headset at this time.</div>
                <div style="text-decoration: underline; cursor: pointer;" onclick="headset_ready();">I'm currently
                    wearing my headset >
                </div>
                <div style="text-decoration: underline; cursor: pointer;"
                     onclick="handle_critical_session_error('Headset Not Ready');">I do not have a headset >
                </div>
            </div>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;"
                 id="beep-check">
                <audio id="beep-audio">
                    <source src="/business/fnirs2023/data/audio/audio-check-beep.mp3">
                </audio>
                <div>Now, can you hear the beep clearly?</div>
                <div style="text-decoration: underline; cursor: pointer;" onclick="audio_ready();">Yes, I can ></div>
                <div style="text-decoration: underline; cursor: pointer;"
                     onclick="handle_critical_session_error('Audio Check Failure');">No, I cannot >
                </div>
            </div>
        </div>
        <div id="legal-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>Research Project Privacy Agreement</b></div>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;"
                 id="headset-check">
                <div style="border: 1px solid black; padding: 10px; max-height: 400px; margin-top: 10px; margin-bottom: 10px; max-width: 80%; overflow-y: scroll;">
                    Welcome to the research project. Before proceeding, please carefully read and confirm your consent
                    to the following privacy agreement.<br><br>
                    <b>1. Data Collection and Purpose</b><br>
                    <i><u>Data Collection</u></i>: During the research process, we will collect data related to your
                    brain activity to understand the language tone generation mechanism. Data collection will be
                    conducted by qualified researchers in appropriate research settings.<br>
                    <i><u>Data Purpose</u></i>: The collected data will be used for research purposes, primarily to
                    explore brain activity during language tone generation. The data will be anonymized and will not
                    contain any information that can directly identify you.<br><br>
                    <b>2. Data Processing and Storage</b><br>
                    <i><u>Data Processing</u></i>: Our research team will analyze and process the data. We will
                    implement appropriate security measures to ensure the confidentiality and integrity of the data.<br>
                    <i><u>Data Storage</u></i>: Data will be stored in a secure environment, and only authorized
                    researchers will have access. Data will be retained for a certain period after the completion of the
                    research project for analysis and verification of research findings.<br><br>
                    <b>3. Data Sharing and Disclosure</b><br>
                    <i><u>Data Sharing</u></i>: Research results may be shared with the scientific community and
                    relevant stakeholders in an anonymous and aggregated form to promote scientific research and
                    knowledge sharing. In such cases, your personal identity will be protected.<br>
                    <i><u>Data Disclosure</u></i>: Your personal identity information will not be disclosed unless
                    required by law or with your prior consent.<br><br>
                    <b>4. Participant Rights</b><br>
                    <i><u>Access and Correction</u></i>: You have the right to access your personal data and request
                    corrections or deletions of inaccurate data when necessary.<br>
                    <i><u>Consent Withdrawal</u></i>: You may withdraw your participation consent at any time and
                    request the cessation of data collection and processing. Please note that withdrawing consent may
                    affect your ability to participate in the research project.<br><br>
                    <b>5. Contact Information</b><br>
                    If you have any questions or concerns regarding data processing or the privacy policy, please feel
                    free to contact us.<br>
                </div>
                <div style="text-decoration: underline; cursor: pointer;" onclick="agree_privacy();">I agree to the
                    above terms and am willing to participate in the research project >
                </div>
                <div style="text-decoration: underline; cursor: pointer;"
                     onclick="handle_critical_session_error('Terms Agreement Failure')">I disagree >
                </div>
            </div>
        </div>
        <div id="important-msg-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>⚠ Important Notices</b></div>
            <div style="margin-bottom: 10px; margin-top: 10px; max-width: 70%;">
                # Please ensure your headset remains on throughout the entire session.<br>
                # Please make an effort to minimize head movement during the session.<br>
                # Please refrain from using the mouse or keyboard unless given specific instructions to do so<br>
                # By clicking "I understand" below, your session initiation data will be transmitted to our recording
                server.<br>If you exit the session midway, you will not be able to restart it unless you are reassigned
                by the supervisor<br>
            </div>
            <div style="text-decoration: underline; cursor: pointer;" onclick="waiting_for_admin_auth();">I understand >
            </div>
            <div style="text-decoration: underline; cursor: pointer;"
                 onclick="handle_critical_session_error('Final Consent Failure');">I am not sure >
            </div>
        </div>
        <div id="admin-consent-div"
             style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none;">
            <div><b>Admin Authorization</b></div>
            <div id="admin-auth-msg" style="margin-top: 10px; text-align: center; max-width: 70%;">
                The administrator is reviewing the setup for session initiation.<br>
                Please stand by.
            </div>
            <div id="start-count-down"
                 style="font-family: sans-serif, Arial, Helvetica; display: none; text-align: center;">
                Session starts in 5 seconds
            </div>
        </div>
    </div>
    <div style="justify-content: center; align-items: center; flex-direction: column; height: 100%; display: none;"
         id="display-end-page">
        <div style="font-family: sans-serif, Arial, Helvetica; text-align: center;">Session completed, thank you.</div>
        <div style="font-family: sans-serif, Arial, Helvetica; text-decoration: underline; cursor: pointer;" onclick="exit_program()">Click to exit ></div>
    </div>
</div>
<div id="pre-fail-div"
     style="display: flex; justify-content: center; align-items: center; flex-direction: column; display: none; font-family: sans-serif, Arial, Helvetica; width: 100%; height: 100%;">
    <div><b>Critical Error</b></div>
    <div id="critical_error_msg" style="margin-bottom: 10px; color: darkred"></div>
    <div>Kindly seek assistance from our staff with the above error message.</div>
    <div style="text-decoration: underline; cursor: pointer;" onclick="exit_program()">Click to exit ></div>
</div>
<script>
    let events = [];
    let registered = 0;
    let critical_error = 0;
    let session_end = 0;
    let events_length = 0;

    var contentContainer = document.getElementById('content-container');
    var startFullscreenButton = document.getElementById('startFullscreenButton');
    var htmlContents = contentContainer.querySelectorAll('.html-content');
    var currentIndex = 0;
    var fullscreenRequested = false;

    function displayNextHtml() {
        if(session_end === 1 || critical_error === 1){
            return;
        }
        document.body.style.cursor = 'none';
        document.body.pointerEvents = 'none';
        document.getElementById("pre-check").style.display = 'none';
        contentContainer.style.display = 'block';
        htmlContents[currentIndex].style.display = 'block';
        let audioElement = htmlContents[currentIndex].querySelector("audio");
        if(audioElement){
            audioElement.play();
        }
        let timeout = document.getElementById('duration-' + currentIndex).value;
        currentIndex = (currentIndex + 1);
        if (currentIndex === (htmlContents.length)) {
            if(typeof save_records_interval !== 'undefined'){
                clearInterval(save_records_interval);
            }
            save_records("run");
            setTimeout(displayEnd, timeout)
        } else {
            setTimeout(displayNextHtml, timeout);
        }
    }

    function displayEnd() {
        document.body.style.cursor = 'auto';
        document.body.pointerEvents = 'all';
        contentContainer.style.display = 'none';
        document.getElementById('display-end-page').style.display = 'flex';
        session_end = 1;
        end_all_listener();
    }

    function headset_ready() {
        document.getElementById("headset-check").style.display = "none";
        document.getElementById("beep-check").style.display = "flex";
        intervalAudio = setInterval(function () {
            document.getElementById("beep-audio").play();
        }, 1000);
    }

    function audio_ready() {
        clearInterval(intervalAudio);
        document.getElementById("audio-check-div").style.display = "none";
        document.getElementById("legal-div").style.display = "flex";
    }

    function request_serial(){
        navigator.serial.requestPort()
            .then(port => {
                console.log("[System @ " + time_mil() + "] Serial permission granted.");
                document.getElementById("serial-div").style.display = "none";
                document.getElementById("fullscreen-div").style.display = "flex";
                console.log("[System @ " + time_mil() + "] Requesting fullscreen permission...")
            })
            .catch(error => {
                handle_critical_session_error("Serial Connection Failure")
            });
    }

    function enter_fullscreen() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
            document.documentElement.msRequestFullscreen();
        }

        if (function () {
            return (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
        }) {
            fullscreenRequested = true;
            console.log("[System @ " + time_mil() + "] Fullscreen enabled.")

            add_fullscreen_listener();

            document.getElementById("fullscreen-div").style.display = "none";
            document.getElementById("audio-check-div").style.display = "flex";

            start_recording();
        } else {
            handle_critical_session_error("Fullscreen Failure")
        }
    }

    function fullscreenChangeHandler() {
        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
        } else {
            handle_critical_session_error("Fullscreen Failure");
        }
    }

    function add_fullscreen_listener(){
        document.addEventListener('fullscreenchange', fullscreenChangeHandler);
        document.addEventListener('webkitfullscreenchange', fullscreenChangeHandler);
        document.addEventListener('mozfullscreenchange', fullscreenChangeHandler);
        document.addEventListener('MSFullscreenChange', fullscreenChangeHandler);
    }

    function end_fullscreen_listener(){
        document.removeEventListener('fullscreenchange', fullscreenChangeHandler);
        document.removeEventListener('webkitfullscreenchange', fullscreenChangeHandler);
        document.removeEventListener('mozfullscreenchange', fullscreenChangeHandler);
        document.removeEventListener('MSFullscreenChange', fullscreenChangeHandler);
    }

    function start_recording(){
        const urlParams = new URLSearchParams(window.location.search);
        const jobId = parseInt(urlParams.get('job-id'), 10);
        console.log("[System @ " + time_mil() + "] Starting session record...")
        let stopFn = rrweb.record({
            emit(event) {
                events.push(event);
                if (critical_error == 1 || session_end == 1) {
                    clearInterval(echo_event_interval);
                    stopFn();
                    console.log("[Recorder @ " + time_mil() + "] Session recording has stopped.");
                }
            },
        });

        function echo_event() {
            if(events.length !== events_length){
                console.log("[Recorder @ " + time_mil() + "] Data points collected:" + events.length);
                events_length = events.length;
            }
        }

        let echo_event_interval = setInterval(echo_event, 3000);
        console.log("[System @ " + time_mil() + "] Session recording started.");
    }

    function agree_privacy() {
        document.getElementById('legal-div').style.display = "none";
        document.getElementById("important-msg-div").style.display = "flex";
    }

    function waiting_for_admin_auth(){
        document.getElementById("important-msg-div").style.display = "none";
        document.getElementById("admin-consent-div").style.display = "flex";
        console.log("[System @ " + time_mil() + "] Requesting admin authorization...");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/business/fnirs2023/php/req_auth_job.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let dataObj = JSON.parse(data);
                    if (dataObj.length > 0) {
                        console.log("[System @ " + time_mil() + "] Admin auth requested.");
                        console.log("[System @ " + time_mil() + "] Waiting for admin auth...");

                        function check_admin_auth(){
                            let xhr = new XMLHttpRequest();
                            xhr.open("POST", "/business/fnirs2023/php/lookup_auth_job.php", true);
                            xhr.onload = () => {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        let data = xhr.response;
                                        let dataObj = JSON.parse(data);
                                        if (dataObj.length > 0) {
                                            if(dataObj[0].success===1){
                                                clearInterval(check_auth_interval);
                                                console.log("[System @ " + time_mil() + "] Authorized.");
                                                document.getElementById("admin-auth-msg").innerText = "Authorized";
                                                start_job();
                                            }else{
                                                clearInterval(check_auth_interval);
                                                handle_critical_session_error("Authorization Rejected")
                                            }
                                        }
                                    }
                                }
                            }
                            let formData = new FormData();
                            formData.append("job_id", <?php echo $job_id; ?>);
                            xhr.send(formData);
                        }

                        check_auth_interval = setInterval(check_admin_auth, 5000)

                    } else {
                        handle_critical_session_error("Authorization Failure");
                    }
                }
            }
        }
        let formData = new FormData();
        formData.append("job_id", <?php echo $job_id; ?>);
        xhr.send(formData);
    }

    function start_job() {
        console.log("[System @ " + time_mil() + "] Registering Session...");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/business/fnirs2023/php/start_job.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let dataObj = JSON.parse(data);
                    if (dataObj.length > 0) {
                        console.log("[System @ " + time_mil() + "] Registration Success.");
                        registered = 1;
                        document.body.style.cursor = 'none';
                        document.getElementById("start-count-down").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("start-count-down").innerText = 'Session starts in 4 seconds';
                        }, 1000);
                        setTimeout(function () {
                            document.getElementById("start-count-down").innerText = 'Session starts in 3 seconds';
                        }, 2000);
                        setTimeout(function () {
                            document.getElementById("start-count-down").innerText = 'Session starts in 2 seconds';
                        }, 3000);
                        setTimeout(function () {
                            document.getElementById("start-count-down").innerText = 'Session starts in 1 seconds';
                        }, 4000);
                        setTimeout(displayNextHtml, 5000);
                        start_saving_records();
                    } else {
                        handle_critical_session_error("Registration Failure");
                    }
                }
            }
        }
        let formData = new FormData();
        formData.append("job_id", <?php echo $job_id; ?>);
        xhr.send(formData);
    }

    function start_saving_records(){
        save_records("run");
        save_records_interval = setInterval(save_records("run"), 10*1000);
    }

    function save_records(action) {
        if (events.length === 0) {
            return 1;
        }

        const events_string = JSON.stringify({ events });
        const dataToSend = {
            events: events_string,
            job_id: <?php echo $job_id;?>,
            ip: "<?php echo $_SERVER['REMOTE_ADDR'];?>",
        };
        const body = JSON.stringify(dataToSend);

        fetch('https://www.sunrays.top/business/fnirs2023/php/save_record_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'User-Agent': navigator.userAgent,
            },
            body,
        })
            .then(response => {
                if (response.ok) {
                    console.log("[Recorder @ " + time_mil() + "] Data uploaded.");
                    events = [];
                    if(action==="exit"){
                        exit_program();
                    }
                    return 1;
                } else {
                    handle_critical_session_error("Record Upload Failure")
                    return 0;
                }
            })
            .catch(error => {
                handle_critical_session_error("Record Upload Failure");
                return 0;
            });
    }
</script>
</body>
</html>
