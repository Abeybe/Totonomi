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
  </head>
  <body>

    <!-- skywayでid発行(仮にルーム作成をする) @js -->

    <h1>遠飲み ~トオトノミ~</h1>
  
    <h3>いらっしゃいませ、宴会のご企画ですね。</h3>

    <form action="/check" method="POST">
      <!-- hiddenに取得したルームIDを保存 -->
      <input type="hidden" name="room-id" value=""/>
      <p>
        <!-- ルームID(と有効期限情報)に紐づけて招待コード発行 -->
        <input type="text" name="invide-code" 
          value="https://totonomi.prodbyfit.com/room?id=XXXXXX" disabled
        />
        <!-- クリックでコピー -->
        <input type="button" name="invite-code-copy" value="コピー"/>
      </p>
      <input type="submit" value="次へ"/>
    </form>
    <a href="/invited">宴会へ招待された方はこちらから</a>

  </body>
</html>
