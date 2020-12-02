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

	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
		exit();
	}

	function CheckTableAvailability($SearchTable,$DatabaseConnection,$CheckFor = 'all' ,$CheckMultiple = false){
		if(($CheckFor !== 'any' && $CheckFor !== 'all') || strlen($SearchTable) == 0 || ($CheckMultiple != false && $CheckMultiple != true)){
			return ["status"=>"Error","msg"=>"Process failed! Try again later1"]; exit();
		}
		

		$SearchTableArray = explode("::::",$SearchTable);
		if($CheckMultiple === true && $CheckFor === 'any'){
			$UnavailableTables =  array();
			$AvailableTables =  array();
			$i = 0;
			foreach ($SearchTableArray as $value){
				$Temp = $SearchTableArray[$i];
				$results = $DatabaseConnection->query("SHOW TABLES LIKE '".$SearchTableArray[$i]."'");
			    if($results->rowCount()>0){
			    	array_push($AvailableTables, $value);
			    	$i = $i+1;
			    }else{
			    	array_push($UnavailableTables, $value);
			    }
			}
			if($i > 0){
				return ["status"=>"Success","msg"=>"Table exists","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"code"=>200]; exit();
			}else{
				return ["status"=>"Error","msg"=>"Table not exists","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"code"=>400]; exit();
			}
		}else if($CheckMultiple === true && $CheckFor === 'all'){
			$i = 0; $j = 0;
			$UnavailableTables =  array();
			$AvailableTables =  array();
			foreach ($SearchTableArray as $value){
				$j = $j+1;
				$Temp = $SearchTableArray[$i];
				$results = $DatabaseConnection->query("SHOW TABLES LIKE '".$SearchTableArray[$i]."'");
			    if($results->rowCount()>0){
			    	array_push($AvailableTables, $value);
			    	$i = $i+1;
			    }else{
			    	array_push($UnavailableTables, $value);
			    }
			}
			if($i < $j){
				 return ["status"=>"Error","msg"=>"Table not exists","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"code"=>400]; exit();
			}else{
				 return ["status"=>"Success","msg"=>"Table exists","UnavailableTables"=>$UnavailableTables,"AvailableTables"=>$AvailableTables,"code"=>200]; exit();
			}
		}else if($CheckMultiple === false){
			$results = $DatabaseConnection->query("SHOW TABLES LIKE '$SearchTable'");
		    if($results->rowCount()>0){
		    	return ["status"=>"Success","msg"=>"Table exists","UnavailableTables"=>NULL,"AvailableTables"=>$SearchTable,"code"=>200]; exit();
		    }else{
		    	 return ["status"=>"Error","msg"=>'Table not exists',"UnavailableTables"=>$SearchTable,"AvailableTables"=>NULL,"code"=>400]; exit();
		    }
		}else{
			return ["status"=>"Error","msg"=>"Process failed! Try again later2"]; exit(); 
		}
	}
?>