<?php 
/*
*@FileName GetResetPasswordOtp.php
*@Des ---
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
define("RootPath", "../../../");

// Get all requested data
if(isset($_POST['Mobile']) && isset($_POST['OrgName']) && isset($_POST['Token_CSRF'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/LibraryStore/SiteComponents/ResetPassword/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$Mobile = preg_replace('!\s+!', ' ',strip_tags($_POST['Mobile']));
			$OrgName = preg_replace('!\s+!', ' ',strip_tags($_POST['OrgName']));


			class GetResetPasswordOtp 
			{
				public static function ValidedData($Mobile,$OrgName){
					
					date_default_timezone_set('Asia/Kolkata');

					// Mobile number  valided in backend
					if($Mobile != preg_replace("/[^0-9]/","",$Mobile)){
						return_response("Mobile number contains invalid characters");

					}else if(strlen($Mobile) != 10){
						return_response("Mobile number must be between 10 characters long");
					}

					if($OrgName != preg_replace("/[^a-z0-9_]/","",$OrgName)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Organization name detect");

					}else if(strlen($OrgName) < 4 || strlen($OrgName) > 18){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Organization name detect");
					}

					// Call encode_post_input function
					GetResetPasswordOtp::EncryptData($Mobile,$OrgName);
				}

				// Encode data by self design method
				private static function EncryptData($Mobile,$OrgName){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
					
					// Call profile_imageResize function
					GetResetPasswordOtp::CkeckLoginAndAuthenticate($Mobile,$OrgName,$EncodeAndEncryptPass);
				}
				private static function CkeckLoginAndAuthenticate($Mobile,$OrgName,$EncodeAndEncryptPass){
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

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");
					require_once (RootPath."Users/Service/Dashbord/SMS_axtxbyl4qn1583926727nb91ipl6rj/SendSms/Fast2SmsApi/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/ServiceUseReport/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/ServiceStatusForOrg/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoDeleteWithAes/index.php");

					$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);
					
					if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Sorry! Client currently logined, So you can not reset password'); exit();
					}

					GetResetPasswordOtp::GetResetPasswordOtpProccess($Mobile,$OrgName,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage);
				}
				
				private static function GetResetPasswordOtpProccess($Mobile,$OrgName,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();

					$TempOtp = rand(010101,939213);

					if(strtolower($OrgName) != 'main'){
						$GetOrgDtls = AptPdoFetchWithAes(['Condtion'=> "Username::::$OrgName", 'FetchData'=>'UserUrl', 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>1]);
						if($GetOrgDtls['code'] != 200 && $GetOrgDtls['code'] != 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("We can not fetch Org details due to technical error"); exit();
						}else if($GetOrgDtls['code'] == 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid Organization name detect"); exit();
						}
						$TbName = $GetOrgDtls['msg']->UserUrl;
						$DbCon = $PdoOrganizationUserAccount;
					}else{
						$TbName = 'main_member';
						$DbCon = $PdoMainUserAccountDb;
					}

					$GetUserData = AptPdoFetchWithAes(['Condtion'=> "Mobile::::$Mobile", 'FetchData'=>'OtpData', 'DbCon'=> $DbCon, 'TbName'=> $TbName, 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>1]);
					if($GetUserData['code'] != 200 && $GetUserData['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("We can not fetch User details due to technical error"); exit();
					}else if($GetUserData['code'] == 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Mobile number detect"); exit();
					}

					$GetOtpDataArray = unserialize($GetUserData['msg']->OtpData);
					if($GetOtpDataArray['ResetOtpData']['OtpExp'] >= $CurrentTime){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'GetOtpDataArray'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response("OTP already sent on ".$GetOtpDataArray['ResetOtpData']['OtpSendTo']." at ".date('d-M-Y, h:i:s A',$GetOtpDataArray['ResetOtpData']['OtpSendTime']).' and it is valided for 24 hours',true,'Success',200); exit();
					}

					if(strtolower($OrgName) != 'main'){
						$SMSServiceStatusForOrg = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$GetOrgDtls['msg']->UserUrl,'CurrentTime'=>$CurrentTime]);
						if($SMSServiceStatusForOrg['code'] != 200 || $SMSServiceStatusForOrg['msg']['IsServiceBuyed'] != True || $SMSServiceStatusForOrg['msg']['IsServiceSetUp'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Sms service not active for this Organization so you can not reset password!'); exit();
						}
					}

					$GetOtpDataArray['ResetOtpData']['OtpExp'] = $CurrentTime+86400;
					$GetOtpDataArray['ResetOtpData']['Otp'] = $TempOtp;
					$GetOtpDataArray['ResetOtpData']['OtpTry'] = 0;
					$GetOtpDataArray['ResetOtpData']['OtpUsed'] = 'false';
					$GetOtpDataArray['ResetOtpData']['OtpSendTo'] = $Mobile;
					$GetOtpDataArray['ResetOtpData']['OtpSendTime'] = $CurrentTime;
					$GetOtpData = serialize($GetOtpDataArray);

					if(strtolower($OrgName) != 'main'){

						$SmsResponse = SendSmsByFast2Sms(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$GetOrgDtls['msg']->UserUrl,'CurrentTime'=>$CurrentTime,'SmsBody'=>'24753','SendTo'=>$Mobile,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#CC#}','variables_values'=>substr($TempOtp, 0, 15),'MsgType'=>'QuickTransactional','SendBy'=>'Unknown','MsgLable'=>'ResetPasswordAndPin','ExtMsg'=>"Your EsyManager OTP is ".substr($TempOtp, 0, 15)]);
					}else{
						$SmsResponse = SendSmsByFast2Sms(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>'main','CurrentTime'=>$CurrentTime,'SmsBody'=>'24753','SendTo'=>$Mobile,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#CC#}','variables_values'=>substr($TempOtp, 0, 15),'MsgType'=>'QuickTransactional','SendBy'=>'Unknown','MsgLable'=>'ResetPasswordAndPin','ExtMsg'=>"Your EsyManager OTP is ".substr($TempOtp, 0, 15),'UsedBy'=>'Main']);
					}

					if($SmsResponse['status'] != 'Success' || $SmsResponse['code'] != 200){
						if($SmsResponse['reason'] == 411){
							$error_dic = $Mobile. " Mobile number detect invalid!";
						}else if($SmsResponse['surc'] == 2){
							#$error_dic = $SmsResponse['msg'];
							$error_dic = 'Sms service not active due to Insufficient SMS balance for this Organization so you can not reset password!';
						}else if($SmsResponse['F2SC'] == 400){
							$error_dic = 'Sms service not work due to no internet connection, please check your internet connection';
						}
						if($error_dic != ''){
							return_response($error_dic); exit();
						}
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Sms service not work properly due to technical error or internet connection!'); exit();
					}

					$UpdateOtpData = AptPdoUpdateWithAes(['Update'=>"OtpData::::$GetOtpData",'Condtion'=>"Mobile::::$Mobile",'DbCon'=>$DbCon,'TbName'=>$TbName,'EPass'=>$EncodeAndEncryptPass]);
		            if($UpdateOtpData['code'] == 200){
		            	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'Mobile'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response("OTP send on $Mobile for reset your password",true,'Success',200); exit();
		            }else{
		            	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'Mobile'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response("OTP send on $Mobile for reset your password, but it is not working due to technical error",true,'Error',404); exit();
		            }
					
				}	
			}
			
			// Call classname public function 
			GetResetPasswordOtp::ValidedData($Mobile,$OrgName);
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