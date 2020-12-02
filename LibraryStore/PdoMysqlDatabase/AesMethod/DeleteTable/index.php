<?php
	/*

	*@filename CheckTableAvailable/index.php
	*@des It return Available if Data alredy exixt
	*@Author Arpit sharma
	*/

	// Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}
	// Create Domain name and save it in const variable
	define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);

	/*if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
		exit();
	}
*/
	function DeleteTable($GivenTable,$DatabaseConnection,$CheckFor = 'all',$SelectMultiple = false, $DataBaseName=NULL){
		if(($CheckFor !== 'any' && $CheckFor !== 'all' && $CheckFor !== 'StartLike' && $CheckFor !== 'LastLike' && $CheckFor !== 'StartLikeLast') || strlen($GivenTable) == 0 || ($SelectMultiple != false && $SelectMultiple != true)){
			return ["status"=>"Error","msg"=>"Process failed! Try again later1"]; exit();
		}

		$GivenTableArray = explode("::::",$GivenTable);
		if($SelectMultiple === true && $CheckFor === 'any'){
			$UnavailableTables =  array();
			$AvailableTables =  array();
			$UndeletedTables =  array();
			$DeletedTables =  array();
			$i = 0;
			foreach ($GivenTableArray as $value){
				$results = $DatabaseConnection->query("SHOW TABLES LIKE '$value'");
			    if($results->rowCount()>0){
			   		array_push($AvailableTables, $value);
			    	$sql = $DatabaseConnection->query("DROP TABLE if exists $value");
			    	if($sql->execute() === TRUE){
			    		array_push($DeletedTables, $value);
			    		$i++;
			    	}else{
			    		array_push($UndeletedTables, $value);
			    	}
			    }else{
			    	array_push($UnavailableTables, $value);
			    	array_push($UndeletedTables, $value);
			    }
			}
			if($i > 0){
				return ["status"=>"Success","msg"=>"Deleted tables","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"UndeletedTables"=>$UndeletedTables,"DeletedTables"=>$DeletedTables,"code"=>200]; exit();
			}else{
				return ["status"=>"Error","msg"=>"Tables not deleted","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"UndeletedTables"=>$UndeletedTables,"DeletedTables"=>$DeletedTables,"code"=>400]; exit();
			}
		}else if($SelectMultiple === true && $CheckFor === 'all'){
			$UnavailableTables =  array();
			$AvailableTables =  array();
			$UndeletedTables =  array();
			$DeletedTables =  array();
			$i = 0; $j=0;
			foreach ($GivenTableArray as $value){
				$j++;
				$results = $DatabaseConnection->query("SHOW TABLES LIKE '$value'");
			    if($results->rowCount()>0){
			   		array_push($AvailableTables, $value);
			    	$sql = $DatabaseConnection->query("DROP TABLE if exists $value");
			    	if($sql->execute() === TRUE){
			    		array_push($DeletedTables, $value);
			    		$i++;
			    	}else{
			    		array_push($UndeletedTables, $value);
			    	}
			    }else{
			    	array_push($UnavailableTables, $value);
			    	array_push($UndeletedTables, $value);
			    }
			}
			if($i === $j){
				return ["status"=>"Success","msg"=>"Deleted tables","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"UndeletedTables"=>$UndeletedTables,"DeletedTables"=>$DeletedTables,"code"=>200]; exit();
			}else{
				return ["status"=>"Error","msg"=>"Tables not deleted","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"UndeletedTables"=>$UndeletedTables,"DeletedTables"=>$DeletedTables,"code"=>400]; exit();
			}
		}else if($SelectMultiple === false && ($CheckFor === 'StartLike' || $CheckFor === 'LastLike' || $CheckFor === 'StartLikeLast')){
			if(strlen($DataBaseName) == 0){
				return ["status"=>"Error","msg"=>"Database name required for delete table with like operater"]; exit();
			}
			if($CheckFor == 'StartLike'){$Temp = '%'.$GivenTable;}else if($CheckFor == 'LastLike'){$Temp = $GivenTable.'%';}else if($CheckFor == 'StartLikeLast'){$Temp = '%'.$GivenTable.'%';}
			$TempTablesInString = '';
			$results = $DatabaseConnection->query("select TABLE_NAME from information_schema.tables WHERE TABLE_SCHEMA = '$DataBaseName' AND TABLE_NAME LIKE '$Temp'");
			if($results->rowCount() == 0){
				return ["status"=>"Error","msg"=>"Table not found","UnavailableTables"=>NULL,"AvailableTables"=>NULL,"UndeletedTables"=>NULL,"DeletedTables"=>NULL,'reason'=>json_encode($results->errorinfo()),"code"=>404]; exit();
			}
			foreach ($results->fetchAll() as $value) {
				$TempTablesInString .= $DataBaseName.'.'.$value->TABLE_NAME.', ';
			}
			$sql = $DatabaseConnection->query("DROP TABLE if exists ".trim($TempTablesInString, ', '));
	    	if($sql->execute()){ 
	    		return ["status"=>"Success","msg"=>"Table deleted","UnavailableTables"=>NULL,"AvailableTables"=>NULL,"UndeletedTables"=>NULL,"DeletedTables"=>NULL,"code"=>200]; exit();
	    	}else{
	    		return ["status"=>"Error","msg"=>"Table not deleted","UnavailableTables"=>NULL,"AvailableTables"=>NULL,"UndeletedTables"=>$GivenTable,"DeletedTables"=>NULL,'reason'=>json_encode($sql->errorinfo()),"code"=>400]; exit();
	    	}
		}else if($SelectMultiple === false){
			$results = $DatabaseConnection->query("SHOW TABLES LIKE '$GivenTable'");
		    if($results->rowCount()>0){
		    	$sql = $DatabaseConnection->query("DROP TABLE if exists $GivenTable");
		    	if($sql->execute()){ 
		    		return ["status"=>"Success","msg"=>"Table deleted","UnavailableTables"=>NULL,"AvailableTables"=>$GivenTable,"UndeletedTables"=>NULL,"DeletedTables"=>$GivenTable,"code"=>200]; exit();
		    	}else{
		    		return ["status"=>"Error","msg"=>"Table not deleted","UnavailableTables"=>NULL,"AvailableTables"=>$GivenTable,"UndeletedTables"=>$GivenTable,"DeletedTables"=>NULL,"code"=>400]; exit();
		    	}
		    }else{
		    	return ["status"=>"Error","msg"=>"Table not deleted","UnavailableTables"=>$GivenTable,"AvailableTables"=>NULL,"UndeletedTables"=>$GivenTable,"DeletedTables"=>NULL,'reason'=>json_encode($results->errorinfo()),"code"=>404]; exit();
		    }
		}else{
			return ["status"=>"Error","msg"=>"Process failed! Try again later2"]; exit(); 
		}
	}
?>