<!DOCTYPE html>
<html lang=”en”>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Name of your awesome camera app -->
    <title>Camera App</title>
    <!-- Link to your main style sheet-->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery/jquery.min.js');?>"></script>
    <!-- <script src="<?= baseUrl('assets/js/qrscanner.js');?>"></script>
    <script src="<?= baseUrl('assets/js/qrscanner-worker.js');?>"></script> -->
</head>

<body>
    <!-- Camera -->
    <main id="camera">
        <!-- Camera sensor -->
        <canvas id="camera--sensor"></canvas>
        <!-- Camera view -->
        <video id="camera--view" autoplay playsinline></video>
        <!-- Camera output -->
        <img src="//:0" alt="" id="camera--output">
        <!-- Camera trigger -->
        <button id="camera--trigger">Take a picture</button>

        <video id="vi" autoplay="true" src="http://192.168.1.12:4848"></video>
        <!-- <img name="main" id="main" border="0" width="640" height="480" > -->
        <input type="file" capture="camera">
        <img id = "img" src="">
    </main>
    <!-- Reference to your JavaScript file -->
    <!-- <script src="app.js"></script> -->
</body>

</html>
<script type="text/JavaScript">
    // navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
    
    console.log(navigator.mediaDevices.getUserMedia);
    // if(navigator.getUserMedia){
    //     navigator.getUserMedia({media:true}, handleVideo, videoError);
    // }
    var video = document.querySelector('#vi');
    // function handleVideo(stream){
    //     document.querySelector('#vi').src = window.URL.createObjectURL(stream);
    // }

    // function vidoeError(e){
    //     alert("Problem Occurs")
    // }
    // let scanner = new Instascan.Scanner({ video: document.getElementById('vi') });
    //   scanner.addListener('scan', function (content) {
    //     console.log(content);
    //   });
    
    var canvas = document.createElement("canvas");      
    var context = canvas.getContext("2d");
    $("#camera--trigger").on("click", function(){
        context.drawImage(video, 0, 0, video.clientHeight, video.clientWidth);
        console.log(video)
        var imgBase = canvas.toDataURL("image/png");
        var img = document.getElementById("img");
        img.src = imgBase;
    })

    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            video.srcObject = stream;
            
        })
        .catch(function (err0r) {
        console.log("Something went wrong!");
        });

    }

    function stop(e) {
        var stream = video.srcObject;
        var tracks = stream.getTracks();

        for (var i = 0; i < tracks.length; i++) {
            var track = tracks[i];
            track.stop();
        }

        video.srcObject = null;
    }

    
</script>