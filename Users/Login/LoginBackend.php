 <?php 
	/*
	*@FileName LoginOrganizationBackend
	*@Des Upload data to server for login user
	*@Author arpit sharma
	*/

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
	define("RootPath", "../../");

if(isset($_POST['LoginType']) && isset($_POST['LoginFor']) && isset($_POST['LoginData']) && isset($_POST['LoginPass']) && isset($_POST['LoginPeriodTime']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2']) && isset($_POST['ClientOS']) && isset($_POST['ClientTouch']) && isset($_POST['ClientBrowser'])  && isset($_POST['ClientBrowserVersion']) && isset($_POST['ClientCPU']) && isset($_POST['ClientTimeZoneName']) && isset($_POST['ClientUserAgent']) && isset($_POST['ClientLanguage'])){

	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Signup/index.php" || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Login/index.php?Organization=".$_POST['Organization'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Login/index.php"){
		session_start();
		
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF'] && $_POST['ClientUserAgent'] === $_SERVER['HTTP_USER_AGENT']){

			if($_POST['ClientUserAgent'] != $_SERVER['HTTP_USER_AGENT']){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Request send from unauthorized page");
			}

			$LoginType =  preg_replace('!\s+!', ' ',strip_tags($_POST['LoginType']));
			$LoginFor =  preg_replace('!\s+!', ' ',strip_tags($_POST['LoginFor']));
			$LoginData = strip_tags($_POST['LoginData']);
			$LoginPass = strip_tags($_POST['LoginPass']);
			$LoginPeriodTime = preg_replace('!\s+!', ' ',strip_tags($_POST['LoginPeriodTime']));
			$ClientOS = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientOS']));
			$ClientTouch = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientTouch']));
			$ClientBrowser = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientBrowser']));
			$ClientBrowserVersion = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientBrowserVersion']));
			$ClientCPU = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientCPU']));
			$ClientTimeZoneName = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientTimeZoneName']));
			$ClientUserAgent = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientUserAgent']));
			$ClientLanguage = preg_replace('!\s+!', ' ',strip_tags($_POST['ClientLanguage']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed! Try again later");
			}else{
				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			Class Login{
				public static function ValidedData($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage){
					
					// Login type validation
					if($LoginType != 'Organization' && $LoginType != 'Main'){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Login type detect");
					}

					// LoginFor valided in backend
					if($LoginType === 'Organization'){
						if($LoginFor != preg_replace("/[^a-z0-9_]/","",$LoginFor)){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid Organization found");

						}else if(strlen($LoginFor) < 5 || strlen($LoginFor) > 18){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid Organization found");
						}
					}else{
						$LoginFor = 'main_member';
					}

					if(!(strlen($ClientOS) > 0 && strlen($ClientTouch) > 0  && strlen($ClientBrowser) > 0  && strlen($ClientBrowserVersion) > 0  && strlen($ClientCPU) > 0  && strlen($ClientTimeZoneName) > 0  && strlen($ClientUserAgent) > 0  && strlen($ClientLanguage))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Process failed! Try again later");
					}

					if(strlen($LoginPeriodTime) == 0 || $LoginPeriodTime < 0 || $LoginPeriodTime != preg_replace("/[^0-9]/","",$LoginPeriodTime) || $ClientTouch !== preg_replace("/[^A-Za-z]/","",$ClientTouch) || ($ClientTouch !== "false" &&  $ClientTouch !== "true")){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Process failed! Try again later");
					}
					
					if(strlen($LoginData) == 0 || strlen($LoginPass) < 8 || strlen($LoginPass) > 32){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid loginId or Password");
					}

					Login::EncryptData($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage);
				}

				private static function EncryptData($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage){
					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					$LoginPass = hash_hmac("sha256",hash_hmac("sha512",base64_encode($LoginPass),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					Login::CkeckLoginAndAuthenticate($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass){
					
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
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/Normal/CheckTableAvailability/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
					
					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'UserUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					if($ResponseLogin['status'] === 'Success' || $ResponseLogin['code'] === 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User already logined'); exit();
					}
					Login::AuthenticateLogin($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount);
				}

				private static function AuthenticateLogin($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount){
					if($LoginType === 'Organization'){
						$Response = FetchReuiredDataByGivenData("Username::::$LoginFor::,::SignupType::::$LoginType",'UserUrl::::OrganizationType::::Username',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');
						
						if($Response['status'] === 'Success' && $Response['code'] === 200){
							$OrganizationUserUrl = $Response['msg']->UserUrl;
							$OrganizationType = $Response['msg']->OrganizationType;
							$OrganizationName = $Response['msg']->Username;
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Invalid Organization found');
						}

						$Response = CheckTableAvailability($OrganizationUserUrl,$PdoOrganizationUserAccount);
						if($Response['status'] != 'Success' || $Response['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Invalid Organization found');
						}
						$Temp = $PdoOrganizationUserAccount;
						
					}else{
						$OrganizationUserUrl = 'main_member';
						$OrganizationType = 'Main';
						$Temp = $PdoMainUserAccountDb;
					}
					// Verify login Credential
					$Response = CheckGivenDataAvailability("Mobile::::$LoginData::,::Password::::$LoginPass",$Temp,$OrganizationUserUrl,$EncodeAndEncryptPass,'all','Active');
					if($Response['status'] != "Success" || $Response['msg'] != "Available"){
						$Response = CheckGivenDataAvailability("Email::::$LoginData::,::Password::::$LoginPass",$Temp,$OrganizationUserUrl,$EncodeAndEncryptPass,'all','Active');
						if($Response['status'] != "Success" || $Response['msg'] != "Available"){
							$Response = CheckGivenDataAvailability("UniqueId::::$LoginData::,::Password::::$LoginPass",$Temp,$OrganizationUserUrl,$EncodeAndEncryptPass,'all','Active');
							if($Response['status'] != "Success" || $Response['msg'] != "Available"){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Inavlid username or password"); exit();
							}else{
								$LoginDataFor = 'UniqueId';
							}
						}else{
							$LoginDataFor = 'Email';
						}
					}else{
						$LoginDataFor = 'Mobile';
					}

					if($Response['totalrows'] != 1){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Process failed! Try again later");
					}

					Login::SetAutoLogin($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$OrganizationUserUrl,$OrganizationType,$LoginDataFor,$OrganizationName);
				}

				private static function SetAutoLogin($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$OrganizationUserUrl,$OrganizationType,$LoginDataFor,$OrganizationName){

					function rand_string($length){
						$RandStr = "";
						$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
						$size = strlen( $chars ); 
						for( $i = 0; $i < $length; $i++ ) {  
						$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
						} 
						return $RandStr;
					}
					
					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();
					$LUID = 'LUID:'.rand_string(10).$CurrentTime.rand_string(10);
					
					if($LoginType === 'Organization'){
						$Response = CheckGivenDataAvailability("LoginUniqueId::::$LUID",$PdoOrganizationUserAccount,$OrganizationUserUrl,$EncodeAndEncryptPass);
					}else{
						$Response = CheckGivenDataAvailability("LoginUniqueId::::$LUID",$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass);
					}

					if($Response['status'] != "Success" || $Response['msg'] != "NotAvailable"){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Process failed! Try again");
					}else{

						$ClientAuth = ["LoginPeriodTime"=>$LoginPeriodTime,"BrowserClientId1"=>$BrowserClientId1,"BrowserClientId2"=>$BrowserClientId2,"ClientOSFull"=>$ClientOS,"ClientTouch"=>$ClientTouch,"ClientBrowserName"=>$ClientBrowser,"ClientBrowserVersion"=>$ClientBrowserVersion,"ClientCPUName"=>$ClientCPU,"ClientTimeZoneName"=>$ClientTimeZoneName,"ClientLanguageName"=>$ClientLanguage]; // Browser data which get from clint side by ajax(using post/get request)

						$ServerAuth = ["UserAgent"=>$_SERVER['HTTP_USER_AGENT']]; // Browser data get by server

						$CustomAuth = ["LUID"=>$LUID,"LoginTime"=>$CurrentTime,"LoginExpTime"=>$CurrentTime+$LoginPeriodTime];

						$LoginTokenData = serialize(["ClientAuth"=>$ClientAuth,"ServerAuth"=>$ServerAuth,"CustomAuth"=>$CustomAuth]);

						if(!method_exists('EncodeAndEncrypt', 'exe_task_private') || !method_exists('EncodeAndEncrypt', 'encrypt_method')){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Process failed! Try again later");
						}

						$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,$LUID, $EncodeAndEncryptPass,"false");
						if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
							$EncryptLUID = $Response['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Process failed! Try again");
						}
						
						if($LoginType === 'Organization'){

							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,$OrganizationUserUrl, $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptLoginFor = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}
							
							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,'OrganizationMember', $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptLoginAs = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}

							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,$OrganizationType, $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptOrganizationType = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}
							$LgDetailsUpdateDbName = $PdoOrganizationUserAccount;
						}else{

							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,$OrganizationUserUrl, $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptLoginFor = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}
							
							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,'MainMember', $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptLoginAs = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}

							$Response = EncodeAndEncrypt::exe_task_private("encrypt_method" ,$OrganizationType, $EncodeAndEncryptPass,"false");
							if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
								$EncryptOrganizationType = $Response['msg'];
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Process failed! Try again");
							}
							$LgDetailsUpdateDbName = $PdoMainUserAccountDb;
						}

						$Response = UpdateGivenData("LoginUniqueId::::$LUID::,::LoginTokenData::::$LoginTokenData","$LoginDataFor::::$LoginData::,::Password::::$LoginPass",$LgDetailsUpdateDbName,$OrganizationUserUrl,$EncodeAndEncryptPass,'all');
						if($Response['status'] === 'Success' && $Response['code'] === 200){
							setcookie( 'LUID', $EncryptLUID, $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'LAS', $EncryptLoginAs, $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'LFR', $EncryptLoginFor, $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'LORT', $EncryptOrganizationType, $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'UNM', base64_encode($LoginData), $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'LORG', base64_encode($Organization), $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'OrganizationType', base64_encode($OrganizationType), $CurrentTime+(86000*30*12), '/', false, false, true);
							setcookie( 'OrganizationName', base64_encode($OrganizationName), $CurrentTime+(86000*30*12), '/', false, false, true);
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);

							return_response(['msg'=>'Successfully login!','OrganizationType'=>$OrganizationType],true,'Success',200);
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Process failed! Try again");
						}
					}
				}
			}
			
			// Call Login class
			Login::ValidedData($LoginType,$LoginFor,$LoginData,$LoginPass,$LoginPeriodTime,$BrowserClientId1,$BrowserClientId2,$ClientOS,$ClientTouch,$ClientBrowser,$ClientBrowserVersion,$ClientCPU,$ClientTimeZoneName,$ClientUserAgent,$ClientLanguage);
		}else{
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response("Invalid Token Id! Refresh page");
		}
	}else{
		header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
	}
}else{
	header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
}
?>