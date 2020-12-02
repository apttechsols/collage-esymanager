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

	$OrgId = $_GET['D0'];
	$GRId = $_GET['D1'];

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
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	
	$CurrentTime = time();

	$GetError = array();
	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');

	$ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$OrgId,$CurrentTime);
	if($ResponseCheckServiceBuyStatus['status'] == 'Success' && $ResponseCheckServiceBuyStatus['code'] == 200 && $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] == True){
		$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
		if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
			$DbConnection = $DbConnection['msg'];

			$RequestForUser = FetchReuiredDataByGivenData("GuardianPermissionReceiveUrlKey::::$GRId",'GuardianPermission::::RequestFrom::::Venue::::RequestReason::::RequestOutGoingTime::::RequestInComingTime::::SettingValue',$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass,'all');
		}
	}

	if($RequestForUser['code'] == 200){
		$ReqIdUserDetails = FetchReuiredDataByGivenData("UserUrl::::".$RequestForUser['msg']->RequestFrom,'Status::::Fullname::::FatherFullname::::GuardianFullname::::FatherMobile::::GuardianMobile::::GuardianGender::::ProfileUrl',$PdoOrganizationUserAccount,$OrgId,$EncodeAndEncryptPass,'all');
		$OrgDetails = FetchReuiredDataByGivenData("UserUrl::::$OrgId",'OrganizationName::::Status',$PdoMainUserAccountDb,'main_user_accounts',$EncodeAndEncryptPass,'all');
	}
	if($RequestForUser['msg']->GuardianPermission == 'Pending'){
		$RequestForUserSettingValueArray = unserialize($RequestForUser['msg']->SettingValue);
		if($RequestForUserSettingValueArray['MaxTimeWaitForApproveOrRejectPermissionFromAll'] <= $CurrentTime){
			$Response = UpdateGivenData("Status::::Closed::,::StatusReason::::This request is auto closed, It is expired because your Guardian not respond on this request!","GuardianPermissionReceiveUrlKey::::$GRId",$DbConnection,$OrgId.'_request_store',$EncodeAndEncryptPass,'all');
			array_push($GetError, ['code'=>'3.0','dis'=>"Now you can not Approve Or Reject it, Beause Maximum time for approve or reject is ended! That's why it is closed"]);
		}
	}

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'CurrentTime' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'OrgId' && $SetVarKey != 'GRId' && $SetVarKey != 'ReqIdUserDetails' && $SetVarKey != 'RequestForUser' && $SetVarKey != 'OrgDetails' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetError' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars

	if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
		FullPageErrorMessageDisplay('This information only for Guardian or Father',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		FullPageErrorMessageDisplay('D GatePass is Currently not buyed by this organizationS',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($RequestForUser['code'] != 200 && $RequestForUser['code'] != 404){
		FullPageErrorMessageDisplay('D GatePass request data not fetch! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($RequestForUser['code'] != 200){
		FullPageErrorMessageDisplay('Invalid request id detect',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($RequestForUser['msg']->GuardianPermission != 'Pending'){
		if($RequestForUser['msg']->GuardianPermission == 'NotNeeded'){
			FullPageErrorMessageDisplay('This Request is not needed to Guardian Approval!',true,['MSGpadding'=>'40vh 10px']); exit();
		}

		FullPageErrorMessageDisplay('This Request already '.$RequestForUser['msg']->GuardianPermission.'! You can not change it',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($ReqIdUserDetails['code'] != 200){
		FullPageErrorMessageDisplay('User details not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if(sizeof($GetError) > 0){
		FullPageErrorMessageDisplay($GetError[0]['dis'],true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($OrgDetails['status'] != 'Success' || $OrgDetails['code'] != 200){
		FullPageErrorMessageDisplay('Invalid OrganizationId detect',true,['MSGpadding'=>'40vh 10px']); exit();
	}else if($OrgDetails['msg']->Status != 'Active'){
		FullPageErrorMessageDisplay($OrgDetails['msg']->OrganizationName.' is currently not Active on EsyManager',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	if($ReqIdUserDetails['msg']->GuardianMobile != ''){
		$PName = $ReqIdUserDetails['msg']->GuardianFullname;
		$PGander = $ReqIdUserDetails['msg']->GuardianGender;
	}else{
		$PName = $ReqIdUserDetails['msg']->FatherFullname;
		$PGander = 'Male';
	}
	if($PGander == 'Male'){
		$NamePrfx = 'Mr.';
	}else{
		$NamePrfx = 'Ms.';
	}
	
	define("PageTitle", "D GatePass : Guardian");
	define("CssFile", "GuardianRequest");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "MainContainer">
			<p class = "RequestTitle" >Your Chlid Hostal Digital GatePass Request </p>
			<div class = "SubContainer">
				<?php echo "<div class='PWlcMsg'>Welcome $NamePrfx $PName</div>
				<div class='RequestContainer'>
					<div class='StudentProfile'><img class = 'StudentProfileImg' src=".RootPath."Users/UserDataStore/ProfileImage/Organization/$OrgId/".$ReqIdUserDetails['msg']->ProfileUrl."></div>
					<div class='StBox'><span class='StTl'>College</span><span class='StDt'>".$OrgDetails['msg']->OrganizationName."</span></div>
					<div class='StBox'><span class='StTl'>Name</span><span class='StDt'>".$ReqIdUserDetails['msg']->Fullname."</span></div>
					<div class='StBox'><span class='StTl'>Father</span><span class='StDt'>Mr. ".$ReqIdUserDetails['msg']->FatherFullname."</span></div>
					<div class='StBox'><span class='StTl'>Vanue</span><span class='StDt'>".$RequestForUser['msg']->Venue."</span></div>
					<div class='StBox'><span class='StTl'>Reason</span><span class='StDt'>".$RequestForUser['msg']->RequestReason."</span></div>
					<div class='StBox'><span class='StTl'>OutGoing</span><span class='StDt'>".date('d-M-Y, h:i:s A', $RequestForUser['msg']->RequestOutGoingTime)."</span></div>
					<div class='StBox StLastBox'>
						<span class='StTl'>Guardian Permission</span>
						<span class='StDt'>
							<input type='radio' id='StPrApprove' name='StPr' value='Approve'><label for='StPrApprove'>Approve</label><input type='radio' id='StPrReject' name='StPr' value='Reject'><label for='StPrReject'>Reject</label>
						</span>
					</div>
					<div class='SmtBtn'>Submit<span class='loader_round_main' hidden='true'><span class='loader_round loader_button_center'><span></span></span></span></div>
				</div>
				"; ?>
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){
		window.SubmitProcess = false;
		$(".SmtBtn").click(function(){
			if(window.SubmitProcess == false){
				SubmitStart();
				// append data which we want to send data on targeted page
				var formdata = new FormData();
				formdata.append("OrgId", "<?php echo $OrgId; ?>");
				formdata.append("GRId", "<?php echo $GRId; ?>");
				formdata.append("StPr", $("input[name='StPr']:checked").val());
				formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");

				// Check Internet connection
				if(navigator.onLine == false){
					swal('',"It seems that you are offline. Please check your internet connection", "warning"); SubmitReset(); return false;
				}
				
				// Send data on sigup backend page for uploading on the server
				try{
					var ajax = new XMLHttpRequest();
					ajax.addEventListener("load",SubmitResponse,false);
					ajax.open("POST", "GuardianPermissionBackend.php");
					ajax.send(formdata);
				}catch(error){
					swal('', 'An technical error accur! 1.0', "error"); SubmitReset(); return false;
				}

				//function run on complete login ajax request
				function SubmitResponse(event){
					SubmitReset();
					try{
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] == "Success" && response['code'] == 200){
							swal('','<?php echo "$NamePrfx $PName, "; ?>'+response['msg'], "success")
							.then(() => {
								$('.SubContainer').remove();
								$('.Footer_Container').remove();
								$('.RequestTitle').html('<?php echo "$NamePrfx $PName, "; ?>'+response['msg']);
							});
						}else{
							swal('',response['msg'], "error");
						}
					}catch(error){
						swal('', error, "error"); SubmitReset();
						//swal('', 'An technical error accur! 2.0', "error"); SubmitReset();
					}
					return false;
					// F/ZTk=DBfXÐX‰Ö
					// r1X)3[_3û¹S,ŠMM±
				}
			}else{
				SubmitStart();return false;
			}
		});
		function SubmitStart(){
			window.SubmitProcess = true;
			$("input").prop("disabled",true);
			$('.SmtBtn').css("pointer-events","none");
			$(".SmtBtn").css("background","linear-gradient(skyblue, pink)");
			$(".SmtBtn").css("cursor","default");
			$(".loader_round_main").prop('hidden',false);
		}

		function SubmitReset(){
			$("input").prop("disabled",false);
			$('.SmtBtn').css("pointer-events","auto");
			$(".SmtBtn").css("background","");
			$(".SmtBtn").css("cursor","pointer");
			$(".loader_round_main").prop('hidden',true);
			window.SubmitProcess = false;
		}
	});
</script>