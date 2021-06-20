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
      <h1>遠飲み ~トオトノミ~</h1>
    
      <h3>それじゃ、またオンラインで</h3>

      <form action="/create" method="POST">
        <input type="submit" value="宴会を企画する"/>
      </form>
      <a href="/invited">宴会へ招待された方はこちらから</a>

  </body>
</html>
