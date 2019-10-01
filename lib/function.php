<?php
    function get_post($name) {
        $return = trim(isset($_POST[$name]) ? $_POST[$name] : null);
        if ($return != '') {
            return $return;
        } else {
            return null;
        }
    }

    function get_default_date($date) {
        return date('d-m-Y H:i', strtotime($date));
    }

    function date_to_string($date) {
        return date('Y-m-d H:i:s', intval($date));
    }   

    function check_request_method($method) {
        if ($_SERVER['REQUEST_METHOD'] === $method){
            return true;
        } else {
            return false;
        };
    }

    function get_file($file){
        if($_FILES[$file]['error'] == 0){  
            return $_FILES[$file];
        } else {
            return null;
        }
    }

    function move_to_public($file, $newFile = ''){
        move_uploaded_file($file['tmp_name'], ROOT . 'public/'.$newFile);
    }

    function delete_file($file){
        unlink(ROOT . 'public/' . $file);
    }

    function show_with_tags($data){
        return htmlspecialchars($data);
    }

    function ln_to_br($data) {
        return nl2br($data);
    }
?>