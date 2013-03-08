<?php
// Form Tools - flatfile.class.php
require_once('save.interface.php');
class flatfile implements save {
	
	// Open file connection
	public function open ($file,$type = 'a+'){
		$fh = fopen($file, $type);
		if(!$fh)
			throw new Exception('Unable to open the file: '.$file);
		return $fh;
	}
	
	// Write to file at path.
	public function write($file,$data){
		$fh = $this->open($file);
		if(fwrite($fh, $data))
			throw new Exception('Unable to write to the file: '.$file);
		fclose($fh);
		return true;
	}
	
	// Return contents of file
	public function read($file,$lines = true,$entire = false,$bytes = false,$offset=0){
		$fh = $this->open($file);
		if($lines){
			// Return array of lines
			$i = 0;
			while (!feof($fh) ) {
				$data[$i] = fgets($fh);
				$i++;
			}
		}else if($entire){
			// Entire File
			$data = fread($fh,filesize($file));
		}else{
			// Bytes
			fseek($fh,$offset);
			$data = fread($fh,$bytes);
		}
		fclose($fh);
		return $data;
	}
	
	// Delete file
	public function delete($file){
		unlink($file);
	}
	
	// File array to csv file array
	public function readCSV($file){
		foreach($this->read($file) as $key=>$line){
			$data[$key] = explode(',',$line);
		}
		return $data;
	}
}
?>