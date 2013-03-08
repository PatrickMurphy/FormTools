<?php
// user flatfile
require_once('user.interface.php');
class userFF implements user
{
    // Declare Global class variables
	private $ff, $config;
	public $filepath;
	
	// Get ff and config objects from application
	public function __construct(flatfile $ff, config $config){
		$this->ff = $ff;
		$this->config = $config;
		$this->filepath = $this->config->path.$this->config->prefix;
	}
	
	// Validate a Login for a user
    public function login($user,$pass){
		$user=strtolower($user);
		$pass=strtolower($pass);
		$pass = md5($user.$this->config->usersalt.$pass);
		$file = $this->filepath.'users.csv';
		foreach($this->ff->readCSV($file) as $lines){
			if($lines[0] != $user || $lines[1] != $pass)
				$return = false;
			else {
				$_SESSION['username'] = $lines[0];
				$_SESSION['admin'] = ($lines[2] == 'true');
				return true;
			}
		}
		//die($pass.' = '.$lines);
		return false;
	}

	// Logout a user
    public function logout($redirect='none'){
		$_SESSION = array();
		if($redirect!='none')
			header('Location: '. $redirect);
	}
	
	// Create a new user
	public function createNew($user,$pass,$admin=true){
		$user = strtolower($user);
		$pass = strtolower($pass);
		$file = $this->filepath.'users.csv';
		foreach($this->ff->readCSV($file) as $lines)
			if($lines[1]==$user)
				throw new Exception('Username already in use.');		
		$data = array('username'=>$user,'passsword'=>md5($user.$this->config->usersalt.$pass),'admin'=>$admin);
		if($this->ff->write($file,implode(',',$data)))
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