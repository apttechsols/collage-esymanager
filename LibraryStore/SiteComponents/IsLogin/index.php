<?php
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

	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
	}
	function DoLogOut(){
		setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);
	}

	// Access main_db file to access data base connection ($PdoMainUserAccountDb)
	require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

	// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");

	/*-------------- Apt Library -----------------------*/
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

	function IsLogin($IsLoginData = array()){
		date_default_timezone_set('Asia/Kolkata');
		$ExtCurrentTime = time();

		$FetchDtls='Fullname::::UserUrl::::Position::::ProfileUrl'; $CheckType='Server';
		foreach ($IsLoginData as $key=>$value){ ${ $key } = $value; }

		if($PdoMainUserAccountDb == '' || $PdoOrganizationUserAccount == '' || $FetchDtls == '' || $CheckType == '' || $EPass == ''){
			return ["status"=>"Error","msg"=>"Invalid Data format detect [ IsLogin ]","code"=>400];
		}
		
		if(!function_exists('AptPdoFetchWithAes') || !function_exists('AptPdoUpdateWithAes') || !method_exists('EncodeAndEncrypt', 'exe_task_private') || !method_exists('EncodeAndEncrypt', 'decrypt_method')){
			return ["status"=>"Error","msg"=>"Required function not found [ IsLogin ]","code"=>400];
		}

		$DecryptLUID = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LUID'], $EPass,"false");
		if($DecryptLUID['status'] === 'Success' && $DecryptLUID['msg'] !== false && $DecryptLUID['code'] === 200){
			$LUID = $DecryptLUID['msg'];
		}else{
			DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 1',"code"=>400];
		}

		$DecryptLAS = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LAS'], $EPass,"false");
		if($DecryptLAS['status'] === 'Success' && $DecryptLAS['msg'] !== false && $DecryptLAS['code'] === 200){
			$LAS = $DecryptLAS['msg'];
		}else{
			DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 2',"code"=>400];
		}

		$DecryptLFR = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LFR'], $EPass,"false");
		if($DecryptLFR['status'] === 'Success' && $DecryptLFR['msg'] !== false && $DecryptLFR['code'] === 200){
			$LFR = $DecryptLFR['msg'];
		}else{
			DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 3',"code"=>400];
		}

		$DecryptLORT = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LORT'], $EPass,"false");
		if($DecryptLORT['status'] === 'Success' && $DecryptLORT['msg'] !== false && $DecryptLORT['code'] === 200){
			$LORT = $DecryptLORT['msg'];
		}else{
			DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 4',"code"=>400];
		}
		
		if(strlen($LUID) > 0 &&  strlen($LAS) > 0 && strlen($LFR) > 0){
			if($LAS === 'MainMember' || $LAS === 'OrganizationMember'){
				if($LAS === 'OrganizationMember'){
					$DbCon = $PdoOrganizationUserAccount;
					$GetOrgDtls = AptPdoFetchWithAes(['Condtion'=> "UserUrl::::$LFR::,::OrganizationType::::$LORT::,::SignupType::::Organization::,::Status::::Active", 'FetchData'=>'Username', 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EPass, 'FetchRowNo'=>1]);
					
				}else{
					$DbCon = $PdoMainUserAccountDb;
					$GetOrgDtls = AptPdoFetchWithAes(['Condtion'=> "OrganizationType::::$LORT::,::SignupType::::Main::,::Status::::Active", 'FetchData'=>'Username', 'DbCon'=> $PdoMainUserAccountDb, 'TbName'=> 'main_user_accounts', 'EPass'=> $EPass, 'FetchRowNo'=>1]);
				}
				

				if($GetOrgDtls['status'] === "Success" && $GetOrgDtls['code'] === 200 && $GetOrgDtls['totalrows'] === 1){
					$LFRUNM = $GetOrgDtls['msg']->Username;
					$GetLoginDtls = AptPdoFetchWithAes(['Condtion'=> "LoginUniqueId::::$LUID::,::Status::::Active", 'FetchData'=>'LoginTokenData::::PassChangeTime::::UserUrl', 'DbCon'=> $DbCon, 'TbName'=> $LFR, 'EPass'=> $EPass, 'FetchRowNo'=>1]);
				}else{
					DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 5',"code"=>400];
				}
			}else{
				DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 6',"code"=>400];
			}
			
			if($GetLoginDtls['status'] === 'Success'){
				$LoginTokenData = unserialize($GetLoginDtls['msg']->LoginTokenData);
				$PassChangeTime = $GetLoginDtls['msg']->PassChangeTime;
				if(($LoginTokenData['CustomAuth']['LoginExpTime'] > time() || $LoginTokenData['CustomAuth']['LoginExpTime'] === $LoginTokenData['CustomAuth']['LoginTime']) && $LoginTokenData['CustomAuth']['LoginTime'] > $PassChangeTime && $LoginTokenData['ServerAuth']['UserAgent'] === $_SERVER['HTTP_USER_AGENT']){

					$LgUserDtls = AptPdoFetchWithAes(['Condtion'=> "Status::::Active::,::UserUrl::::".$GetLoginDtls['msg']->UserUrl, 'FetchData'=>$FetchDtls, 'DbCon'=> $DbCon, 'TbName'=> $LFR, 'EPass'=> $EPass, 'FetchRowNo'=>1]);
					

					if($CheckType === 'ClientAndServer'){
						if($ClientData == ''){
							return ["status"=>"Error","msg"=>"Invalid Data format detect [ IsLogin ]","code"=>400];
						}   
						if($ClientData['BrowserClientId1'] != $LoginTokenData['ClientAuth']['BrowserClientId1'] || $ClientData['BrowserClientId2'] != $LoginTokenData['ClientAuth']['BrowserClientId2']){
							DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 7',"code"=>400];
						}
					}else if($CheckType === 'Server'){
						#Continue
					}else{
						DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 8',"code"=>400];
					}

					if($LgUserDtls['status'] === 'Success' && $LgUserDtls['code'] === 200){
						$UpdateLastActive = AptPdoUpdateWithAes(['Update'=>"LastActiveTime::::$ExtCurrentTime",'Condtion'=>"UserUrl::::".$GetLoginDtls['msg']->UserUrl,'DbCon'=>$DbCon,'TbName'=>$LFR,'EPass'=>$EPass]);
						
						if($UpdateLastActive['code'] === 200 || $UpdateLastActive['code'] === 404){
							$FetchDtlsArray = explode('::::', $FetchDtls);
							$IsLoginDtls=array();
							foreach ($FetchDtlsArray as $key){
								$IsLoginDtls[$key] = $LgUserDtls['msg']->$key;
							}
							return ['status'=>'Success','msg'=>$IsLoginDtls,'LAS'=>$LAS,'LFR'=>$LFR,'LORT'=>$LORT,'LFRUNM'=>$LFRUNM,'code'=>200];
						}else{
							DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 9',"code"=>400];
						}
					}else{
						DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined  Code - 9',"code"=>400];
					}
				}else{
					DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 10',"code"=>400];
				}
			}else{
				DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 11',"code"=>400];
			}
		}else{
			DoLogOut(); return ['status'=>'Error','msg'=>'Oops! Client currently not logined Code - 12',"code"=>400];
		}
	}
?>