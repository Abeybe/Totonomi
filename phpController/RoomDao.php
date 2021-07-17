<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/IdGenerator.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/TableDao.php");

//会場管理用クラス
class RoomDao{
    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//

    public function createUniqRoomId($userId){
        $generator=new IdGenerator();
        $id=$generator->createId();
        while(!$this->createRoom($id,$userId)){
            $id=$generator->createId();
        }
        return $id;
    }

    //================================================================//
    //外部Dao(~Dao.php)呼び出し用メソッド
    //================================================================//


    //================================================================//
    //間接利用メソッド
    //================================================================//

    //会場ID登録 一意で登録できればtrue、できなければfalseを返却
    public function createRoom($roomId,$hostUserId){
        if($this->inRoomById($roomId))return false;
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "INSERT INTO TTNM_ROOMS ".
                "(ROOM_ID,HOST_USER_ID,MEMBER_NUM,TABLE_NUM) ".
                "VALUES(?,?,30,6)"
            );
            $stmt->execute(array($roomId,$hostUserId));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            //テーブル作成(TableDao)
            $tableDao=new TableDao();
            $tableDao->createTables($roomId);

            return true;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }//

    
    //IDがすでに存在するかどうかtrue/false
    public function inRoomById($id){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "SELECT COUNT(*) AS 'COUNT' FROM TTNM_ROOMS WHERE ROOM_ID = ?"
            );
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result["COUNT"]>0;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }

}//RoomContoller

?>