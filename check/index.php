<?php
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomUserDao.php");
?>

<?php
  session_start();

  if(isset($_POST["join-room"])){
    $userDao=new UserDao();
    $userDao->insertName($_POST["user-id"],$_POST["user-name"]);

    $_SESSION["ROOM-ID"]=$_POST["room-id"];
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

  //DB上のROOMへ接続処理//ToDo:
  $roomUserDao=new RoomUserDao();
  $roomUserDao->insertRoomUser($roomId,$userId);
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>
    <script src="/js/deviceManager.js"></script>
  </head>
  <body>
      <h1>遠飲み ~トオトノミ~</h1>
    
      <h3>お名前をご記入ください。</h3>

      <video id="local-video">
      </video>

      <!-- Skywayで発行した(もしくは招待コードの)IDとここでの情報を独自DBに保存 -->

      <!-- <form action="/room" method="POST"> -->
      <!-- 入力チェックのため、このページへリダイレクト(#1) -->
      <form action="./" method="POST">
        <input type="hidden" name="room-id" value="<?=$roomId ?>"/>
        <input type="hidden" name="user-id" value="<?=$userId ?>"/>
        <input type="text" name="user-name" placeholder="おなまえ / NAME"/>
        <input id="camera-switch" type="button" name="user-camera" value="カメラON"/>
        <input id="mic-switch" type="button" name="user-mic" value="マイクON"/>
        <label>名前を保存
          <input type="checkbox">
        </label>
        <input type="submit" name="join-room" value="入場"/>
      </form>
      <!-- <a href="/invited">宴会へ招待された方はこちらから</a> -->

  </body>
</html>
