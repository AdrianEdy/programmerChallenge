<?php
    class BoardValidation extends Validation
    {   
        protected $checkBetween = ['title' => [10,32], 'message' => [10,200]];
        protected $checkLimit   = ['password' => [4, 'number']];
        protected $fileSize     = ['image' => 1000000];
    }
?>