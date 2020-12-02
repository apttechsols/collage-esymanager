<?php
	/*
	@FileName DeletePlan/index.php
	@Author arpit sharma
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

	define("RootPath", "../../../../../");

if(isset($_POST['target']) && isset($_POST['PlanFor']) && isset($_POST['PlanCode']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if(str_replace('%20', ' ', $_SERVER['HTTP_REFERER']) === DomainName."/Users/Main/Dashboard/ManageServices/SearchPlan/index.php?target=".$_POST['target'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchPlan/?target=".$_POST['target'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchPlan/index.php" || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchPlan/"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)
			$PlanFor = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanFor']));
			$PlanCode = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanCode']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class DeletePlans{
				public static function ValidedData($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
					
					// Plan for validation
					if($PlanFor != preg_replace("/[^A-Za-z ]/","",$PlanFor)){
						return_response("Invalid service detect"); exit();

					}else if(strlen($PlanFor) <3 ||  strlen($PlanFor) > 50){
						return_response("Invalid service detect"); exit();
					}

					// Plan code validation
					if($PlanCode != preg_replace("/[^A-Za-z0-9]/","",$PlanCode)){
						return_response("Invalid plan detect"); exit();

					}else if(strlen($PlanCode) != 30){
						return_response("Invalid plan detect"); exit();
					}

					if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6 || $SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response('Invalid Security code'); exit();
					}

					DeletePlans::EncryptData($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				private static function EncryptData($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					DeletePlans::CkeckLoginAndAuthenticate($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

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

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						return_response("User currently not login or session expired"); exit();
					}else{
						if($ResponseLogin['LAS'] != 'MainMember'){
							return_response('You are not authorized to take this action'); exit();
						}
					}
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgPosition = $ResponseLogin['msg']['Position'];
					$LgSecurityCode = $ResponseLogin['msg']['SecurityCode'];


					// Verify Login user position
					$ResponsePosition = FetchReuiredDataByGivenData("Position::::$LgPosition","PositionRank",$PdoMainUserAccountDb,"main_member_setting",$EncodeAndEncryptPass,'all');

					if($ResponsePosition['status'] != "Success" || $ResponsePosition['code'] != 200){
						return_response('Process failed! Try again later'); exit();
					}
					$LgPositionRank = $ResponsePosition['msg']->PositionRank;

					if($LgPositionRank != 1 && $LgPositionRank != 2){
						return_response('You are not authorized to delete service plan'); exit();
					}

					if($LgSecurityCode === $SecurityCode){
						DeletePlans::DeletePlansProccess($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank);
					}else{
						return_response('Invalid Security code'); exit();
					}
				}

				private static function DeletePlansProccess($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank){
					
					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$NameSearch = strtolower(trim(preg_replace('/\s+/', '', $PlanFor)));

					$Response = FetchReuiredDataByGivenData("NameSearch::::$NameSearch",'Code',$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');
						
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						$LoginForCode = $Response['msg']->Code;
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('This service not exist'); exit();
					}

					$Response = CheckGivenDataAvailability("PlanCode::::$PlanCode::,::PlanFor::::$LoginForCode",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all');
					if($Response['status'] != "Success" || $Response['msg'] != "Available"){
						return_response('This plan not exist for this service'); exit();
					}
					
					$Response = DeleteDataFromTable("PlanCode::::$PlanCode::,::PlanFor::::$LoginForCode",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass);

					return_response('This plan delete successfully',true,'Success',200);
					
				}
			}
			DeletePlans::ValidedData($PlanFor,$PlanCode,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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