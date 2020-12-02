<?php
	/*
	*@FileName Setting/index.php
	*@Des Search members of organitaion and perform task for Hostal Digital Gate Pass Service
	*@Author Ankit Sharma
	*/
?>
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
	require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	
	$CurrentTime = time();

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
		$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
		if($ResponseCheckServiceBuyStatus['status'] == 'Success' && $ResponseCheckServiceBuyStatus['code'] == 200 && $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] == True){
			$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
			if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
				$DbConnection = $DbConnection['msg'];

				$GetDataOfServiceSetting = FetchReuiredDataByGivenData("Position::::NULL::,::SettingKeyUnique::::NULL",'Position::::PositionRank::::SettingKeyUnique::::SettingValue',$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'NotEqualAny',NULL,'all');

				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::GroupSetting::,::SettingKeyUnique::::ServiceActiveSchedule::,::SettingKeyUnique::::SmsUpdatePermission::,::SettingKeyUnique::::GeneralSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
			}
		}
	}


	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetDataOfServiceSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}else{
		if($ResponseRank != 1 && $ResponseRank != 2){
				$CheckManager = True;
		}
	}

	if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200){
		return_response('Some Error occur for this service! Please try again later 1.2');
	}

	if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	/*if($ResponseCheckServiceBuyStatus['msg']['IsServiceActiveted'] != True){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service plan expired for this organization',true,['MSGpadding'=>'40vh 10px']); exit();
	}
*/
	if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
	    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service setting not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	foreach ($GetServiceSetting['msg'] as $value){
		${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
	}

	foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
		$Temp =  explode(':', $value);
		${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
	}

	$TempGetServiceSettingSmsUpdatePermission = explode(',', $GetServiceSettingSmsUpdatePermission);
	foreach ($TempGetServiceSettingSmsUpdatePermission as $value) {
		$Temp =  explode('-', $value);
		${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
	}
	
	if($GetServiceSettingServiceActiveSchedule != 'always' && $GetServiceSettingServiceActiveSchedule != 'never'){
		$TempGetServiceSettingServiceActiveSchedule = 'Custom';
		$Temp = explode('-', $GetServiceSettingServiceActiveSchedule);
		$TempStartTime = explode('_', $Temp[0]);
		$TempStartTimeHour = $TempStartTime[0];
		$TempStartTimeMin = $TempStartTime[1];
		$TempEndTime = explode('_', $Temp[1]);
		$TempEndTimeHour = $TempEndTime[0];
		$TempEndTimeMin = $TempEndTime[1];
		$TempGetServiceSettingServiceActiveScheduleCustomStartHour = $TempStartTimeHour;
		$TempGetServiceSettingServiceActiveScheduleCustomStartMin = $TempStartTimeMin;
		$TempGetServiceSettingServiceActiveScheduleCustomEndHour = $TempEndTimeHour;
		$TempGetServiceSettingServiceActiveScheduleCustomEndMin = $TempEndTimeMin;
	}else{
		$TempGetServiceSettingServiceActiveSchedule = $GetServiceSettingServiceActiveSchedule;
		$TempGetServiceSettingServiceActiveScheduleCustomStartHour = '00';
		$TempGetServiceSettingServiceActiveScheduleCustomStartMin = '00';
		$TempGetServiceSettingServiceActiveScheduleCustomEndHour = '00';
		$TempGetServiceSettingServiceActiveScheduleCustomEndMin = '00';
	}
	
	if($GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual != 'always' && $GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual != 'never'){
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = 'Custom';
		$Temp = explode('-', $GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual);
		$TempStartTime = explode('_', $Temp[0]);
		$TempStartTimeHour = $TempStartTime[0];
		$TempStartTimeMin = $TempStartTime[1];
		$TempEndTime = explode('_', $Temp[1]);
		$TempEndTimeHour = $TempEndTime[0];
		$TempEndTimeMin = $TempEndTime[1];
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartHour = $TempStartTimeHour;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartMin = $TempStartTimeMin;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndHour = $TempEndTimeHour;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndMin = $TempEndTimeMin;
	}else{
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual = $GetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartHour = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartMin = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndHour = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndMin = '00';
	}

	if($GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual != 'always' && $GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual != 'never'){
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = 'Custom';
		$Temp = explode('-', $GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual);
		$TempStartTime = explode('_', $Temp[0]);
		$TempStartTimeHour = $TempStartTime[0];
		$TempStartTimeMin = $TempStartTime[1];
		$TempEndTime = explode('_', $Temp[1]);
		$TempEndTimeHour = $TempEndTime[0];
		$TempEndTimeMin = $TempEndTime[1];
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartHour = $TempStartTimeHour;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartMin = $TempStartTimeMin;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndHour = $TempEndTimeHour;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndMin = $TempEndTimeMin;
	}else{
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual = $GetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual;
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartHour = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartMin = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndHour = '00';
		$TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndMin = '00';
	}

	if($GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual != 'always' && $GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual != 'never'){
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = 'Custom';
		$Temp = explode('-', $GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual);
		$TempStartTime = explode('_', $Temp[0]);
		$TempStartTimeHour = $TempStartTime[0];
		$TempStartTimeMin = $TempStartTime[1];
		$TempEndTime = explode('_', $Temp[1]);
		$TempEndTimeHour = $TempEndTime[0];
		$TempEndTimeMin = $TempEndTime[1];
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartHour = $TempStartTimeHour;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartMin = $TempStartTimeMin;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndHour = $TempEndTimeHour;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndMin = $TempEndTimeMin;
	}else{
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual = $GetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartHour = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartMin = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndHour = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndMin = '00';
	}

	if($GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual != 'always' && $GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual != 'never'){
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = 'Custom';
		$Temp = explode('-', $GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual);
		$TempStartTime = explode('_', $Temp[0]);
		$TempStartTimeHour = $TempStartTime[0];
		$TempStartTimeMin = $TempStartTime[1];
		$TempEndTime = explode('_', $Temp[1]);
		$TempEndTimeHour = $TempEndTime[0];
		$TempEndTimeMin = $TempEndTime[1];
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartHour = $TempStartTimeHour;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartMin = $TempStartTimeMin;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndHour = $TempEndTimeHour;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndMin = $TempEndTimeMin;
	}else{
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual = $GetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual;
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartHour = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartMin = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndHour = '00';
		$TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndMin = '00';
	}

	$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTypeAndTime = explode('*', $GetServiceSettingGeneralSettingMaxTimeWaitForOutGoing);
	if($TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTypeAndTime[0] == 'For'){
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTypeAndTime[1];
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour = '00';
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin = '00';
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour = '00';
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin = '00';
	}else{
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTimeArray = explode('-', $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTypeAndTime[1]);
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeArray = explode('_', $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTimeArray[0]);
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeArray[0];
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeArray[1];

		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeArray = explode('_', $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTimeArray[1]);
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeArray[0];
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin = $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeArray[1];
		$TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime = '3600';
	}

	$GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff = explode('-', $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff);
	$GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff = explode('-', $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff);

	define("PageTitle", "D GatePass : Setting");
	define("CssFile", "Setting");
	require_once RootPath."Site_Header/index.php";
?>
	<body class='No_Select_Strat'>
		<div class='PageTitle'>D GatePass : Setting</div>
		<div class = "Container">
			<div class='SettingnBox'>
				<div class="SmsPermissionBox">
					<div class='SettingName'>Sms Send To</div>
					<div class='SettingBox-1' style='display: none;'>
						<span class='SettingName-1'>Warden</span>
						<select class="SmsUpdatePermissionWardenSmsUpdate">
							<option value='No'>No</option>
							<option value='Yes'>Yes</option>
							<option value='Optional'>Optional</option>
						</select>
					</div>
					<div class='SettingBox-1'>
						<span class='SettingName-1'>Guardian OutGoing</span>
						<select class="SmsUpdatePermissionGuardianOutGoingSmsUpdate">
							<option value='No'>No</option>
							<option value='Yes'>Yes</option>
							<option value='Optional'>Optional</option>
						</select>
					</div>
					<div class='SettingBox-1'>
						<span class='SettingName-1'>Guardian InComing</span>
						<select class="SmsUpdatePermissionGuardianInComingSmsUpdate">
							<option value='No'>No</option>
							<option value='Optional'>Optional</option>
						</select>
					</div>
					<div class='SettingBox-1' style='display: none;'>
						<span class='SettingName-1'>Student</span>
						<select class="SmsUpdatePermissionUserSmsUpdate">
							<option value='No'>No</option>
							<option value='Optional'>Optional</option>
						</select>
					</div>
				</div>
				<div class='SmtBtn' id='SmsPermissionSmtBtn'>Update<span class="loader_round_main SmsPermissionSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="ServiceActiveScheduleBox">
					<div class='SettingName'>Service Schedule</div>
					<div class='SettingBox-1'>
						<span class='SettingName-1'>Selected : </span>
						<select class="ServiceActiveSchedule">
							<option value='always'>always</option>
							<option value='Custom'>Custom</option>
							<option value='never'>never</option>
						</select>
						<span class="SettingName-1 Custom-1" style="margin: 18px 0px;">Start Time</span>
						<div type="text" class='ServiceActiveScheduleTime Custom-1' style="display: none;">
							<select class='ServiceActiveScheduleStartTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
							<?php
								for($i=0; $i<=23; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
							?>
							</select>
							<select class='ServiceActiveScheduleStartTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
							<?php
								for($i=0; $i<=59; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
							?>
							</select>
						</div>
						<span class="SettingName-1 Custom-1" style="margin: 18px 0px;">End Time</span>
						<div type="text" class='ServiceActiveScheduleTime Custom-1' style="display: none;">
							<select class='ServiceActiveScheduleEndTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
							<?php
								for($i=0; $i<=23; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
							?>
							</select>
							<select class='ServiceActiveScheduleEndTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
							<?php
								for($i=0; $i<=59; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
							?>
							</select>
						</div>
					</div>
				</div>
				<div class='SmtBtn' id='ServiceActiveScheduleSmtBtn'>Update<span class="loader_round_main ServiceActiveScheduleSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox GenralSettingBox'>
				<div class="GeneralSettingBox">
					<div class='SettingName GenralSettingTl'>General Setting</div>
					<div class='GenralSetting'>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Minimum Time To Req Again</div>
							<div class='GenralSetting-123'>
								<input type="number" class='MinTimeToSubmitRequestAgainTime' placeholder='Enter Time'/>
								<select class="MinTimeToSubmitRequestAgainTimeType">
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Min Time Difference For OutGoing</div>
							<div class='GenralSetting-123'>
								<input type="number" class='MinRequestSubmitAndOutGoingTimeDiffTime' placeholder='Enter Time'/>
								<select class="MinRequestSubmitAndOutGoingTimeDiffTimeType">
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Max Time Difference For OutGoing</div>
							<div class='GenralSetting-123'>
								<input type="number" class='MaxRequestSubmitAndOutGoingTimeDiffTime' placeholder='Enter Time'/>
								<select class="MaxRequestSubmitAndOutGoingTimeDiffTimeType">
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Max Time Wait For Approve Or Reject Of Guradian Or Warden</div>
							<div class='GenralSetting-123'>
								<input type="number" class='MaxTimeWaitForApproveOrRejectPermissionFromAllTime' placeholder='Enter Time'/>
								<select class="MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType">
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>InComing Time Track</div>
							<div class='GenralSetting-123'>
								<select class="InComingTimeTrack">
									<option value='Yes'>Yes</option>
									<option value='No'>No</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>OutGoing Time Track</div>
							<div class='GenralSetting-123'>
								<select class="OutGoingTimeTrack">
									<option value='Yes'>Yes</option>
									<option value='No'>No</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Max Wait Time For OutGoing</div>
							<div class='GenralSetting-123' style='color: #fff;font-weight: bold;'>
								<select class="MaxTimeWaitForOutGoingForOrUntil">
									<option value='For'>For</option>
									<option value='Until'>Until</option>
								</select>
								<input type="number" class='MaxTimeWaitForOutGoingForTime' placeholder='Enter Time'/>
								<select class="MaxTimeWaitForOutGoingForTimeType">
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
								<select class='MaxTimeWaitForOutGoingUntilStartTimeHour' style='height: 25px; color: #726a6a;display: none;'>
								<?php
									for($i=0; $i<=23; $i++){
										if($i < 10){
											echo "<option value='0$i'>0$i</option>";
										}else{
											echo "<option value='$i'>$i</option>";
										}
									}
								?>
								</select>
								<select class='MaxTimeWaitForOutGoingUntilStartTimeMin' style='height: 25px; color: #726a6a;display: none;'>
								<?php
									for($i=0; $i<=59; $i++){
										if($i < 10){
											echo "<option value='0$i'>0$i</option>";
										}else{
											echo "<option value='$i'>$i</option>";
										}
									}
								?>
								</select>
								-
								<select class='MaxTimeWaitForOutGoingUntilEndTimeHour' style='height: 25px; color: #726a6a;display: none;'>
								<?php
									for($i=0; $i<=23; $i++){
										if($i < 10){
											echo "<option value='0$i'>0$i</option>";
										}else{
											echo "<option value='$i'>$i</option>";
										}
									}
								?>
								</select>
								<select class='MaxTimeWaitForOutGoingUntilEndTimeMin' style='height: 25px; color: #726a6a;display: none;'>
								<?php
									for($i=0; $i<=59; $i++){
										if($i < 10){
											echo "<option value='0$i'>0$i</option>";
										}else{
											echo "<option value='$i'>$i</option>";
										}
									}
								?>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Student Create Multiple Request</div>
							<div class='GenralSetting-123'>
								<select class="StudentCreateMultipleRequest">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guardian Approval Needed</div>
							<div class='GenralSetting-123'>
								<select class="GuardianPermissionApprovalNeeded">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Warden Approval Needed</div>
							<div class='GenralSetting-123'>
								<select class="WardenPermissionApprovalNeeded">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guradian Approval Needed OutGoing Shedual</div>
							<div class='GenralSetting-123A'>
								<select class="GuradianPermissionNeededOutGoingShedual">
									<option value='never'>never</option>
									<option value='always'>always</option>
									<option value='Custom'>Custom</option>
								</select>
								<div class='GenralSetting-1234'>
									<span class="SettingName-1 Custom-2 Custom-21" style="margin: 18px 0px;">Start Time</span>
									<div type="text" class='GuradianPermissionNeededOutGoingShedualTime Custom-2 Custom-21' style="display: none;">
										<select class='GuradianPermissionNeededOutGoingShedualStartTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='GuradianPermissionNeededOutGoingShedualStartTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
									<span class="SettingName-1 Custom-2 Custom-21" style="margin: 18px 0px;">End Time</span>
									<div type="text" class='GuradianPermissionNeededOutGoingShedualTime Custom-2 Custom-21' style="display: none;">
										<select class='GuradianPermissionNeededOutGoingShedualEndTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='GuradianPermissionNeededOutGoingShedualEndTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guradian Approval Needed InComing Shedual</div>
							<div class='GenralSetting-123A'>
								<select class="GuradianPermissionNeededInComingShedual">
									<option value='never'>never</option>
									<option value='always'>always</option>
									<option value='Custom'>Custom</option>
								</select>
								<div class='GenralSetting-1234'>
									<span class="SettingName-1 Custom-2 Custom-31" style="margin: 18px 0px;">Start Time</span>
									<div type="text" class='GuradianPermissionNeededInComingShedualTime Custom-2 Custom-31' style="display: none;">
										<select class='GuradianPermissionNeededInComingShedualStartTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='GuradianPermissionNeededInComingShedualStartTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
									<span class="SettingName-1 Custom-2 Custom-31" style="margin: 18px 0px;">End Time</span>
									<div type="text" class='GuradianPermissionNeededInComingShedualTime Custom-2 Custom-31' style="display: none;">
										<select class='GuradianPermissionNeededInComingShedualEndTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='GuradianPermissionNeededInComingShedualEndTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Warden Approval Needed OutGoing Shedual</div>
							<div class='GenralSetting-123A'>
								<select class="WardenPermissionNeededOutGoingShedual">
									<option value='never'>never</option>
									<option value='always'>always</option>
									<option value='Custom'>Custom</option>
								</select>
								<div class='GenralSetting-1234'>
									<span class="SettingName-1 Custom-2 Custom-22" style="margin: 18px 0px;">Start Time</span>
									<div type="text" class='WardenPermissionNeededOutGoingShedualTime Custom-2 Custom-22' style="display: none;">
										<select class='WardenPermissionNeededOutGoingShedualStartTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='WardenPermissionNeededOutGoingShedualStartTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
									<span class="SettingName-1 Custom-2 Custom-22" style="margin: 18px 0px;">End Time</span>
									<div type="text" class='WardenPermissionNeededOutGoingShedualTime Custom-2 Custom-22' style="display: none;">
										<select class='WardenPermissionNeededOutGoingShedualEndTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='WardenPermissionNeededOutGoingShedualEndTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Warden Approval Needed InComing Shedual</div>
							<div class='GenralSetting-123A'>
								<select class="WardenPermissionNeededInComingShedual">
									<option value='never'>never</option>
									<option value='always'>always</option>
									<option value='Custom'>Custom</option>
								</select>
								<div class='GenralSetting-1234'>
									<span class="SettingName-1 Custom-2 Custom-32" style="margin: 18px 0px;">Start Time</span>
									<div type="text" class='WardenPermissionNeededInComingShedualTime Custom-2 Custom-32' style="display: none;">
										<select class='WardenPermissionNeededInComingShedualStartTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='WardenPermissionNeededInComingShedualStartTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
									<span class="SettingName-1 Custom-2 Custom-32" style="margin: 18px 0px;">End Time</span>
									<div type="text" class='WardenPermissionNeededInComingShedualTime Custom-2 Custom-32' style="display: none;">
										<select class='WardenPermissionNeededInComingShedualEndTimeHour' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=23; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
										<select class='WardenPermissionNeededInComingShedualEndTimeMin' style='height: 25px; margin: 15px 0px; color: #726a6a;'>
										<?php
											for($i=0; $i<=59; $i++){
												if($i < 10){
													echo "<option value='0$i'>0$i</option>";
												}else{
													echo "<option value='$i'>$i</option>";
												}
											}
										?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guradian Permission Needed By OutGoing And InComing Time Diff</div>
							<div class='GenralSetting-123'>
								<select class="GuradianPermissionNeededByOutGoingAndInComingTimeDiff">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
								<input type="number" class='GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime' placeholder='Enter Time' style='display: none;'/>
								<select class="GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType" style='display: none;'>
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Warden Permission Needed By OutGoing And InComing Time Diff</div>
							<div class='GenralSetting-123'>
								<select class="WardenPermissionNeededByOutGoingAndInComingTimeDiff">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
								<input type="number" class='WardenPermissionNeededByOutGoingAndInComingTimeDiffTime' placeholder='Enter Time' style='display: none;'/>
								<select class="WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType" style='display: none;'>
									<option value='Hour'>Hour</option>
									<option value='Minute'>Minute</option>
									<option value='Second'>Second</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guradian Permission When OutGoing And InComing Date Diff</div>
							<div class='GenralSetting-123'>
								<select class="GuradianPermissionNeededByOutAndInDateDiff">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Warden Permission When OutGoing And InComing Date Diff</div>
							<div class='GenralSetting-123'>
								<select class="WardenPermissionNeededByOutAndInDateDiff">
									<option value='No'>No</option>
									<option value='Yes'>Yes</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Guardian Permission Priority</div>
							<div class='GenralSetting-123'>
								<select class="GuardianPermissionPriorityFor">
									<option value='Father'>Father</option>
									<option value='Guardian'>Guardian</option>
								</select>
							</div>
						</div>
						<div class='GenralSetting-1'>
							<div class='SettingName-12'>Blank</div>
							<div class='GenralSetting-123'>
								<select disabled='true'>
									<option value=''>Blank</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class='SmtBtn' id='GeneralSettingSmtBtn'>Update<span class="loader_round_main GeneralSettingSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
	<script>
		$(document).ready(function(){

			window.SubmitButton = false;
			$('.SmtBtn').click(function(){
				var GetId = this.id;
				if(window.SubmitButton == true){
					swal('','A process already in queue','warning'); return false;
				}

				SubmitStart();

				var client = new ClientJS();

				imprint.test(browserTests).then(function(result){
					var fingerprint_1 = new Fingerprint().get();
					var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
					audioFingerprint.run(function (fingerprint_2) {
						var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
						var d1 = new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX");
						

						var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

						// append data which we want to send data on targeted page
						var formdata = new FormData();
							
						if(GetId == 'SmsPermissionSmtBtn'){
							var SettingData = {'SmsUpdatePermissionWardenSmsUpdate':$('.SmsUpdatePermissionWardenSmsUpdate').val(),'SmsUpdatePermissionGuardianOutGoingSmsUpdate':$('.SmsUpdatePermissionGuardianOutGoingSmsUpdate').val(),'SmsUpdatePermissionGuardianInComingSmsUpdate':$('.SmsUpdatePermissionGuardianInComingSmsUpdate').val(),'SmsUpdatePermissionUserSmsUpdate':$('.SmsUpdatePermissionUserSmsUpdate').val()};
						}else if(GetId == 'ServiceActiveScheduleSmtBtn'){
							var SettingData = {'ServiceActiveSchedule':$('.ServiceActiveSchedule').val(),'ServiceActiveScheduleStartTimeHour':$('.ServiceActiveScheduleStartTimeHour').val(),'ServiceActiveScheduleStartTimeMin':$('.ServiceActiveScheduleStartTimeMin').val(),'ServiceActiveScheduleEndTimeHour':$('.ServiceActiveScheduleEndTimeHour').val(),'ServiceActiveScheduleEndTimeMin':$('.ServiceActiveScheduleEndTimeMin').val()};
						}else if(GetId == 'GeneralSettingSmtBtn'){
							var SettingData = {'MinTimeToSubmitRequestAgainTime':$('.MinTimeToSubmitRequestAgainTime').val(),'MinTimeToSubmitRequestAgainTimeType':$('.MinTimeToSubmitRequestAgainTimeType').val(),'MinRequestSubmitAndOutGoingTimeDiffTime':$('.MinRequestSubmitAndOutGoingTimeDiffTime').val(),'MinRequestSubmitAndOutGoingTimeDiffTimeType':$('.MinRequestSubmitAndOutGoingTimeDiffTimeType').val(),'MaxRequestSubmitAndOutGoingTimeDiffTime':$('.MaxRequestSubmitAndOutGoingTimeDiffTime').val(),'MaxRequestSubmitAndOutGoingTimeDiffTimeType':$('.MaxRequestSubmitAndOutGoingTimeDiffTimeType').val(),'MaxTimeWaitForApproveOrRejectPermissionFromAllTime':$('.MaxTimeWaitForApproveOrRejectPermissionFromAllTime').val(),'MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType':$('.MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType').val(),'GuardianPermissionApprovalNeeded':$('.GuardianPermissionApprovalNeeded').val(),'WardenPermissionApprovalNeeded':$('.WardenPermissionApprovalNeeded').val(),'InComingTimeTrack':$('.InComingTimeTrack').val(),'OutGoingTimeTrack':$('.OutGoingTimeTrack').val(),'StudentCreateMultipleRequest':$('.StudentCreateMultipleRequest').val(),'GuradianPermissionNeededOutGoingShedual':$('.GuradianPermissionNeededOutGoingShedual').val(),'GuradianPermissionNeededOutGoingShedualStartTimeHour':$('.GuradianPermissionNeededOutGoingShedualStartTimeHour').val(),'GuradianPermissionNeededOutGoingShedualStartTimeMin':$('.GuradianPermissionNeededOutGoingShedualStartTimeMin').val(),'GuradianPermissionNeededOutGoingShedualEndTimeHour':$('.GuradianPermissionNeededOutGoingShedualEndTimeHour').val(),'GuradianPermissionNeededOutGoingShedualEndTimeMin':$('.GuradianPermissionNeededOutGoingShedualEndTimeMin').val(),'WardenPermissionNeededOutGoingShedual':$('.WardenPermissionNeededOutGoingShedual').val(),'WardenPermissionNeededOutGoingShedualStartTimeHour':$('.WardenPermissionNeededOutGoingShedualStartTimeHour').val(),'WardenPermissionNeededOutGoingShedualStartTimeMin':$('.WardenPermissionNeededOutGoingShedualStartTimeMin').val(),'WardenPermissionNeededOutGoingShedualEndTimeHour':$('.WardenPermissionNeededOutGoingShedualEndTimeHour').val(),'WardenPermissionNeededOutGoingShedualEndTimeMin':$('.WardenPermissionNeededOutGoingShedualEndTimeMin').val(),'MaxTimeWaitForOutGoingForOrUntil':$('.MaxTimeWaitForOutGoingForOrUntil').val(),'MaxTimeWaitForOutGoingForTime':$('.MaxTimeWaitForOutGoingForTime').val(),'MaxTimeWaitForOutGoingForTimeType':$('.MaxTimeWaitForOutGoingForTimeType').val(),'MaxTimeWaitForOutGoingUntilStartTimeHour':$('.MaxTimeWaitForOutGoingUntilStartTimeHour').val(),'MaxTimeWaitForOutGoingUntilStartTimeMin':$('.MaxTimeWaitForOutGoingUntilStartTimeMin').val(),'MaxTimeWaitForOutGoingUntilEndTimeHour':$('.MaxTimeWaitForOutGoingUntilEndTimeHour').val(),'MaxTimeWaitForOutGoingUntilEndTimeMin':$('.MaxTimeWaitForOutGoingUntilEndTimeMin').val(),'GuradianPermissionNeededInComingShedual':$('.GuradianPermissionNeededInComingShedual').val(),'GuradianPermissionNeededInComingShedualStartTimeHour':$('.GuradianPermissionNeededInComingShedualStartTimeHour').val(),'GuradianPermissionNeededInComingShedualStartTimeMin':$('.GuradianPermissionNeededInComingShedualStartTimeMin').val(),'GuradianPermissionNeededInComingShedualEndTimeHour':$('.GuradianPermissionNeededInComingShedualEndTimeHour').val(),'GuradianPermissionNeededInComingShedualEndTimeMin':$('.GuradianPermissionNeededInComingShedualEndTimeMin').val(),'WardenPermissionNeededOutGoingShedual':$('.WardenPermissionNeededOutGoingShedual').val(),'WardenPermissionNeededOutGoingShedualStartTimeHour':$('.WardenPermissionNeededOutGoingShedualStartTimeHour').val(),'WardenPermissionNeededOutGoingShedualStartTimeMin':$('.WardenPermissionNeededOutGoingShedualStartTimeMin').val(),'WardenPermissionNeededOutGoingShedualEndTimeHour':$('.WardenPermissionNeededOutGoingShedualEndTimeHour').val(),'WardenPermissionNeededOutGoingShedualEndTimeMin':$('.WardenPermissionNeededOutGoingShedualEndTimeMin').val(),'WardenPermissionNeededInComingShedual':$('.WardenPermissionNeededInComingShedual').val(),'WardenPermissionNeededInComingShedualStartTimeHour':$('.WardenPermissionNeededInComingShedualStartTimeHour').val(),'WardenPermissionNeededInComingShedualStartTimeMin':$('.WardenPermissionNeededInComingShedualStartTimeMin').val(),'WardenPermissionNeededInComingShedualEndTimeHour':$('.WardenPermissionNeededInComingShedualEndTimeHour').val(),'WardenPermissionNeededInComingShedualEndTimeMin':$('.WardenPermissionNeededInComingShedualEndTimeMin').val(),'GuradianPermissionNeededByOutGoingAndInComingTimeDiff':$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiff').val(),'GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime':$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime').val(),'GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType':$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType').val(),'WardenPermissionNeededByOutGoingAndInComingTimeDiff':$('.WardenPermissionNeededByOutGoingAndInComingTimeDiff').val(),'WardenPermissionNeededByOutGoingAndInComingTimeDiffTime':$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTime').val(),'WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType':$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType').val(),'GuradianPermissionNeededByOutAndInDateDiff':$('.GuradianPermissionNeededByOutAndInDateDiff').val(),'WardenPermissionNeededByOutAndInDateDiff':$('.WardenPermissionNeededByOutAndInDateDiff').val(),'GuardianPermissionPriorityFor':$('.GuardianPermissionPriorityFor').val()};

						}else{
							swal('','Invalid click detect','warning'); SubmitReset(); return false;
						}
						
						formdata.append('SettingData', JSON.stringify(SettingData));
						formdata.append('SettingId', GetId);
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						// Check Internet connection
						if(navigator.onLine == false){
							$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">It seems that you are offline. Please check your internet connection</div>')
							swal("It seems that you are offline. Please check your internet connection", "", "warning");
							$("#Signup_response").css("color","red");
							$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
							SubmitReset(); return false;
						}

						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",UpdateHandler,false);
							ajax.open("POST", 'UpdateSettingBackend.php');
							ajax.send(formdata);
						}catch(error){
							swal("",'Response can not sent Error('+error+')','error'); SubmitReset(); return false;
						}

						//function run on listion response from ajax
						function UpdateHandler(event){
							SubmitReset();
							var responce = $.parseJSON(event.target.responseText);
							if(responce['status'] === 'Success' && responce['code'] === 200){
								swal('Update',responce['msg'],'success')
								.then((value) => {
									window.location.reload();
								});
							}else if(responce['code'] === 404){
								swal('Update',responce['msg'],'warning');
							}else{
								swal('Update',responce['msg'],'error');
							}
							return false;
						}
					});
			    });
				
				function SubmitStart(){
					window.SubmitButton = true;
					$("input").prop("disabled",true);
					$("select").prop("disabled",true);
					$('.SmtBtn').css("pointer-events","none");
					$('#'+GetId).css("background","linear-gradient(skyblue, pink)");
					$(".SmtBtn").css("cursor","default");
					$('.'+GetId+"Loader").prop('hidden',false);
				}

				function SubmitReset(){
					$("input").prop("disabled",false);
					$("select").prop("disabled",false);
					$('.SmtBtn').css("pointer-events","auto");
					$('#'+GetId).css("background","green");
					$(".SmtBtn").css("cursor","pointer");
					$('.'+GetId+"Loader").prop('hidden',true);
					window.SubmitButton = false;
				}
			});

			$('.ServiceActiveSchedule').change(function(){
				if(this.value == 'Custom'){
					$('.Custom-1').css({'display':'block'});
					$('.ServiceActiveScheduleTime').css({'display':'grid'});
				}else{
					$('.Custom-1').css({'display':'none'});
				}
			});

			$('.MaxTimeWaitForOutGoingForOrUntil').change(function(){
				if(this.value == 'For'){
					$('.MaxTimeWaitForOutGoingUntilStartTimeHour').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingUntilStartTimeMin').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingUntilEndTimeHour').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingUntilEndTimeMin').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingForTime').css({'display':'block'});
					$('.MaxTimeWaitForOutGoingForTimeType').css({'display':'block'});
				}else{
					$('.MaxTimeWaitForOutGoingForTime').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingForTimeType').css({'display':'none'});
					$('.MaxTimeWaitForOutGoingUntilStartTimeHour').css({'display':'block'});
					$('.MaxTimeWaitForOutGoingUntilStartTimeMin').css({'display':'block'});
					$('.MaxTimeWaitForOutGoingUntilEndTimeHour').css({'display':'block'});
					$('.MaxTimeWaitForOutGoingUntilEndTimeMin').css({'display':'block'});
				}
			});

			$('.MaxTimeWaitForInComingForOrUntil').change(function(){
				if(this.value == 'For'){
					$('.MaxTimeWaitForInComingUntilStartTimeHour').css({'display':'none'});
					$('.MaxTimeWaitForInComingUntilStartTimeMin').css({'display':'none'});
					$('.MaxTimeWaitForInComingUntilEndTimeHour').css({'display':'none'});
					$('.MaxTimeWaitForInComingUntilEndTimeMin').css({'display':'none'});
					$('.MaxTimeWaitForInComingForTime').css({'display':'block'});
					$('.MaxTimeWaitForInComingForTimeType').css({'display':'block'});
				}else{
					$('.MaxTimeWaitForInComingForTime').css({'display':'none'});
					$('.MaxTimeWaitForInComingForTimeType').css({'display':'none'});
					$('.MaxTimeWaitForInComingUntilStartTimeHour').css({'display':'block'});
					$('.MaxTimeWaitForInComingUntilStartTimeMin').css({'display':'block'});
					$('.MaxTimeWaitForInComingUntilEndTimeHour').css({'display':'block'});
					$('.MaxTimeWaitForInComingUntilEndTimeMin').css({'display':'block'});
				}
			});

			$('.GuradianPermissionNeededOutGoingShedual').change(function(){
				if(this.value == 'Custom'){
					$('.Custom-21').css({'display':'block'});
					$('.GuradianPermissionNeededOutGoingShedualTime').css({'display':'grid','grid-template-columns': '1fr 1fr'});
				}else{
					$('.Custom-21').css({'display':'none'});
				}
			});

			$('.GuradianPermissionNeededInComingShedual').change(function(){
				if(this.value == 'Custom'){
					$('.Custom-31').css({'display':'block'});
					$('.GuradianPermissionNeededInComingShedualTime').css({'display':'grid','grid-template-columns': '1fr 1fr'});
				}else{
					$('.Custom-31').css({'display':'none'});
				}
			});

			$('.WardenPermissionNeededOutGoingShedual').change(function(){
				if(this.value == 'Custom'){
					$('.Custom-22').css({'display':'block'});
					$('.WardenPermissionNeededOutGoingShedualTime').css({'display':'grid','grid-template-columns': '1fr 1fr'});
				}else{
					$('.Custom-22').css({'display':'none'});
				}
			});

			$('.WardenPermissionNeededInComingShedual').change(function(){
				if(this.value == 'Custom'){
					$('.Custom-32').css({'display':'block'});
					$('.WardenPermissionNeededInComingShedualTime').css({'display':'grid','grid-template-columns': '1fr 1fr'});
				}else{
					$('.Custom-32').css({'display':'none'});
				}
			});

			$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiff').change(function(){
				if(this.value == 'Yes'){
					$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime').css({'display':'block'});
					$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType').css({'display':'block'});
				}else{
					$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime').css({'display':'none'});
					$('.GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType').css({'display':'none'});
				}
			});

			$('.WardenPermissionNeededByOutGoingAndInComingTimeDiff').change(function(){
				if(this.value == 'Yes'){
					$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTime').css({'display':'block'});
					$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType').css({'display':'block'});
				}else{
					$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTime').css({'display':'none'});
					$('.WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType').css({'display':'none'});
				}
			});

			(function(){
				$(".SmsUpdatePermissionWardenSmsUpdate option[value='<?php echo $GetServiceSettingSmsUpdatePermissionWardenSmsUpdate; ?>']").prop('selected',true);
				$(".SmsUpdatePermissionGuardianOutGoingSmsUpdate option[value='<?php echo $GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate; ?>']").prop('selected',true);
				$(".SmsUpdatePermissionGuardianInComingSmsUpdate option[value='<?php echo $GetServiceSettingSmsUpdatePermissionGuardianInComingSmsUpdate; ?>']").prop('selected',true);
				$(".SmsUpdatePermissionUserSmsUpdate option[value='<?php echo $GetServiceSettingSmsUpdatePermissionUserSmsUpdate; ?>']").prop('selected',true);
				$(".ServiceActiveSchedule option[value='<?php echo $TempGetServiceSettingServiceActiveSchedule; ?>']").prop('selected',true);
				$(".ServiceActiveScheduleStartTimeHour").val('<?php echo $TempGetServiceSettingServiceActiveScheduleCustomStartHour; ?>');
				$(".ServiceActiveScheduleStartTimeMin").val('<?php echo $TempGetServiceSettingServiceActiveScheduleCustomStartMin; ?>');
				$(".ServiceActiveScheduleEndTimeHour").val('<?php echo $TempGetServiceSettingServiceActiveScheduleCustomEndHour; ?>');
				$(".ServiceActiveScheduleEndTimeMin").val('<?php echo $TempGetServiceSettingServiceActiveScheduleCustomEndMin; ?>');
				$(".MinTimeToSubmitRequestAgainTime").val('<?php echo $GetServiceSettingGeneralSettingMinTimeToSubmitRequestAgain; ?>');
				$(".MinTimeToSubmitRequestAgainTimeType option[value='<?php echo 'Second'; ?>']").prop('selected',true);
				$(".MinRequestSubmitAndOutGoingTimeDiffTime").val('<?php echo $GetServiceSettingGeneralSettingMinRequestSubmitAndOutGoingTimeDiff; ?>');
				$(".MinRequestSubmitAndOutGoingTimeDiffTimeType option[value='<?php echo 'Second'; ?>']").prop('selected',true);
				$(".MaxRequestSubmitAndOutGoingTimeDiffTime").val('<?php echo $GetServiceSettingGeneralSettingMaxRequestSubmitAndOutGoingTimeDiff; ?>');
				$(".MaxRequestSubmitAndOutGoingTimeDiffTimeType option[value='<?php echo 'Second'; ?>']").prop('selected',true);
				$(".MaxTimeWaitForApproveOrRejectPermissionFromAllTime").val('<?php echo $GetServiceSettingGeneralSettingMaxTimeWaitForApproveOrRejectPermissionFromAll; ?>');
				$(".MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType option[value='<?php echo 'Second'; ?>']").prop('selected',true);
				$(".GuardianPermissionApprovalNeeded").val('<?php echo $GetServiceSettingGeneralSettingGuardianPermissionApprovalNeeded; ?>');
				$(".WardenPermissionApprovalNeeded").val('<?php echo $GetServiceSettingGeneralSettingWardenPermissionApprovalNeeded; ?>');
				$(".InComingTimeTrack").val('<?php echo $GetServiceSettingGeneralSettingInComingTimeTrack; ?>');
				$(".OutGoingTimeTrack").val('<?php echo $GetServiceSettingGeneralSettingOutGoingTimeTrack; ?>');
				$(".StudentCreateMultipleRequest").val('<?php echo $GetServiceSettingGeneralSettingStudentCreateMultipleRequest; ?>');
				$(".GuradianPermissionNeededOutGoingShedual").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedual; ?>');
				$(".GuradianPermissionNeededOutGoingShedualStartTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartHour; ?>');
				$(".GuradianPermissionNeededOutGoingShedualStartTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomStartMin; ?>');
				$(".GuradianPermissionNeededOutGoingShedualEndTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndHour; ?>');
				$(".GuradianPermissionNeededOutGoingShedualEndTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededOutGoingShedualCustomEndMin; ?>');
				$(".GuradianPermissionNeededInComingShedual").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedual; ?>');
				$(".GuradianPermissionNeededInComingShedualStartTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartHour; ?>');
				$(".GuradianPermissionNeededInComingShedualStartTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomStartMin; ?>');
				$(".GuradianPermissionNeededInComingShedualEndTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndHour; ?>');
				$(".GuradianPermissionNeededInComingShedualEndTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingGuradianPermissionNeededInComingShedualCustomEndMin; ?>');
				$(".WardenPermissionNeededOutGoingShedual").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedual; ?>');
				$(".WardenPermissionNeededOutGoingShedualStartTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartHour; ?>');
				$(".WardenPermissionNeededOutGoingShedualStartTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomStartMin; ?>');
				$(".WardenPermissionNeededOutGoingShedualEndTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndHour; ?>');
				$(".WardenPermissionNeededOutGoingShedualEndTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededOutGoingShedualCustomEndMin; ?>');
				$(".WardenPermissionNeededInComingShedual").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedual; ?>');
				$(".WardenPermissionNeededInComingShedualStartTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartHour; ?>');
				$(".WardenPermissionNeededInComingShedualStartTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomStartMin; ?>');
				$(".WardenPermissionNeededInComingShedualEndTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndHour; ?>');
				$(".WardenPermissionNeededInComingShedualEndTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingWardenPermissionNeededInComingShedualCustomEndMin; ?>');
				$(".MaxTimeWaitForOutGoingForOrUntil").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTypeAndTime[0]; ?>');
				$(".MaxTimeWaitForOutGoingForTime").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingTime; ?>');
				$(".MaxTimeWaitForOutGoingForTimeType").val('Second');
				$(".MaxTimeWaitForOutGoingUntilStartTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeHour; ?>');
				$(".MaxTimeWaitForOutGoingUntilStartTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingStartTimeMin; ?>');
				$(".MaxTimeWaitForOutGoingUntilEndTimeHour").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeHour; ?>');
				$(".MaxTimeWaitForOutGoingUntilEndTimeMin").val('<?php echo $TempGetServiceSettingGeneralSettingMaxTimeWaitForOutGoingEndTimeMin; ?>');
				$(".GuradianPermissionNeededByOutGoingAndInComingTimeDiff").val('<?php echo $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff['0']; ?>');
				$(".GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime").val('<?php echo $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutGoingAndInComingTimeDiff['1']; ?>');
				$(".GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType").val('Second');
				$(".WardenPermissionNeededByOutGoingAndInComingTimeDiff").val('<?php echo $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff['0']; ?>');
				$(".WardenPermissionNeededByOutGoingAndInComingTimeDiffTime").val('<?php echo $GetServiceSettingGeneralSettingWardenPermissionNeededByOutGoingAndInComingTimeDiff['1']; ?>');
				$(".WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType").val('Second');
				$(".GuradianPermissionNeededByOutAndInDateDiff").val('<?php echo $GetServiceSettingGeneralSettingGuradianPermissionNeededByOutAndInDateDiff; ?>');
				$(".WardenPermissionNeededByOutAndInDateDiff").val('<?php echo $GetServiceSettingGeneralSettingWardenPermissionNeededByOutAndInDateDiff; ?>');
				$(".GuardianPermissionPriorityFor").val('<?php echo $GetServiceSettingGeneralSettingGuardianPermissionPriorityFor; ?>');
				$( ".ServiceActiveSchedule" ).trigger( "change" );
				$( ".MaxTimeWaitForOutGoingForOrUntil" ).trigger( "change" );
				$( ".MaxTimeWaitForInComingForOrUntil" ).trigger( "change" );
				$( ".GuradianPermissionNeededOutGoingShedual" ).trigger( "change" );
				$( ".GuradianPermissionNeededInComingShedual" ).trigger( "change" );
				$( ".WardenPermissionNeededOutGoingShedual" ).trigger( "change" );
				$( ".WardenPermissionNeededInComingShedual" ).trigger( "change" );
				$( ".GuradianPermissionNeededByOutGoingAndInComingTimeDiff" ).trigger( "change" );
				$( ".WardenPermissionNeededByOutGoingAndInComingTimeDiff" ).trigger( "change" );
			})();
		});
	</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>