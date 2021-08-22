<?php
  session_start();
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/UserDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/RoomUserDao.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/TableDao.php");
?>

<?php
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

  //SkyWayのPeerIdをユーザテーブルに保持
  //roomManager.js読み込み後、peerJoinイベントから呼び出し(ajax)
  if(isset($_POST["ajax-skyway-peerid"])){
    $userDao=new UserDao();
    //skywayのpeerIdをDBに保存
    $userDao->updateSkywayPeerid($userId,$_POST["ajax-skyway-peerid"]);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($_POST["ajax-skyway-peerid"]);exit;
  }
  
  //テーブル変更とそれに伴う表示Videoの変更
  //js変更イベント->phpでDBに反映->jsでvideoの表示非表示切り替え
  //tableManager.js読み込み後、changeイベントから呼び出し(ajax)
  if(isset($_POST["ajax-table-id"])){
    $tableDao=new TableDao();
    //tableIdの変更
    $tableDao->changeTable($roomId,$userId,$_POST["ajax-table-id"]);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($_POST["ajax-table-id"]);exit;
  }
  
  //
  //tableManager.js読み込み後、定期的に呼び出し(ajax)
  if(isset($_POST["ajax-get-usertable"])){
    $tableDao=new TableDao();
    $result=$tableDao->getUserIdAtMyTable($roomId,$userId);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($result);exit;
  }

  //userManager.js読み込み後、changeイベントで呼び出し(ajax)
  if(isset($_POST["ajax-change-username"])){
    $userDao=new UserDao();
    $userDao->updateUserName($userId,$_POST["ajax-change-username"]);
    header("Content-Type: application/json; charset=UTF-8"); 
    echo json_encode($_POST["ajax-change-username"]);exit;
  }

  //部屋へ接続(joined_flagは1)
  //最初はエントランス(tableId=0)に移動//ToDo:
  $roomUserDao=new RoomUserDao();
  $roomUserDao->joinRoom($roomId,$userId);

  //ユーザ情報取得
  $userDao=new UserDao();
  $user=$userDao->getUser($userId);
  // $roomUsers=$userDao->getUsersByRoomId($roomId);

  //テーブル情報一覧取得
  $tableDao=new TableDao();
  $tables=$tableDao->getAllTables($roomId);
  
  $cameraEnabled=(isset($_SESSION["CAMERA_ENABLED"]))?$_SESSION["CAMERA_ENABLED"]:"true";
  $micEnabled=(isset($_SESSION["MIC_ENABLED"]))?$_SESSION["MIC_ENABLED"]:"true";

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
    <script src="/js/userManager.js"></script>
    <script src="/js/script.js"></script>

    <script>
      let userId="<?=$userId ?>";
      let roomId="<?=$roomId ?>";
    </script>

  </head>
  <body>
    
    <article>

      <div id="remote-videos-area" class="remote-videos-area">
        <!-- <video class="remote-video video-stream"></video>
        <video class="remote-video video-stream"></video>
        <video class="remote-video video-stream"></video> -->
      </div>

      <div id="local-videos-area" class="local-videos-area">
        <video id="local-video" class="local-video video-stream"></video>
      </div>

    </article>

    <footer class="under-menu">

      <ul class="inline-list">
        <li>      
          <form >
            <input id="camera-enabled" type="hidden" name="camera-enabled" value="<?=$cameraEnabled ?>"/>
            <input id="camera-switch" type="button" name="user-camera" value="カメラON"/>
            <input id="mic-enabled" type="hidden" name="mic-enabled" value="<?=$micEnabled ?>"/>
            <input id="mic-switch" type="button" name="user-mic" value="マイクON"/>
            <input id="share-screen" type="button" value="画面共有"/>
          </form> 
        </li>
        <li>
          <form>
            <select id="select-table" name="select-table">
              <?php foreach($tables as $table){?>
                <option value="<?=$table["TABLE_ID"] ?>">
                  <?=$table["TABLE_NAME"] ?>
                </option>
              <?php } ?>
            </select>
            <input type="text" value="" style="display:none;" />
            <input id="user-name" type="text" value="<?=$user["USER_NAME"]?>"/>
          </form>
          <input id="create_letter" type="button" name="" value="招待状を作成"/>
        </li>
        <li>
          <form action="" metohd="">
            <input type="submit" value="退出"/>
          </form>        
        </li>
      </ul>

      <?php include_once($_SERVER["DOCUMENT_ROOT"]."/popup/letter.php"); ?>

    </footer>
  
    <?php//デバイスセットアップ後、SkyWay接続 ?>
    <script>
      deviceSetup().then(()=>{
        peerJoin();
      });
    </script>
  </body>
</html>
