<?php
  session_start();
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
?>

<?php
  if(isset($_POST["room-id"])){
    $roomDao=new RoomDao();
    if($roomDao->inRoomById($_POST["room-id"])){
      $_SESSION["USER-ID"]=$_POST["user-id"];
      header("Location: /check?room=".$_POST["room-id"],true);
    }
  }
  
  //重複のないユーザID生成
  //ToDo:ここでリロード繰り返すとDBあふれるので要改良
  $userDao=new UserDao();
  $userId=$userDao->createUniqUserId();

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

    <form action="./" method="POST">
      <input type="hidden" name="user-id" value="<?=$userId ?>" />
      <input type="text" name="room-id" value="" placeholder="" require/>
      <input type="submit" name="" value="参加する"/>
    </form>
    <a href="/create">宴会を企画する人はこちらから</a>

    <footer>
      <a class="common-fitlink" href="https://prodbyfit.com">prodbyfit.</a>
    </footer>

  </body>
</html>
