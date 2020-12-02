<?php
/*
*@FileName GuardianPermissionBackend.php
*@Des This procees add new members in orgnization database
*@Author arpit sharma
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
define("RootPath", "../../../../../../");

// Get all requested data
if(isset($_POST['OrgId']) && isset($_POST['GRId']) && isset($_POST['StPr']) && isset($_POST['Token_CSRF'])){
	require_once (RootPath."JsonShowError/index.php");
	
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Guardian/Request/index.php?D0=".$_POST['OrgId']."&D1=".$_POST['GRId']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$OrgId = preg_replace('!\s+!', ' ',strip_tags($_POST['OrgId']));
			$GRId = preg_replace('!\s+!', ' ',strip_tags($_POST['GRId']));
			$StPr = preg_replace('!\s+!', ' ',strip_tags($_POST['StPr']));
			$Token_CSRF = preg_replace('!\s+!', ' ',strip_tags($_POST['Token_CSRF']));

			class GuardianStPr{

				public static function ValidedData($OrgId,$GRId,$StPr){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					// OrgId valided in backend
					if($OrgId != preg_replace("/[^A-Za-z0-9]/","",$OrgId)){
						return_response("Invalid Org Id detect"); exit();

					}else if(strlen($OrgId) != 30){
						return_response("Invalid Org Id detect"); exit();

					}

					// GRId valided in backend
					if($GRId != preg_replace("/[^A-Za-z0-9]/","",$GRId)){
						return_response("Invalid Guardian Id detect"); exit();

					}else if(strlen($GRId) != 20){
						return_response("Invalid Guardian Id detect"); exit();

					}

					// StPr valided in backend
					if($StPr != 'Approve' && $StPr != 'Reject'){
						return_response("Invalid Permission detect");

					}

					// Call encode_post_input function
					GuardianStPr::EncryptData($OrgId,$GRId,$StPr);
				}

				// Encode data by self design method
				private static function EncryptData($OrgId,$GRId,$StPr){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Call profile_imageResize function
					GuardianStPr::CkeckLoginAndAuthenticate($OrgId,$GRId,$StPr,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($OrgId,$GRId,$StPr,$EncodeAndEncryptPass){

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
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');

					if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('This information only for Guardian or Father'); exit();
					}

					GuardianStPr::GuardianStPrProccess($OrgId,$GRId,$StPr,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage);
				}
				
				private static function GuardianStPrProccess($OrgId,$GRId,$StPr,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$LgFor = $ResponseLogin['LFR'];

					$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$OrgId,$CurrentTime);
					if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True/* || $DGatePassServiceBuyStatus['msg']['IsServiceActiveted'] != True*/ ){
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

					$RequestForUser = FetchReuiredDataByGivenData("GuardianPermissionReceiveUrlKey::::$GRId",'RequestOutGoingTime::::SettingValue::::WardenPermission::::RequestId',$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass,'all');

					# $OrgId,$GRId
					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::ServiceActiveSchedule::,::SettingKeyUnique::::SmsUpdatePermission::,::SettingKeyUnique::::GeneralSetting","SettingKeyUnique::::SettingValue",$DbConnection,$OrgId.'_setting',$EncodeAndEncryptPass,'any',NULL,'all');

					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service data can not feched!'); exit();
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

					if($RequestForUser['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Request Data Not feched!"); exit();
					}

					/*if($GetServiceSettingSmsUpdatePermissionWardenSmsUpdate == 'Yes' && $GetServiceSettingGeneralSettingWardenPermissionApprovalNeeded == 'Yes'){
						$SmsServiceBuyStatus = CheckServiceBuyStatus('aXTxByL4Qn1583926727NB91IPL6rj',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$OrgId,$CurrentTime);
						if($SmsServiceBuyStatus['status'] != 'Success' || $SmsServiceBuyStatus['code'] != 200 || $SmsServiceBuyStatus['msg']['ServiceBuy'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('SMS service not buyed for this organization'); exit();
						}

						$SmsServiceDbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj');
						if($SmsServiceDbConnection['status'] === 'Success' && $SmsServiceDbConnection['code'] === 200){
							$SmsServiceDbConnection = $SmsServiceDbConnection['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Sms service database connection failed'); exit();
						}
					}*/

					$GetRequestData = FetchReuiredDataByGivenData("GuardianPermissionReceiveUrlKey::::$GRId",'GuardianPermission::::RequestFrom',$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass);
					if($GetRequestData['status'] != 'Success' || $GetRequestData['code'] != 200 || $GetRequestData['totalrows'] != 1){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Request data not feched! due to technical error'); exit();
					}

					if($GetRequestData['msg']->GuardianPermission != 'Pending'){
						return_response('This Request already '.$GetRequestData['msg']->GuardianPermission.'! You can not change it'); exit();
					}
					// Wrog type to close MaxTimeWaitForApproveOrRejectPermissionFromAll
					$RequestForUserSettingValueArray = unserialize($RequestForUser['msg']->SettingValue);
					if($RequestForUserSettingValueArray['MaxTimeWaitForApproveOrRejectPermissionFromAll'] < $CurrentTime){
						$Response = UpdateGivenData("Status::::Closed::,::StatusReason::::This request is auto closed, It is expired because your Guardian not respond on this request!","GuardianPermissionReceiveUrlKey::::$GRId",$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass,'all');
						return_response("Now you can not Approve Or Reject it, Because Maximum time for approve or reject is ended! That's why it is closed"); exit();
					}

					$GetUserAllOpenOrApproveRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Open::::Any::,::Status::::Approve::::Any::,::RequestFrom::::".$GetRequestData['msg']->RequestFrom, 'FetchData'=>'Status::::RequestId::::OutGoingStatus::::InComingStatus::::SettingValue::::RequestOutGoingTime::::GuardianPermission::::WardenPermission::::RequestTime', 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All']);
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
									}else if($value->WardenPermission != 'Approve' && $value->WardenPermission != 'NotNeeded'){
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
							$StPr = 'Reject';
						}
					}

					if($StPr == 'Reject'){
						$UpdateData = "Status::::Closed::,::";
					}else if($RequestForUser['msg']->WardenPermission == 'Approve' || $RequestForUser['msg']->WardenPermission == 'NotNeeded'){
						$UpdateData = "Status::::Approve::,::";						
						$QrStorePath = RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/';

						$QrSavePath = $QrStorePath.$OrgId;
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
						
						$QrCode = GenrateQrCode(['QrMsg'=>serialize(['ReqId'=>$RequestForUser['msg']->RequestId]),'FileName'=>$RequestForUser['msg']->RequestId.'.png','SavePath'=>$QrSavePath.'/']);
						if($QrCode['status'] != 'Success' || $QrCode['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RequestType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response('Qr code not create! Due to technical error'); exit();
						}
					}

					$Response = UpdateGivenData($UpdateData."GuardianPermission::::$StPr::,::GuardianPermissionTime::::$CurrentTime","GuardianPermissionReceiveUrlKey::::$GRId",$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass,'all');
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'StPr'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response('You '.$StPr.' your child hostal Digital Gatepass request!',true,'Success',200); exit();
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Oops! There is problem accur due to technical error! You can not submit your permission'); exit();
					}
				}	
			}
			
			// Call classname public function 
			GuardianStPr::ValidedData($OrgId,$GRId,$StPr);
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