<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");

//会場への接続情報管理用クラス
//会場内のテーブル管理はTableDaoで行うが、初接続時にはここでテーブルIDを0に設定
class RoomUserDao{

    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//

    //仮接続(JOINED_FLAGをdefaultの0にしておく)
    public function joinRoom($roomId,$userId){
        if($this->isUserJoined($roomId,$userId))return;
        //roomId,userIdをTTNM_ROOM_USERへINSERT
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "INSERT INTO TTNM_ROOM_USER (ROOM_ID,USER_ID,JOIN_FLAG) ".
                "VALUES (?,?,1) "
            );
            $stmt->execute(array(
                $roomId,
                $userId
            ));
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }
    //切断
    public function leaveRoom($roomId,$userId){
        //roomId,userIdをTTNM_ROOM_USERからDELETE
        //or JOINED_FLAGを0にUPDATE
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "DELETE FROM TTNM_ROOM_USER ".
                "WHERE ROOM_ID=? ". 
                "   AND USER_ID=?"
            );
            $stmt->execute(array(
                $roomId,
                $userId
            ));
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    //================================================================//
    //外部Dao(~Dao.php)呼び出し用メソッド
    //================================================================//

    
    
    //================================================================//
    //間接利用メソッド
    //================================================================//

    //すでに接続処理をしていたか
    //=roomId,userIdの組み合わせがDBにあるか
    //ToDo:userIdのみで検索
    public function isUserJoined($roomId,$userId){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "SELECT COUNT(*) AS 'COUNT' FROM TTNM_ROOM_USER ".
                "WHERE ROOM_ID=? ".
                "   AND USER_ID=?"
            );
            $stmt->execute(array(
                $roomId,
                $userId
            ));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result["COUNT"]>0;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }

}//RoomUserDao

?>