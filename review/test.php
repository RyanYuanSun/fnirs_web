<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record and Replay Interactions</title>
</head>
<body>
<h1>Record and Replay Interactions</h1>

<!-- Button to start recording -->
<button id="startRecording">Start Recording</button>

<!-- Button to stop recording -->
<button id="stopRecording" disabled>Stop Recording</button>

<!-- Button to replay recorded interactions -->
<button id="replay">Replay</button>

<!-- Container to replay interactions -->
<div id="rrweb-container"></div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rrweb@latest/dist/rrweb.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/rrweb@latest/dist/rrweb.min.js"></script>
<script>
    let rrwebRecord;
    let rrwebPlayer;

    const startRecordingButton = document.getElementById('startRecording');
    const stopRecordingButton = document.getElementById('stopRecording');
    const replayButton = document.getElementById('replay');
    const rrwebContainer = document.getElementById('rrweb-container');

    startRecordingButton.addEventListener('click', () => {
        rrwebRecord = new rrweb.Record({
            emit(event) {
                // Handle recorded events as they happen (optional)
            },
        });

        rrwebRecord.start();

        startRecordingButton.disabled = true;
        stopRecordingButton.disabled = false;
        replayButton.disabled = true;
    });

    stopRecordingButton.addEventListener('click', () => {
        rrwebRecord.stop();

        startRecordingButton.disabled = false;
        stopRecordingButton.disabled = true;
        replayButton.disabled = false;
    });

    replayButton.addEventListener('click', () => {
        if (rrwebPlayer) {
            rrwebPlayer.destroy();
        }

        rrwebPlayer = new rrweb.Player({
            target: rrwebContainer,
            data: rrwebRecord.get(),
        });

        rrwebPlayer.play();
    });
</script>
</body>
</html>
