<?php
$_POST=json_decode(file_get_contents("php://input"),true);
if($_POST['action']=="submit"){ 
    $arr = json_encode($_POST['details'],JSON_PRETTY_PRINT);
    $filePath = 'config_file.json';
    $v = file_put_contents($filePath, $arr);
    if($v){
        $result['status'] = "success";
        $resutl['error'] = "";
    }
    else{
        $result['status'] = "fail";
        $resutl['error'] = "something went wrong";
    }
    echo json_encode($result);
    exit;
} 
?>