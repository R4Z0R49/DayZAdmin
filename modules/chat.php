<?php
	if($ftp_path != NULL){
		$ftp_connect = ftp_connect($ftp_host) or die("Couldn't connect to ".  $ftp_host); 
		$login_result = ftp_login($ftp_connect, $ftp_username, $ftp_password);
	}

	$year = date("Y");
	$month = date("m");
	$day = date("d");

    $log_array = array();
    $chat_array = array();

	if($local_path != NULL){
        $filename_log = $local_path . DIRECTORY_SEPARATOR . 'BeLog' . DIRECTORY_SEPARATOR . 'Be_'.$year.'-'.$month.'-'.$day.'.log';
	    $filename_chat = $local_path . DIRECTORY_SEPARATOR . 'Chat' . DIRECTORY_SEPARATOR . 'Chat_'.$year.'-'.$month.'-'.$day.'.log';
		if(file_exists($filename_log)){
			$log_array = file($filename_log);
		} else {
			$log_array = array("There is no log present(It might be empty)");
		}
		if(file_exists($filename_chat)){
			$chat_array = file($filename_chat);
		} else {
			$chat_array = array("There is no log present(It might be empty)");
		}
	}elseif($ftp_path != NULL){
		$filename_log = "/". $ftp_path ."/BeLog/Be_".$year."-".$month."-".$day.".log";
		$filename_chat = "/". $ftp_path ."/Chat/Chat_".$year."-".$month."-".$day.".log";
		if(file_exists("ftp://". $ftp_username .":". $ftp_password ."@". $ftp_host . $filename_log)){
			$log_array = file("ftp://". $ftp_username .":". $ftp_password ."@". $ftp_host . $filename_log);
		} else {
			$log_array = array("There is no log present(It might be empty)");
		}
		if(file_exists("ftp://". $ftp_username .":". $ftp_password ."@". $ftp_host . $filename_chat)){
			$chat_array = file("ftp://". $ftp_username .":". $ftp_password ."@". $ftp_host . $filename_chat);	
		} else {
			$chat_array = array("There is no log present(It might be empty)");
		}
	}

	if($chat_view == 'logs'){
		$array = $log_array;
	} elseif ($chat_view == 'chat'){
		$array = $chat_array;
	}

	$array = array_reverse($array);
	foreach ($array as $messages) {
		if (stripos($messages,'BEC :')) {
			echo '<font color="red"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Player #')) {
			echo '<font color="grey"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Verified GUID')) {
			echo '<font color="red"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Side:')) {
			echo '<font color="#00FFFF"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Group:')) {
			echo '<font color="#ffd88d"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Direct:')) {
			echo '<font color="#FFF"><b>'. $messages .'</b></font><br>';
		} elseif (stripos($messages,': Vehicle:')) {
			echo '<font color="#ffd479"><b>'. $messages .'</b></font><br>';
		} else {
			echo $messages . '<br>';
		}
	}
?>