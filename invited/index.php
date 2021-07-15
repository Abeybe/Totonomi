<?php
  include($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomController.php");
?>

<?php
  $_SESSION["ERROR_MESSAGE"]="";
  session_start();
  
  $con=new RoomController();
  if(isset($_POST["invite_code"])){
    $id=$_POST["invite_code"];
    //ルームIDが存在するか
    if($con->inRoomById($id)){
      echo "あるよ";
      //入室処理
      header("Location: /check?id=".$id);
    }else{
      echo "ないよ";
      //
    }
  }

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
        <input type="text" name="invite_code" value="" placeholder="" require/>
        <input type="submit" value="宴会を企画する"/>
      </form>
      <a href="/create">宴会を企画する人はこちらから</a>

  </body>
</html>
