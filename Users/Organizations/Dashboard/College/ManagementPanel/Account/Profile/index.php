<?php
	/*
	*@FileName Profile/index.php
	*@Des Provide your Profile details
	*@Author arpit sharma
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


	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	/*-------------- Apt Library -----------------------*/
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

	#return_response(AptPdoFetchWithAes(['Condtion'=> "SettingKeyUnique::::Position", 'FetchData'=>'SettingValue', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>1]));

	$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);

	$ResponseRank = GetSubStringBetweenTwoCharacter(AptPdoFetchWithAes(['Condtion'=> "SettingKeyUnique::::Position", 'FetchData'=>'SettingValue', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>1])['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	$GetOrganizationData = AptPdoFetchWithAes(['Condtion'=> "SettingKeyUnique::::Position::,::SettingKeyUnique::::Branch::,::SettingKeyUnique::::StudyYear::,::SettingKeyUnique::::StudySemester::,::SettingKeyUnique::::PrimaryBatchId::,::SettingKeyUnique::::SecondaryBatchId::,::SettingKeyUnique::::MemberOperationPermissionRankUpTo", 'FetchData'=>'SettingKeyUnique::::SettingValue', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'All','DefaultCheckFor'=>'Any']);
	
	$GetUpdateUserData = AptPdoFetchWithAes(['Condtion'=> "UserUrl::::".$ResponseLogin['msg']['UserUrl'], 'FetchData'=>'Status::::Fullname::::Mobile::::Email::::Gender::::Position::::PrimaryBatchId::::SecondaryBatchId::::UniqueId::::FatherFullname::::FatherMobile::::FatherEmail::::Department::::Semester::::StudyYear::::Branch::::OrgJoinTime::::OrgExitTime::::Pincode::::City::::State::::Country::::Address::::ProfileUrl', 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass]);


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
	}
	
	define("PageTitle", "Profile");
	define("CssFile", "Profile");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class="container">
		<div class="add_member_text">PROFILE</div>
		<div class="SubContainer">
		    <?php
    		    if($GetUpdateUserData['status'] != 'Success' || $GetUpdateUserData['code'] != 200 || $GetUpdateUserData['totalrows'] != 1){
        			 FullPageErrorMessageDisplay('We not found this user in organitaion member',true,['MSGpadding'=>'40vh 10px']); exit();
        		}
		    ?>
			<div class="ImageBox">
				<div class="ImageLabelBox">
					<input class="ProfileImageFile" type="file" name="ProfileImageFile" id="ProfileImageFile" accept="image/*" hidden>
					<img src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$GetUpdateUserData['msg']->ProfileUrl; ?>" class="ProfileImage" id="ProfileImage">
				</div>
			</div>
			<div class="Form1">
			    <div class="StatusBox">
			    	<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Status; ?></p>
			    	<p class='DtlTl'>Status</p>
				</div>
				
				<div class="FullNameBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Fullname; ?></p>
					<p class='DtlTl'>Name</p>
				</div>
				
				<div class="MobileNumberBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Mobile; ?></p>
					<p class='DtlTl'>Mobiles</p>
				</div>
				<div class="EmailBox">
					<?php if($GetUpdateUserData['msg']->Email != ''){ ?>
						<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Email; ?></p>
					<?php }else{ ?>
						<p class='DtlTxt'><?php echo 'Unknown'; ?></p>
					<?php } ?>
					<p class='DtlTl'>Email</p>
				</div>
				<div class="GenderBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Gender; ?></p>
					<p class='DtlTl'>Gender</p>
				</div>
				<div class="PositionBox">
					<p class='DtlTxt'><?php echo $ResponseLogin['msg']['Position']; ?></p>
					<p class='DtlTl'>Position</p>
				</div>
                <div class='OrgJoinTimeBox'>
					<?php if($GetUpdateUserData['msg']->OrgJoinTime > 0){ ?>
						<p class='DtlTxt'><?php echo date("d-M-Y, h:i:s A",$GetUpdateUserData['msg']->OrgJoinTime); ?></p>
					<?php }else{ ?>
						<p class='DtlTxt'><?php echo 'Unknown'; ?></p>
					<?php } ?>
					<p class='DtlTl'>Org Join Time</p>
				</div>
				
				<div class="UniqueIdBox">
					<?php if($GetUpdateUserData['msg']->UniqueId != ''){ ?>
						<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->UniqueId; ?></p>
					<?php }else{ ?>
						<p class='DtlTxt'><?php echo 'Unknown'; ?></p>
					<?php } ?>
					<p class='DtlTl'>Unique Id</p>
				</div>

				<div class="DepartmentBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Department;; ?></p>
					<p class='DtlTl'>Department</p>
				</div>
				<div class="AddressBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Address; ?></p>
					<p class='DtlTl'>Address</p>
				</div>
				<div class="CityBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->City; ?></p>
					<p class='DtlTl'>City</p>
				</div>
				<div class="StateBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->State; ?></p>
					<p class='DtlTl'>State</p>
				</div>
				<div class="CountryBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Country; ?></p>
					<p class='DtlTl'>Country</p>
				</div>
				<div class="PincodeBox">
					<p class='DtlTxt'><?php echo $GetUpdateUserData['msg']->Pincode; ?></p>
					<p class='DtlTl'>Pincode</p>
				</div>
			</div>
			<div class='Form2'>
				<div class='Button ChangePassAndPin'>Change Password & Pin</div>
			</div>
		</div>
	</div>
</body>
<div class='Footer'>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</div>
</html>
<script>
	$(document).ready(()=>{
		$('.ChangePassAndPin').click(function(){
			window.location.href = RootPath+'LibraryStore/SiteComponents/ChangePasswordAndPin/index.php';
		});
	});
</script>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>