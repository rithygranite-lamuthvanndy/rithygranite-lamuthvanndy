<?php 
if(isset($_GET['data'])){
	$old_file=@$_GET['data'];
   if(file_exists('D:/File_System/'.$old_file)){
      copy('D:/File_System/'.$old_file,'../../file/file_attatch_document/'.$old_file);
        unlink('D:/File_System/'.$old_file);
        $status='Save Completed';
    }
    else{
      $status='fail';
    }
    echo $status;
}
?>