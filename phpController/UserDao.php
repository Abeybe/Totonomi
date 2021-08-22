<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/IdGenerator.php");

class UserDao{
    
    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//

    //一意なユーザID生成・登録
    public function createUniqUserId(){
        $generator=new IdGenerator();
        $id=$generator->createId();
        while(!$this->createUser($id)){
            $id=$generator->createId();
        } 
        return $id;
    }

    //ユーザIDによるユーザ情報取得
    public function getUser($userId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "SELECT ".
                "   USER_ID".
                "   ,USER_NAME".
                "   ,SKYWAY_PEERID ".
                "FROM TTNM_USERS ".
                "WHERE USER_ID = ?"
            );
            $stmt->execute(array($userId));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    //会場IDによるユーザ情報一覧取得
    public function getUsersByRoomId($roomId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "SELECT ".
                "   TU.USER_ID ".
                "   ,USER_NAME ".
                "   ,SKYWAY_PEERID ".
                "FROM TTNM_USERS AS TU".
                "   JOIN TTNM_ROOM_USER AS TRU ".
                "       ON TU.USER_ID=TRU.USER_ID ".
                "WHERE ROOM_ID = ?"
            );
            $stmt->execute(array($roomId));
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }
    
    //名前データ登録
    public function updateUserName($userId,$userName){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "UPDATE TTNM_USERS ".
                "SET USER_NAME=? ".
                "WHERE USER_ID=?"
            );
            $stmt->execute(array(
                $userName,
                $userId
            ));
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }
    
    //SkyWayのID取得(PeerId)
    public function updateSkywayPeerid($userId,$peerId){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "UPDATE TTNM_USERS ".
                "SET SKYWAY_PEERID=? ".
                "WHERE USER_ID=?"
            );
            $stmt->execute(array(
                $peerId,
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
    
    //ユーザID登録 一意で登録できればtrue、できなければfalseを返却
    public function createUser($userId){
        if($this->inUserById($userId))return false;
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "INSERT INTO TTNM_USERS "
                ."(USER_ID) "
                ."VALUES(?)"
            );
            $stmt->execute(array($userId));
            return true;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }//

    //IDがすでに存在するかどうかtrue/false
    public function inUserById($id){
        try{
            $con=(new DbConnectionFactory())->connect();
            $stmt=$con->prepare(
                "SELECT COUNT(*) AS 'COUNT' ".
                "FROM TTNM_USERS ".
                "WHERE USER_ID = ?");
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