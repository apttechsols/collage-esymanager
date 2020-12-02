<?php
	/*
	@FileName - DeleteMemberBackend.php
	@Desc - Update Service Member profiel for sthis service
	@Author - Arpit sharma
	*/

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
	define("RootPath",  '../../../../');

	if(isset($_POST['UserUrl']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
		require_once (RootPath."JsonShowError/index.php"); // Require Show error file
		
		// Verify data send from same domain or not
		if(DomainName === "http://localhost"){
			
			session_start();
			if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

				// Create variable from get data by request (example Post and Get methos)
				$UserUrl = preg_replace('!\s+!', ' ',strip_tags($_POST['UserUrl']));
				$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

				if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
					foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
					return_response("Process failed!");
				}else{
					// Create New BrowserUniqueDetails
					$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

					$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
				}

				class DeleteMember{
					public static function ValidedData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

						if($UserUrl != preg_replace("/[^A-Za-z0-9]/","",$UserUrl)){
							return_response("UserUrl detect invalid"); exit();
						}

						if($SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
							return_response('Invalid Security code detect'); exit();
						}
						
						// Call encode_post_input function
						DeleteMember::EncryptData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
					}

					private static function EncryptData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
						$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

						$SecurityCode = hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

						DeleteMember::CkeckLoginAndAuthenticate($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
					}

					private static function CkeckLoginAndAuthenticate($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

						//Secrate code for access database file
						$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

						//Secrate code for access otherfiles file
						$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

						// Access main_db file to access data base connection ($PdoMainUserAccountDb)
						require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

						// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
						require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

						// Access organization_user_setting file to access data base connection ($PdoOrganizationUserSetting)
						require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

						// Access main_db file to access data base connection ($PdoServiceManage)
						require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

						//Create connection for any Database (CreateDbConnection(DbName))
						require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");

						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
						require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
						require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
						require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
						require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

						// Check user login
						$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);

						if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not login'); exit();
						}

						if($ResponseLogin['msg']['SecurityCode'] != $SecurityCode){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Invalid Security code detect'); exit();
						}

						$LgFor = $ResponseLogin['LFR'];
						
						if($ResponseLogin['LAS'] === 'OrganizationMember' && $ResponseLogin['LORT'] === 'College'){
							$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
							if($ResponseRank == ''){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Org setting data not fetched!'); exit();
							}
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not authorized for take this action'); exit();
						}

						$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
						$LgFor = $ResponseLogin['LFR'];
						$LgUserPosition = $ResponseLogin['msg']['Position'];
						$LgPositionRank = $ResponseRank;
						DeleteMember::DeleteMemberRequest($UserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank);
					}
					private function DeleteMemberRequest($UserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank){

						// Create isset time according Asia/Kolkata
						date_default_timezone_set('Asia/Kolkata');
						
						$CurrentTime = time();

						$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
						
						if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('This service not buyed by this organization'); exit();
						}

						$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
						if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
							$DbConnection = $DbConnection['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Connection failed! Try again later'); exit();
						}
						
						if($LgPositionRank != 1 && $LgPositionRank != 2){

							$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
							if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to take this action'); exit();
							}

							$ServiceMemberPositionRank = FetchReuiredDataByGivenData("Position::::".$ServiceMemberData['msg']->Position,'PositionRank',$DbConnection,$LgFor.'_setting',$EncodeAndEncryptPass);
							if($ServiceMemberPositionRank['status'] != 'Success' || $ServiceMemberPositionRank['code'] != 200 || $ServiceMemberPositionRank['msg']->PositionRank != 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to take this action'); exit();
							}
						}
						
						$UserMemberData =FetchReuiredDataByGivenData("UserUrl::::$UserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
						if($UserMemberData['status'] != 'Success' || $UserMemberData['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User not exist in this service'); exit();
						}

						$UserMemberPositionRank = FetchReuiredDataByGivenData("Position::::".$UserMemberData['msg']->Position,'PositionRank',$DbConnection,$LgFor.'_setting',$EncodeAndEncryptPass);
						if($UserMemberPositionRank['status'] != 'Success' || $UserMemberPositionRank['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User not exist in this service'); exit();
						}

						if($LgPositionRank != 1 && $LgPositionRank != 2){
							if($UserMemberPositionRank['msg']->PositionRank == 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to delete this member'); exit();
							}
						}

						if($UserMemberPositionRank['msg']->PositionRank == 0){
							$Response = DeleteDataFromTable("UserUrl::::$UserUrl",$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
							if($Response['status'] != 'Success' || $Response['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('User delation process failed due to technical error'); exit();
							}
							$Response = DeleteDataFromTable("RequestFrom::::$UserUrl",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
							if($Response['status'] != 'Success' || $Response['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('User delation process failed due to technical error'); exit();
							}
						}else{
							$Response = DeleteDataFromTable("UserUrl::::$UserUrl",$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
							if($Response['status'] != 'Success' || $Response['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('User delation process failed due to technical error'); exit();
							}
						}

						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User delete successfully',true,'Success',200); exit();
					}
				}
				DeleteMember::ValidedData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
			}else{
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
				return_response("Invalid Token Id! Refresh page");
			}
		}else{
			header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
		}
	}else{
		header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
	}
?>