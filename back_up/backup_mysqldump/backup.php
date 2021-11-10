<?php 
	function backup_mysqldump()
	{
		global $database,$host_name,$user_name,$password;
		$dir='C://BackupSystem/BackUp-'.$database.'-'.date('Y-m-d').'/';
		if( is_dir($dir) === false )
		{
		    mkdir($dir,0777, true);
		}
		$dumpfile = $dir.$database . "_" . date("Y-m-d_H-i-s") . ".sql";
		echo $dumpfile;
		$v_path='C://xampp//mysql//bin//mysqldump';//Path Mysqldump
		exec("$v_path --opt --host=$host_name --user=$user_name --password=$password $database > $dumpfile", $output, $return);
		if(!$return){//Create Success
			// echo "Created Successfully";
			// echo "$dumpfile "; //passthru("tail -1 $dumpfile");
			// ConvertToZip($dir);
		}else {
		    die("Back  Up Fail");
		}
	}
	function ConvertToZip($root_folder){
		// Get real path for our folder
		$rootPath = realpath('root_folder');

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);
		$i=0;
		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    	$i++;
		    }
		}
		echo $i;
		// Zip archive will be created only after closing object
		$zip->close();
	}
 ?>