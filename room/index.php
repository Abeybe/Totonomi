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
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>

    <link rel="stylesheet" href="/css/room.css"/>

  </head>
  <body>
    <h1>遠飲み ~トオトノミ~</h1>
    
    <div id="local-videos-area">
      <video class="local-video video-stream"></video>
    </div>

    <div id="remote-videos-area">
      <video class="remote-video video-stream"></video>
      <video class="remote-video video-stream"></video>
      <video class="remote-video video-stream"></video>
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
