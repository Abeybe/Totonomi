<?php
define("HOST","mysql144.phy.lolipop.lan");
define("USER","LAA1211686");
define("PASS","fitTotonomifit");
define("DBNAME","LAA1211686-totonomi");
// define("HOST","localhost");
// define("USER","root");
// define("PASS","");
// define("DBNAME","ttnm");

class DbConnectionFactory{
    public static function connect(){
        try{
            $dsn=sprintf("mysql:host=%s;dbname=%s;charset=utf8;",HOST,DBNAME);//pdo_mysql.default_socket=/tmp/mysql.sock
            return new PDO($dsn, USER,PASS, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
?>