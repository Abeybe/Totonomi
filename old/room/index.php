<?php
    
    session_start();
    
    if(isset($_POST["join"])){
      if(empty($_POST["user-name"] || empty($_POST["room-id"]))){
        $_SESSION["ERROR_MESSAGE"]="入力情報が不足しています";
        header("Location: ../");
      }
    }else {
      header("Location: ../");exit;
    }

    if($_SERVER['REQUEST_METHOD'] != "POST"){
      $_SESSION["ERROR_MESSAGE"]="不正なアクセスです。";
      header("Location: ../");
    }
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

    <!-- <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js" ></script>-->
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-4.3.0.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script>

    <script src="../_shared/key.js"></script>
    <script>
        let phpUserCamera='<?=$_POST["camera"] ?>';
        let phpUserMic='<?=$_POST["mic"] ?>';

        let phpRoomId='<?=$_POST["room-id"] ?>';
        let phpUserName='<?=$_POST["user-name"] ?>';
        let phpUserStatus='<?=($_POST["user-status"]==true)?"HOST":"" ?>';
        let phpMaxNum='<?=($_POST["user-status"]==true)?$_POST["max-num"]:"" ?>';

        let themes=[
          {name:"beer",img:"beer.png",audio:"soda.mp3"},
          {name:"wine",img:"wine.png",audio:"wine.wav"},
          {name:"coke",img:"coke.png",audio:"soda.mp3"},
          {name:"soda",img:"soda.png",audio:"soda.mp3"}
        ];
        let theme=themes[Math.floor(Math.random()*themes.length)];
    </script>
    <script src="js/room.js"></script>
    <script src="js/tableManager.js"></script>

    <!-- <script src="js/face-api.min.js"></script> -->
    <!-- <script src="js/p5.min.js"></script> -->

  </head>
  <body>
    <div id="toppage">
        <a href="/"><h3>遠飲み</h3></a>
    </div>

    <div id="room">
        <div id="remote-stream-area">

        </div>    
        
        <div id="table-select">
          <p>参加するテーブルを選んでください。</p>
          <select>
            <option>準備中</option>
          </select>
        </div>

        <div id="local-stream">
          <video id="local-video"></video>
          <img class="device-icon"/>
          <!-- <input type="range" id="local-mycamera" /> -->
          <p class="device-switch">
            <label id="video-switch">カメラ
              <input type="checkbox" form="status" name="camera" checked="true" id="video-switch-check" />
            </label>
            <label id="audio-switch">マイク
              <input type="checkbox" form="status" name="mic" checked="true" id="audio-switch-check" />
            </label>
          </p>
        </div>

    </div>
        
    <div id="loading">
      <!-- <img src="../img/wine.png"/>    -->
      <audio src="../sources/wine.wav" id="loading-music" playsinline></audio>
    </div>
    <script>
        $(window).on("load",function(){
          var audio=$("#loading-music").get(0);
          var isPlaying;
          $("#loading").css("background-image","url(../img/"+theme["img"]+")");
          audio.src="../sources/"+theme["audio"];
          audio.playsInline=true;
          audio.defaultPlayBackRate=2;
          try{
            audio.play();isPlaying=true;
          }catch(e){}
          $("#loading").delay(1000).fadeOut(5000,"swing",function(){
            // $(this).remove();
            $(this).css("display","none");
            if(isPlaying){
              audio.pause();
              isPlaying=false;
            }
          });
        });
      </script>   
  </body>
</html>