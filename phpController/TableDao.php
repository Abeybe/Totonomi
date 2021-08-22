<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");

//会場内のテーブル管理用クラス
class TableDao{

    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//

    //テーブル一覧取得
    public function getAllTables($roomId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "SELECT TABLE_ID,TABLE_NAME,TOPIC ".
                "FROM TTNM_TABLES ". 
                "WHERE ROOM_ID=?"
            );
            $stmt->execute(array(
                $roomId
            ));
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    //テーブル移動
    //ToDo:該当情報がない場合のことを考えるべきか
    public function updateTopic($roomId,$tableId,$topic){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "UPDATE TTNM_TABLES SET TOPIC=? ".
                "WHERE ROOM_ID=? AND TABLE_ID=? "
            );
            $stmt->execute(array(
                $topic,
                $roomId,
                $tableId
            ));
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }
    
    //テーブル移動
    //ToDo:該当情報がない場合のことを考えるべきか
    public function changeTable($roomId,$userId,$tableId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "UPDATE TTNM_ROOM_USER SET TABLE_ID=?".
                "WHERE ROOM_ID=? ".
                "   AND USER_ID=? "
            );
            $stmt->execute(array(
                $tableId,
                $roomId,
                $userId
            ));
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    //自分のテーブルのユーザID一覧情報取得
    public function getUserIdAtMyTable($roomId,$userId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "SELECT ".
                "   TU.USER_ID, SKYWAY_PEERID, TABLE_ID ".
                "FROM TTNM_ROOM_USER AS TRU".
                "   JOIN TTNM_USERS AS TU".
                "       ON TRU.USER_ID=TU.USER_ID ".
                "WHERE ROOM_ID=? ".
                "   AND TU.USER_ID<>? ".
                "   AND TABLE_ID IN (".
                "       SELECT TABLE_ID FROM TTNM_ROOM_USER WHERE USER_ID=?".
                "   )"
            );
            $stmt->execute(array(
                $roomId,
                $userId,
                $userId
            ));
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    // //ユーザのテーブル情報取得
    // public function getUserTable($roomId,$userId){
    //     try{
    //         $con=(new DbConnectionFactory())->connect();
    //         $stmt=$con->prepare(
    //             "SELECT ".
    //             "   IF(
    //                    TABLE_ID IN (SELECT TABLE_ID FROM TTNM_ROOM_USER WHERE USER_ID=?)
    //                    ,1,0
    //                 ) AS MYTABLE_FLAG".
    //             "   ,USER_ID ".
    //             "   ,TABLE_ID ".
    //             "FROM TTNM_ROOM_USER ". 
    //             "WHERE ROOM_ID=? ".
    //             "ORDER BY MYTABLE_FLAG DESC"
    //         );
    //         $stmt->execute(array(
    //             $userId,
    //             $roomId
    //         ));
    //         $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $result;
    //     }catch(DAOException $e){
    //         echo $e->getMassage();
    //     }
    // }

    //================================================================//
    //外部Dao(~Dao.php)呼び出し用メソッド
    //================================================================//
    
    //テーブル生成(会場作成時に呼び出し)
    public function createTables($roomId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $tableNum=$this->getTableNum($roomId);
            for($i=0;$i<$tableNum;$i++){
                $tableName=
                    ($i==0)?"ENTRANCE":(
                        ($i==1)?"STAGE":
                        "TABLE".($i-1)
                    );
                $stmt=$con->prepare(
                    "INSERT INTO TTNM_TABLES (ROOM_ID,TABLE_ID,TABLE_NAME) ".
                    "VALUES(?,?,?)"
                );
                $stmt->execute(array($roomId,$i+1,$tableName));
            }             
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    //================================================================//
    //間接利用メソッド
    //================================================================//

    //会場IDからテーブル数を取得
    public function getTableNum($roomId){
        try{
            $con=(new DbConnectionFactory())->connect();   
            $stmt=$con->prepare(
                "SELECT TABLE_NUM FROM TTNM_ROOMS WHERE ROOM_ID=?"
            );
            $stmt->execute(array($roomId));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result["TABLE_NUM"];
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

}//RoomContoller

?>