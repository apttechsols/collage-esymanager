<?php
    // Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}
	// Create Domain name and save it in const variable
	define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
	
	define('RootPath', '../../../');
	require_once (RootPath."JsonShowError/index.php");
	//header("Location: " . DomainName . "/LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	//return_response('Its provide Testing feature'); exit();
	
    $EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

	//Secrate code for access database file
	$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

	//Secrate code for access otherfiles file
	$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

	require_once (RootPath."JsonShowError/index.php");
	
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

	// Access base connection file to access data base connection ($DbConnectionWithoutDbName)
	require_once (RootPath."DatabaseConnections/Normal/DbConnectionWithoutDbName.php");

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");

	/*-------------- Apt Library -----------------------*/
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

	$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseLogin['LAS'] != 'MainMember' || $ResponseLogin['msg']['Position'] != 'Owner' || $ResponseLogin['LORT'] != 'Main'){
		header("Location: " . DomainName . "/LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		return_response('It is not available for you'); exit();
	}

	#return_response('Wait');

	$SmsServiceDbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj');
	if($SmsServiceDbConnection['status'] === 'Success' && $SmsServiceDbConnection['code'] === 200){
		$SmsServiceDbConnection = $SmsServiceDbConnection['msg'];
	}else{
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		return_response('Sms service database connection failed!'); exit();
	}

	$GetMsgDtls = AptPdoFetchWithAes(['FetchData'=>'Status::::MsgId::::SendTime::::MsgLength::::MsgCount::::SendTo::::MsgBody::::SendBy::::MsgType::::MsgLable::::MsgSendByService::::MsgServiceId::::MsgDetail', 'DbCon'=> $SmsServiceDbConnection, 'TbName'=> 'acr9cgvrhr1583355327ejq2pglzja_report', 'EPass'=> $EncodeAndEncryptPass,'AcceptNullCondtion'=>true,'FetchRowNo'=>'All']);

	return_response($GetMsgDtls);
	
	/*$stmt = $PdoOrganizationUserSetting->prepare("SELECT table_name FROM information_schema.tables WHERE table_type = 'base table' AND table_schema='topicste_organization_user_setting'");
	if($stmt->execute()){
		if($stmt->rowCount() == 0){
			return_response($stmt->errorinfo());
		}
	}else{
		return_response($stmt->errorinfo());
	}
	
	foreach ($stmt->fetchAll() as $Mainkey => $Mainvalue){
	    foreach ($Mainvalue as $key => $value){
    		$Response = FetchReuiredDataByGivenData("Position::::Owner",'PositionRank',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all');
    		return_response($Response['msg']->PositionRank);
	    }
	}*/
	
?>