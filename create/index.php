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
    
    <link rel="stylesheet" href="css/style.css">

    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script>
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js" ></script>

    <script src="script.js"></script>

    <!-- <script src="js/face-api.min.js"></script> -->
    <!-- <script src="js/p5.min.js"></script> -->

  </head>
  <body>
      <h1>遠飲み ~トオトノミ~</h1>
    
      <h3>いらっしゃいませ、宴会のご企画ですね。</h3>

      <form action="/check" method="POST">
        <p>
          <input type="text" name="invide-code" value="https://totonomi.prodbyfit.com/room?id=XXXXXX"/>
          <input type="button" name="invite-code-copy" value="コピー"/>
        </p>
        <input type="submit" value="次へ"/>
      </form>
      <a href="/invited">宴会へ招待された方はこちらから</a>

  </body>
</html>
