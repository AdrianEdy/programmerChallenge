<?php
    class Board extends Model
    {   
        protected $tableName = 'boards';
        protected $fillable  = ['title', 'message', 'image', 'password'];
    }
?>