<?php
	/*
	*@FileName College/index.php
	*@Des Provide dashboard layout or interface
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

	define("RootPath", "../../../../");

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

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
	
	$ResponseData = FetchReuiredDataByGivenData("ServiceFor::::,".$ResponseLogin['LORT'].',',"Name::::ShortDescription::::Code",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'StartLikeLast',NULL,'all');

	$ResponseDataAll = FetchReuiredDataByGivenData("ServiceFor::::All","Name::::ShortDescription::::Code",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'StartLikeLast',NULL,'all');

	$PlansCountStore = array();

	if($ResponseData['status'] === 'Success' && $ResponseData['code'] === 200){
		foreach ($ResponseData['msg'] as $key => $value) {
			$TempResponse = FetchReuiredDataByGivenData("Status::::Active::,::PlanFor::::".$ResponseData['msg'][$key]->Code,"Signature",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all');
			if($TempResponse['status'] === 'Success'){
				$PlansCountStore[$ResponseData['msg'][$key]->Name] = $TempResponse['totalrows'];
			}
		}
	}

	if($ResponseDataAll['status'] === 'Success' && $ResponseDataAll['code'] === 200){
		foreach ($ResponseDataAll['msg'] as $key => $value) {
			$TempResponse = FetchReuiredDataByGivenData("Status::::Active::,::PlanFor::::".$ResponseDataAll['msg'][$key]->Code,"Signature",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all');
			if($TempResponse['status'] === 'Success'){
				$PlansCountStore[$ResponseDataAll['msg'][$key]->Name] = $TempResponse['totalrows'];
			}
		}
	}

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseData' && $SetVarKey != 'ResponseDataAll' && $SetVarKey != 'PlansCountStore' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank != 1 && $ResponseRank != 2){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}

	define("PageTitle", "Available Service");
	define("CssFile", "AvailableService");
	require_once RootPath."Site_Header/index.php";

?>
<body>
	<div class='Container'>
		<?php
			if(($ResponseData['status'] != 'Success' || $ResponseData['code'] != 200) && ($ResponseDataAll['status'] != 'Success' || $ResponseDataAll['code'] != 200)){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>No service found for your organization</p>"; exit();
			}
		?>
		<?php
			if($ResponseData['status'] === 'Success' && $ResponseData['code'] === 200){ ?>
				<div class='ServiceFor'>For &#10148; <b><?php echo $Response['LORT']; ?></b></div>
				<?php foreach ($ResponseData['msg'] as $key => $value) { ?>
					<div class='ServiceBox'>
						<div class='ServiceOne'>
							<p class='ServiceNameBox'><b>Name </b>&#10148; <span class='ServiceName'><?php echo $ResponseData['msg'][$key]->Name; ?></span></p>
							<p class='ServicePlansBox'><span><b>Available Plans </b>&#10148; <span class='ServicePlans'><?php echo $PlansCountStore[$ResponseData['msg'][$key]->Name]; ?> packs</span></span><span class='ServiceOpenBox' id='<?php echo $ResponseData['msg'][$key]->Code; ?>' onclick='OpenService(this.id);'>Open</span></p>
						</div>
						<div class='ServiceSecond'>
							<p class='ServiceDescriptionBox'><b>Discription </b>&#10148; <span class='ServiceDescription'><?php echo $ResponseData['msg'][$key]->ShortDescription; ?></span></p>
						</div>
					</div>
		<?php	} } ?>
		<?php
			if($ResponseDataAll['status'] === 'Success' && $ResponseDataAll['code'] === 200){ ?>
				<div class='ServiceFor'>For &#10148; <b>All</b></div>
				<?php foreach ($ResponseDataAll['msg'] as $key => $value) { ?>
					<div class='ServiceBox'>
						<div class='ServiceOne'>
							<p class='ServiceNameBox'><b>Name </b>&#10148; <span class='ServiceName'><?php echo $ResponseDataAll['msg'][$key]->Name; ?></span></p>
							<p class='ServicePlansBox'><span><b>Available Plans </b>&#10148; <span class='ServicePlans'><?php echo $PlansCountStore[$ResponseDataAll['msg'][$key]->Name]; ?> packs</span></span><span class='ServiceOpenBox' id='<?php echo $ResponseDataAll['msg'][$key]->Code; ?>' onclick='OpenService(this.id);'>Open</span></p>
						</div>
						<div class='ServiceSecond'>
							<p class='ServiceDescriptionBox'><b>Discription </b>&#10148; <span class='ServiceDescription'><?php echo $ResponseDataAll['msg'][$key]->ShortDescription; ?></span></p>
						</div>
					</div>
		<?php	} } ?>
	</div>
</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	function OpenService(getId){
		window.location.href = 'Open/index.php?target='+getId;
	}
</script>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>