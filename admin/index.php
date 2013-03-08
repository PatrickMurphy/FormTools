<?php
ob_start();
// Form Tools - index.php

// Prepare Variables and Classes
session_start(); 
try {
	/*
	// Class Auto Loader
	function __autoload($class) {
		include '..//classes//'.$class.'.class.php';
	}
	*/
	
	include('..//classes//config.class.php');
	include('..//classes//flatfile.class.php');
	include('..//classes//userFF.class.php');
	$config = new config();
	$save = new flatfile();
	$user = new userFF($save,$config);
	
	if(isset($_GET['action'])){
		$pageAction=$_GET['action'];
	}else{
		$pageAction=1;
	}	
	function actionSwitch($page_id){
		switch($page_id){
			case 2:
				return 'options.php';
			break;
			case 3:
				return 'create.php';
			break;
			case 4:
				return 'edit.php';
			break;
			case 5:
				return 'data.php';
			break;
			case 6:
				return 'stats.php';
			break;
			default:
				return 'home.php';
		}
	}
	if($pageAction=='logout')
		$user->logout('index.php?action='.$_GET['previous']);
	if($user->authenticate(TRUE)){
		// Page Switch
		$include_page = actionSwitch($pageAction);
		$include_page_id = $pageAction;
	}else{
		$include_page = 'template/login.form.layout.php';	
		$include_page_id = $pageAction;
	}
	
	// Begin Page Creation
	include('template/header.layout.php');
	include($include_page);
	include('template/footer.layout.php');
	
} catch (Exception $e) {
	ob_clean();
	include('template/header.layout.php');
	echo '<div class="error" style="margin-left:15px"><h2>Error:</h2><p>',$e->getMessage(),'</p></div>',"\n";
	if(isset($_POST['user'])){
		unset($_POST['user']);
		include('template/login.form.layout.php');
	}else
		include(actionSwitch($pageAction));
	include('template/footer.layout.php');
}
ob_end_flush();
?>