<?php

	// Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}

	define("RootPath", "../../../");

	session_start();
	$Token_CSRF = md5(rand(1345694, 9893456));
	$RandomPass1 = md5(rand(13456, 9893456));
	$RandomPass2 = md5(rand(13456, 9893456));
	$RandomPass3 = md5(rand(13456, 9893456));
	$RandomPass4 = md5(rand(13456, 9893456));
	$RandomPass5 = md5(rand(13456, 9893456));
	$_SESSION['Token_CSRF'] = $Token_CSRF;
	$_SESSION['RandomPass1'] = $RandomPass1;
	$_SESSION['RandomPass2'] = $RandomPass2;
	$_SESSION['RandomPass3'] = $RandomPass3;
	$_SESSION['RandomPass4'] = $RandomPass4;
	$_SESSION['RandomPass5'] = $RandomPass5;

	function LogOut(){
		setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);
	}
	
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

	// Access organization_user_setting file to access data base connection ($PdoOrganizationUserSetting)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	
	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');
    #return_response($ResponseLogin);
	if($ResponseLogin['LAS'] === 'OrganizationMember'){
		$TempRankCheckDb = $PdoOrganizationUserSetting;
		$TempRankCheckTble = $ResponseLogin['LFR'];
	}else if($ResponseLogin['LAS'] === 'MainMember'){
		$TempRankCheckDb = $PdoMainUserAccountDb;
		$TempRankCheckTble = 'main_member_setting';
	}else{
		$TempRankCheckDb = null;
	}
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$TempRankCheckDb,$TempRankCheckTble,$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();

	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		LogOut();
		header("Location: " . RootPath . "Users/Login/index.php"); die();
	}else{
		
		if($ResponseRank == ''){
			LogOut();
			header("Location: " . RootPath . "Users/Login/index.php"); die();
		}

		if($ResponseLogin['LAS'] != 'OrganizationMember' && $ResponseLogin['LAS'] != 'MainMember'){
			LogOut();
			header("Location: " . RootPath . "Users/Login/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'College' && $ResponseLogin['LORT'] != 'Main'){
			LogOut();
			header("Location: " . RootPath . "Users/Login/index.php"); die();
		}else{

			if($ResponseLogin['LAS'] === 'OrganizationMember'){
				if($ResponseRank != 0){
					header("Location: " . RootPath . "Users/Organizations/Dashboard/".$ResponseLogin['LORT']."/ManagementPanel/index.php"); die();
				}else if($ResponseRank == 0){
					header("Location: " . RootPath . "Users/Organizations/Dashboard/".$ResponseLogin['LORT']."/UserArea/index.php"); die();

				}else{
					LogOut();
					header("Location: " . RootPath . "Users/Login/index.php"); die();
				}
			}else if($ResponseLogin['LAS'] === 'MainMember'){
				if($ResponseRank > 0){
					header("Location: " . RootPath . "Users/Main/Dashboard/index.php"); die();
				}else{
					LogOut();
					header("Location: " . RootPath . "Users/Login/index.php"); die();
				}
			}else{
				LogOut();
				header("Location: " . RootPath . "Users/Login/index.php"); die();
			}
		}
	}
	
?>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>