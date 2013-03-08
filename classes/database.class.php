<?php
// Form Tools - database.class.php
require_once('save.interface.php');
class database implements save
{
	// Class Variables
	public $records,$affected,$result,$DBLink,$aRawResults,$aArrayedResult,$aArrayedResults;
	private $config;
	
	// Constructor method
	public function __construct($config,$host=NULL,$user=NULL,$pass=NULL,$db=NULL){
		if($config){
			$this->config = $config;
			$host = $this->config->host;
			$user = $this->config->user;
			$pass = $this->config->pass;
			$db = $this->config->database;
		}
		return $this->connect($host,$user,$pass,$db);
	}
	
	// Connect to a MySQL database
	public function connect($host,$user,$pass,$db){
		$this->DBLink = mysql_connect($host, $user, $pass);
		if($this->DBLink)
			mysql_select_db($db,$this->DBLink);
		else
			throw new Exception('Unable to secure a database connection.');
		return true;
	}
	
	// Executes MySQL query
	function executeSQL($query){
		if($this->result 		= mysql_query($query, $this->DBLink)){
			$this->records 	= @mysql_num_rows($this->result);
			$this->affected	= @mysql_affected_rows($this->DBLink);
			return true;
		}else{
			throw new Exception('MySQL Error: '.mysql_error($this->DBLink));
		}
	}
	
	// Write data to the database
    public function write($vars,$table){
		// Prepare Variables
		$vars = $this->SecureData($vars);

		$query = 'INSERT INTO `' . $table . '` SET ';
		foreach($vars as $key=>$value){
			$query .= '`' . $key . '` = "' . $value . '", ';
		}

		$query = substr($query, 0, -2);

		if($this->ExecuteSQL($query)){
			return true;
		}else{
			return false;
		}		
	}
	
	// Read
    public function read($sFrom, $aWhere='', $sOrderBy='', $sLimit='', $bLike=false, $sOperand='AND'){
		// Catch Exceptions
		if(trim($sFrom) == ''){
			return false;
		}

		$sSQLQuery = 'SELECT * FROM `' . $sFrom . '` WHERE ';

		if(is_array($aWhere) && $aWhere != ''){
			// Prepare Variables
			$aWhere = $this->SecureData($aWhere);

			foreach($aWhere as $iKey=>$sValue){
				if($bLike){
					$sSQLQuery .= '`' . $iKey . '` LIKE "%' . $sValue . '%" ' . $sOperand . ' ';
				}else{
					$sSQLQuery .= '`' . $iKey . '` = "' . $sValue . '" ' . $sOperand . ' ';
				}
			}

			$sSQLQuery = substr($sSQLQuery, 0, -5);

		}else{
			$sSQLQuery = substr($sSQLQuery, 0, -7);
		}

		if($sOrderBy != ''){
			$sSQLQuery .= ' ORDER BY ' .$sOrderBy;
		}

		if($sLimit != ''){
			$sSQLQuery .= ' LIMIT ' .$sLimit;
		}

		if($this->ExecuteSQL($sSQLQuery)){
			if($this->records > 0){
				$this->ArrayResults();
			}
			return true;
		}else{
			return false;
		}	
	}
	
	// Update
	public function update($sTable, $aSet, $aWhere){
		if(trim($sTable) == '' || !is_array($aSet) || !is_array($aWhere)){
				throw new Exception('Invalid Parameters for the Mysql Update Function.');
		}	
		$aSet 	= $this->SecureData($aSet);
		$aWhere = $this->SecureData($aWhere);

		// SET

		$sSQLQuery = 'UPDATE `' . $sTable . '` SET ';

		foreach($aSet as $iKey=>$sValue){
			$sSQLQuery .= '`' . $iKey . '` = "' . $sValue . '", ';
		}

		$sSQLQuery = substr($sSQLQuery, 0, -2);

		// WHERE

		$sSQLQuery .= ' WHERE ';

		foreach($aWhere as $iKey=>$sValue){
			$sSQLQuery .= '`' . $iKey . '` = "' . $sValue . '" AND ';
		}

		$sSQLQuery = substr($sSQLQuery, 0, -5);

		if($this->ExecuteSQL($sSQLQuery)){
			return true;
		}else{
			return false;
		}
	}
		
	// Delete
	public function delete($sTable, $aWhere='', $sLimit='', $bLike=false){
		$sSQLQuery = 'DELETE FROM `' . $sTable . '` WHERE ';
		if(is_array($aWhere) && $aWhere != ''){
			// Prepare Variables
			$aWhere = $this->SecureData($aWhere);

			foreach($aWhere as $iKey=>$sValue){
				if($bLike){
					$sSQLQuery .= '`' . $iKey . '` LIKE "%' . $sValue . '%" AND ';
				}else{
					$sSQLQuery .= '`' . $iKey . '` = "' . $sValue . '" AND ';
				}
			}

			$sSQLQuery = substr($sSQLQuery, 0, -5);
		}

		if($sLimit != ''){
			$sSQLQuery .= ' LIMIT ' .$sLimit;
		}

		if($this->ExecuteSQL($sSQLQuery)){
			return true;
		}else{
			return false;
		}	
	}
	
	// 'Arrays' a single result
	function ArrayResult(){
		$this->aArrayedResult = mysql_fetch_assoc($this->result) or die (mysql_error($this->DBLink));
		return $this->aArrayedResult;
	}

	// 'Arrays' multiple result
	function ArrayResults(){
		$this->aArrayedResults = array();
		while ($aData = mysql_fetch_assoc($this->result)){
			$this->aArrayedResults[] = $aData;
		}
		return $this->aArrayedResults;
	}

	// 'Arrays' multiple results with a key
	function ArrayResultsWithKey($sKey='id'){
		if(isset($this->aArrayedResults)){
			unset($this->aArrayedResults);
		}
		$this->aArrayedResults = array();
		while($aRow = mysql_fetch_assoc($this->result)){
			foreach($aRow as $sTheKey => $sTheValue){
				$this->aArrayedResults[$aRow[$sKey]][$sTheKey] = $sTheValue;
			}
		}
		return $this->aArrayedResults;
	}
	
	// Performs a 'mysql_real_escape_string' on the entire array/string
	function SecureData($data){
		if(is_array($data)){
			foreach($data as $iKey=>$sVal){
				if(!is_array($data[$iKey])){
					$data[$iKey] = mysql_real_escape_string($data[$iKey], $this->DBLink);
				}
			}
		}else{
			$data = mysql_real_escape_string($data, $this->DBLink);
		}
		return $data;
	}
}
?>