<?php
	/*
	*@FileName DeleteMember/index.php
	*@Des Delete members for organitaion
	*@Author Ashutosh Dhamaniya
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

	define("RootPath", "../../../../../../../");

	if(!isset($_GET['UserUrl']) || strlen($_GET['UserUrl']) !== 30){
		header("Location: " . RootPath . 'LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php'); die();
	}
	$DeleteUserUrl = $_GET['UserUrl'];

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

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	$GetOrganizationData = FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::Branch::,::SettingKeyUnique::::StudyYear::,::SettingKeyUnique::::StudySemester::,::SettingKeyUnique::::PrimaryBatchId::,::SettingKeyUnique::::SecondaryBatchId::,::SettingKeyUnique::::MemberOperationPermissionRankUpTo",'SettingKeyUnique::::SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'any',null,'all');
	
	$GetDeleteUserData = FetchReuiredDataByGivenData("UserUrl::::$DeleteUserUrl",'Status::::Fullname::::Mobile::::Email::::Gender::::Position::::PrimaryBatchId::::SecondaryBatchId::::UniqueId::::FatherFullname::::FatherMobile::::FatherEmail::::Department::::Semester::::StudyYear::::Branch::::OrgJoinTime::::OrgExitTime::::Pincode::::City::::State::::Country::::Address::::ProfileUrl',$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'all');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'GetOrganizationData' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'GetDeleteUserData' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php?RequestFrom=OrganizationMember&&LoginStatus=Logout"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'College'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank == 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}

		if($GetOrganizationData['status'] != 'Success' || $GetOrganizationData['code'] != 200 || $GetOrganizationData['totalrows'] < 1){
			FullPageErrorMessageDisplay('We not found any Position for this organitaion',true,['MSGpadding'=>'40vh 10px']); exit();
		}
		
		foreach ($GetOrganizationData['msg'] as $value) {
			${'GetOrganizationData' . $value->SettingKeyUnique} = $value->SettingValue;
		}

		$TempArray = explode('@', $GetOrganizationDataMemberOperationPermissionRankUpTo);
		foreach ($TempArray as $value) {
			$Temp = explode(':', $value);
			$Temp1 = explode(',', $Temp[1]);
			${'MemberOperationPermissionRankUpTo' . $Temp[0] . 'Start'} = $Temp1[0];
			${'MemberOperationPermissionRankUpTo' . $Temp[0] . 'End'} = $Temp1[1];
		}
	}
	
	define("PageTitle", "Delete Member");
	define("CssFile", "DeleteMember");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class="container">
		<div class="add_member_text">DELETE MEMBER</div>
		<div class="SubContainer">
		    <?php
    		    if($GetDeleteUserData['status'] != 'Success' || $GetDeleteUserData['code'] != 200 || $GetDeleteUserData['totalrows'] != 1){
        			 FullPageErrorMessageDisplay('We not found this user in organitaion member',true,['MSGpadding'=>'40vh 10px']); exit();
        		}

        		if($GetDeleteUserData['msg']->Position == 'Owner'){
        			 FullPageErrorMessageDisplay('You can not Delete owner here',true,['MSGpadding'=>'40vh 10px']); exit();
        		}
            	
            	if($ResponseRank < $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart || $ResponseRank > $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToEnd){
            	    FullPageErrorMessageDisplay('You are not Authorized for Update Member',true,['MSGpadding'=>'40vh 10px']); exit();
            	}
		    ?>
			<div class="ImageBox">
				<div class="ImageLabelBox">
					<img src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$GetDeleteUserData['msg']->ProfileUrl; ?>" class="ProfileImage" id="ProfileImage">
				</div>
			</div>
			<div class="Form1">
			    <div class="StatusBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Status; ?></p>
					<p class='DUFldNm'>Status</p>
				</div>
				
				<div class="FullNameBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Fullname; ?></p>
					<p class='DUFldNm'>FullName</p>
				</div>
				
				<div class="MobileNumberBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Mobile; ?></p>
					<p class='DUFldNm'>Mobile</p>
				</div>
				<div class="EmailBox">
					<?php if($GetDeleteUserData['msg']->Email != ''){
                		echo "<p class='DUDtls'>".$GetDeleteUserData['msg']->Email."</p>";
                	}else{
                		echo "<p class='DUDtls'>Unknown</p>";
                	} ?>
					<p class='DUFldNm'>Email</p>
				</div>
				<div class="GenderBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Gender; ?></p>
					<p class='DUFldNm'>Gender</p>
				</div>
				<div class="PositionBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Position; ?></p>
					<p class='DUFldNm'>Position</p>
				</div>

				<?php if($GetDeleteUserData['msg']->PrimaryBatchId != ''){ ?>
					<div class="PrimaryBatchIdBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->PrimaryBatchId; ?></p>
						<p class='DUFldNm'>Primary Batch Id</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->SecondaryBatchId != ''){ ?>
					<div class="SecondaryBatchIdBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->SecondaryBatchId; ?></p>
						<p class='DUFldNm'>Secondary Batch Id</p>
					</div>
				<?php } ?>
                <div class='OrgJoinTimeBox'>
                	<?php if($GetDeleteUserData['msg']->OrgJoinTime != -1){
                		echo "<p class='DUDtls'>".date('d-M-Y',$GetDeleteUserData['msg']->OrgJoinTime)."</p>";
                	}else{
                		echo "<p class='DUDtls'>Unknown</p>";
                	} ?>
					<p class='DUFldNm'>Org Join Time</p>
				</div>
				
				<?php if($GetDeleteUserData['msg']->UniqueId != ''){ ?>
					<div class="UniqueIdBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->UniqueId; ?></p>
						<p class='DUFldNm'>UniqueId</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->FatherFullname != ''){ ?>
					<div class="FathersNameBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->FatherFullname; ?></p>
						<p class='DUFldNm'>Father Name</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->FatherMobile != ''){ ?>
					<div class="FathersMobileNumberBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->FatherMobile; ?></p>
						<p class='DUFldNm'>Father Mobile</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->FatherEmail != ''){ ?>
					<div class="FathersEmailBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->FatherEmail; ?></p>
						<p class='DUFldNm'>Father Email</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->Department != ''){ ?>
					<div class="DepartmentBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Department; ?></p>
						<p class='DUFldNm'>Department</p>
					</div>
				<?php } ?>	

				<?php if($GetDeleteUserData['msg']->Branch != ''){ ?>
					<div class="BranchBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Branch; ?></p>
						<p class='DUFldNm'>Branch</p>
					</div>
				<?php } ?>

				<?php if($GetDeleteUserData['msg']->StudyYear != ''){ ?>
					<div class="YearBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->StudyYear; ?></p>
						<p class='DUFldNm'>Year</p>
					</div>
				<?php } ?>
				
				<?php if($GetDeleteUserData['msg']->Semester != ''){ ?>
					<div class="SemesterBox">
						<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Semester; ?></p>
						<p class='DUFldNm'>Semester</p>
					</div>
				<?php } ?>
				<div class="PincodeBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Pincode; ?></p>
					<p class='DUFldNm'>Pincode</p>
				</div>
				<div class="CountryBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Country; ?></p>
					<p class='DUFldNm'>Country</p>
				</div>
				<div class="StateBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->State; ?></p>
					<p class='DUFldNm'>State</p>
				</div>
				<div class="CityBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->City; ?></p>
					<p class='DUFldNm'>City</p>
				</div>
				<div class="AddressBox">
					<p class='DUDtls'><?php echo $GetDeleteUserData['msg']->Address; ?></p>
					<p class='DUFldNm'>Address</p>
				</div>
			</div>
			<div class="Form2">
				<div class="SecurityCodeBox">
					<input type="password" name="SecurityCode" placeholder="Security Code" id="SecurityCode" maxlength="6" autocomplete="none">
					<p id="SecurityCodeError" class="Error"></p>
				</div>
			</div>
			<span class="ResponseBox" id="ResponseBox" style="display: none;"></span>
			<div class="SubmitButton" id="SubmitButton">
				Delete Member
				<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span>
			</div>
		</div>
	</div>
</body>
<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){

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
			var SecurityCode = $("#SecurityCode").val();

			if(navigator.onLine == false){
				swal("Please check your internet connection");
				SubmitReset();
				return false;
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
					formdata.append("UserUrl", '<?php echo $_GET['UserUrl']; ?>');
					formdata.append("SecurityCode", SecurityCode);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",DeleteMemberResponse,false);
						ajax.open("POST", "DeleteMemberBackend.php");
						ajax.send(formdata);
					}catch(error){
						$("#ResponseBox").html(error).css({'display':'block',"color":"red"});
						SubmitReset(); return false;
					}
				});
		    });	
		

			//function run on complete login ajax request
			function DeleteMemberResponse(event)
			{	
				SubmitReset();
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
				    $("#ResponseBox").html(response['msg']).css({'display':'block',"color":"white"});
					swal('',response['msg'],'success')
					.then((value) => {
					    window.location.replace(RootPath+'Users/Organizations/Dashboard/College/ManagementPanel/ManageMembers/SearchMember/index.php?Search=<?php echo $GetDeleteUserData['msg']->Mobile; ?>');
					});
				}else if(response['code'] === 404){
					swal(response['msg'],'','warning');
					$("#ResponseBox").html(response['msg']).css({'display':'block',"color":"yellow"}); return false;
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
	});
</script>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>