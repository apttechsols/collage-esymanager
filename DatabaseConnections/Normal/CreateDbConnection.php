<?php
	/*
	*@filename CreateDbConnection.php
	*@Author Arpit sharma
	*/
	error_reporting(0);
	if(!RootPath){
		define("RootPath", "../../../");
	}
	if(isset($DatabaseAccessCode) && $DatabaseAccessCode === "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ"){
		function CreateDbConnection($User,$Pass,$DbName){
			if(strlen($DbName) == 0 || $DbName != preg_replace("/[^A-Za-z0-9_]/","",$DbName) || strlen($User) == 0 || strlen($User) == 0 || !function_exists('return_response')){
				return ['status'=>'Error','msg'=>'User and Database name must required',"code"=>400];
			}
			
			try {
				// Create a PDO instance
				// VariableName = new PDO(hostname,databaseName,databaseUser,DatabasePassword);
				$TempPdoServiceConnection = new PDO("mysql:host=localhost;dbname=$DbName",$User,$Pass);
				$TempPdoServiceConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				return ['status'=>'Success','msg'=>$TempPdoServiceConnection,"code"=>200];
				
			} catch (PDOException $e) {
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Database connection faild due tot technical error");
			}
		}
	}else{
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
		header("Location: " . RootPath . "/PageNotAvailable/index.php");
		die();
		return_response("This page not available");
	}
?>