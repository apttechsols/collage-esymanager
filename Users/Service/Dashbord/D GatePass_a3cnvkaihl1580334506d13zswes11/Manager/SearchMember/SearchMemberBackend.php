<?php
	/*
	@FileName - SearchData.php
	@Desc - Search Member of hostal D gatepass
	@Author - Arpit sharma
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
	define("RootPath",  '../../../../../../');

	if(isset($_POST['SearchDataKey']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
		require_once (RootPath."JsonShowError/index.php"); // Require Show error file
		
		// Verify data send from same domain or not
		if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Manager/SearchMember/index.php"){
			
			session_start();
			if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

				// Create variable from get data by request (example Post and Get methos)
				$SearchDataKey = preg_replace('!\s+!', ' ',strip_tags($_POST['SearchDataKey']));

				if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
					foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
					return_response("Process failed!");
				}else{
					// Create New BrowserUniqueDetails
					$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

					$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
				}

				class SearchData{
					public static function ValidedData($SearchDataKey,$BrowserClientId1,$BrowserClientId2){

						// SearchDataKey valided in backend
						if($SearchDataKey == ""){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); 
							return_response("Please Enter Somthing In Search Box");
						}else if($SearchDataKey != preg_replace("/[^A-Za-z0-9@.]/","",$SearchDataKey)){
							return_response("Invalid serch data detect");
						}
						
						// Call encode_post_input function
						SearchData::CkeckLoginAndAuthenticate($SearchDataKey,$BrowserClientId1,$BrowserClientId2);
					}
					private static function CkeckLoginAndAuthenticate($SearchDataKey,$BrowserClientId1,$BrowserClientId2){

						$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

						//Secrate code for access database file
						$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

						//Secrate code for access otherfiles file
						$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

						// Access main_db file to access data base connection ($PdoMainUserAccountDb)
						require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

						// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
						require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

						// Access organization_user_setting file to access data base connection ($PdoOrganizationUserSetting)
						require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

						// Access main_db file to access data base connection ($PdoServiceManage)
						require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

						//Create connection for any Database (CreateDbConnection(DbName))
						require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");

						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
						require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
						require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
						require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
						require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
						require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

						/*-------------- Apt Library -----------------------*/
						require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");

						// Check user login
						$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);

						if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not login'); exit();
						}

						$LgFor = $ResponseLogin['LFR'];
						
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
						$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
						$LgFor = $ResponseLogin['LFR'];
						$LgUserPosition = $ResponseLogin['msg']['Position'];
						$LgPositionRank = $ResponseRank;
						SearchData::SearchDataRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank);
					}
					private function SearchDataRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgFor,$LgUserUrl,$LgUserPosition,$LgPositionRank){

						// Create isset time according Asia/Kolkata
						date_default_timezone_set('Asia/Kolkata');
						
						$CurrentTime = time();
						
						$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
						if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('D GatePass service not active for this organization'); exit();
						}

						$SearchResult = array();

						$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);

						if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('This service not buyed by this organization'); exit();
						}

						$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
						if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
							$DbConnection = $DbConnection['msg'];
						}else{
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Connection failed! Try again later'); exit();
						}

						$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
						if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
						    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Service Setting can not feched! Due to technical error');
						}
						foreach ($GetServiceSetting['msg'] as $value){
							${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
						}
						
						if($LgPositionRank != 1 && $LgPositionRank != 2){

							$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
							if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('Service member data can not feched due to technical error!'); exit();
							}
							$LgUserServiceMemberPosition = $ServiceMemberData['msg']->Position;
							$LgUserServiceMemberPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $LgUserServiceMemberPosition.':', '*');
							if($LgUserServiceMemberPositionRank == ''){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'LgUserServiceMemberPosition'){unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
								return_response($LgUserServiceMemberPosition.' Not found in this service');
							}
							if($LgUserServiceMemberPositionRank != 1){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('You are not authorized to take this action'); exit();
							}
						}

						$GetSearchUserUrl = AptPdoFetchWithAes(['Condtion'=> "Fullname::::$SearchDataKey::,::Position::::$SearchDataKey::,::Mobile::::$SearchDataKey::,::UniqueId::::$SearchDataKey::,::Email::::$SearchDataKey::,::UserUrl::::$SearchDataKey", 'FetchData'=>'UserUrl::::ProfileUrl::::Fullname::::Gender::::Position', 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $LgFor, 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DefaultCheckType'=>'ValLike','DefaultCheckFor'=>'Any','Limit'=>10]);

						if($GetSearchUserUrl['status'] != 'Success' || $GetSearchUserUrl['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('This user not member of this organization'); exit();
						}
						$i = 0;
						foreach ($GetSearchUserUrl['msg'] as $key => $value){

							$SearchUserUrl = $value->UserUrl;
							$SearchProfileUrl = $value->ProfileUrl;
							$SearchFullname = $value->Fullname;
							$SearchGender = $value->Gender;
							$SearchPosition = $value->Position;

							$SearchUserData =FetchReuiredDataByGivenData("UserUrl::::$SearchUserUrl",'Status::::GroupId::::Position::::ActiveSchedule::::GroupType::::MemberOfGroup',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);

							if($SearchUserData['status'] != 'Success' || $SearchUserData['code'] != 200){
								continue;
							}

							$SearchUserData['msg']->ProfileUrl = $SearchProfileUrl;
							$SearchUserData['msg']->Fullname = $SearchFullname;
							$SearchUserData['msg']->Gender = $SearchGender;
							$SearchUserData['msg']->OrgPosition = $SearchPosition;
							$SearchUserData['msg']->SearchUserUrl = $SearchUserUrl;

							$SearchResult[$i] = $SearchUserData['msg'];

							$i++;
						}
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'SearchResult' && $SetVarKey !== 'i'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
						return_response(array('Result'=>$SearchResult,'ResultRows'=>$i),true,'Success',200); exit();
					}
				}
				SearchData::ValidedData($SearchDataKey,$BrowserClientId1,$BrowserClientId2);
			}else{
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
				return_response("Invalid Token Id! Refresh page");
			}
		}else{
			header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
		}
	}else{
		header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
	}
?>