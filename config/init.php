<?php
    define('ROOT', str_replace('public/', '', $_SERVER['DOCUMENT_ROOT']));
    
    require(ROOT . 'config/Database.php');
    require(ROOT . 'config/Router.php');
    require(ROOT . 'config/Request.php');
    
    require(ROOT . 'lib/Database.php');
    require(ROOT . 'lib/Model.php');
    require(ROOT . 'controller/Controller.php');
    require(ROOT . 'lib/Pagination.php');
    require(ROOT . 'lib/validation/Validation.php');
    require(ROOT . 'lib/function.php');
    
    require(ROOT . 'config/Dispatcher.php');
?>