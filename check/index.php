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
    
      <h3>お名前をご記入ください。</h3>

      <form action="/room" method="POST">
        <input type="text" name="user-name" placeholder="おなまえ / NAME"/>
        <input type="button" name="user-camera" value="カメラON"/>
        <input type="button" name="user-mic" value="マイクON"/>
        <label>名前を保存
          <input type="checkbox">
        </label>
        <input type="submit" value="入場"/>
      </form>
      <!-- <a href="/invited">宴会へ招待された方はこちらから</a> -->

  </body>
</html>
