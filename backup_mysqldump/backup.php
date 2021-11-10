<?php 
	if(@$_GET['status']=='backup'){
		include_once '../config/database.php';
		backup_mysqldump();
		echo 'Back Up Completed ';
	}

	// backup_mysqldump();
	function backup_mysqldump()
	{
		global $database,$host_name,$user_name,$password;
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			// ============================ For Window ==========================
			$v_new_file_name="db_win_".date('Ymd_H-i-s').'.sql';
			$v_path_store="C://wamp64//www//14systemsdemo//backup_mysqldump//storage//";//.$v_new_file_name;//For Window
			makeNewDir($v_path_store,date('Y')); $v_path_store.='/'.date('Y');
			makeNewDir($v_path_store,date('m')); $v_path_store.='/'.date('m');
			makeNewDir($v_path_store,date('d')); $v_path_store.='/'.date('d');
			$v_path_store.='/'.$v_new_file_name;
			// echo $v_path_store;
			$v_dir_mysqldump="C:/wamp64/bin/mariadb/mariadb10.4.10/bin/mysqldump.exe"; //For Window
			$v_cmd=$v_dir_mysqldump.' --user= '.$user_name.' --password= '.$password.' --host=localhost --port=3306 '.$database.' > '.$v_path_store;

		}
		else {
		    // ============================ For Linux ==========================

			$v_new_file_name="db_server_".date('Ymd_H-i-s').'.sql.bz2';
			$v_path_store="/var/www/html/backup_mysqldump/storage/";//.$v_new_file_name; //For Linux
			makeNewDir($v_path_store,date('Y')); $v_path_store.='/'.date('Y');
			makeNewDir($v_path_store,date('m')); $v_path_store.='/'.date('m');
			makeNewDir($v_path_store,date('d')); $v_path_store.='/'.date('d');
			$v_path_store.='/'.$v_new_file_name;
			$v_dir_mysqldump="/usr/bin/mysqldump"; //For Linux
			$v_cmd=$v_dir_mysqldump.' -u '.$user_name.' -p'.$password.' '.$database.' | bzip2 > '.$v_path_store;
		}

		// die($v_cmd);
		shell_exec($v_cmd);
		// die(getcwd());
	}

	function makeNewDir($path,$dir_name)
	{
		if(!file_exists($path.'/'.$dir_name)){
			mkdir($path.'/'.$dir_name, 0777, true);
		}
	}
 ?>