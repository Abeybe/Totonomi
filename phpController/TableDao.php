<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");

//会場内のテーブル管理用クラス
class TableDao{

    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//
    
    //テーブル移動
    public function changeTable($roomId,$userId,$tableId){

    }

    //================================================================//
    //外部Dao(~Dao.php)呼び出し用メソッド
    //================================================================//
    
    //テーブル生成(会場作成時に呼び出し)
    public function createTables($roomId){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $tableNum=$this->getTableNum($roomId);
            for($i=0;$i<$tableNum;$i++){
                $tableName=
                    ($i==0)?"ENTRANCE":(
                        ($i==1)?"STAGE":
                        "TABLE".($i-1)
                    );
                $stmt=$dao->prepare(
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
            $dao=(new DbConnectionFactory())->connect();   
            $stmt=$dao->prepare(
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