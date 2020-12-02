<?php
	/*
	@FileName - SearchServices.php
	@Desc - Search Member of hostal D gatepass
	@Author - Arpit sharma
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
	
	if(isset($_POST['SearchDataKey']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
		require_once (RootPath."JsonShowError/index.php"); // Require Show error file
		
		// Verify data send from same domain or not
		if(DomainName === 'http://localhost' || DomainName === 'https://localhost'){
			session_start();
			if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){
				if($_POST['SearchDataKey'] !== "undefined"){
					if($_POST['SearchDataKey'] == ""){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
						return_response("Please Enter Service Name In Search Box");
					}

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


					class SearchServices{
						Public static function CkeckLoginAndAuthenticate($SearchDataKey,$BrowserClientId1,$BrowserClientId2){

							$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

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
							$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);

							if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response("User currently not login or session expired"); exit();
							}else{
								if($ResponseLogin['LAS'] != 'MainMember'){
									foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
									return_response('You are not authorized to take this action'); exit();
								}
							}

							SearchServices::SearchServicesRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoServiceManage,$ResponseLogin);
							
						}
						private function SearchServicesRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoServiceManage,$ResponseLogin){
							
							// Create isset time according Asia/Kolkata
							date_default_timezone_set('Asia/Kolkata');
							
							$CurrentTime = time();

							$getOrgnizationName = $ResponseLogin['LFR'];
							$SearchData = "NameSearch::::".strtolower(trim(preg_replace('/\s+/', '', $SearchDataKey)));
							$Response = FetchReuiredDataByGivenData($SearchData,'Code',$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								$ServiceCode = $Response['msg']->Code;
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('This Service not exist',true,'Error',404);
							}

							$RequireUserDetails = 'Status::::PlanCode::::Price::::Validity::::StartTime::::ExpTime::::LastUpdateTime::::TotalSelledPack::::MaxRequestLimit';

							$Response = FetchReuiredDataByGivenData("PlanFor::::$ServiceCode",$RequireUserDetails,$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all',NULL,'all');

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								function ConvertToDayFromsec($seconds){
									$dt1 = new DateTime("@0");
									$dt2 = new DateTime("@$seconds");
									return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
								}
								$i =0;
								foreach ($Response['msg'] as $key => $value) {
									$Response['msg'][$i]->LastUpdateTime = date("d-M-Y h:i:s A",$Response['msg'][$i]->LastUpdateTime);
									if($Response['msg'][$i]->Validity != -1){
										$Response['msg'][$i]->Validity = ConvertToDayFromsec($Response['msg'][$i]->Validity);
									}else{
										$Response['msg'][$i]->Validity = 'Unlimited';
									}
									if($Response['msg'][$i]->MaxRequestLimit == -1){
										$Response['msg'][$i]->MaxRequestLimit = 'Unlimited';
									}
									$i++;
								}
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
								return_response($Response,true,'Success',200);
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								return_response('No Plans Found for this service',true,'Error',404);
							}
						}
					}
					SearchServices::CkeckLoginAndAuthenticate($SearchDataKey,$BrowserClientId1,$BrowserClientId2);
				}else{
					foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
					return_response("You Request wrong data(Undifined) to process");
				}
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