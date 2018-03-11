<?php
/*
    PDOでデータベース接続
*/
function connect()
{
    require_once(__DIR__.'/dbsetting.php');
    $pdo = null;
    try{
        $pdo = new PDO($dsn, $dbuser, $dbpass);
    } catch(PDOException $e){
        exit('ERROR:'.$e->getMessage());
    }
    return $pdo;
}