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

	$GetUserUrl = $_GET['u'];
	
	$CurrentTime = time();
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

				$ServiceGetUserData =FetchReuiredDataByGivenData("UserUrl::::$GetUserUrl",'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
				if($ServiceGetUserData['status'] === 'Success' && $ServiceGetUserData['code'] === 200){
					$GetApprovePendingInComingRequest = AptPdoFetchWithAes(['Condtion'=> "Status::::Approve::,::InComingStatus::::Pending::,::RequestFrom::::$GetUserUrl", 'FetchData'=>'WardenPermission::::RequestId::::WardenPermissionTime::::WardenUrl::::RequestTime::::Venue::::RequestReason::::RequestOutGoingTime::::GuardianPermission::::GuardianPermissionTime::::OutGoingStatus::::ExactOutGoingTime::::InComingStatus::::SettingValue', 'DbCon'=> $DbConnection, 'TbName'=> $ResponseLogin['LFR'].'_request_store', 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DataOrder'=> 'DESC|RequestOutGoingTime']);

					if($GetApprovePendingInComingRequest['status'] === 'Success' && $GetApprovePendingInComingRequest['code'] === 200){
						foreach ($GetApprovePendingInComingRequest['msg'] as $key => $value) {
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
				}
			}
		}
	}
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'GetUserUrl' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'ServiceGetUserData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetApprovePendingInComingRequest' && $SetVarKey != 'StoreWardenUrlData' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	if(($ServiceGetUserData['status'] != 'Success' || $ServiceGetUserData['code'] != 200 ) || ($ServiceGetUserData['msg']->Status != 'Active')){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	if($ResponseRank != 1 && $ResponseRank != 2){
		if(($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 )){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
		}
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

	if($ResponseRank != 1 && $ResponseRank != 2){
		$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*',  $ServiceMemberData['msg']->Position.':', '*');
		if($LgUserServicePositionRank == ''){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
		}
		
		if($LgUserServicePositionRank != 1){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
		}
	}

	$GetUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceGetUserData['msg']->Position.':', '*');
	if($GetUserServicePositionRank == ''){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	
	if($GetUserServicePositionRank != 0){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	/*if($ResponseCheckServiceBuyStatus['msg']['IsServiceActiveted'] != True){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service plan expired for this organization',true,['MSGpadding'=>'40vh 10px']); exit();
	}*/

	if($GetApprovePendingInComingRequest['code'] == 404){
		FullPageErrorMessageDisplay('Currently no requested created by Student',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($GetApprovePendingInComingRequest['code'] == 400){
		FullPageErrorMessageDisplay('Student Request data not feched, due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
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

	define("PageTitle", "D GatePass : Request Status");
	define("CssFile", "RequestStatus");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "Request_Main_Container">
			<p class = "Request_Title" >REQUEST STATUS</p>
			<div class = "MainContainer">
				<div class="RequestBox">
					<?php
					if($GetApprovePendingInComingRequest['code'] == 200){
						 foreach ($GetApprovePendingInComingRequest['msg'] as $key => $value) { $TempStoreWardenUrlData = $StoreWardenUrlData[$value->WardenUrl]; $TempSettingValue = unserialize($value->SettingValue); ?>
						 	<span class="<?php echo $value->RequestId; ?>">
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
												$CheckStMaxOutGoingTime = false;
											}
										}else{
											$CheckStMaxInComingTime = false;
										}
									}else{
										$CheckStMaxInComingTime = false;
									}

									if($CheckStMaxOutGoingTime == true){
										continue;
									}
								?>
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
									if($CheckStMaxInComingTime == true){
										echo "<div class='NoticeBord' style='color:red;'>
											<p>Warning - Your InComing Status Still Pending, but your Max InComing time expired</p>
										</div>";
										echo "<div id='$value->RequestId' class='CloseBtn'>
											<p>Close</p>
										</div>";
									}
								?>
							</span>
					<?php } }
					?>
				</div>
			</div>
		</div>
	</body>
	<?php
	require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){
		window.SubmitButton = false;
		$(".CloseBtn").click(function(){
			if(window.SubmitButton == true){
				swal('','A process already in queue','warning'); return false;
			}
			var ReqId = this.id;
			SubmitStart();

			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					var d1 = new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX");
					

					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					swal('Enter your Security Code to Close this request', {
						buttons: {
							cancel: "Cancel",
							Next: true,
						},
						content: {
							element: "input",
							attributes: {
								placeholder: "Security Code",
								type: "password",
								className: "VirtualSecurityCode",
								autocomplete: "off",
							},
						},
					  	closeOnClickOutside: false,
					  	closeOnEsc: false,
					})
					.then((value) => {
						if(value === "Next"){
							// append data which we want to send data on targeted page
							var formdata = new FormData();
							formdata.append('StUserUrl', '<?php echo $GetUserUrl; ?>');
							formdata.append('ReqId', ReqId);
							formdata.append("SecurityCode", $(".VirtualSecurityCode").val());
							formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
							formdata.append("BrowserClientId1", BrowserClientId1);
							formdata.append("BrowserClientId2", BrowserClientId2);

							// Check Internet connection
							if(navigator.onLine == false){
								swal("It seems that you are offline. Please check your internet connection", "", "warning");
								SubmitReset(); return false;
							}
							
							try{
								var ajax = new XMLHttpRequest();
								ajax.addEventListener("load",ReqCloseResponse,false);
								ajax.open("POST", 'RequestCloseBackend.php');
								ajax.send(formdata);
							}catch(error){
								swal("",'Response can not sent Error('+error+')','error'); SubmitReset(); return false;
							}

							//function run on listion response from ajax
							function ReqCloseResponse(event){
								SubmitReset();
								var response = $.parseJSON(event.target.responseText);
								if(response['status'] === "Success" && response['code'] === 200){
									swal('',response['msg'], "success")
									.then(() => {
										$("."+ReqId).remove();
									});
					               }else{
									swal('',response['msg'],'error');
								}
								return false;
							}
						}else{
							SubmitReset();
						}
					});
				});
		    });

			function SubmitStart(){
				window.SubmitButton = true;
				$('.CloseBtn').css("pointer-events","none");
				$(".CloseBtn").css("background","linear-gradient(skyblue, pink)");
				$(".CloseBtn").css("cursor","default");
				$(".loader_round_main").prop('hidden',false);
			}

			function SubmitReset(){
				$('.CloseBtn').css("pointer-events","auto");
				$(".CloseBtn").css("background","transparent");
				$(".CloseBtn").css("cursor","pointer");
				$(".loader_round_main").prop('hidden',true);
				window.SubmitButton = false;
			}
		});
	});
</script>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ?>