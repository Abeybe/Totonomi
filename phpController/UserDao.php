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
    
    //名前データ登録
    public function insertName($userId,$userName){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "UPDATE TTNM_USERS ".
                "SET USER_NAME=? ".
                "WHERE USER_ID=?"
            );
            $stmt->execute(array(
                $userName,
                $userId
            ));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result["COUNT"]>0;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
    }

    public function insertSkywayPeerid($userId,$peerId){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "UPDATE TTNM_USERS ".
                "SET SKYWAY_PEERID=? ".
                "WHERE USER_ID=?"
            );
            $stmt->execute(array(
                $peerId,
                $userId
            ));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
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
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare(
                "INSERT INTO TTNM_USERS "
                ."(USER_ID) "
                ."VALUES(?)"
            );
            $stmt->execute(array($userId));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return true;
        }catch(DAOException $e){
            echo $e->getMassage();
        }
        return false;
    }//

    //IDがすでに存在するかどうかtrue/false
    public function inUserById($id){
        try{
            $dao=(new DbConnectionFactory())->connect();
            $stmt=$dao->prepare("SELECT COUNT(*) AS 'COUNT' FROM TTNM_USERS WHERE USER_ID = ?");
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