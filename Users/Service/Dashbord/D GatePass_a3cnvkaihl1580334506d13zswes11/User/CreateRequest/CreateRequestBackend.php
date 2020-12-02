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
define("RootPath", "../../../../../../");

// Get all requested data
if(isset($_POST['Venue']) && isset($_POST['Reason']) && isset($_POST['GivenDate']) && isset($_POST['InComingDate']) && isset($_POST['InComingTime']) && isset($_POST['GivenTime']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/User/CreateRequest/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$Venue = preg_replace('!\s+!', ' ',strip_tags($_POST['Venue']));
			$Reason = preg_replace('!\s+!', ' ',strip_tags($_POST['Reason']));
			$GivenDate = preg_replace('!\s+!', ' ',strip_tags($_POST['GivenDate']));
			$GivenTime = preg_replace('!\s+!', ' ',strip_tags($_POST['GivenTime']));
			$InComingDate = preg_replace('!\s+!', ' ',strip_tags($_POST['InComingDate']));
			$InComingTime = preg_replace('!\s+!', ' ',strip_tags($_POST['InComingTime']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class CreateRequest{
				public static function ValidedData($Venue,$Reason,$GivenDate,$GivenTime,$InComingDate,$InComingTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					// Venue valided in backend
					if($Venue != preg_replace("/[^A-Za-z0-9,-. ]/","",$Venue)){
						return_response("Invalid Venue detect");

					}else if(strlen($Venue) < 3 || strlen($Venue) > 100){
						return_response("Invalid Venue detect");

					}

					// Venue valided in backend
					if($Reason != preg_replace("/[^A-Za-z0-9,-. ]/","",$Reason)){
						return_response("Invalid Reason detect");

					}else if(strlen($Reason) < 10 || strlen($Reason) > 250){
						return_response("Invalid Reason detect");

					}
					if($GivenDate != ''){
						if($GivenDate != preg_replace("/[^0-9-]/","",$GivenDate)){
							return_response('Invalid OutGoing Date detect!'); exit();
						}else if($GivenTime != preg_replace("/[^A-Z0-9:]/","",$GivenTime)){
							return_response('Invalid OutGoing Time detect 1!'); exit();
						}

						$GivenDateArray = explode('-', $GivenDate);
						if(!checkdate($GivenDateArray[1], $GivenDateArray[0], $GivenDateArray[2])){
							return_response('Invalid OutGoing Date detect!');
						}

						if($GivenDateArray[2] < date('Y') || strlen($GivenDateArray[2]) != 4){
							return_response('Invalid Given Date detect 1.1');
						}else{
							$GivenYear = $GivenDateArray[2];
						}

						if($GivenDateArray[1] == '1' || $GivenDateArray[1] == '01'){
							$GivenMonth = 'Jan';
						}else if($GivenDateArray[1] == '2' || $GivenDateArray[1] == '02'){
							$GivenMonth = 'Feb';
						}else if($GivenDateArray[1] == '3' || $GivenDateArray[1] == '03'){
							$GivenMonth = 'Mar';
						}else if($GivenDateArray[1] == '4' || $GivenDateArray[1] == '04'){
							$GivenMonth = 'Apr';
						}else if($GivenDateArray[1] == '5' || $GivenDateArray[1] == '05'){
							$GivenMonth = 'May';
						}else if($GivenDateArray[1] == '6' || $GivenDateArray[1] == '06'){
							$GivenMonth = 'Jun';
						}else if($GivenDateArray[1] == '7' || $GivenDateArray[1] == '07'){
							$GivenMonth = 'July';
						}else if($GivenDateArray[1] == '8' || $GivenDateArray[1] == '08'){
							$GivenMonth = 'Aug';
						}else if($GivenDateArray[1] == '9' || $GivenDateArray[1] == '09'){
							$GivenMonth = 'Sep';
						}else if($GivenDateArray[1] == '10' || $GivenDateArray[1] == '10'){
							$GivenMonth = 'Oct';
						}else if($GivenDateArray[1] == '11' || $GivenDateArray[1] == '11'){
							$GivenMonth = 'Nov';
						}else if($GivenDateArray[1] == '12' || $GivenDateArray[1] == '12'){
							$GivenMonth = 'Dec';
						}else{
							return_response('Invalid Given Date detect 1.1');
						}

						$TempGivenDate = $GivenDateArray[0].' '.$GivenMonth.' '.$GivenYear;

						if($GivenTime != preg_replace("/[^A-Z0-9:]/","",$GivenTime)){
							return_response('Invalid Given Time detect 1.0');
						}

						
						$GivenTimeArray = explode(':', $GivenTime);

						if($GivenTimeArray[2] != 'AM' && $GivenTimeArray[2] != 'PM'){
							return_response('Invalid Given Time detect 1.1');
						}else{
							$TempTimeType = $GivenTimeArray[2];
						}
						if($GivenTimeArray[0] < 0 || $GivenTimeArray[0] > 12 || $GivenTimeArray[1] < 0 || $GivenTimeArray[1] > 59){
							return_response('Invalid Given Time detect 1.2');
						}
						
						if($TempTimeType == 'PM'){
							if($GivenTimeArray[0] < 1){
								return_response('Invalid OutGoing Time detect 1.2.0');
							}
							if($GivenTimeArray[0] != 12){
								$GivenTimeArray[0] = $GivenTimeArray[0] + 12;
							}
							if($GivenTimeArray[0] > 23){
								return_response('Invalid OutGoing Time detect 1.2.1');
							}
						}else{
							if($GivenTimeArray[0] > 11){
								return_response('Invalid OutGoing Time detect 1.2.1');
							}
						}

						$TempGivenTime = $GivenTimeArray[0].' hours '.$GivenTimeArray[1].' minutes 0 seconds ';
						
						$TempGivenTime = strtotime($TempGivenDate.' '.$TempGivenTime);
						if($TempGivenTime == false){
							return_response('Invalid Given Date or Time detect 1.3');
						}
					}else{
						$TempGivenTime = '';
					}
						
					
					if($InComingDate != ''){
						if($InComingDate != preg_replace("/[^0-9-]/","",$InComingDate)){
							return_response('Invalid InComing Date detect!'); exit();
						}else if($InComingTime != preg_replace("/[^A-Z0-9:]/","",$InComingTime)){
							return_response('Invalid InComing Time detect!'); exit();
						}

						// InComing Date And Time Verify
						$InComingDateArray = explode('-', $InComingDate);
						if(!checkdate($InComingDateArray[1], $InComingDateArray[0], $InComingDateArray[2])){
							return_response('Invalid InComing Datae detect!'); exit();
						}

						if($InComingDateArray[2] < date('Y') || strlen($InComingDateArray[2]) != 4){
							return_response('Invalid Given Date detect 1.1');
						}else{
							$InComingYear = $InComingDateArray[2];
						}

						if($InComingDateArray[1] == '1' || $InComingDateArray[1] == '01'){
							$InComingMonth = 'Jan';
						}else if($InComingDateArray[1] == '2' || $InComingDateArray[1] == '02'){
							$InComingMonth = 'Feb';
						}else if($InComingDateArray[1] == '3' || $InComingDateArray[1] == '03'){
							$InComingMonth = 'Mar';
						}else if($InComingDateArray[1] == '4' || $InComingDateArray[1] == '04'){
							$InComingMonth = 'Apr';
						}else if($InComingDateArray[1] == '5' || $InComingDateArray[1] == '05'){
							$InComingMonth = 'May';
						}else if($InComingDateArray[1] == '6' || $InComingDateArray[1] == '06'){
							$InComingMonth = 'Jun';
						}else if($InComingDateArray[1] == '7' || $InComingDateArray[1] == '07'){
							$InComingMonth = 'July';
						}else if($InComingDateArray[1] == '8' || $InComingDateArray[1] == '08'){
							$InComingMonth = 'Aug';
						}else if($InComingDateArray[1] == '9' || $InComingDateArray[1] == '09'){
							$InComingMonth = 'Sep';
						}else if($InComingDateArray[1] == '10' || $InComingDateArray[1] == '10'){
							$InComingMonth = 'Oct';
						}else if($InComingDateArray[1] == '11' || $InComingDateArray[1] == '11'){
							$InComingMonth = 'Nov';
						}else if($InComingDateArray[1] == '12' || $InComingDateArray[1] == '12'){
							$InComingMonth = 'Dec';
						}else{
							return_response('Invalid InComing Date detect 1.1');
						}

						$TempInComingDate = $InComingDateArray[0].' '.$InComingMonth.' '.$InComingYear;

						if($InComingTime != preg_replace("/[^A-Z0-9:]/","",$InComingTime)){
							return_response('Invalid InComing Time detect 1.0');
						}

						
						$InComingTimeArray = explode(':', $InComingTime);

						if($InComingTimeArray[2] != 'AM' && $InComingTimeArray[2] != 'PM'){
							return_response('Invalid InComing Time detect 1.1');
						}else{
							$TempInComingTimeType = $InComingTimeArray[2];
						}
						if($InComingTimeArray[0] < 0 || $InComingTimeArray[0] > 12 || $InComingTimeArray[1] < 0 || $InComingTimeArray[1] > 59){
							return_response('Invalid InComing Time detect 1.2');
						}
						if($TempInComingTimeType == 'PM'){
							if($InComingTimeArray[0] < 1){
								return_response('Invalid InComing Time detect 1.2.0');
							}
							if($InComingTimeArray[0] != 12){
								$InComingTimeArray[0] = $InComingTimeArray[0] + 12;
							}
							if($InComingTimeArray[0] > 23){
								return_response('Invalid InComing Time detect 1.2.1');
							}
						}else{
							if($InComingTimeArray[0] > 11){
								return_response('Invalid InComing Time detect 1.2.1');
							}
						}

						$TempInComingTime = $InComingTimeArray[0].' hours '.$InComingTimeArray[1].' minutes 0 seconds ';
						
						$TempInComingDateAndTime = strtotime($TempInComingDate.' '.$TempInComingTime);
						if($TempInComingDateAndTime == false){
							return_response('Invalid InComing Date or Time detect 1.3');
						}

						if($TempInComingDateAndTime <= $TempGivenTime+299){
							return_response('InComing Time Must Be 5 Min Grater Then OutGoing Time!'); exit();
						}
					}else{
						$TempInComingDateAndTime = '';
					}
					
					// Call encode_post_input function
					CreateRequest::EncryptData($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
					
					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					// Call profile_imageResize function
					CreateRequest::CkeckLoginAndAuthenticate($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
					require_once (RootPath."Users/Service/Dashbord/SMS_axtxbyl4qn1583926727nb91ipl6rj/SendSms/Fast2SmsApi/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/Valided24HourGivenTimeAvaiableInGivenTwoTimeState/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/QrCodeGenrate/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/ServiceUseReport/index.php");
					require_once (RootPath."LibraryStore/SiteComponents/ServiceStatusForOrg/index.php");
					

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode::::FatherMobile::::GuardianMobile::::Fullname','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);

					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not login'); exit();
					}

					if($ResponseLogin['msg']['SecurityCode'] != $SecurityCode){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Invalid Security code 1.0'); exit();
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
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Some error occur! Try again later'); exit();
					}
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];
					$LgPositionRank = $ResponseRank;
					
					if($LgUserPosition == 1 || $LgUserPosition == 2){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorize to take this action 1.0'); exit();
					}

					CreateRequest::CreateRequestProccess($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank);
				}
				
				private static function CreateRequestProccess($Venue,$Reason,$TempGivenTime,$TempInComingDateAndTime,$SecurityCode,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$LgFor = $ResponseLogin['LFR'];

					$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
					if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True/* || $DGatePassServiceBuyStatus['msg']['IsServiceActiveted'] != True */){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('D GatePass service not active for this organization'); exit();
					}
					
					function rand_string( $length ) {  
						$RandStr = "";
						$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
						$size = strlen( $chars ); 
						for( $i = 0; $i < $length; $i++ ) {  
						$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
						} 
						return $RandStr;
					}

					function ConvertToDayFromsec($seconds){
						$dt1 = new DateTime("@0");
						$dt2 = new DateTime("@$seconds");
						return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
					}

					$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
					if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
						$DbConnection = $DbConnection['msg'];
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Database connection failed'); exit();
					}

					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::ServiceActiveSchedule::,::SettingKeyUnique::::SmsUpdatePermission::,::SettingKeyUnique::::GeneralSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');

					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service data can not feched!'); exit();
					}

					foreach ($GetServiceSetting['msg'] as $value){
						${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					if($GetServiceSettingServiceActiveSchedule == 'always'){
						# No need to change anything
						$CheckGetServiceSettingServiceActiveSchedule = true;
					}else if($GetServiceSettingServiceActiveSchedule == 'never'){
						return_response('Currently service is not active! It is done by this organization'); exit();
					}else{
						date_default_timezone_set('Asia/Kolkata');
						$TempGetServiceSettingServiceActiveSchedule = explode('*', $GetServiceSettingServiceActiveSchedule);
						foreach ($TempGetServiceSettingServiceActiveSchedule as $value) {
							$TempTimeArray = explode('-', $value);
							$TempStartTime = $TempTimeArray[0];
							$TempStartTimeArray = explode('_', $TempStartTime);
							$TempStartTimeHour = $TempStartTimeArray[0];
							$TempStartTimeMin = $TempStartTimeArray[1];
							$TempEndTime = $TempTimeArray[1];
							$TempEndTimeArray = explode('_', $TempEndTime);
							$TempEndTimeHour = $TempEndTimeArray[0];
							$TempEndTimeMin = $TempEndTimeArray[1];
							
							$Response = Valided24HourGivenTimeAvaiableInGivenTwoTimeState(['StartTimeHour'=>$TempStartTimeHour,'StartTimeMin'=>$TempStartTimeMin,'EndTimeHour'=>$TempEndTimeHour,'EndTimeMin'=>$TempEndTimeMin])['code'];
							if($Response == '400'){
								$CheckGetServiceSettingServiceActiveSchedule = false;
							}else if($Response == '200'){
								$CheckGetServiceSettingServiceActiveSchedule = true;
							}else{
								return_response('An technical error occur! Try again 1.0.0'); exit();
							}
						}
					}

					if($CheckGetServiceSettingServiceActiveSchedule == false){
						return_response('Currently service is not active! Schedule - '.preg_replace("/[*]/"," OR ",preg_replace("/[-]/"," To ",preg_replace("/[_]/",":",$GetServiceSettingServiceActiveSchedule)))); exit();
					}
					
					$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position::::GroupId::::GroupType',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);

					if($ServiceMemberData['status'] != "Success" || $ServiceMemberData['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorize to take this action 1.1'); exit();
					}

					$ServiceMemberDataPosition = $ServiceMemberData['msg']->Position;
					$ServiceMemberDataGroupId = $ServiceMemberData['msg']->GroupId;
					$ServiceMemberDataGroupType = $ServiceMemberData['msg']->GroupType;

					
					$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
					if($LgUserServicePositionRank == ''){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not a member of this service'); exit();
					}
					if($LgUserServicePositionRank != 0){
						return_response('You are not authorize to take this action 1.1'); exit();
					}

					foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
						$Temp =  explode(':', $value);
						${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
					}

					if($GetServiceSettingGeneralSettingInComingTimeTrack == 'Yes' && $TempInComingDateAndTime == ''){
						return_response('Invalid InComing Time detect!'); exit();
					}

					if($GetServiceSettingGeneralSettingOutGoingTimeTrack == 'Yes' && $TempGivenTime == ''){
						return_response('Invalid OutGoing Time detect!'); exit();
					}

					if($GetServiceSettingGeneralSettingOutGoingTimeTrack == 'No'){
						$TempGivenTime = $CurrentTime;
					}
					
					$GetUserAllOpenOrApproveRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Open::::Any::,::Status::::Approve::::Any::,::RequestFrom::::$LgUserUrl", 'FetchData'=>'Status::::RequestId::::OutGoingStatus::::InComingStatus::::SettingValue::::RequestOutGoingTime::::GuardianPermission::::WardenPermission::::RequestTime', 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All']);
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
										$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>11,'msg'=>'This request is auto closed, It is expired because your Guardian not respond on this request!'))];
									}else if($value->WardenPermission != 'Approve' && $value->WardenPermission != 'NotNeeded'){
										$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>12,'msg'=>'This request is auto closed, It is expired because warden not respond on this request!'))];
									}else{
										$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>13,'msg'=>'This request is auto closed, But we can not find reason! You can report it at support panel to help us'))];
									}
								}else if($CheckStMaxOutGoingTime == true){
									$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>14,'msg'=>'This request is auto closed, Because Max OutGoing Time Expired And You not go OutSide yet'))];
								}else if($CheckStMaxInComingTime == true){
									$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>15,'msg'=>'This request is auto closed, Because Max InComing Time Expired And You not go Outside yet'))];
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
									$AutoCloseIt = ['return'=>'Success','Reason'=>serialize(array('code'=>16,'msg'=>'This request is auto closed, Because Max OutGoing Time Expired And You not go OutSide yet'))];
								}else if($CheckStMaxInComingTime == true){
									$AutoCloseNeedPemission = true;
									$AutoCloseIt = ['return'=>'Error','Reason'=>serialize(array('code'=>17,'msg'=>'This request can not be auto closed, Because Max InComing Time Expired But You not come yet'))];
								}
							}
							
							if($AutoCloseIt['return'] == 'Success' || $AutoCloseIt['return'] == 'Error'){
								unlink(RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/'.$ResponseLogin['LFR'].'/'.$value->RequestId.'.png');
								if($AutoCloseIt['return'] == 'Success'){
									UpdateGivenData("Status::::Closed::,::StatusReason::::".$AutoCloseIt['Reason'],"RequestTime::::".$value->RequestTime."::,::RequestFrom::::$LgUserUrl",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass,'all');
								}
							}
						}

						if($AutoCloseNeedPemission == true){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Some Request Max InComing Time Expired But InComing status still pending! Plese resove it with the help of Organization Or Guardian'); exit();
						}
					}

					$GetUserAllOpenOrApproveRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Open::::Any::,::Status::::Approve::::Any::,::RequestFrom::::$LgUserUrl", 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All']);
					if($GetUserAllOpenOrApproveRequest['code'] != 200 && $GetUserAllOpenOrApproveRequest['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User Previous Request details not feched! due to technical error'); exit();
					}
					if($GetUserAllOpenOrApproveRequest['totalrows'] >= 5){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Maximum 5 request can Open or Approve, first close previous request to create new request'); exit();
					}

					$GetUserAllClosedRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Closed::,::RequestFrom::::$LgUserUrl", 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All']);
					if($GetUserAllClosedRequest['code'] != 200 && $GetUserAllClosedRequest['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User Previous Request details not feched! due to technical error'); exit();
					}else if($GetUserAllClosedRequest['code'] == 200){
						if($GetUserAllClosedRequest['totalrows'] > 10){
							$TempLimit = $GetUserAllClosedRequest['totalrows'] - 10;
							$AptPdoDeleteWithAes = AptPdoDeleteWithAes(['Condtion'=> "Status::::Closed::,::RequestFrom::::$LgUserUrl", 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass,'DataOrder'=> 'ASC|RequestTime','Limit'=>$TempLimit]);
							if($AptPdoDeleteWithAes['code'] != 200 && $AptPdoDeleteWithAes['code'] != 404){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Request can not create due to technical error Code - 1'); exit();
							}
						}
					}

					$AptPdoDeleteWithAes = AptPdoDeleteWithAes(['Condtion'=> "Status::::Closed::,::RequestFrom::::$LgUserUrl::,::RequestTime::::".($CurrentTime - 86400*7)."::::Lower", 'DbCon'=> $DbConnection, 'TbName'=> $LgFor.'_request_store', 'EPass'=> $EncodeAndEncryptPass]);
					
					if($GetServiceSettingGeneralSettingStudentCreateMultipleRequest == 'No'){
						$Response = FetchReuiredDataByGivenData("Status::::Open::,::RequestFrom::::$LgUserUrl",NULL,$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass,'all');
						if($Response['code'] != 404 && $Response['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Some technical error occur! Please try again later'); exit();
						}else if($Response['code'] != 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You can not create multiple request'); exit();
						}
						$Response = FetchReuiredDataByGivenData("Status::::Approve::,::RequestFrom::::$LgUserUrl",NULL,$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass,'all');
						if($Response['code'] != 404 && $Response['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Some technical error occur! Please try again later'); exit();
						}else if($Response['code'] != 404){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You can not create multiple request'); exit();
						}
					}
					
					if($TempGivenTime != '' && $TempInComingDateAndTime != ''){
						if($TempGivenTime < ($CurrentTime + ($GetServiceSettingGeneralSettingMinRequestSubmitAndOutGoingTimeDiff)) ||  $TempGivenTime > ($CurrentTime + ($GetServiceSettingGeneralSettingMaxRequestSubmitAndOutGoingTimeDiff))){
							return_response('Permission time not more then '.ConvertToDayFromsec($GetServiceSettingGeneralSettingMaxRequestSubmitAndOutGoingTimeDiff).' or less then '.ConvertToDayFromsec($GetServiceSettingGeneralSettingMinRequestSubmitAndOutGoingTimeDiff).' from current time');
						}
					}

					$TempGetServiceSettingSmsUpdatePermission = explode(',', $GetServiceSettingSmsUpdatePermission);
					foreach ($TempGetServiceSettingSmsUpdatePermission as $value) {
						$Temp =  explode('-', $value);
						${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
					}

					$SmsServiceBuyStatus = CheckServiceBuyStatus('aXTxByL4Qn1583926727NB91IPL6rj',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
					if($SmsServiceBuyStatus['status'] == 'Success' && $SmsServiceBuyStatus['code'] == 200 && $SmsServiceBuyStatus['msg']['ServiceBuy'] == True/* && $SmsServiceBuyStatus['msg']['IsServiceActiveted'] == True*/){
						$SmsServiceBuyStatus = true;
						$SmsServiceDbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj');
						if($SmsServiceDbConnection['status'] === 'Success' && $SmsServiceDbConnection['code'] === 200){
							$SmsServiceDbConnection = $SmsServiceDbConnection['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Sms service database connection failed!'); exit();
						}
					}else{
						$SmsServiceBuyStatus = false;
					}

					if($GetServiceSettingGeneralSettingGuardianPermissionPriorityFor == 'Guardian'){
						if($ResponseLogin['msg']['GuardianMobile'] == ''){
							if($ResponseLogin['msg']['FatherMobile'] == ''){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('We can not fetch your Father Mobile number!'); exit();
							}else{
								$ParentType = 'Father';
								$SendTo = $ResponseLogin['msg']['FatherMobile'];
							}
						}else{
							$ParentType = 'Guardian';
							$SendTo = $ResponseLogin['msg']['GuardianMobile'];
						}
					}else{
						if($ResponseLogin['msg']['FatherMobile'] == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('We can not fetch your Father Mobile number!'); exit();
						}else{
							$ParentType = 'Father';
							$SendTo = $ResponseLogin['msg']['FatherMobile'];
						}
					}
					
					$StudentFullname =  $ResponseLogin['msg']['Fullname'];

					if($GetServiceSettingGeneralSettingGuardianPermissionApprovalNeeded == 'Yes'){
						$CheckGetServiceSettingGeneralSettingGuardianPermissionApprovalNeeded = true;

						if($GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual == 'always'){
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = true;
						}else if($GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual == 'never'){
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = false;
						}else{

							# Continue from here , check guardion permission needed is for current time
							$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = explode('*', $GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual);
							foreach ($TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual as $value) {
								$TempTimeArray = explode('-', $value);
								$TempStartTime = $TempTimeArray[0];
								$TempStartTimeArray = explode('_', $TempStartTime);
								$TempStartTimeHour = $TempStartTimeArray[0];
								$TempStartTimeMin = $TempStartTimeArray[1];
								$TempEndTime = $TempTimeArray[1];
								$TempEndTimeArray = explode('_', $TempEndTime);
								$TempEndTimeHour = $TempEndTimeArray[0];
								$TempEndTimeMin = $TempEndTimeArray[1];
								
								$Response = Valided24HourGivenTimeAvaiableInGivenTwoTimeState(['StartTimeHour'=>$TempStartTimeHour,'StartTimeMin'=>$TempStartTimeMin,'EndTimeHour'=>$TempEndTimeHour,'EndTimeMin'=>$TempEndTimeMin,'CheckForThisHour'=>date('H',$TempGivenTime),'CheckForThisMin'=>date('i',$TempGivenTime)])['code'];
								if($Response == '400'){
									$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = false;
								}else if($Response == '200'){
									$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = true;
								}else{
									return_response('An technical error occur! Try again 1.0.1'); exit();
								}
							}

						}

						if($GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual == 'always'){
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = true;
						}else if($GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual == 'never'){
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = false;
						}else{

							# Continue from here , check guardion permission needed is for current time
							$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = explode('*', $GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual);
							foreach ($TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual as $value) {
								$TempTimeArray = explode('-', $value);
								$TempStartTime = $TempTimeArray[0];
								$TempStartTimeArray = explode('_', $TempStartTime);
								$TempStartTimeHour = $TempStartTimeArray[0];
								$TempStartTimeMin = $TempStartTimeArray[1];
								$TempEndTime = $TempTimeArray[1];
								$TempEndTimeArray = explode('_', $TempEndTime);
								$TempEndTimeHour = $TempEndTimeArray[0];
								$TempEndTimeMin = $TempEndTimeArray[1];
								
								$Response = Valided24HourGivenTimeAvaiableInGivenTwoTimeState(['StartTimeHour'=>$TempStartTimeHour,'StartTimeMin'=>$TempStartTimeMin,'EndTimeHour'=>$TempEndTimeHour,'EndTimeMin'=>$TempEndTimeMin,'CheckForThisHour'=>date('H',$TempGivenTime),'CheckForThisMin'=>date('i',$TempGivenTime)])['code'];

								if($Response == '400'){
									$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = false;
								}else if($Response == '200'){
									$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = true;
								}else{
									return_response('An technical error occur! Try again 1.0.1'); exit();
								}
							}

						}
					}else{
						$CheckGetServiceSettingGeneralSettingGuardianPermissionApprovalNeeded = false;
						$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = false;
						$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = false;
					}
					
					if($GetServiceSettingGeneralSettingWardenPermissionApprovalNeeded == 'Yes'){
						$CheckGetServiceSettingGeneralSettingWardenPermissionApprovalNeeded = true;
						if($GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual == 'always'){
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = true;
						}else if($GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual == 'never'){
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = false;
						}else{
							# Continue from here , check guardion permission needed is for current time
							$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = explode('*', $GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual);
							foreach ($TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual as $value) {
								$TempTimeArray = explode('-', $value);
								$TempStartTime = $TempTimeArray[0];
								$TempStartTimeArray = explode('_', $TempStartTime);
								$TempStartTimeHour = $TempStartTimeArray[0];
								$TempStartTimeMin = $TempStartTimeArray[1];
								$TempEndTime = $TempTimeArray[1];
								$TempEndTimeArray = explode('_', $TempEndTime);
								$TempEndTimeHour = $TempEndTimeArray[0];
								$TempEndTimeMin = $TempEndTimeArray[1];
								$Response = Valided24HourGivenTimeAvaiableInGivenTwoTimeState(['StartTimeHour'=>$TempStartTimeHour,'StartTimeMin'=>$TempStartTimeMin,'EndTimeHour'=>$TempEndTimeHour,'EndTimeMin'=>$TempEndTimeMin,'CheckForThisHour'=>date('H',$TempGivenTime),'CheckForThisMin'=>date('i',$TempGivenTime)])['code'];
								if($Response == '400'){
									$CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = false;
								}else if($Response == '200'){
									$CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = true;
								}else{
									return_response('An technical error occur! Try again 1.0.2'); exit();
								}
							}
						}
						
						if($GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual == 'always'){
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = true;
						}else if($GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual == 'never'){
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = false;
						}else{
							# Continue from here , check guardion permission needed is for current time
							$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = explode('*', $GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual);
							foreach ($TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual as $value) {
								$TempTimeArray = explode('-', $value);
								$TempStartTime = $TempTimeArray[0];
								$TempStartTimeArray = explode('_', $TempStartTime);
								$TempStartTimeHour = $TempStartTimeArray[0];
								$TempStartTimeMin = $TempStartTimeArray[1];
								$TempEndTime = $TempTimeArray[1];
								$TempEndTimeArray = explode('_', $TempEndTime);
								$TempEndTimeHour = $TempEndTimeArray[0];
								$TempEndTimeMin = $TempEndTimeArray[1];
								$Response = Valided24HourGivenTimeAvaiableInGivenTwoTimeState(['StartTimeHour'=>$TempStartTimeHour,'StartTimeMin'=>$TempStartTimeMin,'EndTimeHour'=>$TempEndTimeHour,'EndTimeMin'=>$TempEndTimeMin,'CheckForThisHour'=>date('H',$TempGivenTime),'CheckForThisMin'=>date('i',$TempGivenTime)])['code'];
								if($Response == '400'){
									$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = false;
								}else if($Response == '200'){
									$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = true;
									$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = true;
								}else{
									return_response('An technical error occur! Try again 1.0.2'); exit();
								}
							}
						}
					}else{
						$CheckGetServiceSettingGeneralSettingWardenPermissionApprovalNeeded = false;
						$CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = false;
						$CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = false;
					}
					
					if($GetServiceSettingGeneralSettingInComingTimeTrack == 'Yes'){
						$CheckGetServiceSettingGeneralSettingInComingTimeTrack = true;
						$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffArray = explode('-', $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff);
						if($GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffArray[0] == 'Yes'){
							$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = 'Yes';
							$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffTime = $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffArray[1];
						}else{
							$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = 'No';
							$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffTime = null;
						}

						$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffArray = explode('-', $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff);
						if($GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffArray[0] == 'Yes'){
							$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = 'Yes';
							$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffTime = $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffArray[1];
						}else{
							$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = 'No';
							$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffTime = null;
						}

						if($GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff == 'Yes'){
							if($TempInComingDateAndTime - $TempGivenTime >= $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiffTime){
								$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = true;
							}else{
								$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = false;
							}
						}else{
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = false;
						}

						if($GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff == 'Yes'){
							if($TempInComingDateAndTime - $TempGivenTime >= $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiffTime){
								$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = true;
							}else{
								$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = false;
							}
						}else{
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = false;
						}

						if($GetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff == 'Yes'){
							if(date('d-M-Y',$TempGivenTime) == date('d-M-Y',$TempInComingDateAndTime)){
								$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff = false;
							}else{
								$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff = true;
							}
						}else{
							$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff = false;
						}

						if($GetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff == 'Yes'){
							if(date('d',$TempGivenTime) == date('d',$TempInComingDateAndTime)){
								$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff = false;
							}else{
								$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff = true;
							}
						}else{
							$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff = false;
						}
					}else{
						$CheckGetServiceSettingGeneralSettingInComingTimeTrack = false;
						$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = false;
						$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = false;
						$CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff = false;
						$CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff = false;
					}

					$Number1 = floor((29 - strlen($CurrentTime))/2);
					$Number2 = (29 - strlen($CurrentTime)) - $Number1;

					$Number3 = floor((19 - strlen($CurrentTime))/2);
					$Number4 = (19 - strlen($CurrentTime)) - $Number3;

					// Create unique user for user account
					$RequestId = "a".rand_string($Number1).$CurrentTime.rand_string($Number2);
					$GuardianPermissionReceiveUrlKey = "a".rand_string($Number3).$CurrentTime.rand_string($Number4);

					$ServiceRequestStore = FetchReuiredDataByGivenData("RequestId::::$RequestId",NULL,$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
					if($ServiceRequestStore['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Some technical error occur! Please try again later'); exit();
					}
					$InsertData = '';

					if($CheckGetServiceSettingGeneralSettingGuardianPermissionApprovalNeeded == true && ($CheckGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual == true || $CheckGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual == true || ($CheckGetServiceSettingGeneralSettingInComingTimeTrack == true && $CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff == true) || $CheckGetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff == true)){
						$GuardianPermission = 'Pending';
						$InsertData .= "GuardianPermissionReceiveUrlKey::::$GuardianPermissionReceiveUrlKey::,::";
					}else{
						$GuardianPermission = 'NotNeeded';
						$InsertData .= "GuardianPermissionTime::::$CurrentTime::,::";
					}

					if($CheckGetServiceSettingGeneralSettingWardenPermissionApprovalNeeded == true && ($CheckGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual == true || $CheckGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual == true || ($CheckGetServiceSettingGeneralSettingInComingTimeTrack == true && $CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff == true) || $CheckGetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff == true)){
						$WardenPermission = 'Pending';
					}else{
						$WardenPermission = 'NotNeeded';
						$InsertData .= "WardenPermissionTime::::$CurrentTime::,::";
					}

					if($GetServiceSettingGeneralSettingInComingTimeTrack == 'Yes'){
						$StMaxInComingTime = $TempInComingDateAndTime;
						$InComingStatus = 'Pending';
						$InsertData .= "RequestInComingTime::::$TempInComingDateAndTime::,::";
					}else{
						$InComingStatus = 'NotNeeded';
						$StMaxInComingTime = 'NotNeeded';
					}
					if($GetServiceSettingGeneralSettingOutGoingTimeTrack == 'Yes'){
						$OutGoingStatus = 'Pending';
						if($GuardianPermission == 'Pending' || $WardenPermission == 'Pending'){
							$Status = 'Open';
						}else{
							$Status = 'Approve';
						}
					}else{
						$OutGoingStatus = 'NotNeeded';
						$Status = 'Approve';
					}
					
					if($OutGoingStatus == 'Pending'){
						# Max Wait For OutGoing
						$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing = explode('*', $GetServiceSettingGeneralSettingMaxTimeWaitForOutGoing);
						$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingType = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing[0];
						if($TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingType == 'For'){
							$GetGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing[1];
						}else{
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime = explode('-', $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing[1]);
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTime = explode('_', $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime[0]);
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour = $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTime[0];
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin = $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTime[1];
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTime = explode('_', $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime[1]);
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour = $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTime[0];
							$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin = $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTime[1];
						}
						
						if($TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingType == 'For'){
							$StMinOutGoingTime = $TempGivenTime;
							$StMaxOutGoingTime = $TempGivenTime+$GetGetServiceSettingGeneralSettingMaxTimeWaitForOutGoing;
						}else{

							$TempMinWaitForOutGoingByMaxWaitForOutGoing = strtotime(date('d M Y',$TempGivenTime)." $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour hours $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin minutes 0 seconds");
							if($TempMinWaitForOutGoingByMaxWaitForOutGoing == false){
								return_response('Invalid Min Wait For OutGoing, due to technical error');
							}

							$TempMaxWaitForOutGoingByMaxWaitForOutGoing = strtotime(date('d M Y',$TempGivenTime)." $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour hours $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin minutes 0 seconds");
							if($TempMaxWaitForOutGoingByMaxWaitForOutGoing == false){
								return_response('Invalid Max Wait For OutGoing, due to technical error');
							}

							if($TempGivenTime > $TempMinWaitForOutGoingByMaxWaitForOutGoing){
								$StMinOutGoingTime = $TempGivenTime;
							}else{
								return_response("Request OutGoing Time Must Be Between - $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour:$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin to $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour:$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin ".'[Min]');
							}

							if($TempGivenTime < $TempMaxWaitForOutGoingByMaxWaitForOutGoing){
								$StMaxOutGoingTime = $TempMaxWaitForOutGoingByMaxWaitForOutGoing;
							}else{
								return_response("Request OutGoing Time Must Be Between - $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour:$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin to $TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour:$TempUntilGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin ".'[Max]');
							}
						}
						if($GetServiceSettingGeneralSettingInComingTimeTrack == 'Yes'){
							if($StMaxOutGoingTime > $TempInComingDateAndTime){
								$StMaxOutGoingTime = $TempInComingDateAndTime;
							}
						}

						if($Status == 'Open'){
							if($TempGivenTime+$GetServiceSettingGeneralSettingMaxTimeWaitForApproveOrRejectPermissionFromAll < $StMaxOutGoingTime){
								$MaxTimeWaitForApproveOrRejectPermissionFromAll = $TempGivenTime+$GetServiceSettingGeneralSettingMaxTimeWaitForApproveOrRejectPermissionFromAll;
							}else{
								$MaxTimeWaitForApproveOrRejectPermissionFromAll = $StMaxOutGoingTime;
							}
						}else{
							$MaxTimeWaitForApproveOrRejectPermissionFromAll = 'NotNeeded';
						}
					}else{
						$StMinOutGoingTime = $CurrentTime;
						$StMaxOutGoingTime = 'NotNeeded';
						if($Status == 'Open'){
							$MaxTimeWaitForApproveOrRejectPermissionFromAll = $TempGivenTime+$GetServiceSettingGeneralSettingMaxTimeWaitForApproveOrRejectPermissionFromAll;
						}else{
							$MaxTimeWaitForApproveOrRejectPermissionFromAll = 'NotNeeded';
						}
					}

					if($OutGoingStatus == 'NotNeeded' && $InComingStatus == 'NotNeeded'){
						return_response('An technical error occur'); exit();
					}

					
					$SettingValueArray = serialize(['MaxTimeWaitForApproveOrRejectPermissionFromAll'=>$MaxTimeWaitForApproveOrRejectPermissionFromAll,'StMinOutGoingTime'=>$StMinOutGoingTime,'StMaxOutGoingTime'=>$StMaxOutGoingTime,'StMaxInComingTime'=>$StMaxInComingTime,'GuardianOrParentNo'=>$SendTo,'GuardianOrParentType'=>$ParentType]);
					$InsertData .= "Status::::$Status::,::RequestId::::$RequestId::,::GroupId::::$ServiceMemberDataGroupId::,::GroupType::::$ServiceMemberDataGroupType::,::WardenPermission::::$WardenPermission::,::RequestFrom::::$LgUserUrl::,::RequestTime::::$CurrentTime::,::Venue::::$Venue::,::RequestReason::::$Reason::,::RequestOutGoingTime::::$TempGivenTime::,::OutGoingStatus::::$OutGoingStatus::,::InComingStatus::::$InComingStatus::,::GuardianPermission::::$GuardianPermission::,::SettingValue::::$SettingValueArray";
					
					if(($OutGoingStatus == 'Pending' || $InComingStatus == 'Pending') && $Status == 'Approve'){
						$QrCodeCreate = true;
					}else{
						$QrCodeCreate = false;
					}
					
					if($QrCodeCreate == true){
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
					
					$Response = InsertGivenData($InsertData,$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						$ServiceUseReport = ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'RequestNo'=>1,'ReqType'=>'Charge']);

						if($ServiceUseReport['code'] != 200){
							DeleteDataFromTable("RequestId::::$RequestId",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
							if($QrCodeCreate == true){
								unlink($QrSavePath.'/'.$RequestId.'.png');
							}
							if($ServiceUseReport['surc'] == 1){
								$ErrorDes = 'Currently service is not active for this organization!';
							}else if($ServiceUseReport['surc'] == 2){
								$ErrorDes = 'Currently service is not active due to Insufficient D GatePass balance!';
							}else{
								$ErrorDes = 'Request Not Created due to technical error in D GatePass Service! Code - '.$ServiceUseReport['surc'];
							}
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey!='ErrorDes'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
							return_response($ErrorDes); exit();
						}

						if($GuardianPermission == 'Pending'){
							if($SmsServiceBuyStatus != True){
								ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'RequestNo'=>1,'ReqType'=>'Refund']);
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Request Not Created Beacuse Sms service not active for this organization!'); exit();
							}

							$SmsResponse = SendSmsByFast2Sms(['DbConnection'=>$SmsServiceDbConnection,'PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'CurrentTime'=>$CurrentTime,'SmsBody'=>'24555','SendTo'=>$SendTo,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#FF#}|{#DD#}','variables_values'=>substr($LgFor, 0, 30)."|".substr("$GuardianPermissionReceiveUrlKey&20", 0, 20),'MsgType'=>'QuickTransactional','SendBy'=>$ResponseLogin['msg']['UserUrl'],'MsgLable'=>'HDGatePass','ExtMsg'=>"Dear parent your child generate HDPass req, So Approve Or Reject - http://topicster.live/SPRBC/?".substr($LgFor, 0, 30)."&".substr("$GuardianPermissionReceiveUrlKey&20", 0, 20)]);

							if($SmsResponse['status'] != 'Success' || $SmsResponse['code'] != 200){
								DeleteDataFromTable("RequestId::::$RequestId",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
								if($SmsResponse['reason'] == 411){
									$error_dic = $ParentType. "'s Mobile number detect invalid!";
								}else if($SmsResponse['surc'] == 2){
									$error_dic = $SmsResponse['msg'];
								}

								ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'RequestNo'=>1,'ReqType'=>'Refund']);
								
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'error_dic'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
								if($error_dic != ''){
									return_response($error_dic); exit();
								}
								
								return_response('Sms service not work properly due to technical error or internet connection!'); exit();
							}

							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Your Request created Successfully! Text Sms sent to your Guardian for Approval',true,'Success',200); exit();
						}

						if($Status === 'Approve'){
							if($OutGoingStatus == 'NotNeeded'){
								if($GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Yes' || $GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Optional'){
									if($GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Yes'){
										if($SmsServiceBuyStatus != True){
											DeleteDataFromTable("RequestId::::$RequestId",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
											ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'RequestNo'=>1,'ReqType'=>'Refund']);
											foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
											return_response('Request Not Created Beacuse Sms service not active for this organization!'); exit();
										}	
									}

									if($SmsServiceBuyStatus == True){
										$SmsResponse = SendSmsByFast2Sms(['DbConnection'=>$SmsServiceDbConnection,'PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'CurrentTime'=>$CurrentTime,'SmsBody'=>'24752','SendTo'=>$SendTo,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#FF#}|{#EE#}','variables_values'=>substr($StudentFullname, 0, 30)."|".substr(date('d-M-Y, h:i:s A',$CurrentTime), 0, 25),'MsgType'=>'QuickTransactional','SendBy'=>$ResponseLogin['msg']['UserUrl'],'MsgLable'=>'HDGatePass','ExtMsg'=>"Dear Guardian, Your child (".substr($StudentFullname, 0, 30).") go outside of college at ".substr(date('d-M-Y, h:i:s A',$CurrentTime), 0, 25)]);

										if($SmsResponse['status'] != 'Success' || $SmsResponse['code'] != 200){
											if($GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Yes'){
												DeleteDataFromTable("RequestId::::$RequestId",$DbConnection,$LgFor.'_request_store',$EncodeAndEncryptPass);
												if($SmsResponse['reason'] == 411){
													$error_dic = $ParentType. "'s Mobile number detect invalid!";
												}else if($SmsResponse['surc'] == 2){
													$error_dic = $SmsResponse['msg'];
												}
												ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFor,'RequestNo'=>1,'ReqType'=>'Refund']);
												return_response(json_encode($SmsResponse));
												foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'error_dic'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
												if($error_dic != ''){
													return_response($error_dic); exit();
												}
												
												return_response('Sms service not work properly due to technical error or internet connection!'); exit();
											}
										}
									}
								}
							}
							
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Your Request created And Approved Successfully!',true,'Success',200); exit();
						}

						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Your Request created Successfully',true,'Success',200); exit();
					}else{
						if($QrCodeCreate == true){
							unlink($QrSavePath.'/'.$RequestId.'.png');
						}
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Oops! Your Request not created due to technical error'); exit();
					}
				}	
			}
			
			// Call classname public function 
			CreateRequest::ValidedData($Venue,$Reason,$GivenDate,$GivenTime,$InComingDate,$InComingTime,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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