<?php
	// Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}
	// Create Domain name and save it in const variable
	define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
	define("RootPath", "../../../");
	require_once (RootPath."JsonShowError/index.php");
    // Get all requested data
	if(isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

		session_start();
		return_response($_POST['Token_CSRF'].'__'.$_SESSION['Token_CSRF'],true,'Success',200);
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Data Not Found!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}
			
			//Secrate code for access main_db file
			$DatabaseAccessCode = 'Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ';
			
			//Secrate code for access otherfiles file
			$FileAccessCode = 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH';

			// Encryption pass for all data
			$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
			
			// Access main_db file to access data base connection ($PdoMainUserAccountDb)
			require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

			// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
			require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");
	
			require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
			require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
			require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
			require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
			
			$$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'UserUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
            
		    if($$ResponseLogin['status'] != 'Success' || $$ResponseLogin['code'] != 200){
	        
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response('User not login');
			}else{
			    return_response('User logined',true,'Success',200);
			}
		}else{
			header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
		}
    }else{
        header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
    }
?>