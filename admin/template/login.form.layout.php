<?php
	if(isset($_POST['user']))
		if($user->login($_POST['user'],$_POST['pass']))
			header('Location: index.php?action='.$include_page_id);
		else
			throw new Exception('Unable to validate login. Check your Username & Password.');
?>
<h1>Login</h1>
<section>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'],'?action='; if(isset($pageAction)) echo $pageAction; ?>">
        <input type="text" name="user" placeholder="Username" /><br />
        <input type="password" name="pass" placeholder="Password" /><br />
        <input type="submit" value="Login" />
    </form>
</section>