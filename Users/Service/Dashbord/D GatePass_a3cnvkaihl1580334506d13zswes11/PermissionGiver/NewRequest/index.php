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

	$RequestForLoginUserError = False;
	$StoreUserData = array();

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
		$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
		if($ResponseCheckServiceBuyStatus['status'] == 'Success' && $ResponseCheckServiceBuyStatus['code'] == 200 && $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] == True){
			$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
			if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
				$DbConnection = $DbConnection['msg'];

				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position::::GroupId::::GroupType',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);

				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');

				if($ServiceMemberData['status'] === 'Success' && $ServiceMemberData['code'] === 200){
					$RequestForLoginUser = FetchReuiredDataByGivenData("Status::::Open::,::GroupId::::".$ServiceMemberData['msg']->GroupId."::,::GroupType::::".$ServiceMemberData['msg']->GroupType."::,::WardenPermission::::Pending",'RequestId::::RequestFrom::::RequestTime::::Venue::::RequestReason::::RequestOutGoingTime::::GuardianPermission::::SettingValue',$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all',NULL,'all');
					if($RequestForLoginUser['status'] === 'Success' && $RequestForLoginUser['code'] === 200){
						foreach ($RequestForLoginUser['msg'] as $key => $value) {
							if (!array_key_exists($value->RequestFrom,$StoreUserData)){
								$FatchUserDetais = FetchReuiredDataByGivenData("UserUrl::::".$value->RequestFrom,'Fullname::::Gender::::FatherFullname::::FatherMobile::::GuardianFullname::::GuardianMobile::::StudyYear::::Semester::::Branch::::PrimaryBatchId::::ProfileUrl::::State',$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass);
								
								if($FatchUserDetais['status'] === 'Success' && $FatchUserDetais['code'] === 200){
									$StoreUserData[$value->RequestFrom] = $FatchUserDetais['msg'];
								}else{
									$RequestForLoginUserError = True;
								}
							}
						}
					}
				}
			}
		}
	}

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'RequestForLoginUser' && $SetVarKey != 'StoreUserData' && $SetVarKey != 'RequestForLoginUserError' && $SetVarKey != 'CurrentTime' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 || $ServiceMemberData['msg']->Status != 'Active'){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	/*if($ResponseCheckServiceBuyStatus['msg']['IsServiceActiveted'] != True){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service plan expired for this organization',true,['MSGpadding'=>'40vh 10px']); exit();
	}*/

	if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
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
	if($LgUserServicePositionRank != 2){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}
	
	if($RequestForLoginUser['code'] != 200 && $RequestForLoginUser['code'] != 404){
		FullPageErrorMessageDisplay('New Request not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($RequestForLoginUser['code'] != 200){
		FullPageErrorMessageDisplay('Currently There is no Open request available for you',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	
	if($RequestForLoginUserError == True){
		FullPageErrorMessageDisplay('New Request not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	define("PageTitle", "D GatePass : RESPONDER");
	define("CssFile", "NewRequest");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "Request_Main_Container">
			<p class = "Request_Title">REQUEST FOR YOU</p>
			<div class = "MainContainer">
				<div class="RequestBox">
					<?php
						if($RequestForLoginUser['code'] == 200){
						 $CountTotalRequest = 0;
						foreach ($RequestForLoginUser['msg'] as $key => $value) {
							$RequestForUserSettingValueArray = unserialize($value->SettingValue);
						 	if(/*$RequestForUserSettingValueArray['MaxTimeWaitForApproveOrRejectPermissionFromAll'] <= $CurrentTime ||  */($value->GuardianPermission != 'NotNeeded' && $value->GuardianPermission != 'Approve')){
						 		continue;
						 	}else{
						 		$CountTotalRequest++;
						 	}
						 	$TempStoreUserData = $StoreUserData[$value->RequestFrom];
						 	$TempStore = "','".$TempStoreUserData->ProfileUrl ."','". $TempStoreUserData->Fullname ."','". $TempStoreUserData->Gender ."','". $TempStoreUserData->FatherFullname ."','". $TempStoreUserData->FatherMobile ."','". $TempStoreUserData->StudyYear ."','". $TempStoreUserData->Semester ."','". $TempStoreUserData->Branch ."','". $TempStoreUserData->PrimaryBatchId ."','". $TempStoreUserData->State ."','". $value->Venue ."','". date("d-M-Y h:i:s A",$value->RequestOutGoingTime) ."','". date("d-M-Y h:i:s A",$value->RequestTime) ."','". $value->RequestReason ."','". $value->RequestId ."','". $value->RequestFrom ."','";
						 	?>
							<div class = "RequestDetails <?php echo $value->RequestId; ?>">
								<div class="ProfileImageBox">
									<img class="ProfileImage" src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$StoreUserData[$value->RequestFrom]->ProfileUrl; ?>"/>
								</div>
								<div class="FullNameBox">
									<p>FullName</p><p><?php echo $TempStoreUserData->Fullname; ?></p>
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
								<div class="RequestOutGoingTimeBox">
									<p>OutGoing Time</p><p><?php echo date("d-M-Y h:i:s A",$value->RequestOutGoingTime); ?></p>
								</div>
							</div>
							<div class="RequestRespondButtonBox <?php echo $value->RequestId; ?>">
								<div class="ShowDetails" onclick="ShowDetails('ShowDetails<?php echo $TempStore; ?>')">Show Details</div>
								<div class="ApproveRequest" onclick="ShowDetails('Approve<?php echo $TempStore; ?>')">Approve</div>
								<div class="RejectRequest" onclick="ShowDetails('Reject<?php echo $TempStore; ?>')">Reject</div>
								<div class="BlockUser" onclick="ShowDetails('Block<?php echo $TempStore; ?>')">Block User</div>
							</div>
					<?php } }
						if($CountTotalRequest == 0){
							FullPageErrorMessageDisplay('Currently There is no Open request available for you',true,['MSGpadding'=>'40vh 10px']); exit();
						}
					 ?>
				</div>
			</div>
		</div>
		<div Id='ShowDetailsBox' style='display: none;'>
			<div class='CloseShowDetailsBox'>Close</div>
			<div class='Form'>
				<div class="ImageBox">
					<div class="ProfileBox"><img src="" class="Profile"></div>
				</div>
				<div class="Form1">
					<div class="FullnameBoxF1"><span class='InputSpanTitle'>Name : </span><div></div></div>
					<div class="GenderBoxF1"><span class='InputSpanTitle'>Gender : </span><div></div></div>
					<div class="FatherFullnameBoxF1"><span class='InputSpanTitle'>Father's Name : </span><div></div></div>
					<div class="FatherMobileBoxF1"><span class='InputSpanTitle'>Father's Mobile : </span><div></div></div>
					<div class='StudyYearBoxF1'><span class='InputSpanTitle'>Year : </span><div></div></div>
					<div class="SemesterBoxF1"><span class='InputSpanTitle'>Semester : </span><div></div></div>
					<div class="BranchBoxF1"><span class='InputSpanTitle'>Branch : </span><div></div></div>
					<div class="PrimaryBatchIdBoxF1"><span class='InputSpanTitle'>BatchId : </span><div></div></div>
					<div class="StateBoxF1"><span class='InputSpanTitle'>State : </span><div></div></div>
					<div class="VenueBoxF1"><span class='InputSpanTitle'>Venue : </span><div></div></div>
					<div class="RequestOutGoingTimeBoxF1"><span class='InputSpanTitle'>OutGoing Time : </span><div></div></div>
					<div class="RequestTimeBoxF1"><span class='InputSpanTitle'>Request Time : </span><div></div></div>
					<div class="RequestIdBoxF1" style='display: none;'><span class='InputSpanTitle'>Request Id : </span><div></div></div>
					<div class="RequestFromBoxF1" style='display: none;'><span class='InputSpanTitle'>Request From : </span><div></div></div>
				</div>
				<div class='FormLast'>
					<div class="RequestReasonBoxFLast"><span class='InputSpanTitle'>Reason : </span><div></div></div>
					<input type="password" name="SecurityCode" spellcheck="false" maxlength="6" class="SecurityCode" id='SecurityCode' placeholder="Security Code" style='display: none;'>
					<span class="ResponseBox" id="ResponseBox" style="display: none;"></span>
					<div id="ResponseButton" style='display: none;'><span id='ResponseButtonName'></span><span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span></div>
				</div>
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>

<script>
	$(document).ready(function(){
		$('.CloseShowDetailsBox').click(function(){
			$('#ShowDetailsBox').css('display','none');
			$('#SecurityCode').val('').css({'display':'none'});
			$('#ResponseButton').css({'display':'none'});
			$('#ResponseButtonName').html('');
			$("#ResponseBox").html('').css({'display':'none',"color":"red"});
		});

		$('#SecurityCode').keyup(function(){
			$("#ResponseBox").html('');
		});

		window.Submit_process = false;
		$('#ResponseButton').click(function(){
			if(window.Submit_process == true){
				swal('','A request already in queue','warning'); return false;
			}
			StartSubmit();
			var RequestType = $('#ResponseButtonName').html();
			var RequestId = $('.RequestIdBoxF1 div').html();
			var RequestFrom = $('.RequestFromBoxF1 div').html();
			var SecurityCode = $('#SecurityCode').val();
			
			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					

					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					// append data which we want to send data on targeted page
					var formdata = new FormData();
					formdata.append("RequestType", RequestType);
					formdata.append("RequestId", RequestId);
					formdata.append("RequestFrom", RequestFrom);
					formdata.append("SecurityCode", SecurityCode);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					if(navigator.onLine == false){
						swal('',"Please check your internet connection",'warning');
						$("#ResponseBox").html('Please check your internet connection').css({'display':'block',"color":"red"});
						SubmitReset(); return false;
					};

					if(RequestType != 'Approve' && RequestType != 'Reject' && RequestType != 'Block'){
						swal('',"Invalid request detect",'warning'); SubmitReset(); return false;
					}

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",ResponseHandler,false);
						ajax.open("POST", 'ResponseSend.php');
						ajax.send(formdata);
					}catch(error){
						$("#ResponseBox").html(error).css({'display':'block',"color":"red"}); SubmitReset(); return false;
					}

					function ResponseHandler(event){
						SubmitReset();
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
							$('.'+RequestId).remove();
							$("#ResponseBox").html(response['msg']).css({'display':'block',"color":"white"});
							swal('',response['msg'], "success")
							.then(() => {
								$('.CloseShowDetailsBox').click(); return false;
							});
						}else{
							swal('',response['msg'],'error');
							$("#ResponseBox").html(response['msg']).css({'display':'block',"color":"red"}); return false;
						}
					}
				});
		    });	
		});

		function StartSubmit(){
			window.Submit_process = true;
			$(".loader_round_main").prop('hidden',false);
		}
		function SubmitReset(){
			window.Submit_process = false;
			$(".loader_round_main").prop('hidden',true);
		}
	});
	function ShowDetails(RequestType,Profile,Fullname,Gender,FatherFullname,FatherMobile,StudyYear,Semester,Branch,PrimaryBatchId,State,Venue,RequestOutGoingTime,RequestTime,RequestReason,RequestId,RequestFrom){
		$('.Profile').attr('src',RootPath+'Users/UserDataStore/ProfileImage/Organization/<?php echo $ResponseLogin['LFR']; ?>/'+Profile);
		$('.FullnameBoxF1 div').html(Fullname);
		$('.GenderBoxF1 div').html(Gender);
		$('.FatherFullnameBoxF1 div').html(FatherFullname);
		$('.FatherMobileBoxF1 div').html(FatherMobile);
		$('.StudyYearBoxF1 div').html(StudyYear);
		$('.SemesterBoxF1 div').html(Semester);
		$('.BranchBoxF1 div').html(Branch);
		$('.PrimaryBatchIdBoxF1 div').html(PrimaryBatchId);
		$('.StateBoxF1 div').html(State);
		$('.VenueBoxF1 div').html(Venue);
		$('.RequestOutGoingTimeBoxF1 div').html(RequestOutGoingTime);
		$('.RequestTimeBoxF1 div').html(RequestTime);
		$('.RequestIdBoxF1 div').html(RequestId);
		$('.RequestFromBoxF1 div').html(RequestFrom);
		$('.RequestReasonBoxFLast div').html(RequestReason);
		$('#ShowDetailsBox').css('display','block');
		if(RequestType != 'ShowDetails'){
			if(RequestType == 'Approve'){
				$('#ResponseButtonName').html('Approve');
			}else if(RequestType == 'Reject'){
				$('#ResponseButtonName').html('Reject');
			}else if(RequestType == 'Block'){
				$('#ResponseButtonName').html('Block');
			}else{
				return false;
			}
			$('#SecurityCode').css({'display':'block'});
			$('#ResponseButton').css({'display':'block'});
		}
	}
</script>
</html>