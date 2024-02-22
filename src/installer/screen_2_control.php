<?php
// echo "hiiii";
// exit;
$_POST=json_decode(file_get_contents("php://input"),true);
if(isset($_POST['action']) && $_POST['action'] == "get_data"){

	$json_file_path = '../config_file.json';

	$json_data = file_get_contents($json_file_path);

	$data_array = json_decode($json_data, true); // Use true to decode as an associative array, or omit for an object
	if($data_array){
		$result['status'] = "success";
		$result['res'] = $data_array;
		$result['error'] = "";
	}
	else{
		$result['status'] = "fail";
		$result['error'] = "something went wrong";
	}
	echo json_encode($result);
	exit;
}
if(isset($_POST['action']) && $_POST['action'] == "submit_data"){
	$arr = json_encode($_POST,JSON_PRETTY_PRINT);
    $filePath = '../config_global_settings.php';
    $dataa = $_POST['data']; 
    $details =[];
    $str="";

    foreach ($dataa as $key => $value) {
        $keys ="";
    	$keys = "$".$key;
        $stt="";
        if(gettype($value)=="array"){
            foreach ($value as $key1 => $value1) {
                $formattedArray = array_map(fn($val) => '"' . $val . '"', $value1);
                if($key1==0){
                    $str .= $keys . ' = [' . implode(', ', $formattedArray) . ',';
                }
                else if($key1==sizeof($value)-1){
                     $str.=implode(', ', $formattedArray) .'];' . PHP_EOL;
                }
                else{
                    $str.=implode(', ', $formattedArray) .',';
                }
               
            }
            
        }
        else{
            $str .= $keys . ' = "'  . $value . '"; '.PHP_EOL;
        }
    }
    $k = strip_tags($str);
    $v=file_put_contents($filePath, $k);
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