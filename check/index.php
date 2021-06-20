<?php
  $_SESSION["ERROR_MESSAGE"]="";
  session_start();
  // if($_SERVER['REQUEST_METHOD'] != "POST"){
  //   $_SESSION["ERROR_MESSAGE"]="";
  // }
?>

<?php
  //#1 リダイレクト時の入力チェック

  //入力に不備がなければ
  //roomへ遷移

  //入力に不備があれば
  //エラー出力処理
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>
  </head>
  <body>
      <h1>遠飲み ~トオトノミ~</h1>
    
      <h3>お名前をご記入ください。</h3>

      <!-- Skywayで発行した(もしくは招待コードの)IDとここでの情報を独自DBに保存 -->

      <!-- <form action="/room" method="POST"> -->
      <!-- 入力チェックのため、このページへリダイレクト(#1) -->
      <form action="/" method="POST">
        <input type="text" name="user-name" placeholder="おなまえ / NAME"/>
        <input type="button" name="user-camera" value="カメラON"/>
        <input type="button" name="user-mic" value="マイクON"/>
        <label>名前を保存
          <input type="checkbox">
        </label>
        <input type="submit" value="入場"/>
      </form>
      <!-- <a href="/invited">宴会へ招待された方はこちらから</a> -->

  </body>
</html>
