<?php
    echo "<pre/>";
    print_r($_FILES);die();
    $file_arr = array();
    $files = $_FILES['image'];
    foreach($files['name'] as $key => $file_name){
        $file_info['name'] = $file_name;
        $file_info['type'] = $files['type'][$key];
        $file_info['tmp_name'] = $files['tmp_name'][$key];
        $file_info['error'] = $files['error'][$key];
        $file_info['size'] = $files['size'][$key];
        array_push($file_arr,$file_info);
    }
    print_r($file_arr);