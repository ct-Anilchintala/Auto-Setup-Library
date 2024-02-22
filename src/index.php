<?php

$cofig_file_path = '../config.json';
if (file_exists($file_path)) {
    header("Location: installer/screen_2.php");
    exit;
} 

// $file_path = '../config_file.json';
// if (file_exists($file_path)) {
//     header("Location: installer/screen_2.php");
// } else {
//     header("Location: installation/screen_1.php");
// }
?>