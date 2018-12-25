<?php
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$key=trim($_GET['key']);
	if($redis->get($key)&&$redis->get(md5($key.'_num'))>0){
		$redis->decr($key.'_num');
		$f1=getcwd().'/file/'.$_GET['file'];
		$o1=abs2($f1);
		$o2=abs2($redis->get($key));
		if(strpos($o1,$o2)!==FALSE){
			header("Content-Type: application/octet-stream");
			header("X-Accel-Redirect: /afile/" . $_GET['file']);
		}
	}
	function abs2($file){
		var_dump($file);
		$dir=dirname($file);
		$filename=basename($file);
		chdir($dir);
		$abs_dir=getcwd();
		return $abs_dir.'/'.$filename;
	}
	session_start();
    $filedir=isset($_SESSION['think']['dir']['dir'])?$_SESSION['think']['dir']['dir']:'';
	$file=isset($_SESSION['think']['file'])?$_SESSION['think']['file']:'';
	$log=isset($_SESSION['think']['log'])?$_SESSION['think']['log']:'';
	$sfile=isset($_SESSION['think']['sfile'])?$_SESSION['think']['sfile']:'';
	if($filedir||$file||$sfile||$log){
		$f1=getcwd().'/file/'.$_GET['file'];
		$o1=abs2($f1);
		$o2=abs2($_SESSION['think']['dir']['dir']);
		if(in_array('/file/'.$_GET['file'],$file)||in_array('/file/'.$_GET['file'],$sfile)||in_array('/file/'.$_GET['file'],$log)){
			header("Content-Type: application/octet-stream");
			header("X-Accel-Redirect: /afile/" . $_GET['file']);
		}
		if(strpos($o1,$o2)!==FALSE){
			header("Content-Type: application/octet-stream");
			header("X-Accel-Redirect: /afile/" . $_GET['file']);
		}else{
			header("http/1.1 404 Not Found");
		}
    }else{
        header("http/1.1 404 Not Found");
    }
