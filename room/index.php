<?php
  $_SESSION["ERROR_MESSAGE"]="";
  session_start();
  // if($_SERVER['REQUEST_METHOD'] != "POST"){
  //   $_SESSION["ERROR_MESSAGE"]="";
  // }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>遠飲み ~トオトノミ~</title>

    <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&amp;display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/css/default.css">

    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script>
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js" ></script>

    <script src="/script.js"></script>

    <!-- <script src="js/face-api.min.js"></script> -->
    <!-- <script src="js/p5.min.js"></script> -->

  </head>
  <body>
    <h1>遠飲み ~トオトノミ~</h1>
    
    <div id="local-videos-area">
      <video class="local-video video-stream">
    </div>

    <div id="remote-videos-area">
      <!-- <video class="local-video video-stream"> -->
    </div>

    <div class="user-menu">
      <form action="./" method="GET">
        <select name="select-table">
          <option value="">エントランス</option>
          <option value="">テーブル1</option>
        </select>
      </form>
      <input type="button" value="カメラON"/>
      <input type="button" value="マイクON"/>
      <input type="button" value="画面共有"/>
      <form action="/check" metohd="POST">
        <input type="submit" value="退出"/>
      </form>
    </div>

  </body>
</html>
