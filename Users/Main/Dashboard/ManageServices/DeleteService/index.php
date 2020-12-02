<?php
	/*
	@FileName DeleteService/index.php
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

if(isset($_POST['target']) && isset($_POST['Code']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchService/index.php?target=".$_POST['target'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchService/?target=".$_POST['target'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchService/index.php" || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/SearchService/"){
		
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)
			$Code = preg_replace('!\s+!', ' ',strip_tags($_POST['Code']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class DeleteService{
				public static function ValidedData($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// Code validation
					if($Code != preg_replace("/[^A-Za-z0-9]/","",$Code)){
						return_response("Invalid service detect"); exit();

					}else if(strlen($Code) != 30){
						return_response("Invalid service detect"); exit();
					}

					if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6 || $SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response('Invalid Security code'); exit();
					}

					DeleteService::EncryptData($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				private static function EncryptData($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					DeleteService::CkeckLoginAndAuthenticate($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

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

					// Access base connection file to access data base connection ($DbConnectionWithoutDbName)
					require_once (RootPath."DatabaseConnections/Normal/DbConnectionWithoutDbName.php");

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
						DeleteService::DeleteServiceProccess($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$DbConnectionWithoutDbName,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank);
					}else{
						return_response('Invalid Security code'); exit();
					}
				}

				private static function DeleteServiceProccess($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$DbConnectionWithoutDbName,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank){
					
					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$NameSearch = strtolower(trim(preg_replace('/\s+/', '', $PlanFor)));

					$Response = FetchReuiredDataByGivenData("Code::::$Code",'Code',$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

					$Response = CheckGivenDataAvailability("Code::::$Code",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');
					if($Response['status'] != "Success" || $Response['msg'] != "Available"){
						return_response('This service not exist'); exit();
					}
					
					$Response = DeleteDataFromTable("PlanFor::::$Code",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass);
					if($Response['status'] === 'Success' && ($Response['code'] === 200 || $Response['code'] === 204)){
						$DbConnectionWithoutDbName->query("DROP DATABASE service_create_$Code");
						   $Response = $DbConnectionWithoutDbName->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'service_create_$Code'");
						if(!$Response->fetchColumn()){
							$Response = DeleteDataFromTable("Code::::$Code",$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
							if($Response['status'] === 'Success' && $Response['code'] === 200){
								return_response('This Service delete successfully',true,'Success',200);
							}else{
								return_response('Only Service plans and database delete successfully',true,'Success',204);
							}
						}else{
							return_response('Only Service plans delete successfully',true,'Success',204);
						}
					}else{
						return_response('Service delation failed',true,'Error',400);
					}
				}
			}
			DeleteService::ValidedData($Code,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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