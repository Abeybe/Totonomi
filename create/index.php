<?php
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
?>

<?php
  session_start();
  
  //本ページ「次へ」押下時、DB上に部屋作成(SKYWAYの部屋は/roomで作成)
  if(isset($_POST["create-room"])){
    $_SESSION["USER-ID"]=$_POST["host-user-id"];
    header("Location: /check?room=".$_POST["room-id"]);exit;
  }
  
  //重複のないユーザID生成
  $userDao=new UserDao();
  $userId=$userDao->createUniqUserId();

  //重複のない部屋ID生成
  $roomDao=new RoomDao();
  $roomId=$roomDao->createUniqRoomId($userId);

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>
    <style>
      .share-link{
        width:640px;
      }
    </style>
  </head>
  <body>

    <!-- 独自DBでidの重複検知 -->

    <h1>遠飲み ~トオトノミ~</h1>
  
    <h3>いらっしゃいませ、宴会のご企画ですね。</h3>

    <?php//招待URLからの遷移と同じurlにしたいからget ?>
    <form action="./" method="POST">
      <!-- hiddenに取得したルームIDを保存 -->
      <p>
        <!-- ルームID(と有効期限情報)に紐づけて招待コード発行 -->
        <input type="hidden" name="room-id" value="<?=$roomId ?>"/>
        <input type="hidden" name="host-user-id" value="<?=$userId ?>"/>
        <input id="share_link" type="text" class="share-link"
          value="totonomi.prodbyfit.com/check?room=<?=$roomId ?>" disabled
          />
        <!-- クリックでコピー -->
        <input type="button" name="invite-code-copy" value="コピー"
          onclick="linkCopy('#share_link')"/>
      </p>
      <input type="submit" name="create-room" value="次へ"/>
    </form>
    <a href="/invited">宴会へ招待された方はこちらから</a>

  </body>
</html>
