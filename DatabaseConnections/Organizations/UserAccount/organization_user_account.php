<?php
	/*
	*@Filename - organization_user_account.php
	*@Desc - This file is create connection of organization_user_account database which is store organization userdata data
	*@Author - Arpit sharma
	*/
	error_reporting(0);
	if(!RootPath){
		define("RootPath", "../../../");
	}
	if(isset($DatabaseAccessCode) && $DatabaseAccessCode === "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ"){
		unset($PdoOrganizationUserAccount);
		try {
			// Create a PDO instance
			// VariableName = new PDO(hostname,databaseName,databaseUser,DatabasePassword);
			$PdoOrganizationUserAccount = new PDO("mysql:host=localhost;dbname=topicste_organization_user_account",'topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr');
			$PdoOrganizationUserAccount->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
			return_response("Database connection faild");
		}
	}else{
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
		header("Location: " . RootPath . "/PageNotAvailable/index.php");
		die();
		return_response("This page not available");
	}
?>