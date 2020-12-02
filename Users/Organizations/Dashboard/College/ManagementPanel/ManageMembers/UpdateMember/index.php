<?php
	/*
	*@FileNameUpdateMember/index.php
	*@Des Add new members for organitaion
	*@Author Arpit sharma
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
	$UpdateUserUrl = $_GET['UserUrl'];

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
	
	$GetUpdateUserData = FetchReuiredDataByGivenData("UserUrl::::$UpdateUserUrl",'Status::::Fullname::::Mobile::::Email::::Gender::::Position::::PrimaryBatchId::::SecondaryBatchId::::UniqueId::::FatherFullname::::FatherMobile::::FatherEmail::::GuardianGender::::GuardianFullname::::GuardianMobile::::GuardianEmail::::Department::::Semester::::StudyYear::::Branch::::OrgJoinTime::::OrgExitTime::::Pincode::::City::::State::::Country::::Address::::ProfileUrl',$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'all');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'GetOrganizationData' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'GetUpdateUserData' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
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
	
	define("PageTitle", "Update Member");
	define("CssFile", "UpdateMember");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class="container">
		<div class="add_member_text">UPDATE MEMBER</div>
		<div class="SubContainer">
		    <?php
    		    if($GetUpdateUserData['status'] != 'Success' || $GetUpdateUserData['code'] != 200 || $GetUpdateUserData['totalrows'] != 1){
        			 FullPageErrorMessageDisplay('We not found this user in organitaion member',true,['MSGpadding'=>'40vh 10px']); exit();
        		}
            	
            	if($ResponseRank < $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToStart || $ResponseRank > $MemberOperationPermissionRankUpToChangeMemberPermissionRankUpToEnd){
            	    FullPageErrorMessageDisplay('You are not Authorized for Update Member',true,['MSGpadding'=>'40vh 10px']); exit();
            	}
		    ?>
			<div class="ImageBox">
				<div class="ImageLabelBox">
					<input class="ProfileImageFile" type="file" name="ProfileImageFile" id="ProfileImageFile" accept="image/*" hidden>
					<img src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$GetUpdateUserData['msg']->ProfileUrl; ?>" class="ProfileImage" id="ProfileImage">
					<div>
						<label class="ProfileImageFileLabel" for="ProfileImageFile">Choose Profile</label>
					</div>
				</div>
			</div>
			<div class="Form1">
			    <div class="StatusBox">
					<select id="Status">
						<option value="" >Status</option>
  						<option value="Active">Active</option>
  						<option value="Hold">Hold</option>
  						<option value="Block">Block</option>
  					</select>
					<p id="FullNameError" class="Error"></p>
				</div>
				
				<div class="FullNameBox">
					<input type="text" name="name" placeholder="Fullname" id="FullName" maxlength="30" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->Fullname; ?>" autocomplete="none">
					<p id="FullNameError" class="Error"></p>
				</div>
				
				<div class="MobileNumberBox">
					<input type="text" name="number" placeholder="Mobile Number" id="MobileNumber" maxlength="15" value="<?php echo $GetUpdateUserData['msg']->Mobile; ?>" autocomplete="none">
					<p id="MobileNumberError" class="Error"></p>
				</div>
				<div class="EmailBox">
					<input type="email" name="Email" class='Email' placeholder="Email (optional)" id="Email" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->Email; ?>" autocomplete="none" maxlength="60">
					<p id="EmailError" class="Error"></p>
				</div>
				<div class="GenderBox">
					<select id="Gender">
						<option value="" id="DefaultGender">Gender</option>
  						<option value="Male">Male</option>
  						<option value="Female">Female</option>
  						<option value="Other">Other</option>
					</select>
					<p id="GenderError" class="Error"></p>
				</div>
				<div class="PositionBox">
					<select id="Position">
						<option value="" id="DefaultPosition">Position</option>
						<?php
							foreach(explode('@', $GetOrganizationDataPosition) as $value){
								$Temp = explode(':', $value);
								echo "<option value = $Temp[0]> $Temp[0] ($Temp[1])</option>";
							}
					    ?>
					</select>
					<p id="PositionError" class="Error"></p>
				</div>

				<div class="PrimaryBatchIdBox" hidden="true">
					<input type="text" class='SearchPrimaryBatchId' spellcheck="false" placeholder="Search Primary Batch Id" value='<?php echo $GetUpdateUserData['msg']->PrimaryBatchId; ?>'>
					<select id="PrimaryBatchId">
						<option value="">Primary Batch Id</option>
						<?php
							$TempGetPrimaryBatchIdArray = explode('@', $GetOrganizationDataPrimaryBatchId);
							foreach ($TempGetPrimaryBatchIdArray as $value) {
								echo "<option value = $value> $value</option>";
							}
						?>
					</select>
					<p id="PrimaryBatchIdError" class="Error"></p>
				</div>

				<div class="SecondaryBatchIdBox" hidden="true">
					<input type="text" class='SearchSecondaryBatchId' spellcheck="false" placeholder="Search Primary Batch Id" value="<?php echo $GetUpdateUserData['msg']->SecondaryBatchId; ?>">
					<select id="SecondaryBatchId">
						<option value="">Secondary Batch Id</option>
						<?php
							$TempGetSecondaryBatchIdArray = explode('@', $GetOrganizationDataSecondaryBatchId);
							foreach ($TempGetSecondaryBatchIdArray as $value) {
								echo "<option value = $value> $value</option>";
							}
						?>
					</select>
					<p id="SecondaryBatchIdError" class="Error"></p>
				</div>
                <div class='OrgJoinTimeBox'>
					<p>Organization join Time</p>
					<div class='OrgJoinTime'>
						<input type="number" class="OrgJoinDate" placeholder="Date" value="<?php if($GetUpdateUserData['msg']->OrgJoinTime > 0){ echo date("d",$GetUpdateUserData['msg']->OrgJoinTime);} ?>" />
						<input type="number" class="OrgJoinMonth" placeholder="Month" value="<?php if($GetUpdateUserData['msg']->OrgJoinTime > 0){ echo date("m",$GetUpdateUserData['msg']->OrgJoinTime);} ?>" />
						<input type="number" class="OrgJoinYear" placeholder="Year" value="<?php if($GetUpdateUserData['msg']->OrgJoinTime > 0){ echo date("Y",$GetUpdateUserData['msg']->OrgJoinTime);} ?>" />
					</div>
					<p id="OrgJoinTimeError" class="Error"></p>
				</div>
				
				<div class="UniqueIdBox" hidden="true">
					<input type="text" name="UniqueId" id="UniqueId" value="<?php echo $GetUpdateUserData['msg']->UniqueId; ?>" maxlength="30" autocomplete="none">
					<p id="UniqueIdError" class="Error"></p>
				</div>

				<div class="FathersNameBox" hidden="true">
					<input type="text" name="name" class='FathersName' placeholder="Father's Name" id="FathersName" maxlength="30" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->FatherFullname; ?>" autocomplete="none">
					<p id="FathersNameError" class="Error"></p>
				</div>
				<div class="FathersMobileNumberBox" hidden="true">
					<input type="text" name="number" placeholder="Father's Mobile Number" id="FathersMobileNumber" maxlength="15" value="<?php echo $GetUpdateUserData['msg']->FatherMobile; ?>" autocomplete="none">
					<p id="FathersMobileNumberError" class="Error"></p>
				</div>	
				<div class="FathersEmailBox" hidden="true">
					<input type="email" name="Email" class='FathersEmail' placeholder="Father's Email (optional)" id="FathersEmail" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->FatherEmail; ?>" autocomplete="none" maxlength="60">
					<p id="FathersEmailError" class="Error"></p>
				</div>
				<div class="GuardianGenderBox" hidden="true">
					<select id="GuardianGender">
						<option value="" id="DefaultGuardianGender">Guardian Gender (optional)</option>
  						<option value="Male">Male</option>
  						<option value="Female">Female</option>
  						<option value="Other">Other</option>
					</select>
					<p id="GuardianGenderError" class="Error"></p>
				</div>
				
				<div class="GuardianNameBox" hidden="true">
					<input type="text" name="name" class='GuardianName' placeholder="Guardian Name (optional)" id="GuardianName" maxlength="30" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->GuardianFullname; ?>" autocomplete="none">
					<p id="GuardianNameError" class="Error"></p>
				</div>
				<div class="GuardianMobileNumberBox" hidden="true">
					<input type="text" name="number" placeholder="Guardian Mobile Number (optional)" id="GuardianMobileNumber" maxlength="15" value="<?php echo $GetUpdateUserData['msg']->GuardianMobile; ?>" autocomplete="none">
					<p id="GuardianMobileNumberError" class="Error"></p>
				</div>	
				<div class="GuardianEmailBox" hidden="true">
					<input type="email" name="Email" class='GuardianEmail' placeholder="Guardian Email (optional)" id="GuardianEmail" spellcheck="false" autocomplete="none" value="<?php echo $GetUpdateUserData['msg']->GuardianEmail; ?>" maxlength="60">
					<p id="GuardianEmailError" class="Error"></p>
				</div>
				<div class="DepartmentBox" hidden="true">
					<select id="Department">
						<option value="" id="DefaultDepartment">Department (optional)</option>
						<?php
							foreach(explode('@', $GetOrganizationDataBranch) as $value){
								echo "<option value = $value> $value</option>";
							}
					    ?>
					</select>
					<p id="DepartmentError" class="Error"></p>
				</div>
				<div class="BranchBox" hidden="true">
					<select id="Branch">
						<option value="" id="DefaultBranch">Branch</option>
						<?php
							foreach(explode('@', $GetOrganizationDataBranch) as $value){
								echo "<option value = $value> $value</option>";
							}
					    ?>
					</select>
					<p id="BranchError" class="Error"></p>
				</div>
				<div class="YearBox" hidden="true">
					<select id="Year">
						<option value="" id="DefaultYear">Year</option>
						<?php
							foreach(explode('@', $GetOrganizationDataStudyYear) as $value){
								echo "<option value = $value> $value</option>";
							}
					    ?>
					</select>
					<p id="YearError" class="Error"></p>
				</div>
				
				<div class="SemesterBox" hidden="true">
					<select id="Semester">>	
						<option value="" id="DefaultSemester">Semester</option>
						<?php
							foreach(explode('@', $GetOrganizationDataStudySemester) as $value){
								echo "<option value = $value> $value</option>";
							}
					    ?>
					</select>
					<p id="SemesterError" class="Error"></p>
				</div>
				<div class="PincodeBox">
					<input type="text" name="pincode" placeholder="Pincode" id="Pincode" maxlength="6" value="<?php echo $GetUpdateUserData['msg']->Pincode; ?>" autocomplete="none">
					<p id="PincodeError" class="Error"></p>
				</div>
				<div class="CountryBox">
					<input type="text" name="country" placeholder="Country" id="Country" value="<?php echo $GetUpdateUserData['msg']->Country; ?>" maxlength="50">
					<p id="CountryError" class="Error"></p>
				</div>
				<div class="StateBox">
					<input type="text" name="state" placeholder="State" id="State" value="<?php echo $GetUpdateUserData['msg']->State; ?>" maxlength="50" autocomplete="none">
					<p id="StateError" class="Error"></p>
				</div>
				<div class="CityBox">
					<input type="text" name="city" placeholder="City" id="City" value="<?php echo $GetUpdateUserData['msg']->City; ?>" maxlength="50" autocomplete="none">
					<p id="CityError" class="Error"></p>
				</div>
				<div class="AddressBox">
					<input class="Address" id="Address" placeholder="Address" maxlength="100" spellcheck="false" value="<?php echo $GetUpdateUserData['msg']->Address; ?>" autocomplete="none"/>
					<p id="AddressError" class="Error"></p>
				</div>
				<div class="SecurityCodeBox">
					<input type="password" name="SecurityCode" placeholder="Security Code" id="SecurityCode" maxlength="6" autocomplete="none">
					<p id="SecurityCodeError" class="Error"></p>
				</div>
			</div>
			<span class="ResponseBox" id="ResponseBox" style="display: none;"></span>
			<div class="SubmitButton" id="SubmitButton">
				Update Member
				<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span>
			</div>
		</div>
	</div>
</body>
<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){

		// Verify Date
		function isDate(txtDate){
		    var currVal = txtDate;
		    if(currVal == '')
		        return false;
		    
		    var rxDatePattern = /^(\d{1,2})(\-|-)(\d{1,2})(\-|-)(\d{4})$/; //Declare Regex
		    var dtArray = currVal.match(rxDatePattern); // is format OK?
		    
		    if (dtArray == null) 
		        return false;
		    
		    //Checks for mm/dd/yyyy format.
		    dtDay = dtArray[1];
    		dtMonth= dtArray[3];
		    dtYear = dtArray[5];        
		    
		    if (dtMonth < 1 || dtMonth > 12) 
		        return false;
		    else if (dtDay < 1 || dtDay> 31) 
		        return false;
		    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
		        return false;
		    else if (dtMonth == 2) 
		    {
		        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
		                return false;
		    }
		    return true;
		}

		// Profile Image Validation

		$("#ProfileImageFile").change(function(){
			if(this.files.length==1){
				if((this.files[0].size/1024).toFixed(2) < 2048){
					var reader= new FileReader();
					reader.onload = function(event){
						$("#ProfileImage").attr('src',event.target.result);
					}
					reader.readAsDataURL(this.files[0]);
				}else{
					swal("Image size must be under 2 mb")
					.then((value) => {
						$(".ProfileImageFileLabel").click();
					});
				}
			}else{
				if(this.files.length>1){
					swal("Choose only one profile image")
					.then((value) => {
						$(".ProfileImageFileLabel").click();
					});
				}else{
					swal("Profile image required")
					.then((value) => {
						$(".ProfileImageFileLabel").click();
					});
				}
				$("#ProfileImage").attr('src',"<?php echo RootPath; ?>Image_store/cute_dog.jpg");
			}
		});

		// Fullname Validation
		$("#FullName").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length >=6 && this.value.length<=30){
				if(this.value.replace(/ /g,"").length != this.value.length){
					if(this.value.split(" ")[0].length > 0 && this.value.split(" ")[1].length > 0){
						$("#FullNameError").html("");
					}
				}else{
					$("#FullNameError").html("It looks like firstname");
				}
			}
		});

		$("#FullName").blur(function(){
			if(this.value == ""){
				$("#FullNameError").html("Fullname must required");
			}else if(this.value.length < 6 || this.value.length > 30){
				$("#FullNameError").html("Name length must lie between 6 to 30 character");			
			}else if(this.value.replace(/[^ ]/g,"").length != this.value.length){
				if(this.value.split(" ")[0].length < 1 || this.value.split(" ")[1].length < 1){
					$("#FullNameError").html("It looks like firstname");
				}
			}
		});

		// Unique id validation 
		$("#UniqueId").keyup(function(){
			this.value=this.value.replace(/[^A-Za-z0-9@-_]/g,"");
			if(this.value != ""){
				$("#UniqueIdError").html("");
			}
		});

		$("#UniqueId").blur(function(){
			if($("#Position").val() == 'Student'){
				if(this.value == ""){
					$("#UniqueIdError").html("Unique must required");
				}
			}
		});

		// Mobile Number Validation
		$("#MobileNumber").keyup(function(){
			this.value=this.value.replace(/[^0-9]/g,"");
			if(this.value.length >= 10){
				$("#MobileNumberError").html("");
			}
		});
		$("#MobileNumber").blur(function(){
			if(this.value == ""){
				$("#MobileNumberError").html("Mobile Number must required");	
			}else if(this.value.length != 10){
				$("#MobileNumberError").html("Invalid Mobile Number");			
			}
		});

		//  Email validations
		$("#Email").keyup(function(){
			var Email = $("#Email").val();
			if(Email.length > 0){
				var user_gmail_address_length = Email.substring(0,Email.length-10).length;
				var user_gmail_address_length_after_validations = Email.substring(0,Email.length-10).replace(/[^A-Za-z0-9.]/g,"").length;
				if(user_gmail_address_length == user_gmail_address_length_after_validations && user_gmail_address_length_after_validations >= 6 && user_gmail_address_length_after_validations <= 30){
					if(Email.substring(Email.length-10,Email.length) == "@gmail.com"){
						$("#EmailError").html("");
					}
				}
			}else{
				$("#EmailError").html("");
			}
		});

		$("#Email").blur(function(){
			var Email = $("#Email").val();
			if(Email.length > 0){
				var user_gmail_address_length = Email.substring(0,Email.length-10).length;
				var user_gmail_address_length_after_validations = Email.substring(0,Email.length-10).replace(/[^A-Za-z0-9.]/g,"").length;
				if(user_gmail_address_length == user_gmail_address_length_after_validations && user_gmail_address_length_after_validations >= 6 && user_gmail_address_length_after_validations <= 30){
					if(Email.substring(Email.length-10,Email.length) != "@gmail.com"){
						$("#EmailError").html("Your gmail is invalid");
					}
				}else{
					$("#EmailError").html("Your gmail is invalid");
				}
			}else{
				$("#EmailError").html("");
			}
		});

		//  Gender validation 
		$("#Gender").change(function() {
				$("#DefaultGender").prop('disabled',true);
		});

		$('.SearchPrimaryBatchId').keyup(function(){
			$('#PrimaryBatchId option:contains("'+this.value+'")').prop('selected', true);
			$('#PrimaryBatchId option:contains("&ampA")').prop('selected', true);
		});

		$('.SearchSecondaryBatchId').keyup(function(){
			$('#SecondaryBatchId option:contains("'+this.value+'")').prop('selected', true);
			$('#SecondaryBatchId option:contains("&ampA")').prop('selected', true);
		});

		// FathersName validation
		$("#FathersName").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length >=6 && this.value.length<=30){
				if(this.value.replace(/ /g,"").length != this.value.length){
					if(this.value.split(" ")[0].length > 0 && this.value.split(" ")[1].length > 0){
						$("#FathersNameError").html("");
					}
				}else{
					$("#FathersNameError").html("It looks like firstname");
				}
			}
		});

		$("#FathersName").blur(function(){
			if(this.value.length > 0){
				if(this.value.length < 6 || this.value.length > 30){
					$("#FathersNameError").html("Name length must lie between 6 to 30 character");			
				}else if(this.value.replace(/[^ ]/g,"").length != this.value.length){
					if(this.value.split(" ")[0].length < 1 || this.value.split(" ")[1].length < 1){
						$("#FathersNameError").html("It looks like firstname");
					}
				}
			}else{
				$("#FathersNameError").html("");
			}
		});

		$('.OrgJoinTime input').keyup(function(){
			$('#OrgJoinTimeError').html('');
		});

		// FathersMobileNumber Validation
		$("#FathersMobileNumber").keyup(function(){
			this.value=this.value.replace(/[^0-9]/g,"");
			if(this.value.length > 0){
				if(this.value.length >= 10){
					$("#FathersMobileNumberError").html("");
				}
			}else{
				$("#FathersMobileNumberError").html("");
			}
		});
		$("#FathersMobileNumber").blur(function(){
			if(this.value.length > 0){
				if(this.value.length != 10){
					$("#FathersMobileNumberError").html("Invalid Mobile Number");			
				}
			}else{
				$("#FathersMobileNumberError").html("");
			}
		});

		// GuardianName validation
		$("#GuardianName").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length >=6 && this.value.length<=30){
				if(this.value.replace(/ /g,"").length != this.value.length){
					if(this.value.split(" ")[0].length > 0 && this.value.split(" ")[1].length > 0){
						$("#GuardianNameError").html("");
					}
				}else{
					$("#GuardianNameError").html("It looks like firstname");
				}
			}
		});

		$("#GuardianName").blur(function(){
			if(this.value.length > 0){
				if(this.value.length < 6 || this.value.length > 30){
					$("#GuardianNameError").html("Name length must lie between 6 to 30 character");			
				}else if(this.value.replace(/[^ ]/g,"").length != this.value.length){
					if(this.value.split(" ")[0].length < 1 || this.value.split(" ")[1].length < 1){
						$("#GuardianNameError").html("It looks like firstname");
					}
				}
			}else{
				$("#GuardianNameError").html("");
			}
		});

		// GuardianMobileNumber Validation
		$("#GuardianMobileNumber").keyup(function(){
			this.value=this.value.replace(/[^0-9]/g,"");
			if(this.value.length > 0){
				if(this.value.length >= 10){
					$("#GuardianMobileNumberError").html("");
				}
			}else{
				$("#GuardianMobileNumberError").html("");
			}
		});
		$("#GuardianMobileNumber").blur(function(){
			if(this.value.length > 0){
				if(this.value.length != 10){
					$("#GuardianMobileNumberError").html("Invalid Mobile Number");			
				}
			}else{
				$("#GuardianMobileNumberError").html("");
			}
		});

		//  Position Validation
		$("#Position").change(function() {
				$("#defaultPosition").prop('disabled',true);
				if(this.value != ""){
					$("#PositionError").html("");			
				}
				$("#UniqueIdError").html("");
				$(".UniqueIdBox").prop('hidden',false);
				if(this.value === 'Student'){
					$(".DepartmentBox").prop('hidden',true);
					$(".FathersNameBox, .FathersMobileNumberBox, .FathersEmailBox, .BranchBox, .YearBox, .SemesterBox, .SecondaryBatchIdBox ,.PrimaryBatchIdBox,.GuardianGenderBox,.GuardianNameBox,.GuardianMobileNumberBox,.GuardianEmailBox").prop('hidden',false);
					$("#UniqueId").attr('placeholder','Unique Id');
				}else{
					$(".FathersNameBox, .FathersMobileNumberBox, .FathersEmailBox, .BranchBox, .YearBox, .SemesterBox, .SecondaryBatchIdBox ,.PrimaryBatchIdBox,.GuardianGenderBox,.GuardianNameBox,.GuardianMobileNumberBox,.GuardianEmailBox").prop('hidden',true);
					$(".DepartmentBox").prop('hidden',false);
					$("#UniqueId").attr('placeholder','Unique Id (Optional)');
				}
		});

		//  Pincode Validation
		$("#Pincode").keyup(function(){
			this.value=this.value.replace(/[^0-9]/g,"");
			if(this.value.length == 6){
				$("#PincodeError").html("");
			}
		});

		$("#Pincode").blur(function(){
			if(this.value == ""){
				$("#PincodeError").html("Pincode must required");	
			}else if(this.value.length != 6){
				$("#PincodeError").html("Invalid Pincode");			
			}
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

		// City Validation
		$("#City").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length > 2 && this.value.length < 50){
				$("#CityError").html("");
			}
		});

		$("#City").blur(function(){
			if(this.value.length > 50 || this.value.length <= 2){
				$("#CityError").html("City Name must be between 2 to 50");			
			}
		});

		// State Validation
		$("#State").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length > 2 && this.value.length < 50){
				$("#StateError").html("");
			}
		});

		$("#State").blur(function(){
			if(this.value.length > 50 || this.value.length <= 2){
				$("#StateError").html("State Name must be between 2 to 50");			
			}
		});

		// Country Validation
		$("#Country").keyup(function(){
		    this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length > 1 && this.value.length < 50){
				$("#CountryError").html("");
			}
		});

		$("#Country").blur(function(){
			if(this.value.length > 50 || this.value.length <= 1){
				$("#CountryError").html("Country Name must be between 2 to 50");			
			}
		});

		//  Address Validation
		$("#Address").keyup(function(){
			 this.value = this.value.replace(/[^A-Za-z0-9]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z0-9.,-_ ]/g,'').slice(1).toLowerCase();
			if(this.value.length > 10 || this.value.length < 100){
				$("#AddressError").html("");
			}
		});

		$("#Address").blur(function(){
			if(this.value.length < 10 || this.value.length > 100){
				$("#AddressError").html("Address length lie between 10 to 100");
			}
		});

		//  PrimaryBatchId Validation
		$("#PrimaryBatchId").change(function(){
			$("#PrimaryBatchId option[value = '']").prop('disabled',true);
			if(this.value != ''){
				$("#PrimaryBatchIdError").html('');
			}
		});

		//  Department Validation
		$("#Department").change(function(){
			//$("#DefaultDepartment").prop('disabled',true);
			if(this.value != ''){
				$("#DepartmentError").html('');
			}
		});

		//  Branch Validation
		$("#Branch").change(function(){
			$("#DefaultBranch").prop('disabled',true);
			if(this.value != ''){
				$("#BranchError").html('');
			}
		});

		//  Year Validation
		$("#Year").change(function(){
			$("#DefaultYear").prop('disabled',true);
			if(this.value != ''){
				$("#YearError").html('');
			}
		});

		//  Semester Validation
		$("#Semester").change(function(){
			$("#DefaultSemester").prop('disabled',true);
			if(this.value != ''){
				$("#SemesterError").html('');
			}
		}); 

		// User Click Button Full Validation
		window.Submit_process = false;
		$("#SubmitButton").click(function(){
			
			if(window.Submit_process != false){
				swal('','Button already clicked','error');return false;
			}

			// Create Some Temp Vars
			var OrgJoinDate = $(".OrgJoinDate").val();
			var OrgJoinMonth = $(".OrgJoinMonth").val();
			var OrgJoinYear = $(".OrgJoinYear").val();

			StartSubmit();
			
			var Status = $("#Status").val();
			var FullName = $("#FullName").val();
			var UniqueId = $("#UniqueId").val();
			var Email = $("#Email").val();
			var MobileNumber = $("#MobileNumber").val();
			var Gender = $("#Gender").val();
			var OrgJoinTime = OrgJoinDate+'-'+OrgJoinMonth+'-'+OrgJoinYear;
			var PrimaryBatchId = $("#PrimaryBatchId").val();
			var SecondaryBatchId = $("#SecondaryBatchId").val();
			var FatherFullname = $("#FathersName").val();
			var FatherMobileNo = $("#FathersMobileNumber").val();
			var FatherEmail = $("#FathersEmail").val();
			var GuardianGender = $("#GuardianGender").val();
			var GuardianFullname = $("#GuardianName").val();
			var GuardianMobileNo = $("#GuardianMobileNumber").val();
			var GuardianEmail = $("#GuardianEmail").val();
			var Position = $("#Position").val();
			var Department = $("#Department").val();
			var Branch = $("#Branch").val();
			var Year = $("#Year").val();
			var Semester = $("#Semester").val();
			var Country = $("#Country").val();
			var State = $("#State").val();
			var City = $("#City").val();
			var Pincode = $("#Pincode").val();
			var Address = $("#Address").val();
			var SecurityCode = $("#SecurityCode").val();

			if(OrgJoinTime != '--'){
				if(OrgJoinYear < 1970 || OrgJoinYear > (new Date).getFullYear()){
					$("#OrgJoinTimeError").html("Join Time detect invalid"); window.SubmitError = true;
				}

				if(window.SubmitError == false){
					if(!isDate(OrgJoinTime)){
						$("#OrgJoinTimeError").html("Join Time detect invalid"); window.SubmitError = true;
					}
				}
			}
			
			// Name Validataion
			if(FullName == ""){ $("#FullNameError").html("Fullname must required"); window.SubmitError = true; }

			// Mobile Number Validataion
			if(MobileNumber == ""){ $("#MobileNumberError").html("Mobile Number Must Required"); window.SubmitError = true; }

			// Gender Validataion
			if(Gender == ""){ $("#GenderError").html("Gender Must Required"); window.SubmitError = true; }

			// Position Validataion
			if(Position == ""){ $("#PositionError").html("Position Must Required"); window.SubmitError = true; }

			// Pincode Validataion
			if(Pincode == ""){ $("#PincodeError").html("Pincode Must Required"); window.SubmitError = true; }

			// City Name Validataion
			if(City == ""){ $("#CityError").html("City Must Required"); window.SubmitError = true; }

			// State Validataion
			if(State == ""){ $("#StateError").html("State Must Required"); window.SubmitError = true; }

			// Country Validataion
			if(Country == ""){ $("#CountryError").html("Country Name Must Required"); window.SubmitError = true; }

			// Address Validataion
			if(Address == ""){ $("#AddressError").html("Address Must Required"); window.SubmitError = true; }

			//SecurityCode Validation
			if(SecurityCode == ""){ $("#SecurityCodeError").html("Security Code Must Required"); window.SubmitError = true; }
			
			if(Position === 'Student'){
				if(UniqueId == ""){ $("#UniqueIdError").html("UniqueId must required"); window.SubmitError = true; }
				if(PrimaryBatchId == ""){ $("#PrimaryBatchIdError").html("Primary Batch Id must required"); window.SubmitError = true; }
				if(FatherFullname == ""){ $("#FathersNameError").html("FathersName Must Required"); window.SubmitError = true; }
				if(FatherMobileNo == ""){ $("#FathersMobileNumberError").html("Father Mobile Number Must Required"); window.SubmitError = true; }
				if(Branch == ""){ $("#BranchError").html("Branch Must Required"); window.SubmitError = true; }
				if(Year == ""){ $("#YearError").html("Year Must Required"); window.SubmitError = true; }
				if(Semester == ""){ $("#SemesterError").html("Semester Must Required"); window.SubmitError = true; }
			}else{
				
			}
			
			// Error handel
			if(window.SubmitError == true){
				$("#ResponseBox").html("Please fill all required details").css({'display':'block',"color":"red"}); SubmitReset(); return false;
			}else{
				if(document.getElementById("ProfileImageFile").files.length > 1){
					SubmitReset();
					swal("Select Only One Profile Image")
					.then((value) => {
						$(".ProfileImageFileLabel").click();
					});
					return false;
				}else{
					var ProfileImage = $("#ProfileImageFile")[0].files[0];
				}
			}

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
					formdata.append("Status", Status);
					formdata.append("Fullname", FullName);
					formdata.append("MobileNo", MobileNumber);
					formdata.append("Gender", Gender);
					formdata.append("Email", Email);
					formdata.append("OrgJoinTime", OrgJoinTime);
					formdata.append("Position", Position);
					formdata.append("Pincode", Pincode);
					formdata.append("City", City);
					formdata.append("State", State);
					formdata.append("Country", Country);
					formdata.append("Address", Address);
					formdata.append("Department", Department);
					formdata.append("Branch", Branch);
					formdata.append("Year", Year);
					formdata.append("Semester", Semester);
					formdata.append("FatherFullname", FatherFullname);
					formdata.append("FatherMobileNo", FatherMobileNo);
					formdata.append("FatherEmail", FatherEmail);
					formdata.append("GuardianGender", GuardianGender);
					formdata.append("GuardianFullname", GuardianFullname);
					formdata.append("GuardianMobileNo", GuardianMobileNo);
					formdata.append("GuardianEmail", GuardianEmail);
					formdata.append("UniqueId", UniqueId);
					formdata.append("PrimaryBatchId", PrimaryBatchId);
					formdata.append("SecondaryBatchId", SecondaryBatchId);
					formdata.append("ProfileImage", ProfileImage);
					formdata.append("SecurityCode", SecurityCode);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",AddNewMemberResponse,false);
						ajax.open("POST", "UpdateMemberBackend.php");
						ajax.send(formdata);
					}catch(error){
						$("#ResponseBox").html(error).css({'display':'block',"color":"red"});
						SubmitReset(); return false;
					}
				});
		    });	
		

			//function run on complete login ajax request
			function AddNewMemberResponse(event)
			{	
				SubmitReset();
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
				    $("#ResponseBox").html(response['msg']).css({'display':'block',"color":"white"});
					swal('',response['msg'],'success')
					.then((value) => {
					    location.reload();
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
		(function(){
		    $("#Status option[value='<?php echo $GetUpdateUserData['msg']->Status; ?>']").prop('selected',true);
		    $("#Gender option[value='<?php echo $GetUpdateUserData['msg']->Gender; ?>']").prop('selected',true);
		    $("#GuardianGender option[value='<?php echo $GetUpdateUserData['msg']->GuardianGender; ?>']").prop('selected',true);
		    $("#PrimaryBatchId option[value='<?php echo $GetUpdateUserData['msg']->PrimaryBatchId; ?>']").prop('selected',true);
		    $("#SecondaryBatchId option[value='<?php echo $GetUpdateUserData['msg']->SecondaryBatchId; ?>']").prop('selected',true);
		    $("#Branch option[value='<?php echo $GetUpdateUserData['msg']->Branch; ?>']").prop('selected',true);
		    $("#Year option[value='<?php echo $GetUpdateUserData['msg']->StudyYear; ?>']").prop('selected',true);
		    $("#Semester option[value='<?php echo $GetUpdateUserData['msg']->Semester; ?>']").prop('selected',true);
		    $("#Department option[value='<?php echo $GetUpdateUserData['msg']->Department; ?>']").prop('selected',true);
		    $("#Position option[value='<?php echo $GetUpdateUserData['msg']->Position; ?>']").prop('selected',true);
		    $( "#Position" ).trigger( "change" );
		}());
	});
</script>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>