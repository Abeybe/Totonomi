<?php
include($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");

class RoomController{
    
    //IDがすでに存在するかどうかtrue/false
    public static function inRoomById($id){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare("SELECT COUNT(*) AS 'COUNT' FROM TTNM_ROOMS WHERE ID = ?");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result["COUNT"]>0;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }

    //ルーム作成
    public static function createRoom($roomId,$userId){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare("INSERT INTO TTNM_ROOMS (ROOM_ID,HOST_USER_ID) VALUES(?,?)");
            $stmt->execute(array($roomId,$userId));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }//

}//RoomContoller

?>