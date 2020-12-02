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
if(isset($_POST['UserData']) && isset($_POST['Status']) && isset($_POST['Position']) && isset($_POST['GroupId']) && isset($_POST['GroupType']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Manager/AddMember/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$UserData = preg_replace('!\s+!', ' ',strip_tags($_POST['UserData']));
			$Status = preg_replace('!\s+!', ' ',strip_tags($_POST['Status']));
			$Position = preg_replace('!\s+!', ' ',strip_tags($_POST['Position']));
			$GroupId = preg_replace('!\s+!', ' ',strip_tags($_POST['GroupId']));
			$GroupType = preg_replace('!\s+!', ' ',strip_tags($_POST['GroupType']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class AddNewMember 
			{
				public static function ValidedData($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// UserData valided in backend
					if($UserData != preg_replace("/[^A-Za-z0-9@.]/","",$UserData)){
						return_response("Invalid UserData detect");

					}else if(strlen($UserData) < 5 || strlen($UserData) > 40){
						return_response("Invalid UserData detect");

					}

					// Status valided in backend
					if($Status != "Active" && $Status != "Hold"){
						return_response("Invalid Status detect");
					}
					
					// Position valided in backend
					if($Position != preg_replace("/[^A-Za-z0-9 ]/","",$Position)){
						return_response("Invalid Position detect");
					}

					// GroupId valided in backend
					if($GroupId != "all"){
						return_response("Invalid GroupId detect");
					}

					// GroupType valided in backend
					if($GroupType != "public" && $GroupType != "private"){
						return_response("Invalid GroupType detect");
					}
					
					// Call encode_post_input function
					AddNewMember::EncryptData($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					AddNewMember::CkeckLoginAndAuthenticate($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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
					require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not login'); exit();
					}

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
						return_response('You are not authorized to take this action'); exit();
					}
					
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];
					$LgPositionRank = $ResponseRank;

					AddNewMember::AddNewMemberProccess($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank);
				}
				
				private static function AddNewMemberProccess($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();
					
					$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
					
					if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('D GatePass service not active for this organization'); exit();
					}

					$LgFor = $ResponseLogin['LFR'];

					$CheckManager = False;

					if($LgPositionRank != 1 && $LgPositionRank != 2){
						$CheckManager = True;
					}

					$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetOrgSetting['status'] != "Success" || $GetOrgSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Org Setting can not feched! Due to technical error');
					}
					foreach ($GetOrgSetting['msg'] as $value){
						${'GetOrgSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
					if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
						$DbConnection = $DbConnection['msg'];
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Database connection failed'); exit();
					}
					
					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service Setting can not feched! Due to technical error');
					}
					foreach ($GetServiceSetting['msg'] as $value){
						${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					$LgServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
					if($LgServiceMemberData['status'] === 'Success' && $LgServiceMemberData['code'] === 200){
						
						$AddMemberByPosition = $LgServiceMemberData['msg']->Position;
						$AddMemberByPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $AddMemberByPosition.':', '*');
						if($AddMemberByPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not a member of this service'); exit();
						}

						if($AddMemberByPositionRank != 1){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not authorized to add member in this service! 1.3.2'); exit();
						}
					}else if($CheckManager == False){
						$AddMemberByPosition = $LgUserPosition;
						$AddMemberByPositionRank = $LgPositionRank;
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not a member of this service! 1.3.3'); exit();
					}
					
					// Verify new user position
					$AddUserPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $Position.':', '*');
					if($AddUserPositionRank == ''){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response($Position.' Position is not found in this service '); exit();
					}
                    
					if($CheckManager == True){
						if($AddUserPositionRank == 1){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You can not add member at Manager position'); exit();
						}
					}
					
					$Response = FetchReuiredDataByGivenData("Mobile::::$UserData::,::Email::::$UserData::,::UserUrl::::$UserData","UserUrl::::Position",$PdoOrganizationUserAccount,$LgFor,$EncodeAndEncryptPass,'any');
					if($Response['status'] != "Success" || $Response['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){if($SetVarKey != 'UserData'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response($UserData.' Not member of this Organization'); exit();
					}

					$AddUserUrl = $Response['msg']->UserUrl;
					$AddUserOrgPosition = $Response['msg']->Position;

					$AddUserOrgPositionRank = GetSubStringBetweenTwoCharacter($GetOrgSettingPosition, $AddUserOrgPosition.':', ':');
					if($AddUserOrgPositionRank == ''){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Some technical error occur! Try again later 1.1');
					}
                
					if($AddUserOrgPositionRank == 1 || $AddUserOrgPositionRank == 2){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Organization Owner Or Admin can not be a part of service member'); exit();
					}
                    
					if($AddUserPositionRank == 0 && $AddUserOrgPositionRank != 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You can not add this member as student beacuse it is not a student in Organization position'); exit();
					}else if($AddUserOrgPositionRank == 0 && $AddUserPositionRank != 0){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You can not add this member at this position beacuse this user is added at student position in Organization'); exit();
					}

					$Response = FetchReuiredDataByGivenData("UserUrl::::$AddUserUrl",NULL,$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass,'any');
					if($Response['code'] != 200 && $Response['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service data not feched! due to technical error'); exit();
					}else if($Response['code'] != 404){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){if($SetVarKey != 'UserData'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response($UserData.' Already member of this service');
					}
					
					$InsertData = "Status::::$Status::,::UserUrl::::$AddUserUrl::,::Position::::$Position::,::GroupId::::$GroupId::,::GroupType::::$GroupType::,::MemberOfGroup::::NULL::,::CreateTime::::$CurrentTime::,::CreateBy::::$LgUserUrl::,::CreatePosition::::$AddMemberByPosition::,::CreateRank::::$AddMemberByPositionRank::,::LastUpdateTime::::$CurrentTime::,::LastUpdateBy::::$LgUserUrl::,::LastUpdatePosition::::$AddMemberByPosition::,::LastUpdateRank::::$AddMemberByPositionRank";
					
					$Response = InsertGivenData($InsertData,$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Add new user Successfully',true,'Success',200); exit();
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not added'); exit();
					}
				}	
			}
			
			// Call classname public function 
			AddNewMember::ValidedData($UserData,$Status,$Position,$GroupId,$GroupType,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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