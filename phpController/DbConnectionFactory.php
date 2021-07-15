<?php
define("HOST","localhost");
define("USER","root");
define("PASS","");
define("DBNAME","ttnm");

class DbConnectionFactory{
    public static function connect(){
        try{
            $dsn=sprintf("mysql: host=%s; dbname=%s; charset=utf8",HOST,DBNAME);
            return new PDO($dsn, USER,PASS, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
?>