<?php
	/*
	@FileName AddNewwMemberBackend.php
	@Des This procees add new members in orgnization database
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

if(isset($_POST['PlanCode']) && isset($_POST['PlanStatus']) && isset($_POST['PlanFor']) && isset($_POST['PlanPrice']) && isset($_POST['PlanValidity']) && isset($_POST['PlanValidityType']) && isset($_POST['PlanStartTime']) && isset($_POST['PlanExpTime']) && isset($_POST['MaxSellLimit']) && isset($_POST['MaxRequest']) && isset($_POST['SameOrgCanBuyMaxTimeByPlaneCode']) && isset($_POST['CSPCode']) && isset($_POST['SameOrgCanBuyMaxTimeByCSP']) && isset($_POST['AllOffersPermission']) && isset($_POST['SpecialOffersPermission']) && isset($_POST['PrivateOffersPermission']) && isset($_POST['AllMaxDiscountAmount']) && isset($_POST['SpecialOffersMaxDiscountAmount']) && isset($_POST['PrivateOffersMaxDiscountAmount']) && isset($_POST['AllMaxDiscountPercentage']) && isset($_POST['SpecialOffersMaxDiscountPercentage']) && isset($_POST['PrivateOffersMaxDiscountPercentage']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/UpdatePlan/index.php?target=".$_POST['PlanCode'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/UpdatePlan/?target=".$_POST['PlanCode']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)
			$PlanCode = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanCode']));
			$PlanStatus = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanStatus']));
			$PlanFor = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanFor']));
			$PlanPrice = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanPrice']));
			$PlanValidity = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanValidity']));
			$PlanValidityType = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanValidityType']));
			$PlanStartTime = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanStartTime']));
			$PlanExpTime = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanExpTime']));
			$MaxSellLimit = preg_replace('!\s+!', ' ',strip_tags($_POST['MaxSellLimit']));
			$MaxRequest = preg_replace('!\s+!', ' ',strip_tags($_POST['MaxRequest']));
			$SameOrgCanBuyMaxTimeByPlaneCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SameOrgCanBuyMaxTimeByPlaneCode']));
			$CSPCode = preg_replace('!\s+!', ' ',strip_tags($_POST['CSPCode']));
			$SameOrgCanBuyMaxTimeByCSP = preg_replace('!\s+!', ' ',strip_tags($_POST['SameOrgCanBuyMaxTimeByCSP']));
			$AllOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['AllOffersPermission']));
			$SpecialOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersPermission']));
			$PrivateOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersPermission']));
			$AllMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['AllMaxDiscountAmount']));
			$SpecialOffersMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersMaxDiscountAmount']));
			$PrivateOffersMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersMaxDiscountAmount']));
			$AllMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['AllMaxDiscountPercentage']));
			$SpecialOffersMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersMaxDiscountPercentage']));
			$PrivateOffersMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersMaxDiscountPercentage']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class AddPlans{
				public static function ValidedData($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time(); // Take current time in sec

					// Plan status validation
					if($PlanStatus != 'Active' && $PlanStatus != 'Hold'){
						return_response("Plan Status contains invalid characters");
					}

					// Plan for validation
					if($PlanFor != preg_replace("/[^A-Za-z0-9 ]/","",$PlanFor)){
						return_response("Plan for contains invalid characters 1");

					}else if(strlen($PlanFor) < 3 || strlen($PlanFor) > 50){
						return_response("Plan for contains invalid characters");
					}

					// Plan price validation
					if($PlanPrice != preg_replace("/[^0-9]/","",$PlanPrice)){
						return_response("Plan price contains invalid characters");

					}else if(strlen($PlanPrice) < 1 || strlen($PlanPrice) > 5){
						return_response("Plan price must be between 1 and 5 characters long");
					}

					// Plan validity Type validation
					if($PlanValidityType != 'Seconds'){
						return_response("Plan validity Types contains invalid characters");

					}

					// Plan validity validation
					if($PlanValidity != -1){
						if($PlanValidity != preg_replace("/[^0-9]/","",$PlanValidity)){
							return_response("Plan validity contains invalid characters");
						}else if($PlanValidity > 7776000){
							return_response("Plan validity must be under 99 days"); exit();
						}
					}

					// PlanStartTime validation
					if($PlanStartTime != -1){
						if($PlanStartTime != preg_replace("/[^0-9]/","",$PlanStartTime)){
							return_response("Plan Start Time contains invalid characters");  exit();
						}else if(strlen($PlanStartTime) == 0){
							return_response("Invalid Plan Start Time detect");  exit();
						}else if($PlanStartTime > $CurrentTime+31104000){
							return_response("Max start time can be ".date('d-m-Y, H:i:s',$CurrentTime+31104000));  exit();
						}
					}

					// PlanExpTime validation
					if($PlanExpTime != -1){
						if($PlanExpTime != preg_replace("/[^0-9]/","",$PlanExpTime)){
							return_response("Plan Exp Time contains invalid characters");  exit();
						}else if(strlen($PlanExpTime) == 0){
							return_response("Invalid Plan Exp Time detect");  exit();
						}else if($PlanExpTime > $CurrentTime+31104000){
							return_response("Max Exp time can be ".date('d-m-Y, H:i:s',$CurrentTime+31104000));  exit();
						}
					}

					if(strlen($MaxSellLimit) == 0){
						return_response('Max Sell Limit Required'); exit();
					}else if($MaxSellLimit != preg_replace("/[^0-9-]/","",$MaxSellLimit)){
						return_response('Max Sell Limit contains invalid characters'); exit();
					}else{
						if($MaxSellLimit != -1 && $MaxSellLimit != preg_replace("/[^0-9]/","",$MaxSellLimit)){
							return_response('Max Sell Limit must be -1 or positive number'); exit();
						}
					}

					if($MaxRequest != -1){
						if($MaxRequest == 0){
							return_response('Max Request Required'); exit();
						}else if($MaxRequest != preg_replace("/[^0-9]/","",$MaxRequest)){
							return_response('Max Sell Limit contains invalid characters'); exit();
						}
					}

					if($MaxRequest == -1 &&  $PlanValidity == -1){
						return_response('You can not create plan with unlimited validity and max request'); exit();
					}

					if($SameOrgCanBuyMaxTimeByPlaneCode != preg_replace("/[^0-9]/","",$SameOrgCanBuyMaxTimeByPlaneCode) && $SameOrgCanBuyMaxTimeByPlaneCode != -1){
						return_response('Same Org Can Buy By Plane Code contains invalid characters'); exit();
					}else{
						if($SameOrgCanBuyMaxTimeByPlaneCode == ''){
							$SameOrgCanBuyMaxTimeByPlaneCode = -1;
						}
					}

					if($CSPCode != preg_replace("/[^A-Za-z0-9_.]/","",$CSPCode)){
						return_response('Custom Service Plan Code contains invalid characters'); exit();
					}else if(strlen($CSPCode) > 130){
						return_response('Custom Service Plan Code length must be 1 to 130 character long'); exit();
					}else{
						if($CSPCode == ''){
							$CSPCode = 'DefaultCSPCode';
						}
					}

					if($SameOrgCanBuyMaxTimeByCSP != preg_replace("/[^0-9]/","",$SameOrgCanBuyMaxTimeByCSP) && $SameOrgCanBuyMaxTimeByCSP != -1){
						return_response('Same Org Can Buy By CSP contains invalid characters'); exit();
					}else{
						if($SameOrgCanBuyMaxTimeByCSP == ''){
							$SameOrgCanBuyMaxTimeByCSP = -1;
						}
					}

					if($AllOffersPermission != 'Allow' && $AllOffersPermission != 'Deny'){
						return_response('All Offers Permission contains invalid characters');
					}

					if($SpecialOffersPermission != 'Allow' && $SpecialOffersPermission != 'Deny'){
						return_response('Special Offers Permission contains invalid characters');
					}

					if($PrivateOffersPermission != 'Allow' && $PrivateOffersPermission != 'Deny'){
						return_response('Private Offers Permission contains invalid characters');
					}

					if($AllMaxDiscountAmount != preg_replace("/[^0-9]/","",$AllMaxDiscountAmount)){
						return_response('All Max Discount Amount contains invalid characters');
					}else if($AllMaxDiscountAmount > 100000 || $AllMaxDiscountAmount < 0){
						return_response('All Max Discount Amount cross maximum or minimum discount limit');
					}else if($AllMaxDiscountAmount == 0){
						$AllMaxDiscountAmount = null;
					}

					if($SpecialOffersMaxDiscountAmount != preg_replace("/[^0-9]/","",$SpecialOffersMaxDiscountAmount)){
						return_response('Special Max Discount Amount contains invalid characters');
					}else if($SpecialOffersMaxDiscountAmount > 100000 || $SpecialOffersMaxDiscountAmount < 0){
						return_response('Special Max Discount Amount cross maximum or minimum discount limit');
					}else if($SpecialOffersMaxDiscountAmount == 0){
						$SpecialOffersMaxDiscountAmount = null;
					}

					if($PrivateOffersMaxDiscountAmount != preg_replace("/[^0-9]/","",$PrivateOffersMaxDiscountAmount)){
						return_response('Private Max Discount Amount contains invalid characters');
					}else if($PrivateOffersMaxDiscountAmount > 100000 || $PrivateOffersMaxDiscountAmount < 0){
						return_response('Private Max Discount Amount cross maximum or minimum discount limit');
					}else if($PrivateOffersMaxDiscountAmount == 0){
						$PrivateOffersMaxDiscountAmount = null;
					}

					if($AllMaxDiscountPercentage != preg_replace("/[^0-9]/","",$AllMaxDiscountPercentage)){
						return_response('All Max Discount Percentage contains invalid characters');
					}else if($AllMaxDiscountPercentage > 100 || $AllMaxDiscountPercentage < 0){
						return_response('All Max Discount Percentage cross maximum or minimum discount limit');
					}else if($AllMaxDiscountPercentage == 0){
						$AllMaxDiscountPercentage = null;
					}

					if($SpecialOffersMaxDiscountPercentage != preg_replace("/[^0-9]/","",$SpecialOffersMaxDiscountPercentage)){
						return_response('Special Max Discount Percentage contains invalid characters');
					}else if($SpecialOffersMaxDiscountPercentage > 100 || $SpecialOffersMaxDiscountPercentage < 0){
						return_response('Special Max Discount Percentage cross maximum or minimum discount limit');
					}else if($SpecialOffersMaxDiscountPercentage == 0){
						$SpecialOffersMaxDiscountPercentage = null;
					}

					if($PrivateOffersMaxDiscountPercentage != preg_replace("/[^0-9]/","",$PrivateOffersMaxDiscountPercentage)){
						return_response('Private Max Discount Percentage contains invalid characters');
					}else if($PrivateOffersMaxDiscountPercentage > 100 || $PrivateOffersMaxDiscountPercentage < 0){
						return_response('Private Max Discount Percentage cross maximum or minimum discount limit');
					}else if($PrivateOffersMaxDiscountPercentage == 0){
						$PrivateOffersMaxDiscountPercentage = null;
					}

					if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6 || $SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response('Invalid Security code');
					}

					AddPlans::EncryptData($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				private static function EncryptData($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					AddPlans::CkeckLoginAndAuthenticate($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

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
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

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
					$LgPositionRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $LgPosition.':', ':');

					if($LgPositionRank == ''){
						return_response('Org Setting data not fetched!'); exit();
					}

					if($LgSecurityCode === $SecurityCode){
						AddPlans::AddPlansProccess($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank);
					}else{
						return_response('Invalid Security code'); exit();
					}
				}

				private static function AddPlansProccess($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank){
					
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

					$Response = CheckGivenDataAvailability("PlanCode::::$PlanCode",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass);
					if($Response['status'] != "Success" || $Response['msg'] != "Available"){
						return_response('This plan not exist'); exit();
					}

					$Response = FetchReuiredDataByGivenData("Price::::$PlanPrice::,::PlanFor::::$LoginForCode::,::Validity::::$PlanValidity::,::MaxRequestLimit::::$MaxRequest",'PlanCode',$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all',NULL,'all');
						
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						if($Response['totalrows'] > 1){
							return_response('This plan already exist for this service  3.1'); exit();
						}

						if($Response['msg'][0]->PlanCode != $PlanCode){
							return_response('This plan already existfor this service  3.1'); exit();
						}
					}else if($Response['status'] === 'Error' && $Response['code'] === 404){
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Process failed! Try again later 1"); exit();
					}

					$AllMaxOfferDiscount = serialize(['Amount'=>$AllMaxDiscountAmount,'Percentage'=>$AllMaxDiscountPercentage]);

					$SpecialMaxOfferDiscount = serialize(['Amount'=>$SpecialOffersMaxDiscountAmount,'Percentage'=>$SpecialOffersMaxDiscountPercentage]);

					$PrivateMaxOfferDiscount = serialize(['Amount'=>$PrivateOffersMaxDiscountAmount,'Percentage'=>$PrivateOffersMaxDiscountPercentage]);
					
					$GivenData = "Status::::$PlanStatus::,::PlanCode::::$PlanCode::,::PlanFor::::$LoginForCode::,::Price::::$PlanPrice::,::Validity::::$PlanValidity::,::MaxRequestLimit::::$MaxRequest::,::StartTime::::$PlanStartTime::,::ExpTime::::$PlanExpTime::,::LastUpdateBy::::$LgUserUrl::,::LastUpdateTime::::$CurrentTime::,::LastUpdatePosition::::$LgPosition::,::LastUpdateRank::::$LgPositionRank::,::AllOffersPermission::::$AllOffersPermission::,::SpecialOffersPermission::::$SpecialOffersPermission::,::PrivateOffersPermission::::$PrivateOffersPermission::,::AllMaxOfferDiscount::::$AllMaxOfferDiscount::,::SpecialMaxOfferDiscount::::$SpecialMaxOfferDiscount::,::PrivateMaxOfferDiscount::::$PrivateMaxOfferDiscount::,::MaxSellLimit::::$MaxSellLimit::,::SameOrgCanBuyMaxTimeByPlaneCode::::$SameOrgCanBuyMaxTimeByPlaneCode::,::CSPCode::::$CSPCode::,::SameOrgCanBuyMaxTimeByCSP::::$SameOrgCanBuyMaxTimeByCSP";

					$Response = UpdateGivenData($GivenData,"PlanCode::::$PlanCode",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all');

					if($Response['status'] === 'Success' && $Response['code'] === 200){
						return_response('Plan updated successfully',true,'Success',200);
					}else{
						return_response('Plan update failed');
					}
				}
			}
			AddPlans::ValidedData($PlanCode,$PlanStatus,$PlanFor,$PlanPrice,$PlanValidity,$PlanValidityType,$PlanStartTime,$PlanExpTime,$MaxSellLimit,$MaxRequest,$SameOrgCanBuyMaxTimeByPlaneCode,$CSPCode,$SameOrgCanBuyMaxTimeByCSP,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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