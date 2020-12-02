<?php

    
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
	
	define("RootPath", "../../../");

	if((!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH') && (!isset($_REQUEST['Token_CSRF']))){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
	}
	if(isset($_REQUEST['Token_CSRF'])){
		require_once ("../../../JsonShowError/index.php"); // Require Show error file
		session_start();
		if($_REQUEST['Token_CSRF'] != $_SESSION['Token_CSRF']){
			return_response(['status'=>'Error','msg'=>'Token id expired! refresh page','code'=>400]);
		}
	}
	
	function ClientLogOut(){
	    
	    $ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'UserUrl');
    	
    	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
    	    $LgUserUrl = $ResponseLogin['msg']['UserUrl'];
    	    $LgLFR = $ResponseLogin['LFR'];
    	    if($ResponseLogin['LAS'] == 'MainMember'){
    	        $DbConnection = $PdoMainUserAccountDb;
    	    }else{
    	        $DbConnection = $PdoOrganizationUserAccount;
    	    }
    	    
    	    $ResponseUpdate = UpdateGivenData("LoginTokenData::::None","UserUrl::::$LgUserUrl",$DbConnection,$LgLFR,$EncodeAndEncryptPass,'all');
    	}
    	setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);
        return ['status'=>'Success','msg'=>'Logout successfully','code'=>200];
	}
	
	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
	    //Secrate code for access main_db file
    	$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";
    
    	//Secrate code for access otherfiles file
    	$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
    
    	// Encryption pass for all data
    	$EncodeAndEncryptPass ="DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx";
    	
    	require_once (RootPath."JsonShowError/index.php"); // Require Show error file
    	
    	// Access main_db file to access data base connection ($PdoMainUserAccountDb)
    	require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");
    
    	// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
    	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");
    
    	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
    	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
    	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
    	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
    	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
    	
    	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'UserUrl');
    	
    	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
    	    $LgUserUrl = $ResponseLogin['msg']['UserUrl'];
    	    $LgLFR = $ResponseLogin['LFR'];
    	    if($ResponseLogin['LAS'] == 'MainMember'){
    	        $DbConnection = $PdoMainUserAccountDb;
    	    }else{
    	        $DbConnection = $PdoOrganizationUserAccount;
    	    }
    	    
    	    $ResponseUpdate = UpdateGivenData("LoginTokenData::::None","UserUrl::::$LgUserUrl",$DbConnection,$LgLFR,$EncodeAndEncryptPass,'all');
    	    
    	    if($ResponseUpdate['status'] == 'Success' && $ResponseUpdate['code'] == 200){
    	        setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
        		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
        		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
        		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);
    	        $ResponseLogOut = ['status'=>'Success','msg'=>'Logout successfully','code'=>200];
    	    }else{
    	       $ResponseLogOut = ['status'=>'Error','msg'=>'User Not LogOut','code'=>400];
    	    }
    	}else{
    	    setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
    		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
    		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
    		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);
	        $ResponseLogOut = ['status'=>'Success','msg'=>'Logout successfully','code'=>200];
    	}
    	
    	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'ResponseLogOut'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
    	if($ResponseLogOut['status'] == 'Success' && $ResponseLogOut['code'] == 200){
		    return_response($ResponseLogOut,true,'Success',200);
    	}else{
    	    return_response($ResponseLogOut);
    	}
	}
	
?>