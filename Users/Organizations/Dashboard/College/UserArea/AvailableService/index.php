<?php
	/*
	*@FileName AvailableService/index.php
	*@Des Add new members for organitaion
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
	require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	$GetError = array();
	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'UserUrl::::Fullname::::Mobile::::ProfileUrl::::Position');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	$ResponseBuyedService = FetchReuiredDataByGivenData("ServiceMember::::Yes::,::Organization::::".$ResponseLogin['LFR'],"ServiceCode",$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,'all',NULL,'all');
	if($ResponseBuyedService['code'] != 200 && $ResponseBuyedService['code'] != 404){
		array_push($GetError, ['code'=>'3.0','dis'=>'Buyed service data can not feched!']);
	}else if($ResponseBuyedService['code'] == 404){
		array_push($GetError, ['code'=>'3.0','dis'=>'Currently you are not member of any service!']);
	}

	$UserPartOfServiceStore = array();
	foreach ($ResponseBuyedService['msg'] as $value) {
		$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.strtolower($value->ServiceCode));
		if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
			$DbConnection = $DbConnection['msg'];
		}else{
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response('Database connection failed'); exit();
		}

		$UserPartOfService = FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],NULL,$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);

		/*if($UserPartOfService['code'] != 200 && $UserPartOfService['code'] != 404){
			array_push($GetError, ['code'=>'5.0','dis'=>'User service data not feched!']);
		}else */if($UserPartOfService['code'] != 200){
			continue;
		}

		$GetServiceData = FetchReuiredDataByGivenData("Code::::".$value->ServiceCode,'Name',$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

		if($GetServiceData['code'] != 200){
			array_push($GetError, ['code'=>'6.0','dis'=>'Service list data not feched!']);
		}

		array_push($UserPartOfServiceStore, ['name'=>$GetServiceData['msg']->Name,'code'=>$value->ServiceCode]);
	}
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'UserPartOfServiceStore' && $SetVarKey != 'GetError' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'College'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank != 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}

	if(sizeof($GetError) > 0){
		FullPageErrorMessageDisplay($GetError[0]['dis'],true,['MSGpadding'=>'40vh 10px']); exit();

	}
	define("PageTitle", "AvailableService");
	define("CssFile", "AvailableService");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<H1 class='PageTitle'>MANAGE BUYED SERVICE</H1>
	<div class='Container'>
		<?php
			if(sizeof($UserPartOfServiceStore) == 0){
				FullPageErrorMessageDisplay('You are not a part of any service',true,['MSGpadding'=>'40vh 10px']); exit();
			}

			foreach ($UserPartOfServiceStore as $value) {
				echo"<a class='ServiceBox' href='".RootPath.'Users/Service/Dashbord/'.$value['name'].'_'.$value['code']."/index.php'>".$value['name']."</a>";
			}
		?>
	</div>
</body>
<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>