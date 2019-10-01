<?php
    class Model
    {
        protected $tableName;
        private $database;

        public function __construct()
        {
            $db             = new Database();
            $this->database = $db;
        }
        
        public function insert($request)
        {
            return $this->database->create($this->fillable, $request, $this->tableName);
        }

        public function showAll($select = ['*'])
        {   
            return $this->database->getAll($this->tableName, $select);
        }

        public function showLimit($select = ['*'], $currentPage = null, $limit = null)
        {   
            return $this->database->getLimit($this->tableName, $select, $limit, $currentPage);
        }

        public function show($id)
        {   
            return $this->database->show($this->tableName, $id);
        }

        public function update($request)
        {
            $this->database->update($this->fillable, $request, $this->tableName);
        }

        public function delete($id)
        {   
            return $this->database->delete($this->tableName, $id);
        }
    }
    
?>