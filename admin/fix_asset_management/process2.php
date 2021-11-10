<?php
require_once "../../plugin/PHPExcel/Classes/PHPExcel.php";

$file = $_FILES['file']['name'];
$ekstensi = explode(".", $file);
$file_name ="file-".round(microtime(true)).".".end($ekstensi);
$sumber = $_FILES['file']['tmp_name'];
$target_dir ="../_file/";
$target_file = $target_dir.basename($_FILES["file"]["name"]);
$upload = move_uploaded_file($sumber, $target_file);
if($upload){
    echo "Upload Sucess";
    echo $file_name;
    echo '<br>';
    $obj = PHPExcel_IOFactory::load($target_file);
    $all_data = $obj->getActiveSheet()->toArray(null,true,true,true);
    for($i=9; $i<= count($all_data); $i++){
        echo $all_data[$i]['A'];
        echo $all_data[$i]['B'];
        echo $all_data[$i]['C'];
        echo $all_data[$i]['D'];
        echo $all_data[$i]['E'];
        echo $all_data[$i]['F'];
        echo '<br>';
    }
}else{
    echo "Upload Error";
}
?>