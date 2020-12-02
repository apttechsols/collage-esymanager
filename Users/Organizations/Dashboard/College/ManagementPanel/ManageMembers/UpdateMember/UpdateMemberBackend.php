<?php 
/*
*@FileName AddNewwMemberBackend.php
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
define("RootPath", "../../../../../../../");

// Get all requested data
if(isset($_POST['UserUrl']) && isset($_POST['Status']) && isset($_POST['Fullname']) && isset($_POST['GuardianFullname']) && isset($_POST['FatherFullname']) && isset($_POST['Gender']) && isset($_POST['GuardianGender']) && isset($_POST['Email']) && isset($_POST['OrgJoinTime']) && isset($_POST['FatherEmail']) && isset($_POST['GuardianEmail']) && isset($_POST['MobileNo']) && isset($_POST['FatherMobileNo']) && isset($_POST['GuardianMobileNo']) && isset($_POST['UniqueId']) && isset($_POST['PrimaryBatchId']) && isset($_POST['SecondaryBatchId']) && isset($_POST['Address']) && isset($_POST['Position']) && isset($_POST['Department']) && isset($_POST['Branch']) && isset($_POST['Year'])  && isset($_POST['Semester']) && isset($_POST['Pincode']) && isset($_POST['City']) && isset($_POST['State']) && isset($_POST['Country']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file
    
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Organizations/Dashboard/College/ManagementPanel/ManageMembers/UpdateMember/index.php?UserUrl=".$_POST['UserUrl']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$UserUrl = preg_replace('!\s+!', ' ',strip_tags($_POST['UserUrl']));
			$Status = preg_replace('!\s+!', ' ',strip_tags($_POST['Status']));
			$Fullname = preg_replace('!\s+!', ' ',strip_tags($_POST['Fullname']));
			$FatherFullname = preg_replace('!\s+!', ' ',strip_tags($_POST['FatherFullname']));
			$GuardianFullname = preg_replace('!\s+!', ' ',strip_tags($_POST['GuardianFullname']));
			$Gender = preg_replace('!\s+!', ' ',strip_tags($_POST['Gender']));
			$GuardianGender = preg_replace('!\s+!', ' ',strip_tags($_POST['GuardianGender']));
			$Email = preg_replace('!\s+!', ' ',strip_tags($_POST['Email']));
			$OrgJoinTime = preg_replace('!\s+!', ' ',strip_tags($_POST['OrgJoinTime']));
			$FatherEmail = preg_replace('!\s+!', ' ',strip_tags($_POST['FatherEmail']));
			$GuardianEmail = preg_replace('!\s+!', ' ',strip_tags($_POST['GuardianEmail']));
			$MobileNo = preg_replace('!\s+!', ' ',strip_tags($_POST['MobileNo']));
			$FatherMobileNo = preg_replace('!\s+!', ' ',strip_tags($_POST['FatherMobileNo']));
			$GuardianMobileNo = preg_replace('!\s+!', ' ',strip_tags($_POST['GuardianMobileNo']));
			$UniqueId = preg_replace('!\s+!', ' ',strip_tags($_POST['UniqueId']));
			$PrimaryBatchId = preg_replace('!\s+!', ' ',strip_tags($_POST['PrimaryBatchId']));
			$SecondaryBatchId = preg_replace('!\s+!', ' ',strip_tags($_POST['SecondaryBatchId']));
			$Pincode = preg_replace('!\s+!', ' ',strip_tags($_POST['Pincode']));
			$City = preg_replace('!\s+!', ' ',strip_tags($_POST['City']));
			$State = preg_replace('!\s+!', ' ',strip_tags($_POST['State']));
			$Country = preg_replace('!\s+!', ' ',strip_tags($_POST['Country']));
			$Address = preg_replace('!\s+!', ' ',strip_tags($_POST['Address']));
			$Position = preg_replace('!\s+!', ' ',strip_tags($_POST['Position']));
			$Department = preg_replace('!\s+!', ' ',strip_tags($_POST['Department']));
			$Branch = preg_replace('!\s+!', ' ',strip_tags($_POST['Branch']));
			$Year = preg_replace('!\s+!', ' ',strip_tags($_POST['Year']));
			$Semester = preg_replace('!\s+!', ' ',strip_tags($_POST['Semester']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			$ProfileImage = $_FILES['ProfileImage'];
			$ProfileImage_tmp = $_FILES['ProfileImage']['tmp_name'];
			$ProfileImage_size = round($_FILES['ProfileImage']['size'] / 1024, 2);
			$ProfileImage_ext = pathinfo($_FILES['ProfileImage']['name'], PATHINFO_EXTENSION);

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class UpdateMember 
			{
				public static function ValidedData($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$Address,$City,$State,$Country,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
					
					date_default_timezone_set('Asia/Kolkata');
					
					
                    if($Status != 'Active' && $Status != 'Block' && $Status != 'Hold'){
                        return_response("Invalid status detect"); exit();
                    }
                    
					// UserUrl valided in backend
					if($UserUrl != preg_replace("/[^A-Za-z0-9]/","",$UserUrl)){
						return_response("Invalid user detect");

					}else if(strlen($UserUrl) != 30){
					    return_response("Invalid user detect");

					}
					
					// Fullname valided in backend
					if($Fullname != preg_replace("/[^A-Za-z ]/","",$Fullname)){
						return_response("Fullname contains invalid characters");

					}else if(strlen(preg_replace("/[^ ]/","",$Fullname)) < 1){
						return_response("Fullname look like first name[error : 1]");

					}else if(strlen($Fullname) < 6 || strlen($Fullname) > 30){
						return_response("Fullname name must be between 6 and 30 characters long");

					}else if(strlen(explode(" ",$Fullname)[0]) < 1){
						return_response("Fullname look like first name[error : 2]");

					}else if(strlen(explode(" ",$Fullname)[1]) < 1){
						return_response("Fullname look like first name[error : 3]");
					}
					
					// Gender valided in backend
					if($Gender != "Male" && $Gender != "Female" && $Gender != "Other"){
						return_response("Gender contains invalid characters");
					}
					
					// Position valided in backend
					if($Position != preg_replace("/[^A-Za-z ]/","",$Position)){
						return_response("Position contains invalid characters");
					}
					
					// Email valided in backend
					if(strlen($Email) > 0){
						if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
							return_response("Invalid Email address detect"); exit();
						}else if(strlen($Email) > 60){
							return_response("Email length must be under 60 character"); exit();
						}
					}
					
					// Mobile number  valided in backend
					if($MobileNo != preg_replace("/[^0-9]/","",$MobileNo)){
						return_response("Mobile number contains invalid characters");

					}else if(strlen($MobileNo) != 10){
						return_response("Mobile number must be between 10 characters long");
					}

					// Unique Id valided in backend
					if(strlen($UniqueId) > 0){

						// UniqueId valided in backend
						if($UniqueId != preg_replace("/[^A-Za-z0-9@_-]/","",$UniqueId)){
							return_response("Unique Id contains invalid characters");
						}if(strlen($UniqueId) < 1 || strlen($UniqueId) > 30){
							return_response("Unique Id name must be between 1 to 30 characters long");
						}
					}
					
					// Address valided in backend
					if(substr($Address,0,1) != preg_replace("/[^A-Za-z0-9]/","",substr($Address,0,1))){
						return_response("Organization address contains invalid characters");
					}else if(strlen($Address) > 100){
						return_response("Address must be under 100 characters long");
					}

					// Pincode valided in backend
					if($Pincode != preg_replace("/[^0-9]/","",$Pincode)){
						return_response("Pincode contains invalid characters");

					}else if(strlen($Pincode) != 6){
						return_response("Pincode must be 6 long");

					}

					// CityName valided in backend
					if($City != preg_replace("/[^A-Za-z ]/","",$City)){
						return_response("City contains invalid characters");

					}else if(strlen($City) < 2 && strlen($City) > 30){
						return_response("City Name must be 2 to 30 character long");

					}

					// State valided in backend
					if($State != preg_replace("/[^A-Za-z ]/","",$State)){
						return_response("State contains invalid characters");

					}else if(strlen($State) < 2 && strlen($State) > 30){
						return_response("State Name must be 2 to 30 character long");

					}

					// Country valided in backend
					if($Country != preg_replace("/[^A-Za-z ]/","",$Country)){
						return_response("Country contains invalid characters");

					}else if(strlen($Country) < 2 && strlen($Country) > 30){
						return_response("Country Name must be 2 to 30 character long");

					}
					
					// Image validation
					if($ProfileImage_size > 2048){
						return_response("Profile image size must be under 2Mb");

					}

					// Student valided in backend
					if($Position == 'Student'){

						// OrgJoinTime  valided in backend
						if($OrgJoinTime != preg_replace("/[^0-9-]/","",$OrgJoinTime)){
							return_response("Organization Join Time contains invalid characters");
						}
						
						$OrgJoinTimeArray = explode('-', $OrgJoinTime);
						if(strlen($OrgJoinTimeArray[0]) < 1 || strlen($OrgJoinTimeArray[0]) > 2){
							return_response('Organization join date must be in 1 or 2 digit');
						}else if(strlen($OrgJoinTimeArray[1]) < 1 || strlen($OrgJoinTimeArray[1]) > 2){
							return_response('Organization join month must be in 1 or 2 digit');
						}else if(strlen($OrgJoinTimeArray[2]) != 4 ){
							return_response('Organization join year must be in 4 digit');
						}
						if(!checkdate($OrgJoinTimeArray[1], $OrgJoinTimeArray[0], $OrgJoinTimeArray[2])){
							return_response('Organization join Time detect invalid');
						}

						if($OrgJoinTimeArray[1] == '01' || $OrgJoinTimeArray[1] == '1'){
							$TempMonth = 'Jan';
						}else if($OrgJoinTimeArray[1] == '02' || $OrgJoinTimeArray[1] == '2'){
							$TempMonth = 'Feb';
						}else if($OrgJoinTimeArray[1] == '03' || $OrgJoinTimeArray[1] == '3'){
							$TempMonth = 'Mar';
						}else if($OrgJoinTimeArray[1] == '04' || $OrgJoinTimeArray[1] == '4'){
							$TempMonth = 'Apr';
						}else if($OrgJoinTimeArray[1] == '05' || $OrgJoinTimeArray[1] == '5'){
							$TempMonth = 'May';
						}else if($OrgJoinTimeArray[1] == '06' || $OrgJoinTimeArray[1] == '6'){
							$TempMonth = 'Jun';
						}else if($OrgJoinTimeArray[1] == '07' || $OrgJoinTimeArray[1] == '7'){
							$TempMonth = 'Jul';
						}else if($OrgJoinTimeArray[1] == '08' || $OrgJoinTimeArray[1] == '8'){
							$TempMonth = 'Aug';
						}else if($OrgJoinTimeArray[1] == '09' || $OrgJoinTimeArray[1] == '9'){
							$TempMonth = 'Sep';
						}else if($OrgJoinTimeArray[1] == '10' || $OrgJoinTimeArray[1] == '10'){
							$TempMonth = 'Oct';
						}else if($OrgJoinTimeArray[1] == '11'){
							$TempMonth = 'Nov';
						}else if($OrgJoinTimeArray[1] == '12'){
							$TempMonth = 'Dec';
						}else{
							return_response('Organization join Month detect Invalid');
						}

						$OrgJoinTime = strtotime($OrgJoinTimeArray[0]." $TempMonth ".$OrgJoinTimeArray[2]);

						if($OrgJoinTime > time()){
							return_response('Organization Join Time detect invalid');
						}

						// PrimaryBatchId Validation in backend
						if($PrimaryBatchId != preg_replace("/[^A-Za-z0-9-)(_]/","",$PrimaryBatchId)){
							return_response("Primary Batch Id contains invalid characters");

						}else if(strlen($PrimaryBatchId) < 1 || strlen($PrimaryBatchId) > 30){
							return_response("Primary Batch Id must be between 1 and 30 characters long");

						}

						// SecondaryBatchId Validation in backend
						if($SecondaryBatchId != preg_replace("/[^A-Za-z0-9-)(_]/","",$SecondaryBatchId)){
							return_response("Secondary Batch Id contains invalid characters");

						}else if(strlen($SecondaryBatchId) > 30){
							return_response("Secondary Batch Id must be under 30 characters");

						}

						// Father Fullname valided in backend
						if($FatherFullname == ''){
							return_response("Father fullname look like empty");

						}else if($FatherFullname != preg_replace("/[^A-Za-z ]/","",$FatherFullname)){
							return_response("Father fullname contains invalid characters");

						}else if(strlen(preg_replace("/[^ ]/","",$FatherFullname)) < 1){
							return_response("Father fullname look like first name");

						}else if(strlen($FatherFullname) < 6 || strlen($FatherFullname) > 30){
							return_response("Father fullname name must be between 6 and 30 characters long");

						}else if(strlen(explode(" ",$FatherFullname)[0]) < 1){
							return_response("Father fullname look like first name");

						}else if(strlen(explode(" ",$FatherFullname)[1]) < 1){
							return_response("Father fullname look like first name");
						}

						// Father Email valided in backend
						if(strlen($FatherEmail) > 0){

							if (!filter_var($FatherEmail, FILTER_VALIDATE_EMAIL)) {
								return_response("Invalid fathers Email address detect"); exit();
							}else if(strlen($FatherEmail) > 60){
								return_response("Fathers Email length must be under 60 character"); exit();
							}

							if($Email == $FatherEmail){
								return_response("User and Fathers Email must be different");
							}
						}

						// FatherMobileNo valided in backend
						if($FatherMobileNo != preg_replace("/[^0-9]/","",$FatherMobileNo)){
							return_response("Father Mobile number contains invalid characters");

						}else if(strlen($FatherMobileNo) != 10){
							return_response("Father Mobile number must be between 10 characters long");
						}

						if($MobileNo == $FatherMobileNo){
							return_response("User and Fathers Mobile number must be different");
						}

						if(strlen($GuardianGender) > 0 || strlen($GuardianFullname) > 0 || strlen($GuardianEmail) > 0 || strlen($GuardianMobileNo) > 0){

							// GuardianGender valided in backend
							if($GuardianGender != "Male" && $GuardianGender != "Female" && $GuardianGender != "Other"){
								return_response("Guardian Gender contains invalid characters");
							}

							// Guardian Fullname valided in backend
							if($GuardianFullname == ''){
								return_response("Guardian fullname look like empty");

							}else if($GuardianFullname != preg_replace("/[^A-Za-z ]/","",$GuardianFullname)){
								return_response("Guardian fullname contains invalid characters");

							}else if(strlen(preg_replace("/[^ ]/","",$GuardianFullname)) < 1){
								return_response("Guardian fullname look like first name");

							}else if(strlen($GuardianFullname) < 6 || strlen($GuardianFullname) > 30){
								return_response("Guardian fullname name must be between 6 and 30 characters long");

							}else if(strlen(explode(" ",$GuardianFullname)[0]) < 1){
								return_response("Guardian fullname look like first name");

							}else if(strlen(explode(" ",$GuardianFullname)[1]) < 1){
								return_response("Guardian fullname look like first name");
							}

							// Guardian Email valided in backend
							if(strlen($GuardianEmail) > 0){
								if (!filter_var($GuardianEmail, FILTER_VALIDATE_EMAIL)) {
									return_response("Invalid Guardian Email address detect"); exit();
								}else if(strlen($GuardianEmail) > 60){
									return_response("Guardian Email length must be under 60 character"); exit();
								}

								if($Email == $GuardianEmail){
									return_response("User and Guardian Email must be different");
								}else if($FatherEmail == $GuardianEmail){
									return_response("Father and Guardian Email must be different");
								}
							}

							// GuardianMobileNo valided in backend
							if($GuardianMobileNo != preg_replace("/[^0-9]/","",$GuardianMobileNo)){
								return_response("Guardian Mobile number contains invalid characters");

							}else if(strlen($GuardianMobileNo) != 10){
								return_response("Guardian Mobile number must be between 10 characters long");
							}

							if($MobileNo == $GuardianMobileNo){
								return_response("User and Guardian Mobile number must be different");
							}else if($GuardianMobileNo == $FatherMobileNo){
								return_response("Father and Guardian Mobile number must be different");
							}
						}

						// Branch valided in backend
						if($Branch != preg_replace("/[^A-Za-z ]/","",$Branch)){
							return_response("Branch contains invalid characters");

						}else if(strlen($Branch) < 2 || strlen($Branch) > 50){
							return_response("Branch must be between 2 to 50 characters long");

						}

						// Year valided in backend
						if($Year != preg_replace("/[^0-9]/","",$Year)){
							return_response("Year contains invalid characters");

						}else if($Year > 20 || strlen($Year) > 2 || strlen($Year) == 0){
							return_response("Year must be between 1 to 10");

						}

						// semester valided in backend
						if($Semester != preg_replace("/[^0-9]/","",$Semester)){
							return_response("Semester contains invalid characters");

						}else if($Semester > 20 || strlen($Semester) > 2 || strlen($Semester) == 0){
							return_response("Semester must be between 1 to 20");

						}

						$Department = '';
					}else{

						// Department name valided in backend
						if(strlen($Department)){
							if($Department != preg_replace("/[^A-Za-z ]/","",$Department)){
								return_response("Gender contains invalid characters");

							}else if(strlen($Department) < 2 || strlen($Department) > 50){
								return_response("Department name must be between 2 to 50 characters long");
							}
						}

						$OrgJoinTime = -1;
						$PrimaryBatchId = '';
						$SecondaryBatchId = '';
						$FatherFullname = '';
						$FatherEmail = '';
						$FatherMobileNo = '';
						$Branch = '';
						$Year = '';
						$Semester = '';
					}

					// Call encode_post_input function
					UpdateMember::EncryptData($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$Address,$City,$State,$Country,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$Address,$City,$State,$Country,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Create New Password Password
					$NewPassword = hash_hmac("sha256",hash_hmac("sha512",base64_encode(12345678),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Create New Hash Password
					$NewSecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode('000000'),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					UpdateMember::ProfileImageResize($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode);
				}

				private static function ProfileImageResize($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode){
					if($ProfileImage_tmp != null){
    					// Resize image function
    					function imageResize($imageResourceId,$width,$height){
    						$targetWidth =200;
    						$targetHeight =200;
    						$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    						imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    						return $targetLayer;
    					}
    					
    					// Valided and resize image
    					$sourceProperties = getimagesize($ProfileImage_tmp);
    					$fileNewName = time();
    					$folderPath = "upload/";
    					$imageType = $sourceProperties[2];
    					switch ($imageType) {
    						
    						case IMAGETYPE_PNG:  // If image is PNG
    							$imageResourceId = imagecreatefrompng($ProfileImage_tmp); 
    							$ResizeImageUploadMethod = imagepng; // What type of method use to upload this type og image
    							break;
    
    
    						case IMAGETYPE_GIF:  // If image is GIF
    							$imageResourceId = imagecreatefromgif($ProfileImage_tmp);
    							$ResizeImageUploadMethod = imagegif; // What type of method use to upload this type og image
    							break;
    
    
    						case IMAGETYPE_JPEG:  // If image is JPEG
    							$imageResourceId = imagecreatefromjpeg($ProfileImage_tmp);
    							$ResizeImageUploadMethod = imagejpeg; // What type of method use to upload this type og image
    							break;
    
    
    						default:  // If image is Not PNG, JPEG, GIF
    							return_response("Invalid Image type found");
    							break;
    					}
    					$ResizeImageTargetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
    
    					if (!@getimagesize($ProfileImage_tmp)){
    						return_response('An invalid image was supplied.'); exit();
    					}
					}

					UpdateMember::CkeckLoginAndAuthenticate($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode,$ResizeImageUploadMethod,$ResizeImageTargetLayer);
				}

				private static function CkeckLoginAndAuthenticate($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode,$ResizeImageUploadMethod,$ResizeImageTargetLayer){
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
					
					// Access service manage file to access data base connection ($PdoServiceManage)
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

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not login'); exit();
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
					
					if($ResponseRank <= 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized for take this action'); exit();
					}

					if($ResponseLogin['msg']['SecurityCode'] != $SecurityCode){
						return_response('Invalid Security code'); exit();
					}
					
					$LgPositionRank = $ResponseRank;

					UpdateMember::UpdateMemberProccess($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode,$ResizeImageUploadMethod,$ResizeImageTargetLayer,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoServiceManage,$PdoOrganizationUserAccount,$ResponseLogin,$LgPositionRank);
				}
				
				private static function UpdateMemberProccess($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$City,$State,$Country,$Address,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$NewPassword,$NewSecurityCode,$ResizeImageUploadMethod,$ResizeImageTargetLayer,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoServiceManage,$PdoOrganizationUserAccount,$ResponseLogin,$LgPositionRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();
                    
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];

					// Verify new user position
					$ResponsePositionRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $Position.':', ':');

					if($ResponsePositionRank == ''){
						return_response($Position.' Is Not Found In Organization postions list'); exit();
					}

					if($ResponsePositionRank <= $LgPositionRank && $ResponsePositionRank > 0 && $LgPositionRank != 1){
						return_response('You are not Authorized for update at '.$Position.' postion'); exit();
					}
					
					if($Position == 'Student'){
						$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::MemberOperationPermissionRankUpTo::,::SettingKeyUnique::::PrimaryBatchId::,::SettingKeyUnique::::SecondaryBatchId::,::SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
					}else{
						$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::MemberOperationPermissionRankUpTo::,::SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
					}
					if($GetOrgSetting['status'] != "Success" || $GetOrgSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Org Setting can not feched! Due to technical error');
					}
					foreach ($GetOrgSetting['msg'] as $value){
						${'GetOrgSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}
					$TempArray = explode('@', $GetOrgSettingMemberOperationPermissionRankUpTo);
					foreach ($TempArray as $value) {
						$Temp = explode(':', $value);
						$Temp1 = explode(',', $Temp[1]);
						${'MemberOperationPermissionRankUpTo' . $Temp[0] . 'Start'} = $Temp1[0];
						${'MemberOperationPermissionRankUpTo' . $Temp[0] . 'End'} = $Temp1[1];
					}

					if($MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart == 'e' || $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart <= 0){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
					    return_response('Invalid setting detect for update new member');
					}

					if($LgPositionRank < $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart || $LgPositionRank > $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToEnd){
				        foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
				        return_response('You are not Authorized to update member');
				    }
				    
					/*****  StrToLower and Other operation on some important data ******/
					$UniqueId = strtolower(preg_replace("/[^A-Za-z0-9@_-]/","",$UniqueId));
					$Email = strtolower(preg_replace("/[^A-Za-z0-9@.]/","",$Email));
					
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
                    
					// Create NewProfileUrl path
					$NewProfileUrl = 'a'.rand_string($Number1).$CurrentTime.rand_string($Number2).'.'.$ProfileImage_ext;
					
					$Response = FetchReuiredDataByGivenData("ProfileUrl::::$NewProfileUrl",NULL,$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
                    if($Response['code'] != 404){
						return_response('User data not fetch! Due to some technical error'); exit();
					}
				    
					$GetUpdateUserDetails = FetchReuiredDataByGivenData("UserUrl::::$UserUrl","ProfileUrl::::Position",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
                    if($GetUpdateUserDetails['status'] != "Success" || $GetUpdateUserDetails['code'] != 200){
						return_response('This user is not a member of this organization'); exit();
					}

					$GetUpdateUserCurrentPositionRank = GetSubStringBetweenTwoCharacter($GetOrgSettingPosition, $GetUpdateUserDetails['msg']->Position.':', ':');

					if($GetUpdateUserCurrentPositionRank == ''){
						return_response('Org setting can not feched! due to technical error'); exit();
					}
					
					if(($GetUpdateUserCurrentPositionRank <= $LgPositionRank && $GetUpdateUserCurrentPositionRank > 0) && $GetUpdateUserCurrentPositionRank != 1){
					    return_response('You are not Authorized to update this user'); exit();
					}
					
					$UseNewUpdatedPositionRank = GetSubStringBetweenTwoCharacter($GetOrgSettingPosition, $Position.':', ':');
					if($UseNewUpdatedPositionRank == ''){ return_response($Position.' Is Not Found In Organization'); }
					
					if($GetUpdateUserCurrentPositionRank == 1 && $GetUpdateUserCurrentPositionRank != $UseNewUpdatedPositionRank){
						return_response('You are not Authorized for update owner at another postion'); exit();
					}
					if($GetUpdateUserCurrentPositionRank == 1 && $Status != 'Active'){
						return_response('Owner status must be Active'); exit();
					}

                    if(($UseNewUpdatedPositionRank <= $LgPositionRank && $UseNewUpdatedPositionRank > 0 && $LgPositionRank != 1) || ($UseNewUpdatedPositionRank == 1 && $GetUpdateUserCurrentPositionRank != $UseNewUpdatedPositionRank)){
						return_response('You are not Authorized for update at '.$Position.' postion'); exit();
					}else if($UseNewUpdatedPositionRank == 2){
					    $ResponseTemp = FetchReuiredDataByGivenData("Organization::::".$ResponseLogin['LFR'],'ServiceCode',$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,'all',NULL,'all');
                        
					    if($ResponseTemp['code'] != 200 && $ResponseTemp['code'] != 404){
					        return_response('Service details not fetch! Due to some technical error'); exit();
					    }
					   	
					    foreach($ResponseTemp['msg'] as $value){
							$DbConnectionTemp = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.$value->ServiceCode);
					        $TempTbName = $ResponseLogin['LFR'].'_member';
					        $IsThisServiceHaveMember = $DbConnectionTemp['msg']->query("SHOW TABLES LIKE '$TempTbName'");
						    if($IsThisServiceHaveMember->rowCount() > 0){
						    	$ResponseTemp1 = FetchReuiredDataByGivenData("UserUrl::::$UserUrl",NULL,$DbConnectionTemp['msg'],$TempTbName,$EncodeAndEncryptPass,'any');
						        if($ResponseTemp1['code'] != 404){
						            return_response('This user is currently member of one or more then one service! As our guide line Admin can not be a member of any service so please remove user from all service member'); exit();
						        }
						    }
					    }
					}
					
					if($UseNewUpdatedPositionRank == 0){

						if($GetOrgSettingPrimaryBatchId == ''){
							return_response('PrimaryBatchId Not Found In This Organization'); exit();
						}else{
							$GetOrgSettingPrimaryBatchId = '@'.$GetOrgSettingPrimaryBatchId.'@';
							if(strpos($GetOrgSettingPrimaryBatchId, '@'.$PrimaryBatchId.'@') === false){
								return_response('PrimaryBatchId '.$PrimaryBatchId.' not exist in Organization'); exit();
							}
						}

						if($GetOrgSettingSecondaryBatchId == ''){
							return_response('SecondaryBatchId Not Found In This Organization'); exit();
						}else{
							$GetOrgSettingSecondaryBatchId = '@'.$GetOrgSettingSecondaryBatchId.'@';
							if(strpos($GetOrgSettingSecondaryBatchId, '@'.$SecondaryBatchId.'@') === false){
								return_response('SecondaryBatchId '.$SecondaryBatchId.' not exist in Organization'); exit();
							}
						}

					}
                    
					
					$GetSearchData = "Mobile::::$MobileNo";
					if(strlen($Email) > 0){
						$GetSearchData = $GetSearchData."::,::Email::::$Email";
					}
					if(strlen($UniqueId) > 0){
						$GetSearchData = $GetSearchData."::,::UniqueId::::$UniqueId";
					}

					$Response = FetchReuiredDataByGivenData($GetSearchData,"UserUrl",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
                    if($Response['code'] != 404 && $Response['code'] != 200){
						return_response('User Data Setting data not fetch! Due to some technical error'); exit();
					}
					
					if($Response['code'] == 200) {
						foreach ($Response['msg'] as $value) {
							if($value->UserUrl !== $UserUrl){
						        $Response = FetchReuiredDataByGivenData("Mobile::::$MobileNo","UserUrl",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any');
	                            if($Response['code'] != 404 && $Response['code'] != 200){ 
	        						return_response('User Data Setting data not fetch! Due to some technical error'); exit();
	        					}
	        					
	        					if($Response['code'] == 200) {
	        					    if($Response['msg']->UserUrl !== $UserUrl){
	        					        return_response('This mobile number already exist'); exit();
	        					    }
	        					}
	        					
	        					if(strlen($Email) > 0){
	            					$Response = FetchReuiredDataByGivenData("Email::::$Email","UserUrl",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any');
	                                if($Response['code'] != 404 && $Response['code'] != 200){
	            						return_response('User Data Setting data not fetch! Due to some technical error'); exit();
	            					}
	            					
	            					if($Response['code'] == 200) {
	            					    if($Response['msg']->UserUrl !== $UserUrl){
	            					        return_response('This Email already exist'); exit();
	            					    }
	            					}
						        }
	        					
	        					if(strlen($UniqueId) > 0){
	            					$Response = FetchReuiredDataByGivenData("UniqueId::::$UniqueId","UserUrl",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any');
	                                if($Response['code'] != 404 && $Response['code'] != 200){
	            						return_response('User Data Setting data not fetch! Due to some technical error'); exit();
	            					}
	            					
	            					if($Response['code'] == 200) {
	            					    if($Response['msg']->UserUrl !== $UserUrl){
	            					        return_response('This Unique Id already exist'); exit();
	            					    }
	            					}
	        					}
	        					
	        					return_response("Some data we found dublicate! Try sometime later");
						    }
						}
					}
					
					$UpdateData = "Status::::$Status::,::Fullname::::$Fullname::,::FatherFullname::::$FatherFullname::,::GuardianFullname::::$GuardianFullname::,::Gender::::$Gender::,::GuardianGender::::$GuardianGender::,::Mobile::::$MobileNo::,::FatherMobile::::$FatherMobileNo::,::GuardianMobile::::$GuardianMobileNo::,::Email::::$Email::,::FatherEmail::::$FatherEmail::,::GuardianEmail::::$GuardianEmail::,::UniqueId::::$UniqueId::,::OrgJoinTime::::$OrgJoinTime::,::Position::::$Position::,::Department::::$Department::,::Semester::::$Semester::,::StudyYear::::$Year::,::Branch::::$Branch::,::PrimaryBatchId::::$PrimaryBatchId::,::SecondaryBatchId::::$SecondaryBatchId::,::Pincode::::$Pincode::,::City::::$City::,::State::::$State::,::Country::::$Country::,::Address::::$Address::,::LoginTime::::$CurrentTime::,::LastUpdateBy::::$LgUserUrl::,::LastUpdatePosition::::$LgUserPosition::,::LastUpdateRank::::$LgPositionRank::,::LastUpdateTime::::$CurrentTime";

					if($ProfileImage_tmp != null){
				        $ProfileImageUploadPath = RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$NewProfileUrl;
				        $OldProfileUrl = RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$GetUpdateUserDetails['msg']->ProfileUrl;
					    $UpdateData = $UpdateData."::,::ProfileUrl::::$NewProfileUrl";
					}
					$Response = UpdateGivenData($UpdateData,"UserUrl::::$UserUrl",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'all',false,NULL,['AcceptNullGivenData'=>true]);
					if($Response['status'] != 'Success' || $Response['code'] != 200){
					    return_response('Oops! User data not update'.json_encode($Response)); exit();
					}
					
					if($ProfileImage_tmp != null){
					    if(file_exists($OldProfileUrl)){
					        if(!unlink($OldProfileUrl)){
					            return_response('User Data updated successfully But profile Image not updated due to technical error',true,'207'); exit();
					        }
					    }
					    if($ResizeImageUploadMethod($ResizeImageTargetLayer,$ProfileImageUploadPath)){
					        return_response('User Data Update Successfully',true,'Success',200); exit();
					    }else{
					        return_response('User Data update But profile Image not updated due to technical error',true,'207'); exit();
					    }
					}
					return_response('User Data Update Successfully',true,'Success',200); exit();
				}
			}
			
			// Call classname public function 
			UpdateMember::ValidedData($UserUrl,$Status,$Fullname,$Gender,$GuardianGender,$Email,$OrgJoinTime,$MobileNo,$FatherFullname,$GuardianFullname,$FatherEmail,$GuardianEmail,$FatherMobileNo,$GuardianMobileNo,$UniqueId,$PrimaryBatchId,$SecondaryBatchId,$Pincode,$Address,$City,$State,$Country,$Position,$Department,$Branch,$Year,$Semester,$ProfileImage_size,$ProfileImage_ext,$ProfileImage,$ProfileImage_tmp,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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