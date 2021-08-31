<?php
  session_start();
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
?>

<?php
  //本ページ「次へ」押下時、DB上に部屋作成(SKYWAYの部屋は/roomで作成)
  if(isset($_POST["create-room"])){
    $_SESSION["USER-ID"]=$_POST["user-id"];
    header("Location: /check?room=".$_POST["room-id"]);exit;
  }
  
  //重複のないユーザID生成
  //ToDo:ここでリロード繰り返すとDBあふれるので要改良
  $userDao=new UserDao();
  $userId=$userDao->createUniqUserId();

  //重複のない部屋ID生成
  //ToDo:ここでリロード繰り返すとDBあふれるので要改良
  $roomDao=new RoomDao();
  $roomId=$roomDao->createUniqRoomId($userId);

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>

    <link rel="stylesheet" href="/css/create.css"/>
    <script src="/js/script.js"></script>

    <style>
      .share-link{
        width:120px;
      }
    </style>
    <script>
      let userId="<?=$userId ?>";
      let roomId="<?=$roomId ?>";
    </script>
  </head>
  <body>
    
    <article>
      <!-- <h1>遠飲み ~トオトノミ~</h1> -->
    
      <!-- <h3>いらっしゃいませ、宴会のご企画ですね。</h3> -->

      <img class="l-icon" src="/sources/common_logo_simple.png" />

      <?php//招待URLからの遷移と同じurlにしたいからget ?>
      <form action="./" method="POST">
        <!-- hiddenに取得したルームIDを保存 -->
        <!-- ルームID(と有効期限情報)に紐づけて招待コード発行 -->
        <input id="room_id" type="hidden" name="room-id" value="<?=$roomId ?>"/>
        <input id="user_id" type="hidden" name="user-id" value="<?=$userId ?>"/>
        <p>
          <input id="share_link" type="text" class="share-link"
            value="招待コード:<?=$roomId ?>" disabled
            />
        </p>
          <!-- <input type="button" name="invite-code-copy" value="コピー"
            onclick="linkCopy('#share_link')"/> -->
        <p>
          <input id="create_letter" class="long" type="button" name="" value="招待状を作成"/>
        </p>
        <p>
          <input class="long" type="submit" name="create-room" value="次へ"/>
        </p>
      </form>
      <a href="/invited">宴会へ招待された方はこちらから</a>
    </article>

    <?php include_once($_SERVER["DOCUMENT_ROOT"]."/popup/letter.php"); ?>

    <footer>
      <a class="common-fitlink" href="https://prodbyfit.com">prodbyfit.</a>
    </footer>

  </body>
</html>
