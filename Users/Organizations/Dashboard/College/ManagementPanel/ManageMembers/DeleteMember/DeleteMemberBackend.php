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
if(isset($_POST['UserUrl']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php");
    
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Organizations/Dashboard/College/ManagementPanel/ManageMembers/DeleteMember/index.php?UserUrl=".$_POST['UserUrl']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$UserUrl = preg_replace('!\s+!', ' ',strip_tags($_POST['UserUrl']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class DeleteMember{
				public static function ValidedData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
					
					date_default_timezone_set('Asia/Kolkata');
                    
					// UserUrl valided in backend
					if($UserUrl != preg_replace("/[^A-Za-z0-9]/","",$UserUrl)){
						return_response("Invalid user detect");

					}else if(strlen($UserUrl) != 30){
					    return_response("Invalid user detect");

					}

					// Call encode_post_input function
					DeleteMember::EncryptData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);
					
					// Call profile_imageResize function
					DeleteMember::CkeckLoginAndAuthenticate($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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
					
					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoDeleteWithAes/index.php");

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
						return_response('Invalid Security code detect'); exit();
					}
					
					$LgPositionRank = $ResponseRank;

					DeleteMember::DeleteMemberProccess($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoServiceManage,$PdoOrganizationUserAccount,$ResponseLogin,$LgPositionRank);
				}
				
				private static function DeleteMemberProccess($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoServiceManage,$PdoOrganizationUserAccount,$ResponseLogin,$LgPositionRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					$CurrentTime = time();
                    
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];

					$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::MemberOperationPermissionRankUpTo::,::SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');

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
					    return_response('Invalid setting detect for Delete member');
					}

					if($LgPositionRank < $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart || $LgPositionRank > $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToEnd){
				        foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
				        return_response('You are not Authorized to Delete member');
				    }
				    
					$GetDeleteUserDetails = FetchReuiredDataByGivenData("UserUrl::::$UserUrl","ProfileUrl::::Position",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
                    if($GetDeleteUserDetails['status'] != "Success" || $GetDeleteUserDetails['code'] != 200){
						return_response('This user is not a member of this organization'); exit();
					}

					$GetDeleteUserCurrentPositionRank = GetSubStringBetweenTwoCharacter($GetOrgSettingPosition, $GetDeleteUserDetails['msg']->Position.':', ':');

					if($GetDeleteUserCurrentPositionRank == ''){
						return_response('Org setting can not feched! due to technical error'); exit();
					}else if($GetDeleteUserCurrentPositionRank == 1){
						return_response('Owner can not be deleted from organization'); exit();
					}
					
					if($GetDeleteUserCurrentPositionRank <= $LgPositionRank && $GetDeleteUserCurrentPositionRank > 0){
					    return_response('You are not Authorized to Delete this user'); exit();
					}

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
					        	$AptPdoDeleteWithAes =  AptPdoDeleteWithAes(['Condtion'=>"UserUrl::::$UserUrl",'DbCon'=> $DbConnectionTemp['msg'], 'TbName'=> $TempTbName, 'EPass'=> $EncodeAndEncryptPass]);
					        	if($AptPdoDeleteWithAes['code'] != 200 && $AptPdoDeleteWithAes['code'] != 404){
					        		return_response('This user is currently member of one or more then one service! We try to delete it from services but an technical error occur, Please delete this member manually from services'); exit();
					        	}
					        }
					    }
				    }
					
					$UpdateData = "Status::::$Status::,::Fullname::::$Fullname::,::FatherFullname::::$FatherFullname::,::Gender::::$Gender::,::Mobile::::$MobileNo::,::FatherMobile::::$FatherMobileNo::,::Email::::$Email::,::FatherEmail::::$FatherEmail::,::UniqueId::::$UniqueId::,::OrgJoinTime::::$OrgJoinTime::,::Position::::$Position::,::Department::::$Department::,::Semester::::$Semester::,::StudyYear::::$Year::,::Branch::::$Branch::,::PrimaryBatchId::::$PrimaryBatchId::,::SecondaryBatchId::::$SecondaryBatchId::,::Pincode::::$Pincode::,::City::::$City::,::State::::$State::,::Country::::$Country::,::Address::::$Address::,::LoginTime::::$CurrentTime::,::LastUpdateBy::::$LgUserUrl::,::LastUpdatePosition::::$LgUserPosition::,::LastUpdateRank::::$LgPositionRank::,::LastUpdateTime::::$CurrentTime";
					$AptPdoDeleteWithAes =  AptPdoDeleteWithAes(['Condtion'=>"UserUrl::::$UserUrl",'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass]);
		        	if($AptPdoDeleteWithAes['code'] != 200 && $AptPdoDeleteWithAes['code'] != 404){
		        		return_response('Oops! Member can not delete due to technical error'); exit();
		        	}else if($AptPdoDeleteWithAes['code'] == 404){
		        		return_response('Oops! member is not available in this Organization',true,'Success',404); exit();
		        	}
		        	unlink(RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$GetDeleteUserDetails['msg']->ProfileUrl);
		        	return_response('User Delete Successfully',true,'Success',200); exit();
				}
			}
			
			// Call classname public function 
			DeleteMember::ValidedData($UserUrl,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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