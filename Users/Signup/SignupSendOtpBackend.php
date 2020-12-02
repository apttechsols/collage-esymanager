<?php 
/*
*@FileName SignupOTPOrganizationBackend
*@Des Upload data to server for create user
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
define("RootPath", "../../");

// Get all requested data
if(isset($_POST['MobileNo']) && isset($_POST['Email']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php");
	
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName ."/Users/Signup/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			$MobileNo = preg_replace('!\s+!', ' ',strip_tags($_POST['MobileNo']));
			$Email = preg_replace('!\s+!', ' ',strip_tags($_POST['Email']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
				return_response("Process failed due to invalid data send!"); exit();
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class SignupOTP{
				public static function ValidedData($MobOTP,$EmailOTP,$MobileNo,$Email,$BrowserClientId1,$BrowserClientId2){
					// mobile number valided in backend
					if($MobileNo != preg_replace("/[^0-9]/","",$MobileNo)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Mobile number contains invalid characters");

					}else if(strlen($MobileNo) != 10){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Mobile number must be 10 digit long");
					}

					if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid email id detect");
					}

					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();
					$MobOTP = rand(027123,998634);
					$EmailOTP = rand(0271232,9986349);

					$MobOtpGen = false;
					if($_SESSION['SignupMobOtp'] != ''){
						$GetMobOtpArray = unserialize($_SESSION['SignupMobOtp']);
						if($GetMobOtpArray['OTP'] == '' || $GetMobOtpArray['Try'] >= 3 || $GetMobOtpArray['Exp'] <= ($CurrentTime-300) || $GetMobOtpArray['Used'] != false || $GetMobOtpArray['MobNo'] != $MobileNo || $GetMobOtpArray['BrowserClientId1'] != $BrowserClientId1 || $GetMobOtpArray['BrowserClientId2'] != $BrowserClientId2){
							$MobOTPArray = serialize(['OTP'=>$MobOTP,'Exp'=>$CurrentTime+1800,'Try'=>0,'Used'=>false,'MobNo'=>$MobileNo,'BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2,'OTPSentTime'=>$CurrentTime]);
							$_SESSION['SignupMobOtp'] = $MobOTPArray;
							$MobOtpGen = true;
							$EmailOTPArray = serialize(['OTP'=>$MobOTP,'Exp'=>$CurrentTime+1800,'Try'=>0,'Used'=>false,'Email'=>$Email,'BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2,'OTPSentTime'=>$CurrentTime]);
							$_SESSION['SignupEmailOTP'] = $EmailOTPArray;
						}
					}else{
						$MobOTPArray = serialize(['OTP'=>$MobOTP,'Exp'=>$CurrentTime+1800,'Try'=>0,'Used'=>false,'MobNo'=>$MobileNo,'BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2,'OTPSentTime'=>$CurrentTime]);
						$_SESSION['SignupMobOtp'] = $MobOTPArray;
						$MobOtpGen = true;
						$EmailOTPArray = serialize(['OTP'=>$MobOTP,'Exp'=>$CurrentTime+1800,'Try'=>0,'Used'=>false,'Email'=>$Email,'BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2,'OTPSentTime'=>$CurrentTime]);
						$_SESSION['SignupEmailOTP'] = $EmailOTPArray;
					}

					SignupOTP::CkeckLoginAndAuthenticate($MobOTP,$EmailOTP,$MobileNo,$Email,$BrowserClientId1,$BrowserClientId2,$CurrentTime,$MobOtpGen);
				}

				private static function CkeckLoginAndAuthenticate($MobOTP,$EmailOTP,$MobileNo,$Email,$BrowserClientId1,$BrowserClientId2,$CurrentTime,$MobOtpGen){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

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

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoDeleteWithAes/index.php");

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");

					require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");
					require_once (RootPath."Users/Service/Dashbord/SMS_axtxbyl4qn1583926727nb91ipl6rj/SendSms/Fast2SmsApi/index.php");
					
					// Check user login
					$ResponseLogin =  IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);
					if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Oops! Client already logined So you can not signup when you are logined'); exit();
					}

					if($Email == 'esymanager@gmail.com' || $MobileNo == '7597078875'){
						$GetMainAccountDtls = AptPdoFetchWithAes(['Condtion'=> "SignupType::::Main", 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EncodeAndEncryptPass]);
						if($GetMainAccountDtls['code'] != 200 && $GetMainAccountDtls['code'] != 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("We can not fetch Service data due to technical error"); exit();
						}else if($GetMainAccountDtls['totalrows'] > 0){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Maximum Singup limit reached! Currently we can not available for more account"); exit();
						}
					}else{
						$GetMainAccountDtls = AptPdoFetchWithAes(['Condtion'=> "SignupType::::Organization", 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EncodeAndEncryptPass]);
						if($GetMainAccountDtls['code'] != 200 && $GetMainAccountDtls['code'] != 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("We can not fetch Service data due to technical error"); exit();
						}else if($GetMainAccountDtls['totalrows'] > 0){
							/*foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Maximum Singup limit reached! Currently we can not available for more account"); exit();*/
						}
					}
					
					if($MobOtpGen == true){

						$SmsResponse = SendSmsByFast2Sms(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>'main','CurrentTime'=>$CurrentTime,'SmsBody'=>'24753','SendTo'=>$MobileNo,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#CC#}','variables_values'=>substr($MobOTP, 0, 15),'MsgType'=>'QuickTransactional','SendBy'=>'Unknown','MsgLable'=>'SignupMobileOtp','ExtMsg'=>"Your EsyManager OTP is ".substr($MobOTP, 0, 15),'UsedBy'=>'Main']);

						if($SmsResponse['status'] != 'Success' || $SmsResponse['code'] != 200){
							if($SmsResponse['reason'] == 411){
								$error_dic = $Mobile. " Mobile number detect invalid!";
							}else if($SmsResponse['surc'] == 2){
								$error_dic = $SmsResponse['msg'];
							}
							if($error_dic != ''){
								return_response($error_dic); exit();
							}

							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('OTP not send due to technical error or internet connection!'); exit();
						}
					}

					if($MobOtpGen == true){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			       	 	return_response('Email And Mobile OTP send successfully on your mobile number And Email',true,'Success',200);
					}else{
						$TempOtpSendTime = unserialize($_SESSION['SignupMobOtp'])['OTPSentTime'];
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'TempOtpSendTime'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
			        	return_response('Email OTP send successfully on your Email and Mobile OTP Already sent on mobile at '.date('d-M-Y, h:i:s A',unserialize($_SESSION['SignupMobOtp'])['OTPSentTime']),true,'Success',200);
					}
				}
			}
			
			// Call classname public function 
			SignupOTP::ValidedData($MobOTP,$EmailOTP,$MobileNo,$Email,$BrowserClientId1,$BrowserClientId2);
		}else{
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response("Invalid Token Id! Refresh page");
		}
	}else{
		header("Location: " . RootPath . "PageNotAvailable/index.php"); die();
	}
}else{
	header("Location: " . RootPath . "PageNotAvailable/index.php"); die();
}	
?>