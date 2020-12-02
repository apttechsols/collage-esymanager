<?php
error_reporting(0);
// Get server port type (exampale - http:// or https://)
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
	$HeaderSecureType = "https://";
}else{
	$HeaderSecureType = "http://";
}
// Create Domain name and save it in const variable
define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
define("RootPath", "../../../../../../");

// Get all requested data
if(isset($_POST['RequestType']) && isset($_POST['RequestId']) && isset($_POST['RequestFrom']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/PermissionGiver/NewRequest/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$RequestType = preg_replace('!\s+!', ' ',strip_tags($_POST['RequestType']));
			$RequestId = preg_replace('!\s+!', ' ',strip_tags($_POST['RequestId']));
			$RequestFrom = preg_replace('!\s+!', ' ',strip_tags($_POST['RequestFrom']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class ResponseSend{
				public static function ValidedData($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// RequestType valided in backend
					if($RequestType != "Approve" && $RequestType != "Reject" && $RequestType != "Block"){
						return_response("Invalid Request Type detect");
					}
					
					// RequestId valided in backend
					if($RequestId != preg_replace("/[^A-Za-z0-9]/","",$RequestId)){
						return_response("Invalid RequestId detect");
					}else if(strlen($RequestId) != 30){
						return_response("Invalid RequestId detect");
					}

					// RequestFrom valided in backend
					if($RequestFrom != preg_replace("/[^A-Za-z0-9]/","",$RequestFrom)){
						return_response("Invalid RequestFrom detect");
					}else if(strlen($RequestFrom) != 30){
						return_response("Invalid RequestFrom detect");
					}

					if($SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response("Invalid SecurityCode detect");
					}else if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6){
						return_response("Invalid SecurityCode detect");
					}
					
					// Call encode_post_input function
					ResponseSend::EncryptData($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					ResponseSend::CkeckLoginAndAuthenticate($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
					//Secrate code for access database file
					$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

					//Secrate code for access otherfiles file
					$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
					
					// Access main_db file to access data base connection ($PdoMainUserAccountDb)
					require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");
					
					// Access main_db file to access data base connection($PdoOrganizationUserSetting)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

					// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

					// Access main_db file to access data base connection ($PdoServiceManage)
					require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

					//Create connection for any Database (CreateDbConnection(DbName))
					require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
					require_once (RootPath."Users/Service/Dashbord/SMS_axtxbyl4qn1583926727nb91ipl6rj/SendSms/Fast2SmsApi/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/QrCodeGenrate/index.php");

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not login'); exit();
					}

					$LgFor = $ResponseLogin['LFR'];

					if($ResponseLogin['msg']['SecurityCode'] != $SecurityCode){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Invalid Security code'); exit();
					}
					
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
					$LgUserPosition = $ResponseLogin['msg']['Position'];
					$LgPositionRank = $ResponseRank;

					ResponseSend::ResponseSendProccess($RequestType,$RequestId,$RequestFrom,$SecurityCode,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank);
				}
				
				private static function ResponseSendProccess($RequestType,$RequestId,$RequestFrom,$SecurityCode,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
					if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('D GatePass service not active for this organization'); exit();
					}
					
					$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
					if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
						$DbConnection = $DbConnection['msg'];
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Database connection failed'); exit();
					}

					$RequestForUser = FetchReuiredDataByGivenData("RequestId::::$RequestId",'RequestOutGoingTime::::GuardianPermission::::WardenPermission::::SettingValue::::RequestFrom',$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all');

					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service setting not feched! due to technical error'); exit();
					}

					foreach ($GetServiceSetting['msg'] as $value){
						${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					foreach (explode(',', $GetServiceSettingSmsUpdatePermission) as $value) {
						$Temp =  explode('-', $value);
						${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
					}

					foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
						$Temp =  explode(':', $value);
						${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
					}

					if($RequestForUser['code'] == 200){
						if($RequestForUser['msg']->GuardianPermission == 'Pending'){
							$TempStatusReason = 'This request is auto closed, It is expired because your Guardian not respond on this request';
						}else if(($RequestForUser['msg']->GuardianPermission == 'Approve' || $RequestForUser['msg']->GuardianPermission != 'NotNeeded') && $RequestForUser['msg']->WardenPermission == 'Pending'){
							$TempStatusReason = 'This request is auto closed, It is expired because warden not respond on this request!';
						}else if($RequestForUser['msg']->WardenPermission == 'Approve' || $RequestForUser['msg']->WardenPermission == 'NotNeeded'){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are can not respond on it, Because warden alredy responed on it'); exit();
						}else{
							$TempStatusReason = 'This request is auto closed, But we can not find reason! You can report it at support panel to help us';
						}
						$RequestForUserSettingValueArray = unserialize($RequestForUser['msg']->SettingValue);
					 	if($RequestForUserSettingValueArray['MaxTimeWaitForApproveOrRejectPermissionFromAll'] < $CurrentTime){
					 		$Response = UpdateGivenData("Status::::Closed::,::StatusReason::::$TempStatusReason","RequestId::::$RequestId",$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all');
							return_response("Now you can not Approve Or Reject it, Because Maximum time for approve or reject is ended! That's why it is closed"); exit();
					 	}
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Request Data Not feched!"); exit();
					}

					$GetUserAllOpenOrApproveRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Open::::Any::,::Status::::Approve::::Any::,::RequestFrom::::".$RequestForUser['msg']->RequestFrom, 'FetchData'=>'Status::::RequestId::::OutGoingStatus::::InComingStatus::::SettingValue::::RequestOutGoingTime::::GuardianPermission::::WardenPermission::::RequestTime', 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All']);
					if($GetUserAllOpenOrApproveRequest['code'] != 200 && $GetUserAllOpenOrApproveRequest['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User Previous Request details not feched! due to technical error'); exit();
					}

					if($GetUserAllOpenOrApproveRequest['code'] == 200){

						$AutoCloseNeedPemission = false;
						foreach ($GetUserAllOpenOrApproveRequest['msg'] as $value) {
							$TempSettingValue = unserialize($value->SettingValue);
							$AutoCloseIt = '';
							if($value->Status == 'Open'){
								if($TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] != 'NotNeeded' && $TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] < $CurrentTime){
									if($TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] - $value->RequestTime >= 900){
										$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = true;
									}else{
										$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = false;
									}
								}else{
									$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = false;
								}

								if($TempSettingValue['StMaxOutGoingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxOutGoingTime'] < $CurrentTime){
										$CheckStMaxOutGoingTime = true;
									}else{
										$CheckStMaxOutGoingTime = false;
									}
								}else{
									$CheckStMaxOutGoingTime = false;
								}

								if($TempSettingValue['StMaxInComingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxInComingTime'] < $CurrentTime){
										$CheckStMaxInComingTime = true;
									}else{
										$CheckStMaxInComingTime = false;
									}
								}else{
									$CheckStMaxInComingTime = false;
								}
								
								if($CheckMaxTimeWaitForApproveOrRejectPermissionFromAll == true){
									if($value->GuardianPermission != 'Approve' && $value->GuardianPermission != 'NotNeeded'){
										$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, It is expired because your Guardian not respond on this request!'];
									}else if($value->WardenPermission == 'Approve' && $value->WardenPermission != 'NotNeeded'){
										$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, It is expired because warden not respond on this request!'];
									}else{
										$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, But we can not find reason! You can report it at support panel to help us'];
									}
								}else if($CheckStMaxOutGoingTime == true){
									$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, Because Max OutGoing Time Expired And You not go OutSide yet'];
								}else if($CheckStMaxInComingTime == true){
									$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, Because Max InComing Time Expired And You not go OutSide yet'];
								}
							}else{
								if($TempSettingValue['StMaxOutGoingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxOutGoingTime'] < $CurrentTime){
										if($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded'){
											$CheckStMaxOutGoingTime = true;
										}else{
											$CheckStMaxOutGoingTime = false;
										}
									}else{
										$CheckStMaxOutGoingTime = false;
									}
								}else{
									$CheckStMaxOutGoingTime = false;
								}

								if($TempSettingValue['StMaxInComingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxInComingTime'] < $CurrentTime){
										if($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded'){
											$CheckStMaxInComingTime = true;
										}else{
											$CheckStMaxInComingTime = false;
										}
									}else{
										$CheckStMaxInComingTime = false;
									}
								}else{
									$CheckStMaxInComingTime = false;
								}

								if($CheckStMaxOutGoingTime == true){
									$AutoCloseIt = ['return'=>'Success','Reason'=>'This request is auto closed, Because Max OutGoing Time Expired And You not go OutSide yet'];
								}else if($CheckStMaxInComingTime == true){
									$AutoCloseNeedPemission = true;
									$AutoCloseIt = ['return'=>'Error','Reason'=>'This request can not be auto closed, Because Max InComing Time Expired But You not come yet'];
								}
							}
						}

						if($AutoCloseNeedPemission == true){
							$RequestType = 'Reject';
						}
					}

					$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position::::GroupId::::GroupType',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
					if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200){
						return_response('Service member data not feched! due to technical error'); exit();
					}

					$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
					if($LgUserServicePositionRank == '' || $ServiceMemberData['msg']->Status != 'Active'){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized to take this action'); exit();
					}
					if($LgUserServicePositionRank != 2){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized to take this action'); exit();
					}

					$ServiceRequestData =FetchReuiredDataByGivenData("RequestId::::$RequestId",'GuardianPermission::::GroupId::::GroupType',$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass);
					if($ServiceRequestData['status'] != 'Success' || $ServiceRequestData['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service Request data not feched! due to technical error'); exit();
					}

					if($ServiceMemberData['msg']->GroupId != $ServiceRequestData['msg']->GroupId || $ServiceMemberData['msg']->GroupType != $ServiceRequestData['msg']->GroupType){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized to take this action'); exit();
					}
					
					if($RequestType === 'Approve' || $RequestType === 'Reject'){
						
						if($RequestType === 'Reject'){
							$Status = 'Closed';
						}else if($RequestType === 'Approve'){
							if($RequestForUser['msg']->GuardianPermission == 'Approve' || $RequestForUser['msg']->GuardianPermission == 'NotNeeded'){
								$Status = 'Approve';
							}else{
								$Status = 'Open';
							}

							if($Status == 'Approve'){
								$QrStorePath = RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/';

								$QrSavePath = $QrStorePath.$LgFor;
								if(!file_exists($QrSavePath)){
									if(!mkdir($QrSavePath)){
										foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
										return_response('Organization dir not create in qr code store!'); exit();
									}
								}
								if(file_exists($QrSavePath)){
									if(!file_exists($QrSavePath.'/index.php')){
										if(!copy($QrStorePath."index.php", $QrSavePath."/index.php")){
											foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
											return_response('Organization dir not create properly in qr code store!'); exit();
										}
									}
								}else{
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('Organization dir not exist in qr code store!'); exit();
								}
								
								$QrCode = GenrateQrCode(['QrMsg'=>serialize(['ReqId'=>$RequestId]),'FileName'=>$RequestId.'.png','SavePath'=>$QrSavePath.'/']);
								if($QrCode['status'] != 'Success' || $QrCode['code'] != 200){
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RequestType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
									return_response('Qr code not create! Due to technical error'); exit();
								}
							}
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RequestType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response('Invalid Request type found!'); exit();
						}

						$GivenData = "Status::::$Status::,::WardenPermission::::$RequestType::,::WardenPermissionTime::::$CurrentTime::,::WardenUrl::::$LgUserUrl::,::WardenRank::::$LgPositionRank";
						
						$Response = UpdateGivenData($GivenData,"Status::::Open::,::RequestFrom::::$RequestFrom::,::RequestId::::$RequestId",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass,'all');

						if($Response['status'] === 'Success' && $Response['code'] === 200){

							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RequestType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response('Student request '.$RequestType.' Successfully',true,'Success',200); exit();
						}else{
							if($RequestType === 'Approve'){
								unlink($QrSavePath.'/'.$RequestId.'.png');
							}
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('User request failed! Due to technical error'); exit();
						}
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('This feature currently not activeted'); exit();
					}
				}	
			}
			
			// Call classname public function 
			ResponseSend::ValidedData($RequestType,$RequestId,$RequestFrom,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
		}else{
			return_response("Invalid Token Id! Refresh page");
		}
	}else{
		header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
	}
}else{
	header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
}	
?>