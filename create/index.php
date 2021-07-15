<?php
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomController.php");
?>

<?php
  session_start();

  //独自DBでROOM-IDの重複検知

  //仮に接続
  //ルームIDがすでにあるかどうか
  $con=new RoomController();
  $id=uniqid();//時刻(mm)に基づいた一意な値
  while($con->inRoomById($id)){
    $id=uniqid();
  }
  
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
    <form action="/check" method="GET">
      <!-- hiddenに取得したルームIDを保存 -->
      <p>
        <!-- ルームID(と有効期限情報)に紐づけて招待コード発行 -->
        <input type="hidden" name="invite_code" value="<?=$id ?>"/>
        <input type="text" class="share-link"
          value="https://totonomi.prodbyfit.com/check?id=<?=$id ?>" disabled
        />
        <!-- クリックでコピー -->
        <input type="button" name="invite-code-copy" value="コピー"/>
      </p>
      <input type="submit" value="次へ"/>
    </form>
    <a href="/invited">宴会へ招待された方はこちらから</a>

  </body>
</html>
