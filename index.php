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

    <link rel="stylesheet" href="/css/top.css"/>

    <title>遠飲</title>
  </head>
  <body>
    <article>
      <!-- <h1>遠飲み TOTONOMI</h1> -->
      <!-- <h3>それじゃ、またオンラインで</h3> -->

      <img class="l-icon" src="/sources/common_logo_simple.png" />

      <form action="/create" method="POST">
        <input type="submit" class="btn-cloud-simple" value="宴会を企画する"/>
      </form>
      <a href="/invited">宴会へ招待された方はこちらから</a>
    </article>

    <footer>

    </footer>

  </body>
</html>
