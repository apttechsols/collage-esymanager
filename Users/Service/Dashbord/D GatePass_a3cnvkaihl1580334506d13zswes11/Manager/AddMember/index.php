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
				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);

				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::GroupSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
			}
		}
	}

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}else{
		if($ResponseRank != 1 && $ResponseRank != 2){
				$CheckManager = True;
		}
	}

	if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 ) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	/*if($ResponseCheckServiceBuyStatus['msg']['IsServiceActiveted'] != True){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service plan expired for this organization',true,['MSGpadding'=>'40vh 10px']); exit();
	}*/
	
	if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
	    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('Service setting not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	foreach ($GetServiceSetting['msg'] as $value){
		${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
	}
	if($CheckManager == True){
		$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
		if($LgUserServicePositionRank == ''){
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
		}
		if($LgUserServicePositionRank != 1){
			header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
		}
	}

	define("PageTitle", "D GatePass : Add Member");
	define("CssFile", "AddMember");
	require_once RootPath."Site_Header/index.php";

?>
<body class="No_Select_Strat">
	<div class="container">
		<?php
			if($ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
				FullPageErrorMessageDisplay('This service is not buyed for '.$ResponseLogin['LFR'],true,['MSGpadding'=>'40vh 10px']); exit(); 
			} ?>
		<div class="add_member_text">ADD MEMBER</div>
		<div class="SubContainer">
			<div class="ImageBox">
				<div class="ImageLabelBox">
					<img src="<?php echo RootPath; ?>Image_store/NoImageFound400_264px.png" class="ProfileImage" id="ProfileImage">
				</div>
			</div>
			<div class="Form1">
				<div class="UserDataBox">
					<input type="text" name="UserData" id="UserData" maxlength="30" autocomplete="none" placeholder="User Mobile No or Email or UserUrl">
					<p id="UserDataError" class="Error"></p>
				</div>
				<div class="StatusBox">
					<select id="Status">
						<option value="">Status</option>
						<option value="Active">Active</option>
						<option value="Hold">Hold</option>
					</select>
					<p id="StatusError" class="Error"></p>
				</div>
				<div class="PositionBox">
					<select id="Position">
						<option value="">Position</option>
						<?php
							foreach (explode('*', $GetServiceSettingPosition) as $value) {
								$TempPosition = explode(':', $value);
								echo "<option value= $TempPosition[0] >$TempPosition[0] ($TempPosition[1])</option>";
							}
						?>
					</select>
					<p id="PositionError" class="Error"></p>
				</div>
				<?php
					foreach (explode(',', $GetServiceSettingGroupSetting) as $value) {
						$Temp = explode('-', $value);
						${'GetServiceSettingGroupSetting' . $Temp[0]} = $Temp[1];
					}
				?>
				<div class="GroupIdBox">
					<select id='GroupId'>
						<option value="">GroupId</option>
							<?php
								foreach(explode(':', $GetServiceSettingGroupSettingGroupId) as $value){
									echo "<option value=$value>$value</option>";
								}
							?>
					</select>
					<p id="GroupIdError" class="Error"></p>
				</div>
				<div class="GroupTypeBox">
					<select id="GroupType">
						<option value="">GroupType</option>
						<?php
							foreach(explode(':', $GetServiceSettingGroupSettingGroupType) as $value){
								echo "<option value=$value>$value</option>";
							}
						?>
					</select>
					<p id="GroupTypeError" class="Error"></p>
				</div>

				<div class="SecurityCodeBox">
					<input type="password" name="SecurityCode" placeholder="Security Code" id="SecurityCode"
					maxlength="6" autocomplete="none">
					<p id="SecurityCodeError" class="Error"></p>
				</div>
				</div>
				<span class="ResponseBox" id="ResponseBox" style="display: none;"></span>
				<div class="SubmitButton" id="SubmitButton">
					Add Member
					<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span>
				</div>
		</div>
	</div>
</body>
<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){

		//  Status Validation
		$("#Status").change(function() {
				$("#Status option[value='']").prop('disabled',true);
		});

		//  Position Validation
		$("#Position").change(function() {
				$("#Position option[value='']").prop('disabled',true);
		});

		//  GroupId Validation
		$("#GroupId").change(function() {
				$("#GroupId option[value='']").prop('disabled',true);
		});

		//  GroupType Validation
		$("#GroupType").change(function() {
				$("#GroupType option[value='']").prop('disabled',true);
		});

		//  SecurityCode Validation
		$("#SecurityCode").keyup(function(){
			this.value=this.value.replace(/[^0-9]/g,"");
			if(this.value.length > 3 && this.value.length < 7){
				$("#SecurityCodeError").html("");
			}
		});

		$("#SecurityCode").blur(function(){
			if(this.value == ""){
				$("#SecurityCodeError").html("Security code must required");
			}else if(this.value.length < 4 && this.value.length > 6){
				$("#SecurityCodeError").html("Invalid Security code");
			}
		});

		// User Click Button Full Validation
		window.Submit_process = false;
		$("#SubmitButton").click(function(){
			
			if(window.Submit_process != false){
				swal('','Button already clicked','error');return false;
			}

			StartSubmit();
			
			var UserData = $("#UserData").val();
			var Status = $("#Status").val();
			var Position = $("#Position").val();
			var GroupId = $("#GroupId").val();
			var GroupType = $("#GroupType").val();
			var SecurityCode = $("#SecurityCode").val();

			// Position Validataion
			if(UserData == ""){ $("#UserData").html("User Data Must Required"); window.SubmitError = true; }
			if(Status == ""){ $("#Status").html("Status Must Required"); window.SubmitError = true; }
			if(Position == ""){ $("#PositionError").html("Position Must Required"); window.SubmitError = true; }
			if(GroupId == ""){ $("#GroupId").html("GroupId Must Required"); window.SubmitError = true; }
			if(GroupType == ""){ $("#GroupType").html("GroupType Must Required"); window.SubmitError = true; }
			if(SecurityCode == ""){ $("#SecurityCodeError").html("Security Code Must Required"); window.SubmitError = true; }

			if(window.SubmitError == true){
				$("#ResponseBox").html("Please fill all required details").css({'display':'block',"color":"red"}); SubmitReset(); return false;
			}

			if(navigator.onLine == false){
				swal("Please check your internet connection");
				SubmitReset(); return false;
			};
			
			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					

					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					// append data which we want to send data on targeted page
					var formdata = new FormData();
					formdata.append("UserData", UserData);
					formdata.append("Status", Status);
					formdata.append("Position", Position);
					formdata.append("GroupId", GroupId);
					formdata.append("GroupType", GroupType);
					formdata.append("SecurityCode", SecurityCode);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",AddMemberResponse,false);
						ajax.open("POST", "AddMemberBackend.php");
						ajax.send(formdata);
					}catch(error){
						$("#ResponseBox").html(error).css({'display':'block',"color":"red"}); SubmitReset(); return false;
					}
				});
		    });	
		

			//function run on complete login ajax request
			function AddMemberResponse(event){
				SubmitReset();
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
					$("#ResponseBox").html(response['msg']).css({'display':'block',"color":"white"});
					swal('',response['msg'], "success")
					.then(() => {
						window.location.reload(); return false;
					});
				}else{
					swal(response['msg'],'','error');
					$("#ResponseBox").html(response['msg']).css({'display':'block',"color":"red"}); return false;
				}
			}
		});

		function StartSubmit(){
			window.SubmitError = false;
			window.Submit_process = true;
			$(".SubmitButton").css("display","flex");
			$(".loader_round_main").prop('hidden',false);
		}
		function SubmitReset(){
			window.SubmitError = false;
			window.Submit_process = false;
			$(".SubmitButton").css("display","block");
			$(".loader_round_main").prop('hidden',true);
		}

		$('input').keyup(function(){
			$("#ResponseBox").css('display','none');
		});

		$('select').change(function(){
			$("#ResponseBox").css('display','none');
		});
	});
</script>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>