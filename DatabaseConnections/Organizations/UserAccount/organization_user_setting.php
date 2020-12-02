<?php
	/*
	*@filename organization_user_setting.php
	*@des This file is create connection of organization_user_setting database which is store organization persional data like postion, postion rank, servicepostions etc. each orgnaization has seprate table in this database
	*@Author Arpit sharma
	*/
	error_reporting(0);
	if(!RootPath){
		define("RootPath", "../../../");
	}
	if(isset($DatabaseAccessCode) && $DatabaseAccessCode === "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ"){
		unset($PdoOrganizationUserSetting);
		try {
			// Create a PDO instance
			// VariableName = new PDO(hostname,databaseName,databaseUser,DatabasePassword);
			$PdoOrganizationUserSetting = new PDO("mysql:host=localhost;dbname=topicste_organization_user_setting",'topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr');
			$PdoOrganizationUserSetting->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
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