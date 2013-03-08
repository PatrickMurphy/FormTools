<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Form Tools | Admin</title>
<link href="template/style.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script language="javascript">
function toggle(showHideDiv,loop) {
	var ele = document.getElementById(showHideDiv);
	if (ele.style.display == "block") {
    	ele.style.display = "none";
  	} else {
		ele.style.display = "block";
	}
	if (loop == false)
		if(showHideDiv=='db')
			toggle('ff',true);
		else
			toggle('db',true);
} 
</script>
</head>

<body>
<div class="container">
  <header>
  	<a href="index.php"><img src="template/images/logo.jpg" alt="Form Tools" width="273" height="85" /></a>
  </header>
  <div id="topbar">
  	<?php if($user->authenticate()){?>
    	<span class="userbox">
        	Logged in as <?php echo $_SESSION['username'];?> | <a href="index.php?action=logout&previous=<?php echo $pageAction;?>">Logout</a>
        </span>
  	<?php } ?>
  </div>
  <div class="sidebar1">
    <nav>
      <ul>
        <?php
        	include('template/menu.layout.php');
		?>
      </ul>
    </nav>
  <!-- end .sidebar1 --></div>
  <article class="content">