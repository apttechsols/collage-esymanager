<?php
	// Not show any error
	error_reporting(0);
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
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file
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
	require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	/*-------------- Apt Library -----------------------*/
    require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
    
	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	
	$CurrentTime = time();

	$GetOpenRequestError = False;
	$StoreWardenUrlData = array();

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
		$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
		if($ResponseCheckServiceBuyStatus['status'] == 'Success' && $ResponseCheckServiceBuyStatus['code'] == 200 && $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] == True){
			$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
			if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
				$DbConnection = $DbConnection['msg'];
				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
				if($ServiceMemberData['status'] === 'Success' && $ServiceMemberData['code'] === 200){
					$GetOpenRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Open::,::RequestFrom::::".$ResponseLogin['msg']['UserUrl'], 'FetchData'=>'RequestTime::::Venue::::RequestReason::::RequestOutGoingTime::::GuardianPermission::::GuardianPermissionTime::::WardenPermission::::WardenPermissionTime::::RequestId::::SettingValue', 'DbCon'=> $DbConnection, 'TbName'=> $ResponseLogin['LFR'].'_request_store', 'EPass'=> $EncodeAndEncryptPass,'FetchRowNo'=>'All']);
					
					$GetApproveRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Approve::,::RequestFrom::::".$ResponseLogin['msg']['UserUrl'], 'FetchData'=>'WardenPermission::::RequestId::::WardenPermissionTime::::WardenUrl::::RequestTime::::Venue::::RequestReason::::RequestOutGoingTime::::GuardianPermission::::GuardianPermissionTime::::OutGoingStatus::::ExactOutGoingTime::::InComingStatus::::SettingValue', 'DbCon'=> $DbConnection, 'TbName'=> $ResponseLogin['LFR'].'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DataOrder'=> 'DESC|RequestOutGoingTime']);

					if($GetApproveRequest['status'] === 'Success' && $GetApproveRequest['code'] === 200){
						foreach ($GetApproveRequest['msg'] as $key => $value) {
							if (!array_key_exists($value->WardenUrl,$StoreWardenUrlData) && $value->WardenUrl != ''){
								$FatchWardenDetais = FetchReuiredDataByGivenData("UserUrl::::".$value->WardenUrl,'Fullname::::Gender::::ProfileUrl',$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
								
								if($FatchWardenDetais['status'] === 'Success' && $FatchWardenDetais['code'] === 200){
									$StoreWardenUrlData[$value->WardenUrl] = $FatchWardenDetais['msg'];
								}else{
									$GetOpenRequestError = True;
								}
							}
						}
					}

					$GetClosedRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Closed::,::RequestFrom::::".$ResponseLogin['msg']['UserUrl'], 'FetchData'=>'WardenPermission::::WardenPermissionTime::::WardenUrl::::RequestTime::::Venue::::RequestReason::::RequestOutGoingTime::::GuardianPermission::::GuardianPermissionTime::::OutGoingStatus::::ExactOutGoingTime::::InComingStatus::::ExactInComingTime::::OutAndInComingDiff::::StatusReason', 'DbCon'=> $DbConnection, 'TbName'=> $ResponseLogin['LFR'].'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DataOrder'=> 'DESC|RequestOutGoingTime']);

					if($GetClosedRequest['status'] === 'Success' && $GetClosedRequest['code'] === 200){
						foreach ($GetClosedRequest['msg'] as $key => $value) {
							if (!array_key_exists($value->ResponseTime,$StoreWardenUrlData) && $value->WardenUrl != ''){
								$FatchWardenDetais = FetchReuiredDataByGivenData("UserUrl::::".$value->WardenUrl,'Fullname::::Gender::::ProfileUrl',$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
								if($FatchWardenDetais['status'] === 'Success' && $FatchWardenDetais['code'] === 200){
									$StoreWardenUrlData[$value->WardenUrl] = $FatchWardenDetais['msg'];
								}else{
									$GetOpenRequestError = True;
								}
							}
						}
					}
				}
			}
		}
	}
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetOpenRequest' && $SetVarKey != 'GetApproveRequest' && $SetVarKey != 'GetClosedRequest' && $SetVarKey != 'StoreWardenUrlData' && $SetVarKey != 'GetOpenRequestError' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 ) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}
	if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
	    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service setting not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	foreach ($GetServiceSetting['msg'] as $value){
		${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
	}

	foreach (explode(',', $GetServiceSettingSmsUpdatePermission) as $value) {
		$Temp =  explode('-', $value);
		${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
	}

	foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
		$Temp =  explode(':', $value);
		${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
	}

	$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
	if($LgUserServicePositionRank == ''){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	if($LgUserServicePositionRank != 0){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	/*if($ResponseCheckServiceBuyStatus['msg']['IsServiceActiveted'] != True){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service plan expired for this organization',true,['MSGpadding'=>'40vh 10px']); exit();
	}*/

	if($GetOpenRequest['code'] != 200 && $GetOpenRequest['code'] != 404){
		FullPageErrorMessageDisplay('Service Open request data not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($GetApproveRequest['code'] != 200 && $GetApproveRequest['code'] != 404){
		FullPageErrorMessageDisplay('Service Respond request data not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($GetClosedRequest['code'] != 200 && $GetClosedRequest['code'] != 404){
		FullPageErrorMessageDisplay('Service Rejected request data not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($GetOpenRequest['code'] != 200 && $GetApproveRequest['code'] != 200 && $GetClosedRequest['code'] != 200){
		if($GetOpenRequest['code'] == 400){
			FullPageErrorMessageDisplay('Open Request data not feched, due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
		}else if($GetApproveRequest['code'] == 400){
			FullPageErrorMessageDisplay('Approved Request data not feched, due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
		}else if($GetClosedRequest['code'] == 400){
			FullPageErrorMessageDisplay('Closed Request data not feched, due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
		}
		FullPageErrorMessageDisplay('Currently no requested created by you',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($GetOpenRequestError != False){
		FullPageErrorMessageDisplay('Warden data not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	/*------------------ Function Define ---------------------*/
	function ConvertToDayFromsec($seconds){
        $dt1 = new DateTime("@0");
        $dt2 = new DateTime("@$seconds");
        if($dt1->diff($dt2)->format('%a') == 0 && $dt1->diff($dt2)->format('%h') == 0){
        	return $dt1->diff($dt2)->format('%i Min : %s sec');
        }else if($dt1->diff($dt2)->format('%a') == 0){
        	return $dt1->diff($dt2)->format('%h Hour : %i Min : %s sec');
        }else{
        	return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
        }
    }

    // Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	
	$CurrentTime = time();

	define("PageTitle", "D GatePass : RESPONDER");
	define("CssFile", "RequestStatus");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class="Request_Main_Container">
			<p class="Request_Title">REQUEST STATUS</p>
			<div class="MainContainer">
				<div class="RequestBox">
					<?php
					if($GetOpenRequest['code'] == 200){
						foreach ($GetOpenRequest['msg'] as $key => $value) {  $TempSettingValue = unserialize($value->SettingValue);
							 ?>
							<div class = "RequestDetailsOpen" <?php if($value->ResponseTime == ''){ ?> id='RequestDetailsOpen-Type2' <?php } ?> style='background: #424216;'>
								<div class="StatusBox">
									<p>Status</p><p>Open</p>
								</div>
								<div class="RequestTimeBox">
									<p>RequestTime</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestTime); ?></p>
								</div>
								<div class="VenueBox">
									<p>Venue</p><p><?php echo $value->Venue ?></p>
								</div>
								<div class="RequestReasonseBox">
									<p>Reason</p><p><?php echo $value->RequestReason ?></p>
								</div>
								<div class="OutGoingTimeBox">
									<p>OutGoing Time</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestOutGoingTime); ?></p>
								</div>
								<div class="GuardianPermissionBox">
									<p>Guardian Permission</p><p><?php echo $value->GuardianPermission; ?></p>
								</div>
								<?php
								if($value->GuardianPermission != 'NotNeeded' && $TempSettingValue['GuardianOrParentNo'] != ''){ ?>
									<div class="GuardianPermissionBox">
										<p><?php echo $TempSettingValue['GuardianOrParentType']; ?> Number</p><p><?php echo $TempSettingValue['GuardianOrParentNo']; ?></p>
									</div>
								<?php } ?>
								<?php if(($value->GuardianPermission == 'Approve')){ ?>
									<div class="GuardianPermissionTimeBox">
										<p>Guardian Permission Time</p><p><?php echo date('d-M-Y, h:i:s A',$value->GuardianPermissionTime); ?></p>
									</div>
								<?php } ?>
								<div class="WardenPermissionBox">
									<p>Warden Permission</p><p><?php echo $value->WardenPermission; ?></p>
								</div>
								<?php if(($value->WardenPermission == 'Approve')){ ?>
									<div class="WardenPermissionTimeBox">
										<p>Warden Permission Time</p><p><?php echo date('d-M-Y, h:i:s A',$value->WardenPermissionTime); ?></p>
									</div>
								<?php } ?>
							</div>
							<?php if(($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded') || ($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded')){ ?>
								<div class = "RequestResponseBox-2">
									<?php if($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded'){ ?>
										<div class="MaxTimeWaitForApproveOrRejectPermissionFromAll">
											<p>Max Approval Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll']).' ('.ConvertToDayFromsec($TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] - $value->RequestTime).')'; ?></p>
										</div>
										<div class="MaxOutGoingTime">
											<p>Max OutGoing Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['StMaxOutGoingTime']).' ('.ConvertToDayFromsec($TempSettingValue['StMaxOutGoingTime'] - $value->RequestOutGoingTime).')'; ?></p>
										</div>
									<?php } ?>
									<?php if($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded'){ ?>
										<div class="StMaxInComingTime">
											<p>Max InComing Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['StMaxInComingTime']).' ('.ConvertToDayFromsec($TempSettingValue['StMaxInComingTime'] - $value->RequestOutGoingTime).')'; ?></p>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
							<?php
								if($TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] != 'NotNeeded' && $TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] < $CurrentTime){
									if($TempSettingValue['MaxTimeWaitForApproveOrRejectPermissionFromAll'] - $value->RequestTime >= 900){
										$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = true;
									}else{
										$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = false;
									}
								}else{
									$CheckMaxTimeWaitForApproveOrRejectPermissionFromAll = false;
								}

								if($TempSettingValue['StMaxOutGoingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxOutGoingTime'] < $CurrentTime){
										$CheckStMaxOutGoingTime = true;
									}else{
										$CheckStMaxOutGoingTime = false;
									}
								}else{
									$CheckStMaxOutGoingTime = false;
								}

								if($TempSettingValue['StMaxInComingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxInComingTime'] < $CurrentTime){
										$CheckStMaxInComingTime = true;
									}else{
										$CheckStMaxInComingTime = false;
									}
								}else{
									$CheckStMaxInComingTime = false;
								}
								
								if($CheckMaxTimeWaitForApproveOrRejectPermissionFromAll == true){
									if($value->GuardianPermission != 'Approve' && $value->GuardianPermission != 'NotNeeded'){
										echo "<div id='$value->RequestId' class='NoticeBord' style='color:#fff'>
											<p>Note - Don,t warry! It will be closed autometic when you create new request. It is expired because your parent not respond on your request!</p>
										</div>";
									}else if($value->WardenPermission != 'Approve' && $value->WardenPermission != 'NotNeeded'){
										echo "<div id='$value->RequestId' class='NoticeBord' style='color:yellow;'>
											<p>Note - Don,t warry! It will be closed autometic when you create new request. It is expired because warden not respond on your request! You can also report it to manager of D GatePass</p>
										</div>";
									}else{
										echo "<div id='$value->RequestId' class='NoticeBord' style='color:#fff;'>
											<p>Note - Don,t warry! It will be closed autometic when you create new request, we can not find reason you can report it!</p>
										</div>";
									}
								}else if($CheckStMaxOutGoingTime == true){
									echo "<div id='$value->RequestId' class='NoticeBord' style='color:#fff;'>
										<p>Note - Don,t warry! It will be closed autometic when you create new request</p>
									</div>";
								}else if($CheckStMaxInComingTime == true){
									echo "<div id='$value->RequestId' class='NoticeBord' style='color:#fff;'>
										<p>Note - Don,t warry! It will be closed autometic when you create new request</p>
									</div>";
								}

							?>
					<?php } }
					if($GetApproveRequest['code'] == 200){
						foreach ($GetApproveRequest['msg'] as $key => $value) { $TempStoreWardenUrlData = $StoreWardenUrlData[$value->WardenUrl]; $TempSettingValue = unserialize($value->SettingValue); ?>
							<div class = "RequestDetailsOpen" <?php if($value->ResponseTime == ''){ ?> id='RequestDetailsOpen-Type2' <?php } ?> style='background: green;'>
								<div class="StatusBox">
									<p>Status</p><p>Approve</p>
								</div>
								<div class="RequestTimeBox">
									<p>RequestTime</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestTime); ?></p>
								</div>
								<div class="VenueBox">
									<p>Venue</p><p><?php echo $value->Venue ?></p>
								</div>
								<div class="RequestReasonseBox">
									<p>Reason</p><p><?php echo $value->RequestReason ?></p>
								</div>
								<div class="OutGoingTimeBox">
									<p>OutGoing Time</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestOutGoingTime); ?></p>
								</div>
								<div class="GuardianPermissionBox">
									<p>Guardian Permission</p><p><?php echo $value->GuardianPermission; ?></p>
								</div>
								<?php
								if($value->GuardianPermissionTime != ''){
									echo "<div class='GuardianPermissionTimeBox'>
											<p>Guardian Permission Time</p><p> ". date("d-M-Y h:i:s A",$value->GuardianPermissionTime) ."</p>
										</div>";
								}
								
								if($value->WardenUrl != ''){ ?>
									<div class="ProfileImageBox">
									    <p>Warden Profile</p>
										<img class="ProfileImage" src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$TempStoreWardenUrlData->ProfileUrl; ?>"/>
									</div>
									<div class="FullNameBox">
										<p>Warden Name</p><p><?php echo $TempStoreWardenUrlData->Fullname; ?></p>
									</div>
									<div class="GenderBox">
										<p>Warden Gender</p><p><?php echo $TempStoreWardenUrlData->Gender; ?></p>
									</div>
								<?php } ?>
								<div class="ResponseTimeBox">
									<p>Warden Permission</p><p><?php echo $value->WardenPermission; ?></p>
								</div>
								<div class="ResponseTimeBox">
									<p>Warden Respond Time</p><p><?php echo date("d-M-Y, h:i:s A",$value->WardenPermissionTime); ?></p>
								</div>
							<?php if($value->OutGoingStatus != ''){ ?>
								<div class="OutGoingStatusBox">
									<p>OutGoing Status</p><p><?php echo $value->OutGoingStatus; ?></p>
								</div>
							<?php } if($value->ExactOutGoingTime != ''){ ?>
								<div class="ExactOutGoingTimeBox">
									<p>Exact OutGoing Time</p><p><?php echo date("d-M-Y, h:i:s A",$value->ExactOutGoingTime); ?></p>
								</div>
							<?php } ?>
							<?php if($value->InComingStatus != ''){ ?>
								<div class="OutGoingStatusBox">
									<p>InComing Status</p><p><?php echo $value->InComingStatus; ?></p>
								</div>
							<?php } ?>
							<?php if(file_exists(RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/'.$ResponseLogin['LFR'].'/'.$value->RequestId.'.png')){ ?>
								<div class="QrCodeBox">
									<p>Qr Code</p><img class="QrImage" src="<?php echo RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/'.$ResponseLogin['LFR'].'/'.$value->RequestId.'.png' ?>"/>
								</div>
							<?php } ?>
							</div>
							<?php if(($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded') || ($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded')){ ?>
								<div class = "RequestResponseBox-2"  <?php if(($value->OutGoingStatus == 'Approve' || $value->OutGoingStatus == 'NotNeeded') && ($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded')){ echo "style='grid-template-columns: 1fr'"; } ?>>
									<?php if($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded'){ ?>
										<div class="MinOutGoingTime">
											<p>Min OutGoing Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['StMinOutGoingTime']); ?></p>
										</div>
										<div class="MaxOutGoingTime">
											<p>Max OutGoing Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['StMaxOutGoingTime']).' ('.ConvertToDayFromsec($TempSettingValue['StMaxOutGoingTime'] - $value->RequestOutGoingTime).')'; ?></p>
										</div>
									<?php } ?>
									<?php if($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded'){ ?>
										<div class="StMaxInComingTime">
											<p>Max InComing Time</p><p><?php echo date('d-M-Y, h:i:s A',$TempSettingValue['StMaxInComingTime']).' ('.ConvertToDayFromsec($TempSettingValue['StMaxInComingTime'] - $value->RequestOutGoingTime).')'; ?></p>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
							<?php
								if($TempSettingValue['StMaxOutGoingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxOutGoingTime'] < $CurrentTime){
										if($value->OutGoingStatus != 'Approve' && $value->OutGoingStatus != 'NotNeeded'){
											$CheckStMaxOutGoingTime = true;
										}else{
											$CheckStMaxOutGoingTime = false;
										}
									}else{
										$CheckStMaxOutGoingTime = false;
									}
								}else{
									$CheckStMaxOutGoingTime = false;
								}

								if($TempSettingValue['StMaxInComingTime'] != 'NotNeeded'){
									if($TempSettingValue['StMaxInComingTime'] < $CurrentTime){
										if($value->InComingStatus != 'Approve' && $value->InComingStatus != 'NotNeeded'){
											$CheckStMaxInComingTime = true;
										}else{
											$CheckStMaxInComingTime = false;
										}
									}else{
										$CheckStMaxInComingTime = false;
									}
								}else{
									$CheckStMaxInComingTime = false;
								}

								if($CheckStMaxOutGoingTime == true){
									echo "<div id='$value->RequestId' class='NoticeBord'>
										<p>Note - Don,t warry! It will be closed autometic when you create new request</p>
									</div>";
								}else if($CheckStMaxInComingTime == true){
									echo "<div id='$value->RequestId' class='NoticeBord' style='color:red;'>
										<p>Warning - Your InComing time expire! Only manager of D GatePass can close it</p>
									</div>";
								}
							?>
					<?php } }
					if($GetClosedRequest['code'] == 200){
						 foreach ($GetClosedRequest['msg'] as $key => $value) { $TempStoreWardenUrlData = $StoreWardenUrlData[$value->WardenUrl]; ?>
							<div class = "RequestDetailsOpen" <?php if($value->ResponseTime == ''){ ?> id='RequestDetailsOpen-Type2' <?php } if ($value->WardenPermission == 'Reject' || $value->GuardianPermission == 'Reject'){echo "style='background: red;'";}else if(($value->WardenPermission == 'Approve' || $value->WardenPermission == 'NotNeeded') && ($value->GuardianPermission == 'Approve' || $value->GuardianPermission == 'NotNeeded')){echo "style='background: green;'";}else{echo "style='background: #6a6a6a;'";} ?> >
								<div class="StatusBox">
									<p>Status</p><p>Closed</p>
								</div>
								<div class="RequestTimeBox">
									<p>RequestTime</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestTime); ?></p>
								</div>
								<div class="VenueBox">
									<p>Venue</p><p><?php echo $value->Venue ?></p>
								</div>
								<div class="RequestReasonseBox">
									<p>Reason</p><p><?php echo $value->RequestReason ?></p>
								</div>
								<div class="OutGoingTimeBox">
									<p>OutGoing Time</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestOutGoingTime); ?></p>
								</div>
								<div class="GuardianPermissionBox">
									<p>Guardian Permission</p><p><?php echo $value->GuardianPermission; ?></p>
								</div>
								<?php
								if($value->GuardianPermissionTime != ''){
									echo "<div class='GuardianPermissionTimeBox'>
											<p>Guardian Permission Time</p><p>". date('d-M-Y h:i:s A',$value->GuardianPermissionTime)."</p>
										</div>";
								}
								
								if($value->WardenUrl != ''){ ?>
									<div class="ProfileImageBox">
									    <p>Warden Profile</p>
										<img class="ProfileImage" src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$TempStoreWardenUrlData->ProfileUrl; ?>"/>
									</div>
									<div class="FullNameBox">
										<p>Warden Name</p><p><?php echo $TempStoreWardenUrlData->Fullname; ?></p>
									</div>
									<div class="GenderBox">
										<p>Warden Gender</p><p><?php echo $TempStoreWardenUrlData->Gender; ?></p>
									</div>
								<?php }
									echo "<div class='ResponseTimeBox'>
											<p>Warden Permission</p><p>$value->WardenPermission</p>
										</div>";
									if($value->WardenPermissionTime != ''){
										echo "<div class='ResponseTimeBox'>
												<p>Warden Respond Time</p><p>".date("d-M-Y, h:i:s A",$value->WardenPermissionTime)."</p>
											</div>";
									}
								if(($value->WardenPermission == 'NotNeeded' || $value->WardenPermission == 'Approve') && ($value->GuardianPermission == 'NotNeeded' || $value->GuardianPermission == 'Approve')){

									echo "<div class='OutGoingStatusBox'>
										<p>OutGoing Status</p><p>$value->OutGoingStatus</p>
									</div>";

									if($value->OutGoingStatus == 'Approve'){
										echo "<div class='ExactOutGoingTimeBox'>
												<p>Exact OutGoing Time</p><p>". date('d-M-Y h:i:s A',$value->ExactOutGoingTime)."</p>
											</div>";
									}

									echo "<div class='InComingStatusBox'>
										<p>InComing Status</p><p>$value->InComingStatus</p>
									</div>";

									if($value->InComingStatus == 'Approve'){
										echo "<div class='ExactInComingTimeBox'>
												<p>Exact InComing Time</p><p>". date('d-M-Y h:i:s A',$value->ExactInComingTime)."</p>
											</div>";
									}

									if($value->OutAndInComingDiff != ''){
										echo "<div class='OutAndInComingDiffBox'>
												<p>Out And InComing Diff</p><p>". ConvertToDayFromsec($value->OutAndInComingDiff)."</p>
											</div>";
									}
								}
								?>
							</div>
							<?php
							if($value->StatusReason != ''){
								$TempStatusReason = unserialize($value->StatusReason);
								if($TempStatusReason['code'] == 11 || $TempStatusReason['code'] == 13 || $TempStatusReason['code'] == 14 || $TempStatusReason['code'] == 15 || $TempStatusReason['code'] == 16){
									$TempNoticeBordColorForStatusReason = 'color:#fff';
								}else if($TempStatusReason['code'] == 12){
									$TempNoticeBordColorForStatusReason = 'color:yellow';
								}else if($TempStatusReason['code'] == 101){
									$TempNoticeBordColorForStatusReason = 'color:red';
								}else{
									$TempNoticeBordColorForStatusReason = 'color:#11cdef';
								}
								echo "<div class='NoticeBord' style=$TempNoticeBordColorForStatusReason >
									<p>".$TempStatusReason['msg']."</p>
								</div>";
							}
							?>
					<?php } }
					?>
				</div>
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){
	});
</script>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>