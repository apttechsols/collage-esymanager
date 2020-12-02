<?php 
/*
*@FileName SignupOrganizationBackend
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
if(isset($_POST['SignupType']) && isset($_POST['Fullname']) && isset($_POST['Gender']) && isset($_POST['OrganizationType']) && isset($_POST['PostionRequest']) && isset($_POST['Email']) && isset($_POST['EmailOTP']) && isset($_POST['MobileNumber']) && isset($_POST['MobOTP']) && isset($_POST['OrganizationName']) && isset($_POST['Bio']) && isset($_POST['Address']) && isset($_POST['City']) && isset($_POST['State'])  && isset($_POST['Pincode']) && isset($_POST['Country']) && isset($_POST['Password']) && isset($_POST['ConfirmPassword']) && isset($_POST['SecurityCode']) && isset($_FILES['ProfileImage']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file
	
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName ."/Users/Signup/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos) 
			$SignupType = preg_replace('!\s+!', ' ',strip_tags($_POST['SignupType']));
			$Username = preg_replace('!\s+!', ' ',strip_tags($_POST['Username']));
			$Fullname =  preg_replace('!\s+!', ' ',strip_tags($_POST['Fullname']));
			$Gender =  preg_replace('!\s+!', ' ',strip_tags($_POST['Gender']));
			$OrganizationType =  preg_replace('!\s+!', ' ',strip_tags($_POST['OrganizationType']));
			$PostionRequest =  preg_replace('!\s+!', ' ',strip_tags($_POST['PostionRequest']));
			$Email =  preg_replace('!\s+!', ' ',strip_tags($_POST['Email']));
			$EmailOTP =  preg_replace('!\s+!', ' ',strip_tags($_POST['EmailOTP']));
			$MobileNumber =  preg_replace('!\s+!', ' ',strip_tags($_POST['MobileNumber']));
			$MobOTP =  preg_replace('!\s+!', ' ',strip_tags($_POST['MobOTP']));
			$OrganizationName =  preg_replace('!\s+!', ' ',strip_tags($_POST['OrganizationName']));
			$Bio =  preg_replace('!\s+!', ' ',strip_tags($_POST['Bio']));
			$Address =  preg_replace('!\s+!', ' ',strip_tags($_POST['Address']));
			$City =  preg_replace('!\s+!', ' ',strip_tags($_POST['City']));
			$State =  preg_replace('!\s+!', ' ',strip_tags($_POST['State']));
			$Pincode =  preg_replace('!\s+!', ' ',strip_tags($_POST['Pincode']));
			$Country =  preg_replace('!\s+!', ' ',strip_tags($_POST['Country']));
			$Password =  preg_replace('!\s+!', ' ',strip_tags($_POST['Password']));
			$ConfirmPassword =  preg_replace('!\s+!', ' ',strip_tags($_POST['ConfirmPassword']));
			$SecurityCode =  preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			$GLOBALS['ProfileImage'] = $_FILES['ProfileImage'];
			$GLOBALS['ProfileImage_tmp'] = $_FILES['ProfileImage']['tmp_name'];
			$ProfileImage_size = round($_FILES['ProfileImage']['size'] / 1024, 2);
			$ProfileImage_ext = pathinfo($_FILES['ProfileImage']['name'], PATHINFO_EXTENSION);
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
				return_response("Process failed due to invalid data send!"); exit();
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class Signup{	
				/*
				*@Method name ValidedPostInput
				*@Des valided all user input data
				*/
				public static function ValidedData($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$ConfirmPassword,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EmailOTP,$MobOTP){

					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();
					$GetMobOtpArray = unserialize($_SESSION['SignupMobOtp']);
					$GetEmailOTPArray = unserialize($_SESSION['SignupEmailOTP']);

					if($SignupType != 'Main'){
						$TempString = "$SignupType $Username $Fullname $Gender $OrganizationType $PostionRequest $Email $MobileNumber $OrganizationName $Bio $Address $City $State $Pincode $Country $SecurityCode $ProfileImage_size $ProfileImage_ext $BrowserClientId1 $BrowserClientId2";
						if(stripos(preg_replace("/[^A-Za-z]/","",strtolower($TempString)),"esymanager") !== false){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("You can not use esymanager in any field excluding password");
						}
					}

					// Signup Username valided in backend
					if($SignupType != 'Organization' && $SignupType != 'Main'){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid signup type Choosed");

					}

					// Signup Username valided in backend
					if($Username != preg_replace("/[^a-z0-9_]/","",$Username)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Username contains invalid characters");

					}else if(strlen($Username) < 5 || strlen($Username) > 18){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Username name must be between 5 and 18 characters long");
					}

					// Signup fullname valided in backend
					if($Fullname != preg_replace("/[^A-Za-z ]/","", preg_replace("/^[ ]/"," ",$Fullname))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Fullname contains invalid characters");

					}else if(substr($Fullname,0,1) != preg_replace("/[^A-Z]/","", substr($Fullname,0,1))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Fullname first letter must be capital");

					}else if(strlen($Fullname) < 6 || strlen($Fullname) > 30){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Fullname name must be between 6 and 30 characters long");

					}else if(strlen(explode(" ",$Fullname)[0]) == 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Fullname look like first name");

					}else if(strlen(explode(" ",$Fullname)[1]) == 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Fullname look like first name");
					}
					
					// Signup gender valided in backend
					if($Gender != "Male" && $Gender != "Female" && $Gender != "Organization"){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Gender contains invalid characters");
					}

					if($SignupType === 'Organization'){
						// Signup organization type valided in backend
						if($OrganizationType != "College"){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("organization type contains invalid characters");
						}
						$PostionRequest = 'Organization';
					}else if($SignupType === 'Main'){ 
						// Signup Postion request valided in backend
						if($PostionRequest != "Manager" && $PostionRequest != "ServiceManager" && $PostionRequest != "SalesManager" && $PostionRequest != "CustomerCare"){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid Postion request Choosed");
						}
						$OrganizationType = 'Main';
					}else{
						return_response('Invalid Signup Type Found'); exit();
					}

					if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid email id detect");
					}
					
					// Signup mobile number  valided in backend
					if($MobileNumber != preg_replace("/[^0-9]/","",$MobileNumber)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Mobile number contains invalid characters");

					}else if(strlen($MobileNumber) != 10){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Mobile number must be 10 digit long");
					}

					if($SignupType === 'Organization'){
						// Signup organization name valided in backend
						if($OrganizationName != preg_replace("/[^A-Za-z0-9- _.]/","",preg_replace("/^[-]/", '-',preg_replace("/^[_]/", '_',preg_replace("/^[.]/", '.',preg_replace("/^[ ]/", ' ',$OrganizationName)))))){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Organization name contains invalid characters");

						}else if(substr($OrganizationName,0,1) != preg_replace("/[^A-Z]/","",substr($OrganizationName,0,1))){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Organization name first letter must be capital");

						}else if(strlen($OrganizationName) < 3 || strlen($OrganizationName) > 50){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Organization name must be between 3 and 50 characters long");
						}
						$Bio = 'It is an Organization';
					}else{
						// Signup Bio valided in backend
						if(strlen($Bio) > 80 || strlen($Bio) < 30){
							return_response('Bio must be between 30 to 80 characters long');
						}else if($Bio != preg_replace("/[^A-Za-z0-9- _,.]/","",preg_replace("/^[-]/", '-',preg_replace("/^[_]/", '_',preg_replace("/^[.]/", '.',preg_replace("/^[ ]/", ' ',preg_replace("/^[,]/", ',',$Bio))))))){
							return_response("Bio contains invalid characters");
						}
						$OrganizationName = 'Main';

					}
					
					// Signup organization name valided in backend
					if($City != preg_replace("/[^A-Za-z0-9 ]/","",preg_replace("/^[ ]/", ' ',$City))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("City name contains invalid characters");

					}else if(substr($City,0,1) != preg_replace("/[^A-Z]/","",substr($City,0,1))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("City name first letter must be capital");

					}else if(strlen($City) < 2 || strlen($City) > 50){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("City name must be between 2 and 50 characters long");
					}

					// Signup organization name valided in backend
					if($State != preg_replace("/[^A-Za-z ]/","",preg_replace("/^[ ]/", ' ',$State))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("State name contains invalid characters");

					}else if(substr($State,0,1) != preg_replace("/[^A-Z]/","",substr($State,0,1))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("State name first letter must be capital");

					}else if(strlen($State) < 2 || strlen($State) > 50){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("State name must be between 2 and 50 characters long");
					}


					// Signup organization name valided in backend
					if($Pincode != preg_replace("/[^0-9]/","",$Pincode)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Pincode contains invalid characters");

					}else if(strlen($Pincode) != 6){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Pincode must be 6 digit long");
					}

					// Signup organization name valided in backend
					if($Address != preg_replace("/[^A-Za-z0-9- _.,]/","",preg_replace("/^[-]/", '-',preg_replace("/^[_]/", '_',preg_replace("/^[.]/", '.',preg_replace("/^[ ]/", ' ',preg_replace("/^[,]/", ',',$Address))))))){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Address contains invalid characters");
					}else if(strlen($Address) < 3 || strlen($Address) > 50){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Address must be between 3 and 50 characters long");
					}

					// Signup password valided in backend
					if(strlen($Password) < 8 || strlen($Password) > 32){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Password must be between 8 and 32 characters long");

					}else if($Password != $ConfirmPassword){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Password or Confirm password not mached");
					}

					// Signup password valided in backend
					if($SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Security code contains invalid characters");

					}else if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Security code must be between 4 to 6 digit long");
					}
					
					// Signup image validation
					if($ProfileImage_size > 2048){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Profile image size must be under 2Mb");

					}else if($ProfileImage_size <= 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("No Image Found");
					}

					if($SignupType == 'Organization' && $Email === 'esymanager@gmail.com'){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("This Email can not used for organization register"); exit();
					}else if($SignupType == 'Organization' && $MobileNumber === '7597078875'){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("This Mobile Number can not used for organization register"); exit();
					}

					/*if(strlen($MobOTP) != 6){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Mobile OTP detect");
					}else if($GetMobOtpArray['OTP'] != $MobOTP || $GetMobOtpArray['Try'] >= 3 || $GetMobOtpArray['Exp'] <= $CurrentTime || $GetMobOtpArray['Used'] != false || $GetMobOtpArray['MobNo'] != $MobileNumber || $GetMobOtpArray['BrowserClientId1'] != $BrowserClientId1 || $GetMobOtpArray['BrowserClientId2'] != $BrowserClientId2){
						$GetMobOtpArray['Try'] = $GetMobOtpArray['Try']+1;
						$_SESSION['SignupMobOtp'] = serialize($GetMobOtpArray);
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Mobile OTP detect");
					}

					if(strlen($EmailOTP) != 6){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Email OTP detect");
					}else if($GetEmailOTPArray['OTP'] != $EmailOTP || $GetEmailOTPArray['Try'] >= 3 || $GetEmailOTPArray['Exp'] <= $CurrentTime || $GetEmailOTPArray['Used'] != false || $GetEmailOTPArray['Email'] != $Email || $GetEmailOTPArray['BrowserClientId1'] != $BrowserClientId1 || $GetEmailOTPArray['BrowserClientId2'] != $BrowserClientId2){
						$GetEmailOTPArray['Try'] = $GetEmailOTPArray['Try']+1;
						$_SESSION['SignupEmailOTP'] = serialize($GetEmailOTPArray);
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid Email OTP detect");
					}
					$GetMobOtpArray['Used'] = true;
					$_SESSION['SignupMobOtp'] = serialize($GetMobOtpArray);
					$GetEmailOTPArray['Used'] = true;
					$_SESSION['SignupEmailOTP'] = serialize($GetEmailOTPArray);*/

					// Call encode_post_input function
					Signup::EncryptData($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2);
				}
				private static function EncryptData($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$Password = hash_hmac("sha256",hash_hmac("sha512",base64_encode($Password),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					Signup::profile_imageResize($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}
				private static function profile_imageResize($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
					
					// Resize image function
					function imageResize($imageResourceId,$width,$height) {
						$targetWidth =200;
						$targetHeight =200;
						$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
						imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
						return $targetLayer;
					}
					
					// Valided and resize Signup image
					$sourceProperties = getimagesize($GLOBALS['ProfileImage_tmp']);
					$fileNewName = time();
					$folderPath = "upload/";
					$imageType = $sourceProperties[2];
					switch ($imageType) {
						
						case IMAGETYPE_PNG:  // If Signup image is PNG
							$imageResourceId = imagecreatefrompng($GLOBALS['ProfileImage_tmp']); 
							$ResizeImageUploadMethod = imagepng; // What type of method use to upload this type og image
							break;


						case IMAGETYPE_GIF:  // If Signup image is GIF
							$imageResourceId = imagecreatefromgif($GLOBALS['ProfileImage_tmp']);
							$ResizeImageUploadMethod = imagegif; // What type of method use to upload this type og image
							break;


						case IMAGETYPE_JPEG:  // If Signup image is JPEG
							$imageResourceId = imagecreatefromjpeg($GLOBALS['ProfileImage_tmp']);
							$ResizeImageUploadMethod = imagejpeg; // What type of method use to upload this type og image
							break;


						default:  // If Signup image is Not PNG, JPEG, GIF
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("Invalid Image type");
							break;
					}
					$ResizeImageTargetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);	

					// Call ReadyToUpload function
					Signup::CkeckLoginAndAuthenticate($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$ResizeImageUploadMethod,$ResizeImageTargetLayer);
				}

				private static function CkeckLoginAndAuthenticate($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$ResizeImageUploadMethod,$ResizeImageTargetLayer){
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
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");

					/*-------------- Apt Library -----------------------*/
    				require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					
					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					if($ResponseLogin['status'] === 'Success' || $ResponseLogin['code'] === 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User already logined'); exit();
					}
					Signup::ProcessSignup($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$ResizeImageUploadMethod,$ResizeImageTargetLayer,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$ResponseLogin,$ResponsePosition);
				}

				private static function ProcessSignup($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$ResizeImageUploadMethod,$ResizeImageTargetLayer,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$ResponseLogin,$ResponsePosition){
				    
				    $GetError = [];

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time(); // Take current time in sec

					/* 
					*@Method name rand_string
					*@Des Rndom string genrater
					*/
					function rand_string( $length ) {  
						$RandStr = "";
						$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
						$size = strlen( $chars ); 
						for( $i = 0; $i < $length; $i++ ) {  
						$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
						} 
						return $RandStr;
					}

					$Number1 = floor((29 - strlen($CurrentTime))/2);
					$Number2 = (29 - strlen($CurrentTime)) - $Number1;
					$RandomPassword = rand_string(130);

					// Create unique user for user account
					$UserUrl = "a".rand_string($Number1).$CurrentTime.rand_string($Number2);

					if(strlen($UserUrl) != 30){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("User Url not created due to technical error ! Please try again"); exit();
					}
					// Create User profile image path
					$UserDataStore_ProfileImagePath =  RootPath."Users/UserDataStore/ProfileImage/";
					$ProfileUrl = $UserUrl.'.'.$ProfileImage_ext;
					if($SignupType === 'Organization'){
					    $CreateFolderInOrganizationProfileImage = $UserDataStore_ProfileImagePath.'Organization/'.$UserUrl;
						$ProfileImageUploadPath = $CreateFolderInOrganizationProfileImage.'/'.$UserUrl.'.'.$ProfileImage_ext;
					}else{
					    $ProfileImageUploadPath = $UserDataStore_ProfileImagePath.'Main/'.$UserUrl.'.'.$ProfileImage_ext;
					}

					// Check username availability
					$GetSearchData = "Username::::$Username::,::UserUrl::::$UserUrl";
					
					$Response = CheckGivenDataAvailability($GetSearchData,$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'any');
					if($Response['status'] != "Success" || $Response['msg'] != "NotAvailable" || $Response['code'] != 200){

						$Response = CheckGivenDataAvailability("Username::::$Username",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
						if($Response['status'] != "Success" || $Response['msg'] != "NotAvailable"){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response("This Username already taken! Try another one"); exit();
						}

						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("User Url not created due to technical error ! Please try again"); exit();
					}

					if($SignupType === 'Organization'){
						if($OrganizationType === 'College'){
							$Version = '1.0.0';
						}else{
							return_response('Invalid Organization Type Found'); exit();
						}
					}else if($SignupType === 'Main'){
						$Version = '1.0.0';
					}else{
						return_response('Invalid Signup Type Found'); exit();
					}

					$InsertData = "Status::::Pending::,::Username::::$Username::,::OrganizationType::::$OrganizationType::,::OrganizationName::::$OrganizationName::,::PostionRequest::::$PostionRequest::,::Bio::::$Bio::,::UserUrl::::$UserUrl::,::SignupType::::$SignupType::,::CreateTime::::$CurrentTime::,::LastUpdateBy::::Auto::,::LastUpdateTime::::$CurrentTime::,::LastUpdatePosition::::Auto::,::LastUpdateRank::::1::,::Version::::$Version";
					
					$Response = InsertGivenData($InsertData,$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
					if($Response['status'] != "Success" || $Response['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Process failed! Try again later7');
					}
					
					if($SignupType === 'Organization'){
						if($OrganizationType === 'College'){
							$stmt = $PdoOrganizationUserSetting->prepare("CREATE TABLE $UserUrl (CreateType VARCHAR(100) NOT NULL, UpdateAble VARCHAR(100) NOT NULL,  SettingKeyUnique VARCHAR(400) NULL UNIQUE, SettingValueUnique VARCHAR(600) NULL UNIQUE, SettingKey TEXT, SettingValue TEXT)");
							if($stmt->execute()){
							    
								$Response = InsertGivenData("SettingKeyUnique::::Position::,::SettingValue::::Owner:1:NotUpdateAble@Admin:2:NotUpdateAble@Student:0:NotUpdateAble@ReadOnly:-1:NotUpdateAble@ServiceUserOnly:-2:NotUpdateAble::,::CreateType::::MainAndOrganization::,::UpdateAble::::Both",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for Position', 'GetErrorDes'=>'Position not insert in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::MemberOperationPermissionRankUpTo::,::SettingValue::::ChangeMemberPermissionRankUpTo:1,2@AddMemberPermissionRankUpTo:1,2@SearchMemberPermissionRankUpTo:-1,e@SearchMemberSensitiveDataPermissionRankUpTo:1,2@DeleteMemberPermissionRankUpTo:1,2::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for MemberOperationPermissionRankUpTo', 'GetErrorDes'=>'MemberOperationPermissionRankUpTo not insert in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::Department::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for Department', 'GetErrorDes'=>'Department Key not create in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::Branch::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for Branch', 'GetErrorDes'=>'Branch Key not create in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::StudyYear::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for StudyYear', 'GetErrorDes'=>'StudyYear Key not create in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::PrimaryBatchId::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for PrimaryBatchId', 'GetErrorDes'=>'PrimaryBatchId Key not create in Organization Setting'));
								}
								$Response = InsertGivenData("SettingKeyUnique::::SecondaryBatchId::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for SecondaryBatchId', 'GetErrorDes'=>'SecondaryBatchId Key not create in Organization Setting'));
								}
								
								$Response = InsertGivenData("SettingKeyUnique::::StudySemester::,::CreateType::::Organization::,::UpdateAble::::Yes",$PdoOrganizationUserSetting,$UserUrl ,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									array_push($GetError, array('GetErrorFrom'=>'InsertGivenData for StudySemester', 'GetErrorDes'=>'StudySemester Key not create in Organization Setting'));
								}
								
								if(sizeof($GetError) != 0){
									$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
									$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'GetError'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
									return_response('Error : '.$SetVarKey); exit();
								}
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Process failed! Try again later11'); exit();
							}

						}else{
							$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'OrganizationType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response("This service is currently not available for ".$OrganizationType.' [2]'); exit();
						}
					}

					#$VerifyedAccount = serialize(['MobileStatus'=>true,'Mobile'=>$MobileNumber,'EmailStatus'=>true,'Email'=>$Email]);
					$VerifyedAccount = serialize(['MobileStatus'=>true,'Mobile'=>$MobileNumber]);
					if($SignupType === 'Organization'){
						if($OrganizationType === "College"){
							if($Email == 'esymanager@gmail.com'){
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Email address already exit"); exit();
							}else if($MobileNumber == '7597078875'){
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Mobile number already exit"); exit();
							}

							$GetMainAccountDtls = AptPdoFetchWithAes(['Condtion'=> "SignupType::::Organization", 'FetchData'=>'Username::::SignupType', 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EncodeAndEncryptPass]);
							if($GetMainAccountDtls['code'] != 200 && $GetMainAccountDtls['code'] != 404){
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("We can not fetch Service data due to technical error"); exit();
							}else if($GetMainAccountDtls['totalrows'] > 1){
								/*$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("Maximum Singup limit reached! Currently we can not available for more account"); exit();*/
							}

							$stmt = $PdoOrganizationUserAccount->prepare("CREATE TABLE $UserUrl (Status VARCHAR(50) NOT NULL, Fullname VARCHAR(100) NOT NULL, FatherFullname VARCHAR(100), GuardianFullname VARCHAR(100), Gender VARCHAR(50) NOT NULL, GuardianGender VARCHAR(50), Mobile VARCHAR(100) NOT NULL UNIQUE, FatherMobile VARCHAR(100), GuardianMobile VARCHAR(100), Email VARCHAR(100) NULL UNIQUE, FatherEmail  VARCHAR(100), GuardianEmail  VARCHAR(100), UniqueId VARCHAR(100) NULL UNIQUE, OpUniqueId VARCHAR(100) NULL UNIQUE, SocialAccount TEXT, VerifyedAccount TEXT, FatherSocialAccount TEXT, FatherVerifyedAccount TEXT, GuardianSocialAccount TEXT, GuardianVerifyedAccount TEXT, Position VARCHAR(200) NOT NULL, Department VARCHAR(300), Semester VARCHAR(100), StudyYear VARCHAR(100), Branch VARCHAR(300), UserUrl VARCHAR(100) NOT NULL PRIMARY KEY, ProfileUrl VARCHAR(150) NOT NULL UNIQUE, PrimaryBatchId VARCHAR(100), SecondaryBatchId VARCHAR(100), OrgJoinTime VARCHAR(100) NOT NULL, OrgStayDur VARCHAR(100) NULL, OrgExitTime VARCHAR(100) NULL, Pincode VARCHAR(50) NOT NULL, City VARCHAR(100) NOT NULL, State VARCHAR(100) NOT NULL, Country VARCHAR(100) NOT NULL, Address VARCHAR(300) NOT NULL, OtpData TEXT NULL, Password VARCHAR(300) NOT NULL, SecurityCode VARCHAR(300) NOT NULL, AccountCreateAs VARCHAR(100) NOT NULL, LastActiveTime VARCHAR(100) NULL, LoginTime VARCHAR(100) NOT NULL, LoginUniqueId VARCHAR(150) NULL UNIQUE, LoginTokenData TEXT, CreateTime VARCHAR(100) NOT NULL, PassChangeTime VARCHAR(100) NOT NULL, LastUpdateBy VARCHAR(100) NOT NULL, LastUpdatePosition VARCHAR(200) NOT NULL, LastUpdateRank VARCHAR(100) NOT NULL, LastUpdateTime VARCHAR(100) NOT NULL, CreateBy VARCHAR(100) NOT NULL, CreateByPosition VARCHAR(200) NOT NULL,CreateByRank VARCHAR(100) NOT NULL, LastChanges TEXT, SettingKeyUnique VARCHAR(400) NULL UNIQUE, SettingValueUnique VARCHAR(600) NULL UNIQUE, SettingKey TEXT, SettingValue TEXT, StatusActionReason VARCHAR(200), Signature VARCHAR(300) NULL UNIQUE)");
							if($stmt->execute()){
								$InsertData = "Status::::Active::,::Fullname::::$Fullname::,::Gender::::$Gender::,::Mobile::::$MobileNumber::,::Email::::$Email::,::UniqueId::::$Username::,::VerifyedAccount::::$VerifyedAccount::,::Position::::Owner::,::UserUrl::::$UserUrl::,::ProfileUrl::::$ProfileUrl::,::Pincode::::$Pincode::,::City::::$City::,::State::::$State::,::Country::::$Country::,::Address::::$Address::,::Password::::$Password::,::SecurityCode::::$SecurityCode::,::AccountCreateAs::::OrganizationMember::,::LoginTime::::$CurrentTime::,::CreateTime::::$CurrentTime::,::PassChangeTime::::$CurrentTime::,::LastUpdateBy::::$UserUrl::,::LastUpdatePosition::::Owner::,::LastUpdateRank::::1::,::LastUpdateTime::::$CurrentTime::,::CreateBy::::$UserUrl::,::CreateByPosition::::Owner::,::CreateByRank::::1";
						
								$Response = InsertGivenData($InsertData,$PdoOrganizationUserAccount,$UserUrl,$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
									$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
									$Response = DeleteTable($UserUrl,$PdoOrganizationUserAccount);
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('Process failed! Try again later12');
								}
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Process failed! Try again later13');
							}
						}else{
							$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
							$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'OrganizationType'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response("This service is currently not available for ".$OrganizationType.' [1]'); exit();
						}
					}else{
						$Response = CheckGivenDataAvailability('Status::::Active::,::SignupType::::Main',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');
						if($Response['status'] === "Success" && $Response['msg'] === "NotAvailable" && $Response['code'] === 200){
							if($Email === 'esymanager@gmail.com' && $MobileNumber === '7597078875' && $Gender === 'Organization'){
								$InsertData = "Status::::Pending::,::Fullname::::$Fullname::,::Gender::::$Gender::,::Mobile::::$MobileNumber::,::Email::::$Email::,::UniqueId::::$Username::,::VerifyedAccount::::$VerifyedAccount::,::Position::::Owner::,::UserUrl::::$UserUrl::,::ProfileUrl::::$ProfileUrl::,::Pincode::::$Pincode::,::City::::$City::,::State::::$State::,::Country::::$Country::,::Address::::$Address::,::Password::::$Password::,::SecurityCode::::$SecurityCode::,::AccountCreateAs::::MainMember::,::LoginTime::::$CurrentTime::,::CreateTime::::$CurrentTime::,::PassChangeTime::::$CurrentTime::,::LastUpdateBy::::$UserUrl::,::LastUpdatePosition::::Owner::,::LastUpdateRank::::1::,::LastUpdateTime::::$CurrentTime::,::CreateBy::::$UserUrl::,::CreateByPosition::::Owner::,::CreateByRank::::1";
						
								$Response = InsertGivenData($InsertData,$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass);
								if($Response['status'] != "Success" || $Response['code'] != 200){
									$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('Process failed! Try again later1'); exit();
								}
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Currently this service is not active'); exit();
							}
						}else{
							$Responses = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Currently this service is not active'); exit();
						}	
					}
					
					if($SignupType === 'Organization'){
						if(mkdir($CreateFolderInOrganizationProfileImage) && copy($UserDataStore_ProfileImagePath."index.php", $CreateFolderInOrganizationProfileImage."/index.php") && $ResizeImageUploadMethod($ResizeImageTargetLayer,$ProfileImageUploadPath)){
								
							$Response = UpdateGivenData("Status::::Active","Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Your account create successfully',true,'Success',200);
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
								$Response = DeleteTable($UserUrl,$PdoOrganizationUserAccount);
							  	$Response = DirDeleteWithFiles($CreateFolderInOrganizationProfileImage);
							  	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Process failed! Try again later2');
							}
						}else{
							$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
							$Response = DeleteTable($UserUrl,$PdoOrganizationUserSetting);
							$Response = DeleteTable($UserUrl,$PdoOrganizationUserAccount);
						  	$Response = DirDeleteWithFiles($CreateFolderInOrganizationProfileImage);
						  	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Process failed! Try again later3');
						}
					}else{
						if($ResizeImageUploadMethod($ResizeImageTargetLayer,$ProfileImageUploadPath)){
							$Response = UpdateGivenData("Status::::Active","Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								$Response = UpdateGivenData("Status::::Active","Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass,'all');
								if($Response['status'] === 'Success' && $Response['code'] === 200){
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('Your account create successfully',true,'Success',200);
								}else{
									$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
									$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass);
								  	unlink($ProfileManagePath.'/'.$ProfileUrl);
								  	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('Process failed! Try again later6');
								}
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
								$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass);
							  	unlink($ProfileManagePath.'/'.$ProfileUrl);
							  	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Process failed! Try again later4');
							}
						}else{
							$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
							$Response = DeleteDataFromTable("Status::::Pending::,::UserUrl::::$UserUrl",$PdoMainUserAccountDb,'main_member',$EncodeAndEncryptPass);
							return_response($ProfileManagePath.'/'.$ProfileUrl);
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Process failed! Try again later5');
						}
					}
				}
			}
			
			// Call classname public function 
			Signup::ValidedData($SignupType,$Username,$Fullname,$Gender,$OrganizationType,$PostionRequest,$Email,$MobileNumber,$OrganizationName,$Bio,$Address,$City,$State,$Pincode,$Country,$Password,$ConfirmPassword,$SecurityCode,$ProfileImage_size,$ProfileImage_ext,$BrowserClientId1,$BrowserClientId2,$EmailOTP,$MobOTP);
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