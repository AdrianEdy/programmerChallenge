<?php
    class Database
    {
        private $host;
        private $dbName;
        private $user;
        private $pass;
        private static $db;

        public function __construct()
        {
            $this->host     = SERVER;
            $this->dbName   = DB_NAME;
            $this->user     = USER_DB;
            $this->pass     = PASS_DB;
        }

        public function getDb()
        {
            if (self::$db == null) {
                self::$db = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->user
                , $this->pass);
            }
            return self::$db;
        }

        public function create($fillable, $request, $tableName)
        {               
            $valueCount = '';
            for ($i = 0; $i < count($request); $i++) {
                $valueCount .= '?';
                $valueCount .= count($request) == $i+1 ? '' : ',';
            }

            $sql = "INSERT INTO {$tableName} (" . implode(',', $fillable) . ") "
                 . "VALUE(" . $valueCount . ")";
                 
            $run = $this->getDb()->prepare($sql);
            return $run->execute($request);
        }

        public function getLimit($tableName, $select, $limit = null, $currentPage = null)
        {
            $sql = "SELECT " . implode(',', $select) . " "
                 . "FROM {$tableName}";

            if (!is_null($limit)) {
                $sql    .= " ORDER BY id DESC LIMIT {$limit}";
            }
            
            if (!is_null($currentPage)) {
                $offSet = ($currentPage-1)*10;
                $sql    .= " OFFSET {$offSet}";
            }

            $request = $this->getDb()->query($sql);
            return $request;
        }

        public function getAll($tableName, $select)
        {
            $sql = "SELECT " . implode(',', $select) . " "
                 . "FROM {$tableName}";

            $request = $this->getDb()->query($sql);
            return $request;
        }

        public function show($tableName, $id)
        {
            $sql = "SELECT * FROM {$tableName} WHERE id = {$id}";
            
            $request = $this->getDb()->query($sql)->fetch();
            return $request;
        }

        public function update($fillable, $request, $tableName)
        {   
            $set = '';

            $count = 1;
            foreach ($request as $key => $value) {
                if ($key == 'id') {
                    $count++;
                    continue;
                }
                $set .= "{$key}=:{$key}";
                if ($count < count($request)) {
                    $set .= ',';
                }
                $count++;
            }

            $sql = "UPDATE {$tableName} SET {$set} WHERE id=:id";
            $run = $this->getDb()->prepare($sql);
            $run->bindParam(':id', $request['id'], PDO::PARAM_INT);
            $run->bindParam(':title', $request['title'], PDO::PARAM_STR);
            $run->bindParam(':message', $request['message'], PDO::PARAM_STR);
            $run->bindParam(':image', $request['image'], PDO::PARAM_STR);

            return $run->execute();
        }

        public function delete($tableName, $id)
        {   
            $sql = "DELETE FROM {$tableName} WHERE id = {$id}";
            
            $request = $this->getDb()->query($sql);            
        }
    }
?>