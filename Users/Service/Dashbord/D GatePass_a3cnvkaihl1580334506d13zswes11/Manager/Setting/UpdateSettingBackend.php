 <?php 
/*
*@FileName UpdateSettingBackend.php
*@Des This procees add update setting of D GatePass sevice for login organization
*@Author arpit sharma
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
define("RootPath", "../../../../../../");

// Get all requested data
if(isset($_POST['SettingData']) && isset($_POST['SettingId']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Manager/Setting/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$SettingData = preg_replace('!\s+!', ' ',strip_tags($_POST['SettingData']));
			$SettingId = preg_replace('!\s+!', ' ',strip_tags($_POST['SettingId']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class UpdateSetting{
				public static function ValidedData($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2){
					
					date_default_timezone_set('Asia/Kolkata');
					
					// SettingId valided in backend
					if($SettingId != "SmsPermissionSmtBtn" && $SettingId != "ServiceActiveScheduleSmtBtn" && $SettingId != "GeneralSettingSmtBtn"){
						return_response("Invalid click detect"); exit();
					}
					
					if(gettype(json_decode($SettingData)) != 'object'){
						return_response('Invalid setting Data format detect');exit();
					}
					
					$SettingData = json_decode($SettingData);

					foreach ($SettingData as $key => $value) {
						if($key != 'SmsUpdatePermissionWardenSmsUpdate' && $key != 'SmsUpdatePermissionGuardianOutGoingSmsUpdate' && $key != 'SmsUpdatePermissionGuardianInComingSmsUpdate' && $key != 'SmsUpdatePermissionUserSmsUpdate' && $key != 'ServiceActiveSchedule' && $key != 'ServiceActiveScheduleStartTimeHour' && $key != 'ServiceActiveScheduleStartTimeMin' && $key != 'ServiceActiveScheduleEndTimeHour' && $key != 'ServiceActiveScheduleEndTimeMin' && $key != 'MinTimeToSubmitRequestAgainTime' && $key != 'MinTimeToSubmitRequestAgainTimeType' && $key != 'MinRequestSubmitAndOutGoingTimeDiffTime' && $key != 'MinRequestSubmitAndOutGoingTimeDiffTimeType' && $key != 'MaxRequestSubmitAndOutGoingTimeDiffTime' && $key != 'MaxRequestSubmitAndOutGoingTimeDiffTimeType' && $key != 'MaxTimeWaitForApproveOrRejectPermissionFromAllTime' && $key != 'MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType' && $key != 'GuardianPermissionApprovalNeeded' && $key != 'WardenPermissionApprovalNeeded' && $key != 'InComingTimeTrack' && $key != 'StudentCreateMultipleRequest' && $key != 'GuradianPermissionNeededOutGoingShedual' && $key != 'GuradianPermissionNeededOutGoingShedualStartTimeHour' && $key != 'GuradianPermissionNeededOutGoingShedualStartTimeMin' && $key != 'GuradianPermissionNeededOutGoingShedualEndTimeHour' && $key != 'GuradianPermissionNeededOutGoingShedualEndTimeMin' && $key != 'WardenPermissionNeededOutGoingShedual' && $key != 'WardenPermissionNeededOutGoingShedualStartTimeHour' && $key != 'WardenPermissionNeededOutGoingShedualStartTimeMin' && $key != 'WardenPermissionNeededOutGoingShedualEndTimeHour' && $key != 'WardenPermissionNeededOutGoingShedualEndTimeMin' && $key != 'OutGoingTimeTrack' && $key != 'MaxTimeWaitForOutGoingForOrUntil' && $key != 'MaxTimeWaitForOutGoingForTime' && $key != 'MaxTimeWaitForOutGoingForTimeType' && $key != 'MaxTimeWaitForOutGoingUntilStartTimeHour' && $key != 'MaxTimeWaitForOutGoingUntilStartTimeMin' && $key != 'MaxTimeWaitForOutGoingUntilEndTimeHour' && $key != 'MaxTimeWaitForOutGoingUntilEndTimeMin' && $key != 'GuradianPermissionNeededInComingShedual' && $key != 'GuradianPermissionNeededInComingShedualStartTimeHour' && $key != 'GuradianPermissionNeededInComingShedualStartTimeMin' && $key != 'GuradianPermissionNeededInComingShedualEndTimeHour' && $key != 'GuradianPermissionNeededInComingShedualEndTimeMin' && $key != 'WardenPermissionNeededInComingShedual' && $key != 'WardenPermissionNeededInComingShedualStartTimeHour' && $key != 'WardenPermissionNeededInComingShedualStartTimeMin' && $key != 'WardenPermissionNeededInComingShedualEndTimeHour' && $key != 'WardenPermissionNeededInComingShedualEndTimeMin' && $key != 'GuradianPermissionNeededByOutGoingAndInComingTimeDiff' && $key != 'GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime' && $key != 'GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType' && $key != 'WardenPermissionNeededByOutGoingAndInComingTimeDiff' && $key != 'WardenPermissionNeededByOutGoingAndInComingTimeDiffTime' && $key != 'WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType' && $key != 'GuradianPermissionNeededByOutAndInDateDiff' && $key != 'WardenPermissionNeededByOutAndInDateDiff' && $key != 'GuardianPermissionPriorityFor'){
							return_response('Invalid setting Data detect');exit();
						}else if($value != 'Optional' && $value != 'Yes' && $value != 'No' && $value != 'always' && $value != 'never' && $value != 'Custom' && $value != 'Second' && $value != 'Hour' && $value != 'Minute' && $value != 'For' && $value != 'Until' && $value != '00' && $value != 'Father' && $value != 'Guardian'){
							if($value != preg_replace("/[^0-9]/","",$value)){
								return_response('Invalid Setting Data detect'); exit(); break;
							}
						}
						${$key} = $value;
					}
					
					if($SettingId == "SmsPermissionSmtBtn"){
						if(($SmsUpdatePermissionWardenSmsUpdate != 'Yes' && $SmsUpdatePermissionWardenSmsUpdate != 'No' && $SmsUpdatePermissionWardenSmsUpdate != 'Optional') || ($SmsUpdatePermissionGuardianOutGoingSmsUpdate != 'Yes' && $SmsUpdatePermissionGuardianOutGoingSmsUpdate != 'No' && $SmsUpdatePermissionGuardianOutGoingSmsUpdate != 'Optional') || ($SmsUpdatePermissionGuardianInComingSmsUpdate != 'No' && $SmsUpdatePermissionGuardianInComingSmsUpdate != 'Optional') || ($SmsUpdatePermissionUserSmsUpdate != 'No' && $SmsUpdatePermissionUserSmsUpdate != 'Optional')){
							return_response('Invalid Sms Send To detect!'); exit();
						}
					}else if($SettingId == "ServiceActiveScheduleSmtBtn"){
						if(($ServiceActiveSchedule != 'always' && $ServiceActiveSchedule != 'never' && $ServiceActiveSchedule != 'Custom') || ($ServiceActiveScheduleStartTimeHour == '' || $ServiceActiveScheduleStartTimeMin == '' || $ServiceActiveScheduleEndTimeHour == '' || $ServiceActiveScheduleEndTimeMin == '' || $ServiceActiveScheduleStartTimeHour < 0 || $ServiceActiveScheduleStartTimeHour > 23 || $ServiceActiveScheduleEndTimeHour < 0 || $ServiceActiveScheduleEndTimeHour > 23 || $ServiceActiveScheduleStartTimeMin < 0 || $ServiceActiveScheduleStartTimeMin > 59 || $ServiceActiveScheduleEndTimeMin < 0 || $ServiceActiveScheduleEndTimeMin > 59 || $ServiceActiveScheduleStartTimeHour != preg_replace("/[^0-9]/","",$ServiceActiveScheduleStartTimeHour) || $ServiceActiveScheduleStartTimeMin != preg_replace("/[^0-9]/","",$ServiceActiveScheduleStartTimeMin) || $ServiceActiveScheduleEndTimeHour != preg_replace("/[^0-9]/","",$ServiceActiveScheduleEndTimeHour) || $ServiceActiveScheduleEndTimeMin != preg_replace("/[^0-9]/","",$ServiceActiveScheduleEndTimeMin))){
								return_response('Invalid Service Schedule detect!'); exit();
							}
					}else if($SettingId == "GeneralSettingSmtBtn"){
						if($MinTimeToSubmitRequestAgainTimeType != 'Hour' && $MinTimeToSubmitRequestAgainTimeType != 'Minute' && $MinTimeToSubmitRequestAgainTimeType != 'Second'){
							return_response('Invalid Minimum Time To Req Again detect! '.$MinTimeToSubmitRequestAgain); exit();
						}else if($MinRequestSubmitAndOutGoingTimeDiffTimeType != 'Hour' && $MinRequestSubmitAndOutGoingTimeDiffTimeType != 'Minute' && $MinRequestSubmitAndOutGoingTimeDiffTimeType != 'Second'){
							return_response('Invalid Min Time Difference For OutGoing detect!'); exit();
						}else if($MaxRequestSubmitAndOutGoingTimeDiffTimeType != 'Hour' && $MaxRequestSubmitAndOutGoingTimeDiffTimeType != 'Minute' && $MaxRequestSubmitAndOutGoingTimeDiffTimeType != 'Second'){
							return_response('Invalid Max Time Difference For OutGoing detect!'); exit();
						}else if($MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType != 'Hour' && $MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType != 'Minute' && $MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType != 'Second'){
							return_response('Invalid Max Time Wait For Approve Or Reject Of Guradian Or Warden detect!'); exit();
						}else if($GuardianPermissionApprovalNeeded != 'Yes' && $GuardianPermissionApprovalNeeded != 'No'){
							return_response('Invalid Guardian Approval Needed detect!'); exit();
						}else if($WardenPermissionApprovalNeeded != 'Yes' && $WardenPermissionApprovalNeeded != 'No'){
							return_response('Invalid Warden Approval Needed detect!'); exit();
						}else if($InComingTimeTrack != 'Yes' && $InComingTimeTrack != 'No'){
							return_response('Invalid InComing Time Track detect!'); exit();
						}else if($OutGoingTimeTrack != 'Yes' && $OutGoingTimeTrack != 'No'){
							return_response('Invalid OutGoing Time Track detect!'); exit();
						}else if($StudentCreateMultipleRequest != 'Yes' && $StudentCreateMultipleRequest != 'No'){
							return_response('Invalid Student Create Multiple Request detect!'); exit();
						}else if(($GuradianPermissionNeededOutGoingShedual != 'always' && $GuradianPermissionNeededOutGoingShedual != 'never' && $GuradianPermissionNeededOutGoingShedual != 'Custom') || ($GuradianPermissionNeededOutGoingShedualStartTimeHour == '' || $GuradianPermissionNeededOutGoingShedualStartTimeMin == '' || $GuradianPermissionNeededOutGoingShedualEndTimeHour == '' || $GuradianPermissionNeededOutGoingShedualEndTimeMin == '' || $GuradianPermissionNeededOutGoingShedualStartTimeHour < 0 || $GuradianPermissionNeededOutGoingShedualStartTimeHour > 23 || $GuradianPermissionNeededOutGoingShedualEndTimeHour < 0 || $GuradianPermissionNeededOutGoingShedualEndTimeHour > 23 || $GuradianPermissionNeededOutGoingShedualStartTimeMin < 0 || $GuradianPermissionNeededOutGoingShedualStartTimeMin > 59 || $GuradianPermissionNeededOutGoingShedualEndTimeMin < 0 || $GuradianPermissionNeededOutGoingShedualEndTimeMin > 59 || $GuradianPermissionNeededOutGoingShedualStartTimeHour != preg_replace("/[^0-9]/","",$GuradianPermissionNeededOutGoingShedualStartTimeHour) || $GuradianPermissionNeededOutGoingShedualStartTimeMin != preg_replace("/[^0-9]/","",$GuradianPermissionNeededOutGoingShedualStartTimeMin) || $GuradianPermissionNeededOutGoingShedualEndTimeHour != preg_replace("/[^0-9]/","",$GuradianPermissionNeededOutGoingShedualEndTimeHour) || $GuradianPermissionNeededOutGoingShedualEndTimeMin != preg_replace("/[^0-9]/","",$GuradianPermissionNeededOutGoingShedualEndTimeMin))){
							return_response('Invalid Guardian Approval OutGoing Schedule detect!'); exit();
						}else if(($WardenPermissionNeededOutGoingShedual != 'always' && $WardenPermissionNeededOutGoingShedual != 'never' && $WardenPermissionNeededOutGoingShedual != 'Custom') || ($WardenPermissionNeededOutGoingShedualStartTimeHour == '' || $WardenPermissionNeededOutGoingShedualStartTimeMin == '' || $WardenPermissionNeededOutGoingShedualEndTimeHour == '' || $WardenPermissionNeededOutGoingShedualEndTimeMin == '' || $WardenPermissionNeededOutGoingShedualStartTimeHour < 0 || $WardenPermissionNeededOutGoingShedualStartTimeHour > 23 || $WardenPermissionNeededOutGoingShedualEndTimeHour < 0 || $WardenPermissionNeededOutGoingShedualEndTimeHour > 23 || $WardenPermissionNeededOutGoingShedualStartTimeMin < 0 || $WardenPermissionNeededOutGoingShedualStartTimeMin > 59 || $WardenPermissionNeededOutGoingShedualEndTimeMin < 0 || $WardenPermissionNeededOutGoingShedualEndTimeMin > 59) || $WardenPermissionNeededOutGoingShedualStartTimeHour != preg_replace("/[^0-9]/","",$WardenPermissionNeededOutGoingShedualStartTimeHour) || $WardenPermissionNeededOutGoingShedualStartTimeMin != preg_replace("/[^0-9]/","",$WardenPermissionNeededOutGoingShedualStartTimeMin) || $WardenPermissionNeededOutGoingShedualEndTimeHour != preg_replace("/[^0-9]/","",$WardenPermissionNeededOutGoingShedualEndTimeHour) || $WardenPermissionNeededOutGoingShedualEndTimeMin != preg_replace("/[^0-9]/","",$WardenPermissionNeededOutGoingShedualEndTimeMin)){
							return_response('Invalid Warden Approval OutGoing Schedule detect!'); exit();
						}else if($MaxTimeWaitForOutGoingForOrUntil != 'For' && $MaxTimeWaitForOutGoingForOrUntil != 'Until'){
							return_response('Invalid Max Wait Time For OutGoing detect!'); exit();
						}else if($MaxTimeWaitForOutGoingForOrUntil == 'For' && (($MaxTimeWaitForOutGoingForTimeType != 'Hour' && $MaxTimeWaitForOutGoingForTimeType != 'Minute' && $MaxTimeWaitForOutGoingForTimeType != 'Second') || $MaxTimeWaitForOutGoingForTime == '' || $MaxTimeWaitForOutGoingForTimeType == '')){
							return_response('Invalid Max Wait Time For OutGoing detect!'); exit();
						}else if(($MaxTimeWaitForOutGoingForOrUntil == 'Until') && ($MaxTimeWaitForOutGoingUntilStartTimeHour == '' || $MaxTimeWaitForOutGoingUntilStartTimeMin == '' || $MaxTimeWaitForOutGoingUntilEndTimeHour == '' || $MaxTimeWaitForOutGoingUntilEndTimeMin == '' || $MaxTimeWaitForOutGoingUntilStartTimeHour < 0 || $MaxTimeWaitForOutGoingUntilStartTimeHour > 23 || $MaxTimeWaitForOutGoingUntilEndTimeHour < 0 || $MaxTimeWaitForOutGoingUntilEndTimeHour > 23 || $MaxTimeWaitForOutGoingUntilStartTimeMin < 0 || $MaxTimeWaitForOutGoingUntilStartTimeMin > 59 || $MaxTimeWaitForOutGoingUntilEndTimeMin < 0 || $MaxTimeWaitForOutGoingUntilEndTimeMin > 59 || $MaxTimeWaitForOutGoingUntilStartTimeHour != preg_replace("/[^0-9]/","",$MaxTimeWaitForOutGoingUntilStartTimeHour) || $MaxTimeWaitForOutGoingUntilStartTimeMin != preg_replace("/[^0-9]/","",$MaxTimeWaitForOutGoingUntilStartTimeMin) || $MaxTimeWaitForOutGoingUntilEndTimeHour != preg_replace("/[^0-9]/","",$MaxTimeWaitForOutGoingUntilEndTimeHour) || $MaxTimeWaitForOutGoingUntilEndTimeMin != preg_replace("/[^0-9]/","",$MaxTimeWaitForOutGoingUntilEndTimeMin))){
							return_response('Invalid Max Wait Time For OutGoing detect!'); exit();
						}else if(($GuradianPermissionNeededInComingShedual != 'always' && $GuradianPermissionNeededInComingShedual != 'never' && $GuradianPermissionNeededInComingShedual != 'Custom') || ($GuradianPermissionNeededInComingShedualStartTimeHour == '' || $GuradianPermissionNeededInComingShedualStartTimeMin == '' || $GuradianPermissionNeededInComingShedualEndTimeHour == '' || $GuradianPermissionNeededInComingShedualEndTimeMin == '' || $GuradianPermissionNeededInComingShedualStartTimeHour < 0 || $GuradianPermissionNeededInComingShedualStartTimeHour > 23 || $GuradianPermissionNeededInComingShedualEndTimeHour < 0 || $GuradianPermissionNeededInComingShedualEndTimeHour > 23 || $GuradianPermissionNeededInComingShedualStartTimeMin < 0 || $GuradianPermissionNeededInComingShedualStartTimeMin > 59 || $GuradianPermissionNeededInComingShedualEndTimeMin < 0 || $GuradianPermissionNeededInComingShedualEndTimeMin > 59) || $GuradianPermissionNeededInComingShedualStartTimeHour != preg_replace("/[^0-9]/","",$GuradianPermissionNeededInComingShedualStartTimeHour) || $GuradianPermissionNeededInComingShedualStartTimeMin != preg_replace("/[^0-9]/","",$GuradianPermissionNeededInComingShedualStartTimeMin) || $GuradianPermissionNeededInComingShedualEndTimeHour != preg_replace("/[^0-9]/","",$GuradianPermissionNeededInComingShedualEndTimeHour) || $GuradianPermissionNeededInComingShedualEndTimeMin != preg_replace("/[^0-9]/","",$GuradianPermissionNeededInComingShedualEndTimeMin)){
							return_response('Invalid Warden Approval InComing Schedule detect!'); exit();
						}else if(($WardenPermissionNeededInComingShedual != 'always' && $WardenPermissionNeededInComingShedual != 'never' && $WardenPermissionNeededInComingShedual != 'Custom') || ($WardenPermissionNeededInComingShedualStartTimeHour == '' || $WardenPermissionNeededInComingShedualStartTimeMin == '' || $WardenPermissionNeededInComingShedualEndTimeHour == '' || $WardenPermissionNeededInComingShedualEndTimeMin == '' || $WardenPermissionNeededInComingShedualStartTimeHour < 0 || $WardenPermissionNeededInComingShedualStartTimeHour > 23 || $WardenPermissionNeededInComingShedualEndTimeHour < 0 || $WardenPermissionNeededInComingShedualEndTimeHour > 23 || $WardenPermissionNeededInComingShedualStartTimeMin < 0 || $WardenPermissionNeededInComingShedualStartTimeMin > 59 || $WardenPermissionNeededInComingShedualEndTimeMin < 0 || $WardenPermissionNeededInComingShedualEndTimeMin > 59) || $WardenPermissionNeededInComingShedualStartTimeHour != preg_replace("/[^0-9]/","",$WardenPermissionNeededInComingShedualStartTimeHour) || $WardenPermissionNeededInComingShedualStartTimeMin != preg_replace("/[^0-9]/","",$WardenPermissionNeededInComingShedualStartTimeMin) || $WardenPermissionNeededInComingShedualEndTimeHour != preg_replace("/[^0-9]/","",$WardenPermissionNeededInComingShedualEndTimeHour) || $WardenPermissionNeededInComingShedualEndTimeMin != preg_replace("/[^0-9]/","",$WardenPermissionNeededInComingShedualEndTimeMin)){
							return_response('Invalid Warden Approval OutGoing Schedule detect!'); exit();
						}else if(($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Hour' && $GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Minute' && $GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Second') || ($GuradianPermissionNeededByOutGoingAndInComingTimeDiff != 'Yes' && $GuradianPermissionNeededByOutGoingAndInComingTimeDiff != 'No')){
							return_response('Invalid Guradian Permission Needed By OutGoing And InComing Time Diff detect!'); exit();
						}else if(($WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Hour' && $WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Minute' && $WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType != 'Second') || ($WardenPermissionNeededByOutGoingAndInComingTimeDiff != 'Yes' && $WardenPermissionNeededByOutGoingAndInComingTimeDiff != 'No')){
							return_response('Invalid Warden Permission Needed By OutGoing And InComing Time Diff detect!'); exit();
						}else if($GuradianPermissionNeededByOutAndInDateDiff != 'Yes' && $GuradianPermissionNeededByOutAndInDateDiff != 'No'){
							return_response('Invalid Guradian Permission When OutGoing And InComing Date Diff detect!'); exit();
						}else if($WardenPermissionNeededByOutAndInDateDiff != 'Yes' && $WardenPermissionNeededByOutAndInDateDiff != 'No'){
							return_response('Invalid Warden Permission When OutGoing And InComing Date Diff detect!'); exit();
						}else if($GuardianPermissionPriorityFor != 'Father' && $GuardianPermissionPriorityFor != 'Guardian'){
							return_response('Invalid Guardian Permission Priority For detect!'); exit();
						}
					}else{
						return_response("Invalid click detect"); exit();
					}
					
					if($SettingId == "SmsPermissionSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::WardenSmsUpdate-$SmsUpdatePermissionWardenSmsUpdate,UserSmsUpdate-$SmsUpdatePermissionUserSmsUpdate,GuardianOutGoingSmsUpdate-$SmsUpdatePermissionGuardianOutGoingSmsUpdate,GuardianInComingSmsUpdate-$SmsUpdatePermissionGuardianInComingSmsUpdate";
					}else if($SettingId == "ServiceActiveScheduleSmtBtn"){

						# 20_50-11_30*22_50-11_89
						if($ServiceActiveSchedule == 'Custom'){
							$FormatServiceActiveSchedule = $ServiceActiveScheduleStartTimeHour.'_'.$ServiceActiveScheduleStartTimeMin.'-'.$ServiceActiveScheduleEndTimeHour.'_'.$ServiceActiveScheduleEndTimeMin;
						}else{
							$FormatServiceActiveSchedule = $ServiceActiveSchedule;
						}
						$TrueSettingDataWithFormat = "SettingValue::::$FormatServiceActiveSchedule";

					}else if($SettingId == "GeneralSettingSmtBtn"){
						# 900
						if($MinTimeToSubmitRequestAgainTime != '' && ($MinTimeToSubmitRequestAgainTime === preg_replace("/[^0-9]/","",$MinTimeToSubmitRequestAgainTime))){
							if($MinTimeToSubmitRequestAgainTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($MinTimeToSubmitRequestAgainTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}
							$FormatMinTimeToSubmitRequestAgain = $MinTimeToSubmitRequestAgainTime*$Temp;
							if($FormatMinTimeToSubmitRequestAgain > 2592000){
								return_response('Max 30 day limit for Minimum Time To Req Again'); exit();
							}
						}else{
							return_response('Invalid Minimum Time To Req Again detect!'); exit();
						}

						# 900
						if($MinRequestSubmitAndOutGoingTimeDiffTime != '' && ($MinRequestSubmitAndOutGoingTimeDiffTime == preg_replace("/[^0-9]/","",$MinRequestSubmitAndOutGoingTimeDiffTime))){
							if($MinRequestSubmitAndOutGoingTimeDiffTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($MinRequestSubmitAndOutGoingTimeDiffTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}
							$FormatMinRequestSubmitAndOutGoingTimeDiff = $MinRequestSubmitAndOutGoingTimeDiffTime*$Temp;
							if($FormatMinRequestSubmitAndOutGoingTimeDiff > 2592000){
								return_response('Max 30 day limit for Min Time Difference For OutGoing'); exit();
							}
						}else{
							return_response('Invalid Min Time Difference For OutGoing detect!'); exit();
						}

						# 900
						if($MaxRequestSubmitAndOutGoingTimeDiffTime != '' && ($MaxRequestSubmitAndOutGoingTimeDiffTime === preg_replace("/[^0-9]/","",$MaxRequestSubmitAndOutGoingTimeDiffTime))){
							if($MaxRequestSubmitAndOutGoingTimeDiffTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($MaxRequestSubmitAndOutGoingTimeDiffTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}
							$FormatMaxRequestSubmitAndOutGoingTimeDiff = $MaxRequestSubmitAndOutGoingTimeDiffTime*$Temp;
							if($FormatMaxRequestSubmitAndOutGoingTimeDiff > 2592000){
								return_response('Max 30 day limit for Max Time Difference For OutGoing'); exit();
							}
						}else{
							return_response('Invalid Max Time Difference For OutGoing detect!'); exit();
						}

						# 900
						if($MaxTimeWaitForApproveOrRejectPermissionFromAllTime != '' && ($MaxTimeWaitForApproveOrRejectPermissionFromAllTime === preg_replace("/[^0-9]/","",$MaxTimeWaitForApproveOrRejectPermissionFromAllTime))){
							if($MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($MaxTimeWaitForApproveOrRejectPermissionFromAllTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}
							$FormatMaxTimeWaitForApproveOrRejectPermissionFromAll = $MaxTimeWaitForApproveOrRejectPermissionFromAllTime*$Temp;
							if($FormatMaxTimeWaitForApproveOrRejectPermissionFromAll > 2592000){
								return_response('Max 30 day limit for Max Time Wait For Approve Or Reject Of Guradian Or Warden'); exit();
							}
						}else{
							return_response('Invalid Max Time Wait For Approve Or Reject Of Guradian Or Warden detect!'); exit();
						}

						# Yes
						$FormatGuardianPermissionApprovalNeeded = $GuardianPermissionApprovalNeeded;

						# Yes
						$FormatWardenPermissionApprovalNeeded = $WardenPermissionApprovalNeeded;

						# Yes
						$FormatInComingTimeTrack = $InComingTimeTrack;

						# Yes
						$FormatOutGoingTimeTrack = $OutGoingTimeTrack;

						# Yes
						$FormatStudentCreateMultipleRequest = $StudentCreateMultipleRequest;
						
						# 20_50-11_30*22_50-11_89
						if($GuradianPermissionNeededOutGoingShedual == 'Custom'){
							$FormatGuradianPermissionNeededOutGoingShedual = $GuradianPermissionNeededOutGoingShedualStartTimeHour.'_'.$GuradianPermissionNeededOutGoingShedualStartTimeMin.'-'.$GuradianPermissionNeededOutGoingShedualEndTimeHour.'_'.$GuradianPermissionNeededOutGoingShedualEndTimeMin;
						}else{
							$FormatGuradianPermissionNeededOutGoingShedual = $GuradianPermissionNeededOutGoingShedual;
						}

						# 20_50-11_30*22_50-11_89
						if($WardenPermissionNeededOutGoingShedual == 'Custom'){
							$FormatWardenPermissionNeededOutGoingShedual = $WardenPermissionNeededOutGoingShedualStartTimeHour.'_'.$WardenPermissionNeededOutGoingShedualStartTimeMin.'-'.$WardenPermissionNeededOutGoingShedualEndTimeHour.'_'.$WardenPermissionNeededOutGoingShedualEndTimeMin;
						}else{
							$FormatWardenPermissionNeededOutGoingShedual = $WardenPermissionNeededOutGoingShedual;
						}

						#For*100
						if($MaxTimeWaitForOutGoingForOrUntil == 'For'){
							if($MaxTimeWaitForOutGoingForTime == '' || $MaxTimeWaitForOutGoingForTime != preg_replace("/[^0-9]/","",$MaxTimeWaitForOutGoingForTime)){
								return_response('Invalid Max Wait Time For OutGoing!'); exit();
							}
							if($MaxTimeWaitForOutGoingForTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($MaxTimeWaitForOutGoingForTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp =1;
							}
							$FormatMaxTimeWaitForOutGoing = 'For*'.$MaxTimeWaitForOutGoingForTime*$Temp;
							if($MaxTimeWaitForOutGoingForTime*$Temp > 2592000){
								return_response('Max 30 day limit for Max Wait Time For OutGoing'); exit();
							}

							if($MaxTimeWaitForOutGoingForTime*$Temp < 600){
								return_response('Min 10 Min required for Max wait time for outgoing!'); exit();
							}
						}else{
							$FormatMaxTimeWaitForOutGoing = 'Until*'.$MaxTimeWaitForOutGoingUntilStartTimeHour.'_'.$MaxTimeWaitForOutGoingUntilStartTimeMin.'-'.$MaxTimeWaitForOutGoingUntilEndTimeHour.'_'.$MaxTimeWaitForOutGoingUntilEndTimeMin;		
							if($MaxTimeWaitForOutGoingUntilStartTimeHour == $MaxTimeWaitForOutGoingUntilEndTimeHour && $MaxTimeWaitForOutGoingUntilStartTimeMin < $MaxTimeWaitForOutGoingUntilEndTimeMin && $MaxTimeWaitForOutGoingUntilEndTimeMin - $MaxTimeWaitForOutGoingUntilStartTimeMin < 10){
								return_response('Min 10 Min diff required for Max wait time for outgoing!'); exit();
							}	
						}
						
						# 20_50-11_30*22_50-11_89
						if($GuradianPermissionNeededInComingShedual == 'Custom'){
							$FormatGuradianPermissionNeededInComingShedual = $GuradianPermissionNeededInComingShedualStartTimeHour.'_'.$GuradianPermissionNeededInComingShedualStartTimeMin.'-'.$GuradianPermissionNeededInComingShedualEndTimeHour.'_'.$GuradianPermissionNeededInComingShedualEndTimeMin;
						}else{
							$FormatGuradianPermissionNeededInComingShedual = $GuradianPermissionNeededInComingShedual;
						}
						
						# 20_50-11_30*22_50-11_89
						if($WardenPermissionNeededInComingShedual == 'Custom'){
							$FormatWardenPermissionNeededInComingShedual = $WardenPermissionNeededInComingShedualStartTimeHour.'_'.$WardenPermissionNeededInComingShedualStartTimeMin.'-'.$WardenPermissionNeededInComingShedualEndTimeHour.'_'.$WardenPermissionNeededInComingShedualEndTimeMin;
						}else{
							$FormatWardenPermissionNeededInComingShedual = $WardenPermissionNeededInComingShedual;
						}

						# Yes-900
						if($GuradianPermissionNeededByOutGoingAndInComingTimeDiff == 'No'){
							$FormatGuradianPermissionNeededByOutGoingAndInComingTimeDiff = $GuradianPermissionNeededByOutGoingAndInComingTimeDiff;
						}else if($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime != '' && ($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime === preg_replace("/[^0-9]/","",$GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime))){
							if($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}

							$FormatGuradianPermissionNeededByOutGoingAndInComingTimeDiff = $GuradianPermissionNeededByOutGoingAndInComingTimeDiff.'-'.$GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime*$Temp;
							if($GuradianPermissionNeededByOutGoingAndInComingTimeDiffTime*$Temp > 2592000){
								return_response('Max 30 day limit for Guradian Permission Needed By OutGoing And InComing Time Diff'); exit();
							}
						}else{
							return_response('Invalid Guradian Permission Needed By OutGoing And InComing Time Diff detect!'); exit();
						}

						# Yes-900
						if($WardenPermissionNeededByOutGoingAndInComingTimeDiff == 'No'){
							$FormatWardenPermissionNeededByOutGoingAndInComingTimeDiff = $WardenPermissionNeededByOutGoingAndInComingTimeDiff;
						}else if($WardenPermissionNeededByOutGoingAndInComingTimeDiffTime != '' && ($WardenPermissionNeededByOutGoingAndInComingTimeDiffTime === preg_replace("/[^0-9]/","",$WardenPermissionNeededByOutGoingAndInComingTimeDiffTime))){
							if($WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType == 'Hour'){
								$Temp = 60*60;
							}else if($WardenPermissionNeededByOutGoingAndInComingTimeDiffTimeType == 'Minute'){
								$Temp = 60;
							}else{
								$Temp = 1;
							}
							
							$FormatWardenPermissionNeededByOutGoingAndInComingTimeDiff = $WardenPermissionNeededByOutGoingAndInComingTimeDiff.'-'.$WardenPermissionNeededByOutGoingAndInComingTimeDiffTime*$Temp;
							if($WardenPermissionNeededByOutGoingAndInComingTimeDiffTime*$Temp > 2592000){
								return_response('Max 30 day limit for Warden Permission Needed By OutGoing And InComing Time Diff'); exit();
							}
						}else{
							return_response('Invalid Warden Permission Needed By OutGoing And InComing Time Diff detect!'); exit();
						}


						if($FormatMinRequestSubmitAndOutGoingTimeDiff > 0 && $FormatOutGoingTimeTrack == 'No'){
							return_response('You can not make OutGoing Time Track OFF With Min Time Difference For OutGoing'); exit();
						}

						if($FormatInComingTimeTrack == 'No' && $FormatOutGoingTimeTrack == 'No'){
							return_response('You can not make InComing And OutGoing Time Track both OFF'); exit();
						}

						if(($FormatWardenPermissionApprovalNeeded == 'Yes' || $FormatGuardianPermissionApprovalNeeded == 'Yes') && $FormatOutGoingTimeTrack == 'No'){
							return_response('You can not make OutGoing Time Track OFF With Warden Or Guardian Permission Approval Needed'); exit();
						}

						if($FormatMinRequestSubmitAndOutGoingTimeDiff+ 299 >= $FormatMaxRequestSubmitAndOutGoingTimeDiff){
							return_response('Max Time Difference For OutGoing Must Be 5 min Grater Then Min Time Difference For OutGoing'); exit();
						}

						if($FormatMinRequestSubmitAndOutGoingTimeDiff + $FormatMaxTimeWaitForApproveOrRejectPermissionFromAll < 900){
							return_response('Min Tie Diff For OutGoing And Min Time Wait For Approve Or Reject Of Guardian Or Warden Time Add Must be Equal Or Grater Then 15 Min'); exit();
						}

						# Yes
						$FormatGuradianPermissionNeededByOutAndInDateDiff = $GuradianPermissionNeededByOutAndInDateDiff;

						# Yes
						$FormatWardenPermissionNeededByOutAndInDateDiff = $WardenPermissionNeededByOutAndInDateDiff;

						# Father Or Guardian
						$FormatGuardianPermissionPriorityFor = $GuardianPermissionPriorityFor;

						$TrueSettingDataWithFormat = "SettingValue::::MinTimeToSubmitRequestAgain:$FormatMinTimeToSubmitRequestAgain:UpdateAble,MinRequestSubmitAndOutGoingTimeDiff:$FormatMinRequestSubmitAndOutGoingTimeDiff:UpdateAble,MaxRequestSubmitAndOutGoingTimeDiff:$FormatMaxRequestSubmitAndOutGoingTimeDiff:UpdateAble,GuardianPermissionApprovalNeeded:$FormatGuardianPermissionApprovalNeeded:UpdateAble,WardenPermissionApprovalNeeded:$FormatWardenPermissionApprovalNeeded:UpdateAble,InComingTimeTrack:$FormatInComingTimeTrack:UpdateAble,StudentCreateMultipleRequest:$FormatStudentCreateMultipleRequest:UpdateAble,GuradianPermissionNeededOutGoingShedual:$FormatGuradianPermissionNeededOutGoingShedual:UpdateAble,WardenPermissionNeededOutGoingShedual:$FormatWardenPermissionNeededOutGoingShedual:UpdateAble,VerifierPermissionNeededShedual:always:UpdateAble,MaxTimeWaitForApproveOrRejectPermissionFromAll:$FormatMaxTimeWaitForApproveOrRejectPermissionFromAll:UpdateAble,OutGoingTimeTrack:$FormatOutGoingTimeTrack:UpdateAble,MaxTimeWaitForOutGoing:$FormatMaxTimeWaitForOutGoing:UpdateAble,GuradianPermissionNeededInComingShedual:$FormatGuradianPermissionNeededInComingShedual:UpdateAble,WardenPermissionNeededInComingShedual:$FormatWardenPermissionNeededInComingShedual:UpdateAble,GuradianPermissionNeededByOutGoingAndInComingTimeDiff:$FormatGuradianPermissionNeededByOutGoingAndInComingTimeDiff:UpdateAble,WardenPermissionNeededByOutGoingAndInComingTimeDiff:$FormatWardenPermissionNeededByOutGoingAndInComingTimeDiff:UpdateAble,GuradianPermissionNeededByOutAndInDateDiff:$FormatGuradianPermissionNeededByOutAndInDateDiff:UpdateAble,WardenPermissionNeededByOutAndInDateDiff:$FormatWardenPermissionNeededByOutAndInDateDiff:UpdateAble,GuardianPermissionPriorityFor:$FormatGuardianPermissionPriorityFor:UpdateAble";
					}else{
						return_response("Invalid click detect"); exit();
					}

					// Call encode_post_input function
					UpdateSetting::EncryptData($TrueSettingDataWithFormat,$SettingId,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($TrueSettingDataWithFormat,$SettingId,$BrowserClientId1,$BrowserClientId2){

					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
					
					// Call profile_imageResize function
					UpdateSetting::CkeckLoginAndAuthenticate($TrueSettingDataWithFormat,$SettingId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($TrueSettingDataWithFormat,$SettingId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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

					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('User not login'); exit();
					}

					if($ResponseLogin['LAS'] === 'OrganizationMember' && $ResponseLogin['LORT'] === 'College'){
						$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
						if($ResponseRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Org setting data not fetched!'); exit();
						}
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized for take this action'); exit();
					}

					UpdateSetting::UpdateSettingProccess($TrueSettingDataWithFormat,$SettingId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$ResponseRank);
				}
				
				private static function UpdateSettingProccess($TrueSettingDataWithFormat,$SettingId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$ResponseRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];
					$LgPositionRank = $ResponseRank;
					$LgFor = $ResponseLogin['LFR'];
					
					$DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
					
					if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('D GatePass service not active for this organization'); exit();
					}

					$CheckManager = False;

					if($LgPositionRank != 1 && $LgPositionRank != 2){
						$CheckManager = True;
					}

					$GetOrgSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetOrgSetting['status'] != "Success" || $GetOrgSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Org Setting can not feched! Due to technical error');
					}
					foreach ($GetOrgSetting['msg'] as $value){
						${'GetOrgSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}

					$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
					if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
						$DbConnection = $DbConnection['msg'];
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Database connection failed'); exit();
					}
					
					$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
					if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
					    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Service Setting can not feched! Due to technical error');
					}
					foreach ($GetServiceSetting['msg'] as $value){
						${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
					}
					
					$LgServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);
					if($LgServiceMemberData['status'] === 'Success' && $LgServiceMemberData['code'] === 200){
						
						$LgServiceMemberPosition = $LgServiceMemberData['msg']->Position;
						$LgServiceMemberPositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $LgServiceMemberPosition.':', '*');
						if($LgServiceMemberPositionRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not a member of this service'); exit();
						}

						if($LgServiceMemberPositionRank != 1){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('You are not authorized to update setting in this service! 1.3.2'); exit();
						}
					}else if($CheckManager == False){
						$LgServiceMemberPosition = $LgUserPosition;
						$LgServiceMemberPositionRank = $LgPositionRank;
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not a member of this service! 1.3.3'); exit();
					}
					if($SettingId == 'SmsPermissionSmtBtn'){
						$SettingKeyUnique = 'SmsUpdatePermission';
					}else if($SettingId == 'ServiceActiveScheduleSmtBtn'){
						$SettingKeyUnique = 'ServiceActiveSchedule';
					}else if($SettingId == 'GeneralSettingSmtBtn'){
						$SettingKeyUnique = 'GeneralSetting';
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid click detect"); exit();
					}
					
					$UpdateSettingData = UpdateGivenData($TrueSettingDataWithFormat,"SettingKeyUnique::::$SettingKeyUnique",$DbConnection,$LgFor.'_setting',$EncodeAndEncryptPass);
					
					if($UpdateSettingData['status'] === 'Success' && $UpdateSettingData['code'] === 200){
						return_response('Setting Data Updated Successfully',true,'Success',200); exit();
					}else if($UpdateSettingData['code'] == 404){
						return_response('Change Setting data to perform updation',true,'Warning',404); exit();
					}else{
						return_response('Setting Updatedtion failed'); exit();
					}
				}	
			}
			
			// Call classname public function 
			UpdateSetting::ValidedData($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2);
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