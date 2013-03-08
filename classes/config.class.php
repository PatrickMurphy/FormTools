<?php
class config {
	public $DB,$FF,$prefix; // General
	public $host,$user,$pass,$database; // Database
	public $path; // Flate File
	
	public function __construct($configFile='../config.php'){
		include($configFile);
		foreach($config as $option => $setting)
			$this->$option = $setting;
	}
	
	public function generateConfig($values,$configFile='../config.php'){
		$i = 0;
		$ff = new flatfile();
		$ff->delete($configFile);
		$bool = Array(false => 'false', true => 'true');
		
		$ff->write($configFile,'<?php'."/r/n".'// Config Edit with the admin panel'."/r/n");
		foreach($values as $option => $key){
			if(is_string($key))
				$lines[$i] = '$config[\''.$option.'\'] = \''.$key.'\''."/r/n";
			elseif(is_bool($key))
				$lines[$i] = '$config[\''.$option.'\'] = '.$bool[$key]."/r/n"; 
			else
				$lines[$i] = '$config[\''.$option.'\'] = '.$key."/r/n";
			$ff->write($configFile,$lines[$i]);
			$i++;
		}		
		$ff->write($configFile,'?>');
	}
}
?>