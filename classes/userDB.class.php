<?php
// user interface
require_once('user.interface.php');
class userDB implements user
{
	// Declare Global class variables
	private $db, $config;
	
	// Get db and config objects from application
	public function __construct(database $db, config $config){
		$this->db = $db;
		$this->config = $config;
	}
	
	// Validate a Login for a user
    public function login($user,$pass){
		$user=strtolower($user);
		$user=strtolower($pass);
		$pass = md5($user.$this->config->usersalt.$pass);
		$this->db->read($this->config->prefix.'users',array('username' => $user,'password'=>$pass));
		if($this->db->records == 0)
			return false; // Exception?
		else{
			$_SESSION['username'] = $user;
			$_SESSION['admin'] = $admin;
			return true;
		}
	}
	
	// Logout a user
    public function logout($redirect='none'){
		$_SESSION = array();	
		if($redirect!='none')
			header('Location: '.$redirect);
	}
	
	// Create a new user
	public function createNew($user,$pass,$admin=true){
		$user = strtolower($user);
		$pass = strtolower($pass);
		$this->db->read($this->config->prefix.'users',array('username' => $user));
		if($this->db->records > 0)
			throw new Exception('Username already in use.');
		$columns = array('username'=>$user,'passsword'=>md5($user.$this->config->usersalt.$pass),'admin'=>$admin);
		if($this->db->write($columns,$this->config->prefix.'users'))
			return true;
		else
			return false;
	}
	
	// Check if a user is currently logged in
	public function authenticate($admin = false){
		if(isset($_SESSION['admin']) && isset($_SESSION['username']))
			if($admin)
				if($_SESSION['admin'])
					return true;
				else
					return false;
			else
				return true;
		else
			return false;
	}
}

?>