<?php 
/*
*@FileName RequestCloseBackend.php
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
if(isset($_POST['ReqId']) && isset($_POST['StUserUrl']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php");
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Manager/RequestStatus/index.php?u=".$_POST['StUserUrl']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$ReqId = preg_replace('!\s+!', ' ',strip_tags($_POST['ReqId']));
			$StUserUrl = preg_replace('!\s+!', ' ',strip_tags($_POST['StUserUrl']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class RequestClose{
				public static function ValidedData($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// ReqId valided in backend
					if($ReqId != preg_replace("/[^A-Za-z0-9@.]/","",$ReqId)){
						return_response("Invalid Requset Id detect");

					}else if(strlen($ReqId) < 5 || strlen($ReqId) > 40){
						return_response("Invalid Requset Id detect");
					}
					
					// StUserUrl valided in backend
					if($StUserUrl != preg_replace("/[^A-Za-z0-9 ]/","",$StUserUrl)){
						return_response("Invalid Student Url detect");
					}

					if($SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response("Invalid Security Code detect");
					}
					
					// Call encode_post_input function
					RequestClose::EncryptData($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					RequestClose::CkeckLoginAndAuthenticate($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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

					/*-------------- Apt Library -----------------------*/
    				require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");

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

					RequestClose::RequestCloseProcess($ReqId,$StUserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank);
				}
				
				private static function RequestCloseProcess($ReqId,$StUserUrl,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank){

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

					$DGatePassServiceCon = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
					if($DGatePassServiceCon['status'] === 'Success' && $DGatePassServiceCon['code'] === 200){
						$DGatePassServiceCon = $DGatePassServiceCon['msg'];
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Database connection failed, due to technical error'); exit();
					}
					
					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DGatePassServiceCon,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service Setting can not feched! Due to technical error');
					}
					foreach ($GetServiceSetting['msg'] as $value){
						${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					$LgServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DGatePassServiceCon,$LgFor.'_member',$EncodeAndEncryptPass);
					if($LgServiceMemberData['status'] === 'Success' && $LgServiceMemberData['code'] === 200){
						
						$CloseRequestByPosition = $LgServiceMemberData['msg']->Position;
						$CloseRequestByPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $CloseRequestByPosition.':', '*');
						if($CloseRequestByPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not a member of this service'); exit();
						}

						if($CloseRequestByPositionRank != 1){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not authorized to close student request in this service! 1.3.2'); exit();
						}
					}else if($CheckManager == False){
						$CloseRequestByPosition = $LgUserPosition;
						$CloseRequestByPositionRank = $LgPositionRank;
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not a member of this service! 1.3.3'); exit();
					}

					$GetRequestDtls = AptPdoFetchWithAes(['Condtion'=> "RequestId::::$ReqId", 'FetchData'=>'Status::::InComingStatus::::SettingValue', 'DbCon'=> $DGatePassServiceCon, 'TbName'=> $ResponseLogin['LFR'].'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'1']);
					if($GetRequestDtls['code'] != 200 && $GetRequestDtls['code'] != 404){
						return_response('Request data not feched due to technical error'); exit();
					}else if($GetRequestDtls['code'] == 404){
						return_response('Invalid Request id detect'); exit();
					}

					$TempSettingValue = unserialize($value->SettingValue);

					if($GetRequestDtls['msg']->Status != 'Approve'){
						return_response('This request not approve so you can not close it from here'); exit();
					}else if($GetRequestDtls['msg']->InComingStatus != 'Pending' || $TempSettingValue['StMaxInComingTime'] == 'NotNeeded'){
						return_response('This request InComing Status not pending so you can not close it from here'); exit();
					}else if($TempSettingValue['StMaxInComingTime'] >= $CurrentTime){
						return_response('Max InComing Time not expired yet so you can not close it from here'); exit();
					}else if($TempSettingValue['StMaxInComingTime'] < $CurrentTime){
						#Continue
					}else{
						return_response('Invalid req data detect due to technical error, please report it from support panel'); exit();
					}
					
					$UpdaetData = "Status::::Closed::,::StatusReason::::".serialize(array('code'=>101,'msg'=>'This request is close by Manager, Because Max InComing Time Expired But you can not enter in College'));
					unlink(RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/'.$ResponseLogin['LFR'].'/'.$ReqId.'.png');
					$UpdateReq = UpdateGivenData($UpdaetData,"RequestId::::$ReqId",$DGatePassServiceCon,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all');
					
					if($UpdateReq['code'] == 200){
						return_response('Request Successfully closed',true,'Success',200); exit();
					}else{
						return_response('Request can not closed due to technical error, report it on support panel'); exit();
					}
				}	
			}
			
			// Call classname public function 
			RequestClose::ValidedData($ReqId,$StUserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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