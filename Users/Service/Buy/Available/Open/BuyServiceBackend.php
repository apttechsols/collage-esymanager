<?php
	/*
	@FileName BuyServiceBackend/index.php
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

if(isset($_POST['target']) && isset($_POST['PlanId']) && isset($_POST['ActiveType']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

	require_once (RootPath."JsonShowError/index.php");
	
	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Buy/Available/Open/index.php?target=".$_POST['target'] || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Buy/Available/Open/?target=".$_POST['target']){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)
			$ServiceCode = preg_replace('!\s+!', ' ',strip_tags($_POST['target']));
			$PlanId = preg_replace('!\s+!', ' ',strip_tags($_POST['PlanId']));
			$ActiveType = preg_replace('!\s+!', ' ',strip_tags($_POST['ActiveType']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			class ServiceBuy{
				public static function ValidedData($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// ServiceCode validation
					if($ServiceCode != preg_replace("/[^A-Za-z0-9]/","",$ServiceCode)){
						return_response("Invalid Service Code detect"); exit();

					}else if(strlen($ServiceCode) != 30){
						return_response("Invalid Service Code detect"); exit();
					}
					
					// Plan for validation
					if($PlanId != preg_replace("/[^A-Za-z0-9]/","",$PlanId)){
						return_response("Invalid plan Id detect"); exit();

					}else if(strlen($PlanId) != 30){
						return_response("Invalid plan Id detect"); exit();
					}

					// Plan code validation
					if($ActiveType != 'Now'){
						return_response("Invalid Active Type detect"); exit();
					}

					if($ActiveType === 'Later'){
						$ActiveType = 'Hold';
					}else if($ActiveType === 'Now'){
						$ActiveType = 'Active';
					}else{
						return_response("Invalid Active Type detect"); exit();
					}

					if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6 || $SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response('Invalid Security code'); exit();
					}

					ServiceBuy::EncryptData($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				private static function EncryptData($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					ServiceBuy::CkeckLoginAndAuthenticate($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

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
					require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
                    require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
                    require_once (RootPath."LibraryStore/SiteComponents/ServiceStatusForOrg/index.php");

                    /*-------------- Apt Library -----------------------*/
    				require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
                    
					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						return_response("User currently not login or session expired"); exit();
					}else{
						if($ResponseLogin['LAS'] != 'OrganizationMember'){
							return_response('You are not authorized to take this action'); exit();
						}
					}
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgPosition = $ResponseLogin['msg']['Position'];
					$LgSecurityCode = $ResponseLogin['msg']['SecurityCode'];
					$LgFOR = $ResponseLogin['LFR'];


					// Verify Login user position
					$ResponsePositionRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$LgFOR,$EncodeAndEncryptPass)['msg']->SettingValue, $LgPosition.':', ':');

					if($ResponsePositionRank == ''){
						return_response('Org position data not fetched!'); exit();
					}

					$LgPositionRank = $ResponsePositionRank;

					if($LgPositionRank != 1 && $LgPositionRank != 2){
						return_response('You are not authorized to delete service plan'); exit();
					}

					if($LgSecurityCode === $SecurityCode){
						ServiceBuy::ServiceBuyProccess($ServiceCode,$PlanId,$ActiveType,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$LgFOR,$ResponseLogin,$LgPositionRank);
					}else{
						return_response('Invalid Security code'); exit();
					}
				}

				private static function ServiceBuyProccess($ServiceCode,$PlanId,$ActiveType,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$LgUserUrl,$LgPosition,$LgFOR,$ResponseLogin,$LgPositionRank){
					
					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					function rand_string( $length ) {  
						$RandStr = "";
						$chars = "abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz";
						$size = strlen( $chars ); 
						for( $i = 0; $i < $length; $i++ ) {  
						$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
						} 
						return $RandStr;
					}
                    
					function get_string_between($string, $start, $end){
					    $string = ' ' . $string;
					    $ini = strpos($string, $start);
					    if ($ini == 0) return '';
					    $ini += strlen($start);
					    $len = strpos($string, $end, $ini) - $ini;
					    return substr($string, $ini, $len);
					    //Use -> get_string_between($fullstring, '[tag]', '[/tag]');
					}

					$Number1 = floor((29 - strlen($CurrentTime))/2);
					$Number2 = (29 - strlen($CurrentTime)) - $Number1;

					while (true) {
						$TempBuyId = "a".rand_string($Number1).$CurrentTime.rand_string($Number2);

						$CheckBuyIdForServiceBuyRecord = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_record', 'EPass'=> $EncodeAndEncryptPass]);

						$CheckBuyIdForServiceBuyFeatureRecord = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_for_feature_record', 'EPass'=> $EncodeAndEncryptPass]);
						$CheckBuyIdForServiceBuyHistory = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_history', 'EPass'=> $EncodeAndEncryptPass]);
						$CheckBuyIdForServicePaymentHistory = AptPdoFetchWithAes(['Condtion'=> "PmtId::::$TempBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_payment_history', 'EPass'=> $EncodeAndEncryptPass]);
						if($CheckBuyIdForServiceBuyRecord['code'] == 404 && $CheckBuyIdForServiceBuyFeatureRecord['code'] == 404 && $CheckBuyIdForServiceBuyHistory['code'] == 404 && $CheckBuyIdForServicePaymentHistory['code'] == 404){
							$BuyId = $TempBuyId;
							break;
						}
					}


					if(strlen($BuyId) != 30){
						return_response('Invalid Buy id generated! Try again'); exit();
					}

					$GetServiceData = AptPdoFetchWithAes(['Condtion'=> "Code::::$ServiceCode", 'FetchData'=>'Status::::ServiceMember::::ServiceFor::::StartTime::::ExpTime::::CreateTime::::TablesAndColumns::::TablesAndColumnsDefaultValues::::TotalSelledPack::::MaxSellLimit::::Version', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_list', 'EPass'=> $EncodeAndEncryptPass]);
					if($GetServiceData['code'] != 200){
						return_response('Invalid Service Code detect!'); exit();
					}
					
					if(strpos($GetServiceData['msg']->ServiceFor, ','.$ResponseLogin['LORT'].',') !== false || $GetServiceData['msg']->ServiceFor == 'All'){
						# Continue
					}else{
						return_response('This service is not Available for '.$ResponseLogin['LORT']);
					}

					if($GetServiceData['msg']->Status != 'Active'){
						return_response('This service currently not active'); exit();
					}

					if($GetServiceData['msg']->StartTime != -1){
						if($GetServiceData['msg']->StartTime > $CurrentTime){
							return_response('This Service has been not active'); exit();
						}
					}

					if($GetServiceData['msg']->ExpTime != -1){
						if($GetServiceData['msg']->ExpTime < $CurrentTime){
							return_response('This service has been expired'); exit();
						}
					}

					if($GetServiceData['msg']->TotalSelledPack >= $GetServiceData['msg']->MaxSellLimit && $GetServiceData['msg']->MaxSellLimit != -1){
						return_response('This service currently out of stock'); exit();
					}
					
					$GetPlanData = AptPdoFetchWithAes(['Condtion'=> "PlanCode::::$PlanId", 'FetchData'=>'Status::::PlanFor::::Price::::Validity::::MaxRequestLimit::::StartTime::::ExpTime::::CreateTime::::TotalSelledPack::::MaxSellLimit::::SameOrgCanBuyMaxTimeByPlaneCode::::CSPCode::::SameOrgCanBuyMaxTimeByCSP', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_plans', 'EPass'=> $EncodeAndEncryptPass]);
					if($GetPlanData['code'] != 200){
						return_response('Invalid Plan Id detect!'); exit();
					}

					if($GetPlanData['msg']->PlanFor != $ServiceCode){
						return_response('Invalid Plan Id detect!'); exit();
					}

					if($GetPlanData['msg']->Status != 'Active'){
						return_response('This plan currently not active'); exit();
					}

					if($GetPlanData['msg']->StartTime != -1){
						if($GetPlanData['msg']->StartTime > $CurrentTime){
							return_response('This Plan has been not active'); exit();
						}
					}

					if($GetPlanData['msg']->ExpTime != -1){
						if($GetPlanData['msg']->ExpTime < $CurrentTime){
							return_response('This Plan has been expired'); exit();
						}
					}

					if($GetPlanData['msg']->TotalSelledPack >= $GetPlanData['msg']->MaxSellLimit && $GetPlanData['msg']->MaxSellLimit != -1){
						return_response('This plan currently out of stock'); exit();
					}

					if($GetPlanData['msg']->Validity == -1 &&  $GetPlanData['msg']->MaxRequestLimit == -1){
						return_response('This plan can not be processed, because it contaion invalid data'); exit();
					}

					if($GetPlanData['msg']->SameOrgCanBuyMaxTimeByPlaneCode != -1){
						$CheckPlanCodeForThisOrg = AptPdoFetchWithAes(['Condtion'=> "Organization::::".$ResponseLogin['LFR']."::,::PlanCode::::$PlanId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_history', 'EPass'=> $EncodeAndEncryptPass]);
						if($CheckPlanCodeForThisOrg['code'] == 200 || $CheckPlanCodeForThisOrg['code'] == 404){
							if($CheckPlanCodeForThisOrg['code'] == 200){
								if($CheckPlanCodeForThisOrg['totalrows'] >= $GetPlanData['msg']->SameOrgCanBuyMaxTimeByPlaneCode){
									return_response('Now this plan can be buy only '.$GetPlanData['msg']->SameOrgCanBuyMaxTimeByPlaneCode.' time, And you already buy it '.$CheckPlanCodeForThisOrg['totalrows'].' time'); exit();
								}
							}
						}else{
							return_response('Service history data not feched due to technical error'); exit();
						}
					}

					if($GetPlanData['msg']->SameOrgCanBuyMaxTimeByCSP != -1){
						$CheckCSPCodeForThisOrg = AptPdoFetchWithAes(['Condtion'=> "Organization::::".$ResponseLogin['LFR']."::,::CSPCode::::".$GetPlanData['msg']->CSPCode, 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_history', 'EPass'=> $EncodeAndEncryptPass]);
						
						if($CheckCSPCodeForThisOrg['code'] == 200 || $CheckCSPCodeForThisOrg['code'] == 404){
							if($CheckCSPCodeForThisOrg['code'] == 200){
								if($CheckCSPCodeForThisOrg['totalrows'] >= $GetPlanData['msg']->SameOrgCanBuyMaxTimeByCSP){
									return_response('Now this category of plan can be buy only '.$GetPlanData['msg']->SameOrgCanBuyMaxTimeByCSP.' time, And you already buy this category of plan '.$CheckCSPCodeForThisOrg['totalrows'].' time'); exit();
								}
							}
						}else{
							return_response('Service history data not feched due to technical error'); exit();
						}
					}
                    
					$ServiceConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.$ServiceCode);
					if($ServiceConnection['status'] === 'Success' && $ServiceConnection['code'] === 200){
						$ServiceConnection = $ServiceConnection['msg'];
					}else{
						return_response('Service Database connection failed, due to technical error!'); exit();
					}

					$ServiceStatusForOrg = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$LgFOR,'CurrentTime'=>$CurrentTime]);
					if($ServiceStatusForOrg['code'] != 200){
						return_response('Service status can not found due to technical error'); exit();
					}

					/*********************----------------- Buy Process Start -------------******************/

					if($ServiceStatusForOrg['msg']['IsServiceBuyed'] == false){
						if($ServiceStatusForOrg['msg']['IsServiceSetUp'] == true){
							return_response('There is technical error accur [0.1.0]'); exit();
						}

						while (true) {
							$TempSetupBuyId = "a".rand_string($Number1).$CurrentTime.rand_string($Number2);

							$CheckBuyIdForServiceBuyRecord = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempSetupBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_record', 'EPass'=> $EncodeAndEncryptPass]);

							$CheckBuyIdForServiceBuyFeatureRecord = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempSetupBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_for_feature_record', 'EPass'=> $EncodeAndEncryptPass]);
							$CheckBuyIdForServiceBuyHistory = AptPdoFetchWithAes(['Condtion'=> "BuyId::::$TempSetupBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_history', 'EPass'=> $EncodeAndEncryptPass]);
							$CheckBuyIdForServicePaymentHistory = AptPdoFetchWithAes(['Condtion'=> "PmtId::::$TempSetupBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_payment_history', 'EPass'=> $EncodeAndEncryptPass]);
							if($CheckBuyIdForServiceBuyRecord['code'] == 404 && $CheckBuyIdForServiceBuyFeatureRecord['code'] == 404 && $CheckBuyIdForServiceBuyHistory['code'] == 404 && $CheckBuyIdForServicePaymentHistory['code'] == 404){
								$SetupBuyId = $TempSetupBuyId;
								break;
							}
						}

						$InsertData = "Status::::Pending::,::SetupStatus::::Pending::,::VldPlnValidity::::$CurrentTime::,::VldPlnReqNo::::0::,::NVldPlnReqNo::::0::,::ServiceMember::::".$GetServiceData['msg']->ServiceMember."::,::BuyId::::$SetupBuyId::,::TotalRequest::::0::,::PlanUpdateDate::::$CurrentTime::,::ServiceCode::::$ServiceCode::,::Organization::::$LgFOR::,::ServiceAndOrganization::::".$ServiceCode.'_'.$LgFOR."::,::StartTime::::0::,::ExpTime::::0::,::ServiceVersion::::".$GetServiceData['msg']->Version;
						
						$ServiceDataInsertInServiceBuyRecord = InsertGivenData($InsertData,$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,true);
						if($ServiceDataInsertInServiceBuyRecord['code'] != 200){
							#Refund Process
							return_response('Service can not buyed, because there is an error accur at setup time! [Service Insert F]'); exit();
						}

						// Setup Buy service
						$ServiceSetupError = False;
						$ServiceSetupErrorDetails = '';

						$ServiceTablesAndColumns = $GetServiceData['msg']->TablesAndColumns;
						$TablesDefaultValues = base64_decode($GetServiceData['msg']->TablesAndColumnsDefaultValues);

						$TablesAndColumnsArray = array();
						$$TablesColumnWithValuesArray = array();
						if(strlen($ServiceTablesAndColumns) > 0){
							if(strlen($ServiceTablesAndColumns) <= 11000){
								if($ServiceTablesAndColumns != preg_replace("/[^A-Za-z0-9,=&)(@>_]/","",$ServiceTablesAndColumns)){
									$ServiceSetupError = True;
									$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.0';
								}else{
									$TempArray = explode('&', $ServiceTablesAndColumns);
									$PrimaryKeyStoreArray = array();
									foreach ($TempArray as $key => $TempArrayValue) {
										if($ServiceSetupError == True){ break; }

										$ColumnNameArray = array();
										$ColumnsNameStore = '';
										$PrimaryCount = 0;
										$PrimaryKeyStore = '';
										$AutoIncrement = 0;
										if(substr_count($TempArrayValue,'=') !=  1){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.1'; break;
										}
										$Temp2Array =  explode('=', $TempArrayValue);

										if (array_key_exists(strtolower($Temp2Array[0]),$TablesAndColumnsArray)){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.1.0'; break;
										}

										if(strlen($TempArrayValue) == 0 || strlen($Temp2Array[0]) == 0 || strlen($Temp2Array[1]) == 0 || $Temp2Array[0] != preg_replace("/[^a-z0-9_]/","",$Temp2Array[0]) || $Temp2Array[1] != preg_replace("/[^A-Za-z0-9,)(@>_]/","",$Temp2Array[1])){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.2'; break;
										}
										$Temp3Array =  explode(',', $Temp2Array[1]);
										foreach ($Temp3Array as $key1 => $Temp3ArrayValue){
											if($ServiceSetupError == True){ break; }

											if($Temp3ArrayValue != preg_replace("/[^A-Za-z0-9)(@>_]/","",$Temp3ArrayValue) || strlen($Temp3ArrayValue) == 0){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails ='Service can not buyed, because there is an error accur at setup time. Error Code - 1.3'; break;
											}
											if(substr_count($Temp3ArrayValue,'(') !=  1 || substr_count($Temp3ArrayValue,')') !=  1){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.4'; break;
											}
											$TempString =  get_string_between($Temp3ArrayValue , '(', ')');
											if(strlen($TempString) == 0 || substr_count($TempString,'@') < 1 ){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.5'; break;
											}

											$Temp2String = substr($Temp3ArrayValue, 0, strpos($Temp3ArrayValue, "("));

											if (array_key_exists(strtolower($Temp2String),$ColumnNameArray)){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.5.0.0'; break;
											}

											if($TempString != str_replace(')','',str_replace('(','',str_replace($Temp2String,'',$Temp3ArrayValue)))){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.5.0'; break;
											}

											if($Temp2String != preg_replace("/[^A-Za-z0-9_]/","",$Temp2String)){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.5.1'; break;
											}

											$TempType = 0;
											$TempLength = 0;
											$TempDefault = 0;
											$TempNull = 0;
											$TempIndex = 0;
											$TempAI = 0;
											$TempTypeStore = '';
											$TempLengthStore = 0;
											$TempDefaultStore = '';
											$TempNULLStore = '';
											$TempIndexStore = '';
											$TempAIStore = '';
											$Temp4Array =  explode('@', $TempString);
											foreach ($Temp4Array as $key2 => $Temp4ArrayValue){
												if($ServiceSetupError == True){ break; }

												$Temp5Array =  explode('>', $Temp4ArrayValue);
												if(sizeof($Temp5Array) > 2){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.6.0'; break;
												}
												if($Temp5Array[0] != 'Type' && $Temp5Array[0] != 'Length' && $Temp5Array[0] != 'Default' && $Temp5Array[0] != 'Null' && $Temp5Array[0] != 'Index' && $Temp5Array[0] != 'AI'){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.6'; break;
												}
												if($Temp5Array[0] === 'Type'){
													if($TempType != 0 || $TempLength != 0 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.7'; break;
													}
													if($TempType === 0){
														$TempType = $TempType+1;
														if($Temp5Array[1] === 'INT' || $Temp5Array[1] === 'VARCHAR' || $Temp5Array[1] === 'TEXT'){
															$TempTypeStore = $Temp5Array[1];
															if($Temp5Array[1] === 'INT'){
																if($Temp3ArrayValue == 'String' || $Temp3ArrayValue == 'string' || $Temp3ArrayValue == 'STRING' || $Temp3ArrayValue == 'char' || $Temp3ArrayValue == 'Chare' || $Temp3ArrayValue == 'CHAR'){
																	$ServiceSetupError = True;
																	$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.8'; break;
																}
															}else{
																if($Temp3ArrayValue == 'id' || $Temp3ArrayValue == 'ID' || $Temp3ArrayValue == 'Id'){
																	$ServiceSetupError = True;
																	$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.9'; break;
																}
															}
														}else{
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.10'; break;
														}
													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.11'; break;
													}
												}else if($Temp5Array[0] === 'Length'){
													if($TempType != 1 || $TempLength != 0 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.7'; break;
													}
													if($TempLength === 0){
														$TempLength = $TempLength+1;
														$TempLengthStore = $Temp5Array[1];
														if($TempTypeStore === 'INT'){
															if($Temp5Array[1] < 11 || $Temp5Array[1] > 255){
																$ServiceSetupError = True;
																$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.13'; break;
															} 
														}else if($TempTypeStore === 'VARCHAR'){
															if($Temp5Array[1] < 30 || $Temp5Array[1] > 400){
																$ServiceSetupError = True;
																$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.14'; break;
															}
														}else if($TempTypeStore === 'TEXT'){
															if($Temp5Array[1] < 30 || $Temp5Array[1] > 60000){
																$ServiceSetupError = True;
																$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.15'; break;
															}
														}else{
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.16'; break;
														}
													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.17'; break;
													}
												}else if($Temp5Array[0] === 'Default'){
													if($TempType != 1 || $TempLength != 1 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.18'; break;
													}
													if($TempDefault === 0){
														$TempDefault = $TempDefault+1;
														if(strlen($Temp5Array[1]) > $TempLengthStore){
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.19'; break;
														}
													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.20'; break;
													}
													$TempDefaultStore = $Temp5Array[1];
												}else if($Temp5Array[0] === 'Null'){
													if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.21'; break;
													}
													if($TempNull === 0){
														$TempNull = $TempNull+1;
														if($Temp5Array[1] != 'True' && $Temp5Array[1] != 'False'){
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.22'; break;
														}else{
															$TempNULLStore = $Temp5Array[1];
														}
													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.23'; break;
													}
												}else if($Temp5Array[0] === 'Index'){
													if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 1 || $TempIndex != 0 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.24'; break;
													}
													if($TempIndex === 0){
														$TempIndex = $TempIndex+1;
														if($Temp5Array[1] === 'PRIMARY'){
															if($PrimaryCount === 0 && $AutoIncrement === 0 && $PrimaryKeyStore === ''){
																$PrimaryCount = $PrimaryCount+1;
																$PrimaryKeyStore = $Temp2String;
																if($TempNULLStore == 'True'){
																	$ServiceSetupError = True;
																	$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.25'; break;
																}
															}else{
																$ServiceSetupError = True;
																$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.26'; break;
															}
														}else if($Temp5Array[1] === 'UNIQUE'){

														}else if($Temp5Array[1] === ''){

														}else{
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.27'; break;
														}
														$TempIndexStore = $Temp5Array[1];
													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.28'; break;
													}
												}else if($Temp5Array[0] === 'AI'){
													if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 1 || $TempIndex != 1 || $TempAI != 0){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.29'; break;
													}
													$TempAI = $TempAI+1;
													if($TempDefaultStore != ''){
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.29.0'; break;
													}
													if($Temp5Array[1] === 'True'){
														if($PrimaryCount != 1 || $TempIndexStore != 'PRIMARY' || $PrimaryKeyStore != $Temp2String){
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.30'; break;
														}
														if($AutoIncrement === 0){
															$AutoIncrement = $AutoIncrement+1;
															if($TempTypeStore != 'INT'){
																$ServiceSetupError = True;
																$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.31'; break;
															}

														}else{
															$ServiceSetupError = True;
															$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.32'.$AutoIncrement; break;
														}
													}else if($Temp5Array[1] === 'False'){

													}else{
														$ServiceSetupError = True;
														$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.33'; break;
													}
													$TempAIStore = $Temp5Array[1];
												}else{
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.34'; break;
												}
											}
											if($TempType == 0 || $TempLength == 0 || $TempDefault == 0 || $TempNull == 0 || $TempIndex == 0 || $TempAI  == 0 || $TempTypeStore == '' || $TempLengthStore == 0 || $TempNULLStore == '' || $TempAIStore == ''){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 1.35'; break;
											}
											$ColumnNameArray[strtolower($Temp2String)] = $TempString;
											$ColumnsNameStore .= ','.$Temp2String;
											if($TempDefaultStore != ''){$TempDefaultStore = "DEFAULT '".$TempDefaultStore."'";}
											if($TempNULLStore == 'True'){$TempNULLStore = 'NULL';}else{$TempNULLStore = 'NOT NULL';}
											if($TempIndexStore == 'PRIMARY'){$TempIndexStore = '';}
											if($TempAIStore == 'True'){$TempAIStore = 'AUTO_INCREMENT';}else{$TempAIStore = '';}
											$TablesColumnWithValuesArray[strtolower($Temp2Array[0].'::,::'.$Temp2String)] .= " $Temp2String $TempTypeStore($TempLengthStore) $TempNULLStore $TempAIStore $TempDefaultStore $TempIndexStore";
										}
										$TablesAndColumnsArray[strtolower($Temp2Array[0])] = $ColumnsNameStore.',';
										$PrimaryKeyStoreArray[strtolower($Temp2Array[0])] = $PrimaryKeyStore;
									}
								}
							}else{
								$ServiceSetupError = True;
								$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 0.1';
							}
						}else{
							$ServiceSetupError = True;
							$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 0.2';
						}
						
						$CreatedTablesNameStore =	array();
						foreach ($TablesAndColumnsArray as $key => $value) {
							if($ServiceSetupError == True){ break; }

							$ColumnCraeteString = '';
							$TempColumnCreate = explode(',', trim($value,','));
							foreach ($TempColumnCreate as $key1 => $value1) {
								if($ServiceSetupError == True){ break; }

								$ColumnCraeteString .= $TablesColumnWithValuesArray[strtolower($key.'::,::'.$value1)].',';
							}
							$ColumnCraeteString = trim($ColumnCraeteString,',');

							if($PrimaryKeyStoreArray[$key] != ''){
								$ColumnCraeteString .= " , PRIMARY KEY (".$PrimaryKeyStoreArray[$key].")";
							}

							$stmt = $ServiceConnection->prepare("CREATE TABLE $LgFOR".'_'."$key ($ColumnCraeteString)");
							if($stmt->execute()){
								array_push($CreatedTablesNameStore, $LgFOR.'_'.$key);
							}else{
								foreach ($CreatedTablesNameStore as $key3 => $value3) {
									if($ServiceSetupError == True){ break; }

									$Response = DeleteTable($value3,$ServiceConnection);
								}
								$ServiceSetupError = True;
								$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 0.3'; break;
							}
						}

						$TablesArray2 = array();
						if(strlen($ServiceTablesAndColumns) > 0 && strlen($TablesDefaultValues) > 0 && $ServiceSetupError == False){
							if(strlen($TablesDefaultValues) <= 11000){
								if($ServiceTablesAndColumns != preg_replace("/[^A-Za-z0-9=&@:,*#-_ .]/","",$ServiceTablesAndColumns)){
									$ServiceSetupError = True;
									$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.0';
								}else{
									$k = 0;
									$TempArray = explode('&', $TablesDefaultValues);
									foreach ($TempArray as $key => $TempArrayValue) {
										if($ServiceSetupError == True){ break; }

										if(substr_count($TempArrayValue,'=') !=  1){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.1'; break;
										}
										$Temp2Array =  explode('=', $TempArrayValue);
										if (array_key_exists(strtolower($Temp2Array[0]),$TablesArray2)){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.1.0'; break;
										}

										if (!array_key_exists(strtolower($Temp2Array[0]),$TablesAndColumnsArray)){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.1.1'; break;
										}

										if(strlen($TempArrayValue) == 0 || strlen($Temp2Array[0]) == 0 || strlen($Temp2Array[1]) == 0 || $Temp2Array[0] != preg_replace("/[^a-z0-9_]/","",$Temp2Array[0]) || $Temp2Array[1] != preg_replace("/[^A-Za-z0-9@:,*#-_ .]/","",$Temp2Array[1])){
											$ServiceSetupError = True;
											$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.2'; break;
										}

										$Temp3Array =  explode('@', $Temp2Array[1]);
										
										foreach ($Temp3Array as $key => $Temp3ArrayValue){
											if($ServiceSetupError == True){ break; }

											if($Temp3ArrayValue != preg_replace("/[^A-Za-z0-9,:*#-_ .]/","",$Temp3ArrayValue) || strlen($Temp3ArrayValue) == 0){
												$ServiceSetupError = True;
												$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.3'; break;
											}

											$TempColumnStoreArray = array();
											$Temp4Array =  explode('#', $Temp3ArrayValue);

											foreach ($Temp4Array as $key => $Temp4ArrayValue){
												if($ServiceSetupError == True){ break; }

												if(substr_count($Temp4ArrayValue,'::::') !=  1){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.4'; break;
												}

												$Temp5Array =  explode('::::', $Temp4ArrayValue);
												if(strlen($Temp4ArrayValue) == 0 || strlen($Temp5Array[0]) == 0 || strlen($Temp5Array[1]) == 0 || $Temp5Array[0] != preg_replace("/[^A-Za-z0-9_]/","",$Temp5Array[0]) || $Temp5Array[1] != preg_replace("/[^A-Za-z0-9-,:*_ .]/","",$Temp5Array[1])){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.5'; break;
												}
												
												if(substr_count($TablesAndColumnsArray[$Temp2Array[0]],','.$Temp5Array[0].',') !=  1){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.6'; break;
												}

												if (array_key_exists(strtolower($Temp5Array[0]),$TempColumnStoreArray)){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 2.7'; break;
												}
												$TempColumnStoreArray[strtolower($Temp5Array[0])] = '';
											}
											
											if($ServiceSetupError != True){
												$Response = InsertGivenData(str_replace("#","::,::",$Temp3ArrayValue),$ServiceConnection,$LgFOR.'_'.$Temp2Array[0],$EncodeAndEncryptPass);
												if($Response['status'] != 'Success' || $Response['code'] != 200){
													$ServiceSetupError = True;
													$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 3.0';
												}
											}
										}
									}
								}
							}else{
								$ServiceSetupError = True;
								$ServiceSetupErrorDetails = 'Service can not buyed, because there is an error accur at setup time. Error Code - 3.1';
							}
						}

						if($ServiceSetupError == True){
							DeleteTable($LgFOR.'_',$ServiceConnection,'LastLike',false,'topicste_service_create_'.$ServiceCode);
							return_response($ServiceSetupErrorDetails); exit();
						}

						$Response = UpdateGivenData("Status::::$ActiveType::,::SetupStatus::::Active","BuyId::::$SetupBuyId",$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,'all');

						if($Response['status'] === 'Success' && $Response['code'] === 200){
							$ServiceStatusForOrg['msg']['IsServiceSetUp'] = true;
						}else{
							DeleteTable($LgFOR.'_',$ServiceConnection,'LastLike',false,'topicste_service_create_'.$ServiceCode);
							return_response('Service can not buyed, because there is an error accur at setup time!  [Service SetUp]'); exit();
						}
					}


					if($ServiceStatusForOrg['msg']['IsServiceSetUp'] == false){
						return_response('There is technical error accur Error Code - [0.1.0]'); exit();
					}

					if($GetPlanData['msg']->Validity == -1){
						$InsertData = 'VldPlnValidity::::0::,::VldPlnReqNo::::0::,::NVldPlnReqNo::::'.$GetPlanData['msg']->MaxRequestLimit.'::,::';
					}else if($GetPlanData['msg']->Validity >= 0){
						if($GetPlanData['msg']->MaxRequestLimit == -1){
							$InsertData = 'VldPlnValidity::::'.$GetPlanData['msg']->Validity.'::,::NVldPlnReqNo::::0::,::VldPlnReqNo::::Unlimited::,::';
						}else if($GetPlanData['msg']->MaxRequestLimit >= 0){
							$InsertData = 'VldPlnValidity::::'.$GetPlanData['msg']->Validity.'::,::NVldPlnReqNo::::0::,::VldPlnReqNo::::'.$GetPlanData['msg']->MaxRequestLimit.'::,::';
						}else{
							return_response('Service can not buyed, due to technical error [Invalid Plan]'); exit();
						}
					}else{
						return_response('Service can not buyed, due to technical error [Invalid Plan]'); exit();
					}

					if($GetPlanData['msg']->Price == 0){
						$GetTotalNoOfServiceBuyFeature = AptPdoFetchWithAes(['Condtion'=> "ServiceCode::::$ServiceCode::,::Organization::::$LgFOR::,::Priority::::null::::NotEqual", 'FetchData'=>'Priority', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_for_feature_record', 'EPass'=> $EncodeAndEncryptPass,'DataOrder'=>'DESC|Priority']);
						if($GetTotalNoOfServiceBuyFeature['code'] != 200 && $GetTotalNoOfServiceBuyFeature['code'] != 404){
							return_response('Service details not feched, due to technical error [Service Priority]'); exit();
						}else{
							if($GetTotalNoOfServiceBuyFeature['code'] == 404){
								$InsertData .= "Priority::::1::,::";
							}else{
								$TempPriority = $GetTotalNoOfServiceBuyFeature['msg']->Priority + 1;
								$InsertData .= "Priority::::$TempPriority::,::";
							}
						}
						$InsertData .= "PaymentStatus::::Paid::,::";
					}else if($GetPlanData['msg']->Price > 0){
						$InsertData .= "PaymentStatus::::Unpaid::,::";
						return_response('Currently Paid plan can not be buyed buy any organization'); exit();
					}else{
						return_response('Service can not buyed, due to technical error [Invalid Plan Price]'); exit();
					}

					$InsertData .= "Status::::Active::,::TransferStatus::::ready::,::ServiceMember::::".$GetServiceData['msg']->ServiceMember."::,::BuyId::::$BuyId::,::ServiceCode::::$ServiceCode::,::Organization::::$LgFOR::,::ServiceAndOrganization::::".$ServiceCode.'_'.$LgFOR."::,::StartTime::::0::,::ExpTime::::0";
					
					$ServiceDataInsertInServiceBuyForFeatureRecord = InsertGivenData($InsertData,$PdoServiceManage,'service_buy_for_feature_record',$EncodeAndEncryptPass,true);
					if($ServiceDataInsertInServiceBuyForFeatureRecord['code'] != 200){
						return_response('Service can not buyed, due to technical error! [Service Insert]'); exit();
					}

					$ServiceDataInsertInServiceBuyHistory = InsertGivenData("BuyId::::$BuyId::,::CSPCode::::".$GetPlanData['msg']->CSPCode."::,::PlanCode::::$PlanId::,::ServiceCode::::$ServiceCode::,::Organization::::$LgFOR::,::BuyTime::::$CurrentTime::,::PlanDtls::::".serialize(['Validity'=>'','RequestNo'=>'','AmountINR'=>$GetPlanData['msg']->Price])."::,::BuyByDtls::::".serialize(['UserUrl'=>$LgUserUrl,'Position'=>$LgPosition,'Rank'=>$LgPositionRank]),$PdoServiceManage,'service_buy_history',$EncodeAndEncryptPass);
					if($ServiceDataInsertInServiceBuyHistory['code'] != 200){
						DeleteDataFromTable("BuyId::::$BuyId",$PdoServiceManage,'service_buy_for_feature_record',$EncodeAndEncryptPass,false,'Equal');
						return_response('Service can not buyed, due to technical error! [Service History]'); exit();
					}

					return_response('Service plan buyed successfully',true,'Success',200); exit();
				}
			}
			ServiceBuy::ValidedData($ServiceCode,$PlanId,$ActiveType,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
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