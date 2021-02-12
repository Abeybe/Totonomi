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

      <?=$_SESSION["ERROR_MESSAGE"];?>
      <div id="entry">
        <form id="status" action="room/" method="POST">
          <p>
            <label>
              <input type="radio" name="user-status" value="" checked="checked"/>
              会場に参加する
            </label>
            <label>
              <input type="radio" name="user-status" value="host"/>
              会場を作成する
            </label>
          </p>
          <p><label>
            <select id="max-num" name="max-num" style="display:none">
              <option value="" selected disabled>最大参加人数を指定してください。</option>
              <option value="6">6人(3テーブル)</option>
              <option value="12">12人(6テーブル)</option>
            </select>
          </label></p>
          <p><label>名前
            <input type="text" id="user-name" name="user-name" placeholder="あなたの名前を入力してください" />
          </label></p>
          <p><label>会場ID
            <input type="text" id="room-id" name="room-id" placeholder="参加する会場のIDを入力してください" />
          </label></p>
          <p><label>
            <input type="submit" id="join" name="join" value="入場" />
          </label></p>   
          <script>
            $("input[name='user-status']:radio").on("change",function(){
              var status=$(this).val();
              $("input#room-id").attr("placeholder",(status=="host")?
                "作成する会場のIDを入力してください。":
                "参加する会場のIDを入力してください。"
              );
              $("input#join").val((status=="host")?
                "作成":
                "入場"
              );
              $("select#max-num").css("display",(status=="host")?
                "block":"none"
              );
            });
          </script>
        </form>
      </div>

      <div id="descript">
        <a>操作説明</a>
        <div id="descript-click" style="display:none">
          <h5>幹事の方</h5>
            <p>会場ID(アルファベット)を指定してください。</p>
          <h5>参加者の方</h5>
            <p>...</p>
        </div>
      </div>
      <script>
        var descriptEnabled=false;
        $("#descript a").on("click",function(){
          descriptEnabled=!descriptEnabled;
          $("#descript a").text((descriptEnabled)?"操作説明を閉じる":"操作説明");
          $("#descript-click").css("display",(descriptEnabled)?"block":"none");
        });
      </script>

      <div id="overview">
          <h3>遠飲み とは</h3>
          <div>
            <p>宴会に特化したWeb会議サービスです。</p>
            <p>会場内の「テーブル」ごと2人～4人程度のグループ単位で会話を楽しんでください。</p>
            <p>近くのテーブルの会話も少しずつ聞こえてきます。
            興味ある話題が聞こえたらテーブルを移動してみましょう。</p>
            <p>※全員へのスピーチをするには、「司会席」で話す必要があります。</p>
            <p>　</p>
            <p>トオトノミ・・・「遠くにいる人と飲みたい！」そんな思いから名付けました。</p>
            <p>開発されたのは静岡県西部、通称「遠州地域」に位置する とある大学。
            この場所は昔、トオトウミと呼ばれていたそうで......</p>
          </div>
      </div>

  </body>
</html>
