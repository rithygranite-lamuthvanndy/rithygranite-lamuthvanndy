<?php 
if ($handle = opendir('D:/File_System/')) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
    	// if($file_name==$entry){
    		unlink('D:/File_System/'.$entry);
    	// }
    }

    closedir($handle);
}
 ?>