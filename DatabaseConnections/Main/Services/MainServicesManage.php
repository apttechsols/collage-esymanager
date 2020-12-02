<?php
	/*
	*@filename MainServicesManage.php
	*@Author Arpit sharma
	*/
	error_reporting(0);
	if(!RootPath){
		define("RootPath", "../../../");
	}
	if(isset($DatabaseAccessCode) && $DatabaseAccessCode === "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ"){
		try {
			// Create a PDO instance
			// VariableName = new PDO(hostname,databaseName,databaseUser,DatabasePassword);
			$PdoServiceManage = new PDO("mysql:host=localhost;dbname=topicste_service_manage",'topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr');
			$PdoServiceManage->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
			return_response("Database connection faild");
		}
	}else{
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
		header("Location: " . RootPath . "/PageNotAvailable/index.php");
		die();
		return_response("This page not available");
	}
?>