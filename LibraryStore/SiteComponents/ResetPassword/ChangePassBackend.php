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
if(isset($_POST['Mobile']) && isset($_POST['OrgName']) && isset($_POST['NewPass']) && isset($_POST['NewPin']) && isset($_POST['Otp']) && isset($_POST['Token_CSRF'])){
	require_once (RootPath."JsonShowError/index.php");

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/LibraryStore/SiteComponents/ResetPassword/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$Mobile = preg_replace('!\s+!', ' ',strip_tags($_POST['Mobile']));
			$OrgName = preg_replace('!\s+!', ' ',strip_tags($_POST['OrgName']));
			$NewPass = preg_replace('!\s+!', ' ',strip_tags($_POST['NewPass']));
			$NewPin = preg_replace('!\s+!', ' ',strip_tags($_POST['NewPin']));
			$Otp = preg_replace('!\s+!', ' ',strip_tags($_POST['Otp']));

			class GetResetPasswordOtp 
			{
				public static function ValidedData($Mobile,$OrgName,$NewPass,$NewPin,$Otp){
					
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
					
					if(strlen($NewPass) < 8 || strlen($NewPass) > 32){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Password must be between 8 and 32 characters long");

					}

					// Signup password valided in backend
					if($NewPin != preg_replace("/[^0-9]/","",$NewPin)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Security code contains invalid characters");

					}else if(strlen($NewPin) < 4 || strlen($NewPin) > 6){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Security code must be between 4 to 6 digit long");
					}

					// Call encode_post_input function
					GetResetPasswordOtp::EncryptData($Mobile,$OrgName,$NewPass,$NewPin,$Otp);
				}

				// Encode data by self design method
				private static function EncryptData($Mobile,$OrgName,$NewPass,$NewPin,$Otp){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$NewPass = hash_hmac("sha256",hash_hmac("sha512",base64_encode($NewPass),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create Hash Password
					$NewPin =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($NewPin),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					GetResetPasswordOtp::CkeckLoginAndAuthenticate($Mobile,$OrgName,$NewPass,$NewPin,$Otp,$EncodeAndEncryptPass);
				}
				private static function CkeckLoginAndAuthenticate($Mobile,$OrgName,$NewPass,$NewPin,$Otp,$EncodeAndEncryptPass){
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

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

					$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);
					
					if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Sorry! Client currently logined, So you can not reset password'); exit();
					}

					GetResetPasswordOtp::GetResetPasswordOtpProccess($Mobile,$OrgName,$NewPass,$NewPin,$Otp,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage);
				}
				
				private static function GetResetPasswordOtpProccess($Mobile,$OrgName,$NewPass,$NewPin,$Otp,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage){

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
					if($GetOtpDataArray['ResetOtpData']['OtpExp'] < $CurrentTime || $GetOtpDataArray['ResetOtpData']['OtpUsed'] != 'false' || $GetOtpDataArray['ResetOtpData']['OtpTry'] >= 3){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("OTP Expired so please genrate new OTP"); exit();
					}

		            $GetOtpDataArray['ResetOtpData']['OtpTry'] = $GetOtpDataArray['ResetOtpData']['OtpTry']+1;
		            $TryOtp = $GetOtpDataArray['ResetOtpData']['OtpTry'];
					if($GetOtpDataArray['ResetOtpData']['Otp'] != $Otp){
						$GetOtpDataArray['ResetOtpData']['OtpUsed'] = 'false';
						$OtpMatched = false;
					}else{
						$GetOtpDataArray['ResetOtpData']['OtpUsed'] = 'true';
						$OtpMatched = true;
					}
					$GetOtpData = serialize($GetOtpDataArray);

					$UpdateOtpData = AptPdoUpdateWithAes(['Update'=>"OtpData::::$GetOtpData",'Condtion'=>"Mobile::::$Mobile",'DbCon'=>$DbCon,'TbName'=>$TbName,'EPass'=>$EncodeAndEncryptPass]);
		            if($UpdateOtpData['code'] != 200){
		            	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("We can not process change password, because of an technical error"); exit();
		            }

		            if($OtpMatched != true){
		            	if($TryOtp < 3){
		            		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid OTP detect, please enter correct OTP"); exit();
		            	}else{
		            		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid OTP detect And you cross maximum limit of enter wrong otp, Now you can try again after ".$GetOtpDataArray['ResetOtpData']['OtpExp']); exit();
		            	}
		            }

					$UpdatePass = AptPdoUpdateWithAes(['Update'=>"Password::::$NewPass::,::SecurityCode::::$NewPin::,::PassChangeTime::::$CurrentTime",'Condtion'=>"Mobile::::$Mobile",'DbCon'=>$DbCon,'TbName'=>$TbName,'EPass'=>$EncodeAndEncryptPass]);
		            if($UpdatePass['code'] != 200 && $UpdatePass['code'] != 404){
		            	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Oops! Password not updated due to an technical error"); exit();
		            }else{
		            	setcookie( 'LORG', base64_encode($OrgName), $CurrentTime+(86000*30*12), '/', false, false, true);
		            	setcookie( 'UNM', base64_encode($Mobile), $CurrentTime+(86000*30*12), '/', false, false, true);
		            	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Password And Pin Successfully updated",true,'Success',200); exit();
		            }
					
				}	
			}
			
			// Call classname public function 
			GetResetPasswordOtp::ValidedData($Mobile,$OrgName,$NewPass,$NewPin,$Otp);
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