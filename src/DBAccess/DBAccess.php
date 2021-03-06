<?php
//
// DB接続ユーティリティクラス
//
namespace DBAccess;

use DBAccess\Exception\ConnectionException;
use PDO, PDOException;

class DBAccess{
    private $pdo;
    private $stmt;

    function __construct($dsn, $user, $pass){
        // PDO初期化
        try {
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"
            ];
            $pdo = new PDO($dsn, $user, $pass, $options);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this -> pdo = $pdo;
        } catch (PDOException $e) {
            throw new ConnectionException("Couldn't establish connection to database.", 0, $e);
        }
    }

    // SQL実行
    function execute($sql, $bindarray){
        if(is_null($this->pdo)){
            return;
        }

        $this->stmt = $this->pdo->prepare($sql);
        foreach ($bindarray as $key => $value) {
            $this->stmt->bindValue(":$key", $value);
        }
        $this->stmt->execute();
    }

    // fetch
    function fetchAll(){
        if(is_null($this->stmt)){
            return [];
        }

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
