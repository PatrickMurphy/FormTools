<?php
$menu = array(01=>'Home',02=>'Options',03=>'Create Form',04=>'Edit Form',05=>'Data',06=>'Statistics');
foreach($menu as $act => $title)
	if ($act == $include_page_id)
		echo '<li class="current"><a href="index.php?action=',$act,'">',$title,'</a></li>',"\n";
	else
		echo '<li><a href="index.php?action=',$act,'">',$title,'</a></li>',"\n";
?>