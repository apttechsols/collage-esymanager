<?php
	/*
	@FileName - UpdateMemberBackend.php
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

	if(isset($_POST['Status']) && isset($_POST['Position']) && isset($_POST['GroupId']) && isset($_POST['GroupType']) && isset($_POST['UserUrl']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
		require_once (RootPath."JsonShowError/index.php"); // Require Show error file
		
		// Verify data send from same domain or not
		
		if($_SERVER['HTTP_REFERER'] === str_replace(" ","%20",DomainName."/Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/Manager/SearchMember/index.php")){
			
			session_start();
			if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

				// Create variable from get data by request (example Post and Get methos)
				$Status = preg_replace('!\s+!', ' ',strip_tags($_POST['Status']));
				$Position = preg_replace('!\s+!', ' ',strip_tags($_POST['Position']));
				$GroupId = preg_replace('!\s+!', ' ',strip_tags($_POST['GroupId']));
				$GroupType = preg_replace('!\s+!', ' ',strip_tags($_POST['GroupType']));
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

				class UpdateMember{
					public static function ValidedData($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

						if($Status != "Active" && $Status != "Hold" && $Status != "Block"){
							return_response("Status detect invalid"); exit();
						}

						if($Position != preg_replace("/[^A-Za-z ]/","",$Position)){
							return_response("Position detect invalid"); exit();
						}

						if($GroupId != preg_replace("/[^A-Za-z0-9]/","",$GroupId)){
							return_response("GroupId detect invalid"); exit();
						}

						if($GroupType != "public" && $GroupType != "private"){ 
							return_response("GroupType detect invalid"); exit();
						}

						if($UserUrl != preg_replace("/[^A-Za-z0-9]/","",$UserUrl)){
							return_response("UserUrl detect invalid"); exit();
						}

						if($SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
							return_response('Invalid Security code detect'); exit();
						}
						
						// Call encode_post_input function
						UpdateMember::EncryptData($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
					}

					private static function EncryptData($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
						$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

						$SecurityCode = hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

						UpdateMember::CkeckLoginAndAuthenticate($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
					}

					private static function CkeckLoginAndAuthenticate($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

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
						UpdateMember::UpdateMemberRequest($Status,$Position,$GroupId,$GroupType,$UserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank);
					}
					private function UpdateMemberRequest($Status,$Position,$GroupId,$GroupType,$UserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank){

						// Create isset time according Asia/Kolkata
						date_default_timezone_set('Asia/Kolkata');
						
						$CurrentTime = time();

						$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);

						if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('This service not buyed by this organization'); exit();
						}

						$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
						if($GetOrgSetting['status'] != "Success" || $GetOrgSetting['code'] != 200){
						    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Org Setting can not feched! Due to technical error');
						}
						foreach ($GetOrgSetting['msg'] as $value){
							${'GetOrgSetting' . $value->SettingKeyUnique} = $value->SettingValue;
						}

						$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
						if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
							$DbConnection = $DbConnection['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Connection failed! Try again later'); exit();
						}

						$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
						if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
						    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Service Setting can not feched! Due to technical error');
						}
						foreach ($GetServiceSetting['msg'] as $value){
							${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
						}
						
						if($LgPositionRank != 1 && $LgPositionRank != 2){

							$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
							if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not a member of this service'); exit();
							}
							$ServiceMemberDataPosition = $ServiceMemberData['msg']->Position;
							$ServiceMemberPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberDataPosition.':', '*');
							if($ServiceMemberPositionRank == ''){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not a member of this service'); exit();
							}

							if($ServiceMemberPositionRank != 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not a authorized for this action!'); exit();
							}
						}else{
							$ServiceMemberDataPosition = $LgUserPosition;
							$ServiceMemberPositionRank = $LgPositionRank;
						}
						
						$UserServiceCurrentData = FetchReuiredDataByGivenData("UserUrl::::$UserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
						if($UserServiceCurrentData['status'] != 'Success' || $UserServiceCurrentData['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User not exist in this service 1.0'); exit();
						}

						$UserServiceCurrentPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $UserServiceCurrentData['msg']->Position.':', '*');
						if($UserServiceCurrentPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User not exist in this service 1.1'); exit();
						}

						$UserServiceNewChangedPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $Position.':', '*');
						if($UserServiceNewChangedPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Given position not found in this service'); exit();
						}

						if($LgPositionRank != 1 && $LgPositionRank != 2){
							if($UserServiceCurrentPositionRank == 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to update this member'); exit();
							}

							if($UserServiceNewChangedPositionRank == 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to add member at this position'); exit();
							}
						}

						$Response = FetchReuiredDataByGivenData("UserUrl::::$UserUrl","Position",$PdoOrganizationUserAccount,$LgFor,$EncodeAndEncryptPass);
						if($Response['status'] != "Success" || $Response['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User is Not member of this Organization'); exit();
						}

						$UpdateUserOrgPosition = $Response['msg']->Position;

						$UpdateUserOrgPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetOrgSettingPosition.'*', $UpdateUserOrgPosition.':', '*');
						if($UpdateUserOrgPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('This user is not a member of this organization'); exit();
						}

						if($UpdateUserOrgPositionRank == 1 || $UpdateUserOrgPositionRank == 2){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Organization Owner Or Manager can not be a part of service member'); exit();
						}

						if($UserServiceNewChangedPositionRank == 0 && $UpdateUserOrgPositionRank != 0){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You can not add this member as user beacuse it is not a user in Organization position'); exit();
						}else if($UpdateUserOrgPositionRank == 0 && $AddUserPositionRank != 0){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You can not add this member at this position beacuse this user is add at user position in Organization'); exit();
						}

						$Response = UpdateGivenData("Status::::$Status::,::Position::::$Position::,::GroupId::::$GroupId::,::GroupType::::$GroupType::,::LastUpdateTime::::$CurrentTime::,::LastUpdateBy::::$LgUserUrl::,::LastUpdatePosition::::$ServiceMemberDataPosition::,::LastUpdateRank::::$ServiceMemberPositionRank","UserUrl::::$UserUrl",$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
						if($Response['status'] === 'Success' && $Response['code'] === 200){
							return_response('User Data Updated Successfully',true,'Success',200); exit();
						}else if($Response['reason'] == '["00000",null,null]'){
							return_response('Change user data to perform updation',true,'Warning',404); exit();
						}else{
							return_response('User Updatedtion failed'); exit();
						}
					}
				}
				UpdateMember::ValidedData($Status,$Position,$GroupId,$GroupType,$UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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