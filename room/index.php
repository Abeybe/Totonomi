<?php
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomUserDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/TableDao.php");
?>

<?php
  session_start();
  
  if(isset($_SESSION["ROOM-ID"])){
    //ルームIDがすでにあるかどうか
    $userId=$_SESSION["USER-ID"];
    $roomId=$_SESSION["ROOM-ID"];
    $dao=new RoomDao();
    if(!$dao->inRoomById($roomId)){
      header("Location: /");
    }
  }else{
    header("Location: /");
  }

  //roomManager.js読み込み後、peerJoinイベントから呼び出し(ajax)
  if(isset($_POST["ajax-skyway-peerid"])){
    $userDao=new UserDao();
    //skywayのpeerIdをDBに保存
    $userDao->updateSkywayPeerid($userId,$_POST["skyway-peerid"]);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($_POST["ajax-skyway-peerid"]);exit;
  }
  
  //tableManager.js読み込み後、changeイベントから呼び出し(ajax)
  if(isset($_POST["ajax-table-id"])){
    $tableDao=new TableDao();
    //tableIdの変更
    $tableDao->changeTable($roomId,$userId,$_POST["ajax-table-id"]);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($_POST["ajax-table-id"]);exit;
  }

  //部屋へ接続(joined_flagは1)
  //最初はエントランス(tableId=0)に移動//ToDo:
  $roomUserDao=new RoomUserDao();
  $roomUserDao->joinRoom($roomId,$userId);

  //テーブル情報一覧取得
  $tableDao=new TableDao();
  $tables=$tableDao->getAllTables($roomId);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/loader/inhead.loader.php") ?>
    <title>遠飲み ~トオトノミ~</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="/css/room.css"/>
    <script src="/_shared/key.js"></script>
    <script src="/js/deviceManager.js"></script>
    <script src="/js/roomManager.js"></script>
    <script src="/js/tableManager.js"></script>
    <script>
      var roomId="<?=$roomId ?>";
    </script>

  </head>
  <body>
    <h1>遠飲み ~トオトノミ~</h1>
    
    <div id="local-videos-area">
      <video id="local-video" class="local-video video-stream"></video>
    </div>

    <div id="remote-videos-area">
      <!-- <video class="remote-video video-stream"></video>
      <video class="remote-video video-stream"></video>
      <video class="remote-video video-stream"></video> -->
    </div>

    <div class="under-menu">

      <form >
        <select id="select-table" name="select-table">
        <?php foreach($tables as $table){?>
          <option value="<?=$table["TABLE_ID"] ?>">
            <?=$table["TABLE_NAME"] ?>
          </option>
        <?php } ?>
        </select>
      </form>
      
      <input id="camera-switch" type="button" value="カメラON"/>
      <input id="mic-switch" type="button" value="マイクON"/>
      <input type="button" value="画面共有"/>
      
      <form action="/check" metohd="POST">
        <input type="submit" value="退出"/>
      </form>
      
    </div>
  
    <script>
      deviceSetup().then(function(){
        peerJoin();
      });
    </script>
  </body>
</html>
