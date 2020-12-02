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
	
	if(isset($_REQUEST['LoginType']) && isset($_REQUEST['LoginFor']) && isset($_REQUEST['Token_CSRF']) && !isset($FileAccessCode)){
		require_once (RootPath."JsonShowError/index.php"); // Require Show error file
		session_start();
		if($_REQUEST['Token_CSRF'] != $_SESSION['Token_CSRF']){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response(['status'=>'Error','msg'=>'Token id expired! refresh page','code'=>400]);
		}
		$LoginType = $_REQUEST['LoginType'];
		$LoginFor = $_REQUEST['LoginFor'];

		// LoginType valided in backend
		if($LoginType != 'Organization' && $LoginType != 'Main'){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response("Invalid LoginType detected"); exit();
		}

		// LoginFor valided in backend
		if($LoginFor != preg_replace("/[^a-z0-9_]/","",$LoginFor)){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response("Invalid Organization detected"); exit();

		}else if(strlen($LoginFor) < 1 || strlen($LoginFor) > 18){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response("Invalid Organization detected"); exit();
		}

		$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

		//Secrate code for access database file
		$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

		//Secrate code for access otherfiles file
		$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
		// Access main_db file to access data base connection ($PdoMainUserAccountDb)
		require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");
		
		// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
		require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");
		require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
		if($LoginType === 'Organization'){

			    $Response = FetchReuiredDataByGivenData("Username::::$LoginFor::::Mobile::::$LoginFor::::Email::::$LoginFor","UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'any');

				if($Response['status'] === "Success" && $Response['code'] === 200){

					$Response = FetchReuiredDataByGivenData("UserUrl::::".$Response['msg']->UserUrl,"ProfileUrl::::UserUrl",$PdoOrganizationUserAccount,$Response['msg']->UserUrl,$EncodeAndEncryptPass,'all');
					
					if($Response['status'] === "Success" && $Response['code'] === 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){  if($SetVarKey != 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response(['ProfileUrl'=>$Response['msg']->ProfileUrl,'UserUrl'=>$Response['msg']->UserUrl],true,'Success',200); exit();
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Organization detected"); exit();
					}
				}else{
					foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
					return_response("Invalid Organization detected"); exit();
				}
		}else{
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response('Currently this service is not active'); exit();
		}
	}else if(isset($FileAccessCode) && $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
		function GetUserProfileImage($SignupType,$OrgUrl,$UserData,$RequestFor,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount){
			if(strlen($UserData) == 0 || $UserData != preg_replace("/[^A-Za-z0-9.@]/","",$UserData)){
				return ['status'=>'Error','msg'=>'Invalid User Data Detected','code'=>400];
			}
			if($RequestFor === 'OrgMember'){
				if($SignupType === 'Organization'){
					$Response = FetchReuiredDataByGivenData("UserUrl::::$OrgUrl::,::Status::::Active",NULL,$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');

					if($Response['status'] === "Success" && $Response['code'] === 200){

						$Response = FetchReuiredDataByGivenData("UserUrl::::$UserData::,::Username::::$UserData::,::Mobile::::$UserData::,::Email::::$UserData::,::UniqueId::::$UserData","ProfileUrl",$PdoOrganizationUserAccount,$Response['msg']->UserUrl,$EncodeAndEncryptPass,'any');
						
						if($Response['status'] === "Success" && $Response['code'] === 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){  if($SetVarKey != 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return ['status'=>'Success','msg'=>$Response['msg']->ProfileUrl,'code'=>200];
						}else{
							return ['status'=>'Error','msg'=>'This User Not Found In Organization','code'=>400];
						}
					}else{
						return ['status'=>'Error','msg'=>'This Organization Not Active','code'=>400];
					}
				}else{
					return ['status'=>'Error','msg'=>'Currently this feature is only for organization','code'=>400];
				}
			}else{
				return ['status'=>'Error','msg'=>'Currently this feature is only for Member','code'=>400];
			}
		}
	}else{
		header("Location: " . RootPath . "PageNotAvailable/index.php"); die();
	}
?>