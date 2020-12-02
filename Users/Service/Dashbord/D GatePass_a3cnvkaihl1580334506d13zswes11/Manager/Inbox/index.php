<?php
	// Not show any error
	#error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}

	define("RootPath", "../../../../../../");

	session_start();
	$Token_CSRF = md5(rand(1345694, 9893456));
	$RandomPass1 = md5(rand(13456, 9893456));
	$RandomPass2 = md5(rand(13456, 9893456));
	$RandomPass3 = md5(rand(13456, 9893456));
	$RandomPass4 = md5(rand(13456, 9893456));
	$RandomPass5 = md5(rand(13456, 9893456));
	$_SESSION['Token_CSRF'] = $Token_CSRF;
	$_SESSION['RandomPass1'] = $RandomPass1;
	$_SESSION['RandomPass2'] = $RandomPass2;
	$_SESSION['RandomPass3'] = $RandomPass3;
	$_SESSION['RandomPass4'] = $RandomPass4;
	$_SESSION['RandomPass5'] = $RandomPass5;

	//Secrate code for access main_db file
	$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

	//Secrate code for access otherfiles file
	$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

	// Encryption pass for all data
	$EncodeAndEncryptPass ="DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx";

	require_once (RootPath."JsonShowError/index.php");

	// Access main_db file to access data base connection ($PdoMainUserAccountDb)
	require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

	// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

	// Access organization_user_setting file to access data base connection ($PdoOrganizationUserSetting)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

	// Access main_db file to access data base connection ($PdoServiceManage)
	require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

	//Create connection for any Database (CreateDbConnection(DbName))
	require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");
	
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/ServiceStatusForOrg/index.php");

	/*-------------- Apt Library -----------------------*/
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");

	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	$CurrentTime = time();
	
	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
		$ServiceStatusForOrg = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'a3cnvkaihl1580334506d13zswes11','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$ResponseLogin['LFR'],'CurrentTime'=>$CurrentTime]);

		if($ServiceStatusForOrg['code'] == 200 && $ServiceStatusForOrg['msg']['IsServiceBuyed'] == True && $ServiceStatusForOrg['msg']['IsServiceSetUp'] == True){
			$DGatePassServiceConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
			if($DGatePassServiceConnection['status'] === 'Success' && $DGatePassServiceConnection['code'] === 200){
				$DGatePassServiceConnection = $DGatePassServiceConnection['msg'];
				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DGatePassServiceConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DGatePassServiceConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
			}
		}
	}
	
	$GetAvailablePlan = AptPdoFetchWithAes(['Condtion'=> "Priority::::null::::NotEqual::,::PaymentStatus::::Paid::,::ServiceCode::::a3cnvkaihl1580334506d13zswes11::,::Organization::::".$ResponseLogin['LFR'], 'FetchData'=>'Status::::TransferStatus::::BuyId::::Priority::::VldPlnReqNo::::VldPlnValidity::::NVldPlnReqNo', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_for_feature_record', 'EPass'=> $EncodeAndEncryptPass,'DataOrder'=>'ASC|Priority']);
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ServiceStatusForOrg' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetAvailablePlan' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ServiceStatusForOrg['status'] != 'Success' || $ServiceStatusForOrg['code'] != 200 || $ServiceStatusForOrg['msg']['IsServiceBuyed'] != True || $ServiceStatusForOrg['msg']['IsServiceSetUp'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}else{
		if($ResponseRank != 1 && $ResponseRank != 2){
				$CheckManager = True;
		}
	}

	if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 ) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}
	
	if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
		FullPageErrorMessageDisplay('Service setting not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	foreach ($GetServiceSetting['msg'] as $value){
		${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
	}
	if($CheckManager == True){
		$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
		if($LgUserServicePositionRank == ''){
			FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
		}
		if($LgUserServicePositionRank != 1){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
		}
	}

	if($GetAvailablePlan['code'] != 200 && $GetAvailablePlan['code'] != 404){
		FullPageErrorMessageDisplay('Available plan not fetch due to an technical error occur',true,['MSGpadding'=>'40vh 10px']); exit();
    }else if($GetAvailablePlan['code'] == 404){
       $FAutoActivePlanNo = 0;
       $FAutoActivePlanMsg = 'No feature auto active plan for this organization';
    }else if($GetAvailablePlan['msg']->Status != 'Active'){
    	$FAutoActivePlanNo = $GetAvailablePlan['totalrows'];
    	$FAutoActivePlanMsg = "There is Total $FAutoActivePlanNo feature auto active plan avaiable for this organization<br/><br/>Plan for auto update is pused by organization";
    }else{
    	$FAutoActivePlanNo = $GetAvailablePlan['totalrows'];
    	$NextNVldPlnReqNo = $GetAvailablePlan['msg']->NVldPlnReqNo;
	    $NextVldPlnReqNo = $GetAvailablePlan['msg']->VldPlnReqNo;
	    $NextVldPlnValidity = $GetAvailablePlan['msg']->VldPlnValidity;
	    $NextBuyId = $GetAvailablePlan['msg']->BuyId;
	    $NextPriority = $GetAvailablePlan['msg']->Priority;

	    function ConvertToDayFromsec($seconds){
	        $dt1 = new DateTime("@0");
	        $dt2 = new DateTime("@$seconds");
	        return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
	    }
	    
	    if($NextVldPlnValidity != 0){
			$NextPlanValidity = 'Valided for '.ConvertToDayFromsec($NextVldPlnValidity);
		}else{
			$NextPlanValidity = 'Validity is Unlimited';
		}

	    $FAutoActivePlanMsg = "Total Feature Plan : $FAutoActivePlanNo<br/><br/>Next Auto Active Plan : Balance is ".($NextNVldPlnReqNo+$NextVldPlnReqNo)." And $NextPlanValidity";
    }

	if($ServiceStatusForOrg['msg']['Validity'] != 'Unlimited'){
		$CurrentPlanValidity = 'Valided for '.date('d-M-Y, h:i:s A',$ServiceStatusForOrg['msg']['Validity']);
	}else{
		$CurrentPlanValidity = 'Validity is Unlimited';
	}

	$TotalUsedRequest = $ServiceStatusForOrg['msg']['TotalUsedRequest'];
	
	FullPageErrorMessageDisplay('D GatePass service Balance is '.$ServiceStatusForOrg['msg']['CurrentUsablePlnReqNo']." & $CurrentPlanValidity<br/><br/><br/>$FAutoActivePlanMsg<br/><br/>Total D GatePass Request : $TotalUsedRequest",true,['MSGpadding'=>'40vh 10px']); exit();
?>