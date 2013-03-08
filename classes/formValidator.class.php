<?php
// Form Tools - formValidator.class.php
include_once('dev.php');
class formValidator
{
    // Variable Declaration
    public $email, $path, $subject, $useremail;
	
	// Class Constructor
	public function __construct($e,$p,$s,$u,$post,$success=TRUE){
		// Set Class Variables
			if($this->isEmail($e))
				$this->email = $e;
			else
				$success = '<b>Error:</b> Admin Email not valid.';
			if(is_dir($p))
				$this->path = $p;
			else
				$success = '<b>Error:</b> File Path not valid.';
			$this->subject = $s;
			$this->useremail = $u;
			
		// Prepare Data Array
			$data['First Name'] = $this->clean_string($post['fname']);
			$data['Last Name'] = $this->clean_string($post['lname']);
			$data['State'] = $this->clean_string($post['state']);
			$data['Phone'] = $this->clean_string($post['phone']);
			$data['Email'] = $this->clean_string($post['email']);
			$data['IP'] = $this->getIP();
			$data['Timestamp'] = $this->getTimestamp();
			
		// Run Functions
			if($this->validate($data) && $this->sendEmail($data) && $this->data2files($data)){
				 if($this->useremail['send'])
				 	$this->sendEmail($data, true);
				return $success;
			}else
				return '<b>Error:</b> Scripting Error';
	}
	
	// Validate email syntax
	public function isEmail($email){
		return preg_match('/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/',$email);
	}
	
	// Validate phone syntax
	public function isPhone($phone){
		//remove all characters
		$strippedphone = preg_replace("[^0-9]", "", $phone);
		if(strlen($strippedphone)>=10)
			return TRUE;
		else
			return FALSE;
	}
	
	// Validate url
	public function isUrl($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	// Validate Price
	public function isPrice($price){
		return preg_match('(\d+(?:\.\d+)?)\D*$',$price);
	}
	
	// Validate date
	public function isDate(){
		if(substr_count($str,'/') == 2)
		{
			list($d,$m,$y) = explode('/',$str);
			return checkdate($m,$d,$y);
		}
		return FALSE;
	}
	
	// Validate Captcha
	public function isCaptcha($input){
		if($_SESSION["captcha"]==$input)	
			return true;
		else
			return false;
	}
	
	// Determine and Return user's ip address
	public function getIP() { 
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else 
			$TheIp=$_SERVER['REMOTE_ADDR'];
			
		return trim($TheIp);
    }
	
	// Generate and Return current timestamp
	public function getTimestamp(){
		return date('m/d/y : H:i:s', time());
	}
	
	// Return a string with illegal strings removed
	public function clean_string($s,$additional=array()) {
		return str_replace(array_merge(array('content-type','bcc:','to:','cc:','href','<?','<?php','?>'),$additional),'',$s);
    }
	
	// Validate required form data and email syntax
	public function validate($d){
		if($this->isEmail($d['Email']) && isset($d['First Name']) && isset($d['Last Name']) && isset($d['State']) && isset($d['Phone']))
			return TRUE;
		else
			return FALSE;
	}
	
	// Send admin Email with lead informaton
	public function sendEmail($d, $to = false){
		// Formulate message
		if($to){
			foreach($d as $label => $value){
				$message .= $label.': '.$value."\r\n";
			}
			$recipient = $this->email;
			$sender = $d['Email'];
			// Replace Name Variables in Subject
			$subject = str_replace(array('%fn','%ln'),array($d['First Name'],$d['Last Name']),$this->subject);
		}else{
			$message = $this->useremail['message'];
			$recipient = $d['Email'];
			$sender = $this->email;	
			$subject = $this->useremail['subject'];
		}
		
		// Formulate email headers
		$headers = 'From: '.$sender."\r\n". 'Reply-To: '.$sender."\r\n" . 'X-Mailer: PHP/' . phpversion();
		
		if(mail($recipient, $subject, $message, $headers))
			return TRUE;
		else
			return FALSE;
	}
	
}

?>