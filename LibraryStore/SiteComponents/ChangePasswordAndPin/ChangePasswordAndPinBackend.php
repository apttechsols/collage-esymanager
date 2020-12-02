 <?php 
/*
*@FileName ChangePasswordAndPin.php
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
if(isset($_POST['OldPass']) && isset($_POST['OldPin']) && isset($_POST['NewPass']) && isset($_POST['NewPin']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/LibraryStore/SiteComponents/ChangePasswordAndPin/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$OldPass = preg_replace('!\s+!', ' ',strip_tags($_POST['OldPass']));
			$OldPin = preg_replace('!\s+!', ' ',strip_tags($_POST['OldPin']));
			$NewPass = preg_replace('!\s+!', ' ',strip_tags($_POST['NewPass']));
			$NewPin = preg_replace('!\s+!', ' ',strip_tags($_POST['NewPin']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed due to invalid data send! Try again later");
			}else{
				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class ChangePasswordAndPin{

				public static function ValidedData($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2){
					
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
					ChangePasswordAndPin::EncryptData($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$OldPass = hash_hmac("sha256",hash_hmac("sha512",base64_encode($OldPass),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create Hash Password
					$OldPin =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($OldPin),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create Hash Password
					$NewPass = hash_hmac("sha256",hash_hmac("sha512",base64_encode($NewPass),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create Hash Password
					$NewPin =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($NewPin),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					ChangePasswordAndPin::CkeckLoginAndAuthenticate($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}
				private static function CkeckLoginAndAuthenticate($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
					//Secrate code for access database file
					$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

					//Secrate code for access otherfiles file
					$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
					
					// Access main_db file to access data base connection ($PdoMainUserAccountDb)
					require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

					// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

					$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass,'FetchDtls'=>'UserUrl::::Password::::SecurityCode','ClientData'=>['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2],'CheckType'=>'ClientAndServer']);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Sorry! Client not logined, So you can not changae you password and Pin'); exit();
					}

					ChangePasswordAndPin::ChangePasswordAndPinProccess($OldPass,$OldPin,$NewPass,$NewPin,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$ResponseLogin);
				}
				
				private static function ChangePasswordAndPinProccess($OldPass,$OldPin,$NewPass,$NewPin,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$ResponseLogin){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();

					if($ResponseLogin['msg']['Password'] != $OldPass || $ResponseLogin['msg']['SecurityCode'] != $OldPin){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Wrong Old Password Or Pin detect"); exit();
					}

					if($ResponseLogin['LAS'] != 'MainMember'){
						$TbName = $ResponseLogin['LFR'];
						$DbCon = $PdoOrganizationUserAccount;
					}else{
						$TbName = 'main_member';
						$DbCon = $PdoMainUserAccountDb;
					}

					$UpdatePass = AptPdoUpdateWithAes(['Update'=>"Password::::$NewPass::,::SecurityCode::::$NewPin::,::PassChangeTime::::$CurrentTime",'Condtion'=>"UserUrl::::".$ResponseLogin['msg']['UserUrl'],'DbCon'=>$DbCon,'TbName'=>$TbName,'EPass'=>$EncodeAndEncryptPass]);
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
			ChangePasswordAndPin::ValidedData($OldPass,$OldPin,$NewPass,$NewPin,$BrowserClientId1,$BrowserClientId2);
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