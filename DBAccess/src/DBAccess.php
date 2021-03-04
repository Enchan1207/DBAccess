<?php
    //
    // DB接続ユーティリティクラス
    //
    ini_set('display_errors', 'On');
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
                // 実行環境によって出力を振り分ける
                if(array_key_exists("HTTP_HOST", $_SERVER)){
                    print("<b>ERROR!</b> couldn't establish connection to database.<br>Terminated<br>");
                }else{
                    print("\033[31mERROR!\033[0m couldn't establish connection to database:\n");
                    print($e->getMessage()."\n");
                    print("Terminated\n");
                }
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
