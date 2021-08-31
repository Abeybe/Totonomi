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
    //TODO:文字化け対策その2：エンコード
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
  
  echo $_SESSION["CAMERA-ENABLED"];
  $cameraEnabled=(isset($_SESSION["CAMERA-ENABLED"]))?$_SESSION["CAMERA-ENABLED"]:"true";
  $micEnabled=(isset($_SESSION["MIC-ENABLED"]))?$_SESSION["MIC-ENABLED"]:"true";

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

    <script src="/js/roomMenuManager.js"></script>

    <script>
      let userId="<?=$userId ?>";
      let roomId="<?=$roomId ?>";
    </script>

  </head>
  <body>
    
    <article>

      <div id="remote-videos-area" class="remote-videos-area">
        <!-- <video class="remote-video video-stream" style="display:block !important" ></video>
        <video class="remote-video video-stream" style="display:block !important" ></video>
        <video class="remote-video video-stream" style="display:block !important" ></video> -->
      </div>

    </article>

    <!-- 折り畳みのチャットエリア -->
    <div id="room_slide_chat" class="room-blind room-chat">
      <div id="room_close_chat" class="room-close-chat">×</div>
      <div>
        <p>こんにちは</p>
        <p>Hello</p>
      </div>
    </div>

    <!-- 折り畳みの設定エリア -->
    <div id="room_slide_settings" class="room-blind room-settings">
      <div id="local-videos-area" class="local-videos-area">
        <video id="local-video" class="local-video video-stream"></video>
        <p>
          <input id="user-name" class="short" type="text" value="<?=$user["USER_NAME"]?>"/>
        </p>
      </div>
    </div>

    <!-- フッター兼操作エリア -->
    <footer class="under-menu">
      <ul class="inline-list">
        <li>      
          <form >
            <input id="camera-enabled" type="hidden" name="camera-enabled" value="<?=$cameraEnabled ?>"/>
            <input id="mic-enabled" type="hidden" name="mic-enabled" value="<?=$micEnabled ?>"/>

            <input type="text" style="display:none"/>
            <input id="room_hover_chat" class="room-text-chat" type="text" placeholder="メッセージを入力"/>
            
            <input id="camera-switch" class="short <?=($cameraEnabled=='true')?'active':'' ?>" 
              type="button" name="user-camera" value="<?=($cameraEnabled=='true')?'カメラON':'カメラOFF'?>"/>
            <input id="mic-switch" class="short <?=($micraEnabled=='true')?'active':'' ?>"
             type="button" name="user-mic" value="<?=($micEnabled=='true')?'マイクON':'マイクOFF'?>"/>
            <input id="share-screen" class="short" type="button" value="画面共有"/>
          </form> 
        </li>
        <li>
          <form>
            <input id="create_letter" class="short" type="button" name="" value="招待状を作成"/> 

            <select id="select-table" name="select-table">
              <?php foreach($tables as $table){?>
                <option value="<?=$table["TABLE_ID"] ?>">
                  <?=$table["TABLE_NAME"] ?>
                </option>
              <?php } ?>
            </select>
            <input id="room_click_settings" type="button" value="身だしなみ"/>
            <!-- <input class="short" type="submit" value="退出"/> -->
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
