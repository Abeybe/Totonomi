<?php
  session_start();
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
?>

<?php
  if(isset($_POST["join-room"])){
    $userDao=new UserDao();
    $userDao->updateUserName($_POST["user-id"],$_POST["user-name"]);
    
    $_SESSION["USER-ID"]=$_POST["user-id"];
    $_SESSION["ROOM-ID"]=$_POST["room-id"];

    $_SESSION["CAMERA-ENABLED"]=$_POST["camera-enabled"];
    $_SESSION["MIC-ENABLED"]=$_POST["mic-enabled"];

    header("Location: /room");exit;
  }

  //urlに部屋IDが含まれている&有効なIDであるか
  $roomDao=new RoomDao();
  if(!isset($_GET["room"])){
    header("Location: /");
  }else if(!$roomDao->inRoomById($_GET["room"])){
    header("Location: /");
  }
  
  //ユーザIDがなければ作成(リンクから飛んだ場合)
  if(isset($_SESSION["USER-ID"])){
    $userId=$_SESSION["USER-ID"];
  }else{
    $userDao=new UserDao();
    $userId=$userDao->createUniqUserId();
  }
  $roomId=$_GET["room"];
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>

    <link rel="stylesheet" href="/css/check.css" />

    <title>遠飲み ~トオトノミ~</title>

    <script src="/js/popup.js"></script>
    <script src="/js/deviceManager.js"></script>
  </head>
  <body>
      <!-- Skywayで発行した(もしくは招待コードの)IDとここでの情報を独自DBに保存 -->

    <article>
      <!-- <form action="/room" method="POST"> -->
      <!-- 入力チェックのため、このページへリダイレクト(#1) -->
      <form action="./" method="POST">
        <!-- PHP情報 -->
        <input type="hidden" name="room-id" value="<?=$roomId ?>"/>
        <input type="hidden" name="user-id" value="<?=$userId ?>"/>
        <input id="camera-enabled" type="hidden" name="camera-enabled" value="true"/>
        <input id="mic-enabled" type="hidden" name="mic-enabled" value="true"/>

        <div class="check-settings">
            <video id="local-video"></video>
            <input id="camera-switch" class="short" type="button" name="user-camera" value="カメラON"/>
            <input id="mic-switch" class="short" type="button" name="user-mic" value="マイクON"/>
        </div>
        <div class="check-settings">
          <!-- <label>名前を保存
            <input type="checkbox">
          </label> -->
          <input type="text" name="user-name" placeholder="おなまえ / NAME"/>
          <p>
            <input id="create_letter" class="long" type="button" name="" value="招待状を作成"/>
          </p>
        </div>

        <p>
          <input type="submit" name="join-room" value="入場"/>
        </p>
      </form>
    </article>

    <footer>
      <a class="common-fitlink" href="https://prodbyfit.com">prodbyfit.</a>
    </footer>
    
    
    <?php include_once($_SERVER["DOCUMENT_ROOT"]."/popup/letter.php"); ?>
    <script>
      deviceSetup();
    </script>
  </body>
</html>
