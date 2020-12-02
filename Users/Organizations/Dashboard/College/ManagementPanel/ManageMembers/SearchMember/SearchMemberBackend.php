<?php
	/*
	@FileName - SearchMember.php
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
	define('RootPath', '../../../../../../../');

	if(isset($_POST['SearchDataKey']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
		require_once (RootPath."JsonShowError/index.php");

		// Verify data send from same domain or not
		if(true){
			session_start();
			if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){
				if($_POST['SearchDataKey'] !== "undefined"){
					if($_POST['SearchDataKey'] == ""){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
						return_response("Please Enter Somthing In Search Box");
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

					class SearchMember{
						public function GetResultCheckLoginData($SearchDataKey,$BrowserClientId1,$BrowserClientId2){
							
							//Secrate code for access main_db file
							$DatabaseAccessCode = 'Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ';

							//Secrate code for access otherfiles file
							$FileAccessCode = 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH';

							// Encryption pass for all data
							$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
							
							// Access main_db file to access data base connection ($PdoMainUserAccountDb)
							require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

							// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
							require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");
							
							// Access main_db file to access data base connection($PdoOrganizationUserSetting)
					        require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");
					
							require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
							require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
							require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
							require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");

							/*-------------- Apt Library -----------------------*/
							require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
							
							$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
							
							if($ResponseLogin['status'] === 'Success' && $ResponseLogin['code'] === 200){
								if($ResponseLogin['LAS'] != 'OrganizationMember'){
									return_response('You are not authorized to take this action'); exit();
								}
								SearchMember::SearchMemberRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoOrganizationUserAccount,$PdoOrganizationUserSetting,$ResponseLogin);
							}else{
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
								return_response('User not login');
							}
						}
						private function SearchMemberRequest($SearchDataKey,$EncodeAndEncryptPass,$PdoOrganizationUserAccount,$PdoOrganizationUserSetting,$ResponseLogin){
							$getOrgnizationName = $ResponseLogin['LFR'];
							
						    $ResponseOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::SearchMemberRankUpTo","SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any');
        					if($ResponseLogin['status'] != "Success" || $ResponseLogin['code'] != 200){
        					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
        						return_response('Data can not fetch from database! Try again later');
        					}
        					$SearchMemberRankUpToStart = explode(',',$ResponseOrgSetting['msg']->SettingValue)[0];
        					$SearchMemberRankUpToEnd = explode(',',$ResponseOrgSetting['msg']->SettingValue)[1];
        					if($SearchMemberRankUpToStart !== 'e' || $SearchMemberRankUpToEnd !== 'e'){
        					    if(($SearchMemberRankUpToStart !== 'e' && $LgPositionRank < $SearchMemberRankUpToStart) || ($SearchMemberRankUpToEnd !== 'e' && $LgPositionRank > $SearchMemberRankUpToEnd)){
        					        foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
        					        return_response('You are not Authorized to search member');
        					    }
        					}

							$Response = AptPdoFetchWithAes(['Condtion'=> "Fullname::::$SearchDataKey::,::Mobile::::$SearchDataKey::,::Position::::$SearchDataKey", 'FetchData'=>'Status::::Fullname::::Gender::::Mobile::::Position::::UserUrl::::ProfileUrl', 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $getOrgnizationName, 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DefaultCheckType'=>'ValLike','DefaultCheckFor'=>'Any','Limit'=>10]);

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
								return_response($Response,true,'Success',200);
							}else{
								return_response('No Result Found',true,'Error',404);
							}
						}
					}
					SearchMember::GetResultCheckLoginData($SearchDataKey,$BrowserClientId1,$BrowserClientId2);
				}else{
					foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
					return_response("You Request wrong data(Undifined) to process");
				}
			}else{
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Invalid Token Id! Refresh page");
			}
		}else{
			header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
		}
	}else{
		header("Location: " . DomainName . "/PageNotAvailable/index.php"); die();
	}
?>