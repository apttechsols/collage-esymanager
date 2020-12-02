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
	function UnsetLoginUserData(){
		/*setcookie( 'LUID', NULL, time()-1, '/', false, false, true);
		setcookie( 'LAS', NULL, time()-1, '/', false, false, true);
		setcookie( 'LFR', NULL, time()-1, '/', false, false, true);
		setcookie( 'LORT', NULL, time()-1, '/', false, false, true);*/
	}

	if(empty($EncodeAndEncryptPass)){
		$EncodeAndEncryptPass ="DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx";
	}

	// Access main_db file to access data base connection ($PdoMainUserAccountDb)
	require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

	// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");

	/*-------------- Apt Library -----------------------*/
    require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");	
	
	function CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$RequireUserDetails='Fullname',$CheckLoginType = 'Server',$ClientData=array()){
		date_default_timezone_set('Asia/Kolkata');
		$ExtCurrentTime = time();

		if(!function_exists('AptPdoUpdateWithAes') || !function_exists('FetchReuiredDataByGivenData') || !function_exists('CheckGivenDataAvailability') || !method_exists('EncodeAndEncrypt', 'exe_task_private') || !method_exists('EncodeAndEncrypt', 'decrypt_method') || !isset($PdoMainUserAccountDb) || !isset($PdoOrganizationUserAccount) || !isset($EncodeAndEncryptPass)){
			return ['status'=>'Error','msg'=>'Process failed! Try again later1',"code"=>400];
		}
		
		$Response = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LUID'], $EncodeAndEncryptPass,"false");
		if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
			$LUID = $Response['msg'];
		}else{
			UnsetLoginUserData();
			return ['status'=>'Error','msg'=>'User currently not login',"code"=>400];
		}

		$Response = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LAS'], $EncodeAndEncryptPass,"false");
		if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
			$LAS = $Response['msg'];
		}else{
			UnsetLoginUserData();
			return ['status'=>'Error','msg'=>'User currently not login',"code"=>400];
		}

		$Response = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LFR'], $EncodeAndEncryptPass,"false");
		if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
			$LFR = $Response['msg'];
		}else{
			UnsetLoginUserData();
			return ['status'=>'Error','msg'=>'User currently not login',"code"=>400];
		}

		$Response = EncodeAndEncrypt::exe_task_private("decrypt_method" ,$_COOKIE['LORT'], $EncodeAndEncryptPass,"false");
		if($Response['status'] === 'Success' && $Response['msg'] !== false && $Response['code'] === 200){
			$LORT = $Response['msg'];
		}else{
			UnsetLoginUserData();
			return ['status'=>'Error','msg'=>'User currently not login',"code"=>400];
		}
		
		if(strlen($LUID) > 0 &&  strlen($LAS) > 0 && strlen($LFR) > 0){
			if($LAS === 'MainMember' || $LAS === 'OrganizationMember'){
				if($LAS === 'OrganizationMember'){
					$DatabaseConnection = $PdoOrganizationUserAccount;
					$Response = FetchReuiredDataByGivenData("UserUrl::::$LFR::,::OrganizationType::::$LORT::,::SignupType::::Organization",'Username::::OrganizationName',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all','Active');
				}else{
					$DatabaseConnection = $PdoMainUserAccountDb;
					
					$Response = CheckGivenDataAvailability('OrganizationType::::$LORT::,::SignupType::::Main',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass);
					if($Response['status'] === "Success" && $Response['code'] === 200 && $Response['totalrows'] === 1){
						$Response = FetchReuiredDataByGivenData("OrganizationType::::$LORT::,::SignupType::::Main",'Username::::OrganizationName',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all','Active');
					}else{
						return ['status'=>'Error','msg'=>'Process failed! Try again later2.1',"code"=>400];
					}
				}
				

				if($Response['status'] === "Success" && $Response['code'] === 200){
					$LFRUNM = $Response['msg']->Username;
					$LFRORNM = $Response['msg']->OrganizationName;
					$Response = FetchReuiredDataByGivenData("LoginUniqueId::::$LUID","LoginTokenData::::PassChangeTime::::UserUrl",$DatabaseConnection,$LFR,$EncodeAndEncryptPass,'all','Active');
				}else{
					UnsetLoginUserData();
					if($Response['code'] === "404"){
						return ['status'=>'Error','msg'=>'User currently not login',"code"=>404];
					}else{
						return ['status'=>'Error','msg'=>'Process failed! Try again later3',"code"=>400];
					}
				}
			}else{
				return ['status'=>'Error','msg'=>'User currently not login',"code"=>404];
			}
			
			if($Response['status'] === 'Success'){
				$LoginTokenData = unserialize($Response['msg']->LoginTokenData);
				$PassChangeTime = $Response['msg']->PassChangeTime;
				$TbName = $Response['msg']->UserUrl;

				if(($LoginTokenData['CustomAuth']['LoginExpTime'] > time() || $LoginTokenData['CustomAuth']['LoginExpTime'] === $LoginTokenData['CustomAuth']['LoginTime']) && $LoginTokenData['CustomAuth']['LoginTime'] > $PassChangeTime && $LoginTokenData['ServerAuth']['UserAgent'] === $_SERVER['HTTP_USER_AGENT']){

					$Response = FetchReuiredDataByGivenData("UserUrl::::$TbName",$RequireUserDetails,$DatabaseConnection,$LFR,$EncodeAndEncryptPass,'all','Active');

					if($CheckLoginType === 'ClientAndServer'){
						if($ClientData['BrowserClientId1'] != $LoginTokenData['ClientAuth']['BrowserClientId1'] || $ClientData['BrowserClientId2'] != $LoginTokenData['ClientAuth']['BrowserClientId2']){
							UnsetLoginUserData();
							return ['status'=>'Error','msg'=>'User Not logined Code -1','code'=>404];
						}
					}else if($CheckLoginType === 'Server'){
					}else{
						return ['status'=>'Error','msg'=>'Invalid check login type Code -2','code'=>404];
					}

					if($Response['status'] === 'Success' && $Response['code'] === 200){
						
						$UpdateLastActive = AptPdoUpdateWithAes(['Update'=>"LastActiveTime::::$ExtCurrentTime",'Condtion'=>"UserUrl::::$TbName",'DbCon'=>$DatabaseConnection,'TbName'=>$LFR,'EPass'=>$EncodeAndEncryptPass]);
						
						if($UpdateLastActive['code'] === 200 || $UpdateLastActive['code'] === 404){
							
							$RequireUserDetailsArray = explode('::::', $RequireUserDetails);
							$Result=array();
							foreach ($RequireUserDetailsArray as $key) {
								$Result[$key] = $Response['msg']->$key;
							}
							return ['status'=>'Success','msg'=>$Result,'LAS'=>$LAS,'LFR'=>$LFR,'LORT'=>$LORT,'LFRUNM'=>$LFRUNM,'LFRORNM'=>$LFRORNM,'code'=>200];
						}else{
							UnsetLoginUserData(); return ['status'=>'Error','msg'=>'User currently not login Code -3','code'=>404];
						}
					}else if($Response['code'] === 404){
						UnsetLoginUserData(); return ['status'=>'Error','msg'=>'User currently not login Code -4','code'=>404];
					}else{
						return ['status'=>'Error','msg'=>'Process failed! Try again later4','code'=>400];
					}
				}else{
					UnsetLoginUserData();
					return ['status'=>'Error','msg'=>'User currently not login Code -5','code'=>404];
				}
			}else{
				UnsetLoginUserData();
				if($Response['code'] === "404"){
					UnsetLoginUserData();
					return ['status'=>'Error','msg'=>'User currently not login',"code"=>404];
				}else{
					return ['status'=>'Error','msg'=>'Process failed! Try again later5',"code"=>400];
				}
			}
		}else{
			UnsetLoginUserData();
			return ['status'=>'Error','msg'=>'User currently not login Code - 6','code'=>404];
		}
	}


?>