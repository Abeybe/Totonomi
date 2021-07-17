<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/phpController/DbConnectionFactory.php");

//会場への接続情報管理用クラス
//会場内のテーブル管理はTableDaoで行うが、初接続時にはここでテーブルIDを0に設定
class RoomUserDao{

    //================================================================//
    //外部ファイル(~index.php)呼び出し用メソッド
    //================================================================//

    //接続(もしくは仮接続(JOINED_FLAGを0にしておく))
    public function joinRoom(){
        //roomId,userIdをTTNM_ROOM_USERへINSERT

    }
    //切断
    public function leaveRoom(){
        //roomId,userIdをTTNM_ROOM_USERからDELETE
        //or JOINED_FLAGを0にUPDATE

    }

    //================================================================//
    //外部Dao(~Dao.php)呼び出し用メソッド
    //================================================================//

    
    
    //================================================================//
    //間接利用メソッド
    //================================================================//

    //すでに接続処理をしていたか
    //=roomId,userIdの組み合わせがDBにあるか
    public function inRoomUser(){

    }

}//RoomUserDao

?>