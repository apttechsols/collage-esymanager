 <?php
    // Not show any error
	error_reporting(0);
	
	$Error = false;
	
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
	header("Location: " . DomainName . "/LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	return_response('Its provide Update feature'); exit();
	
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
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	
	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
	    $Error = true;
	}else{
		if($ResponseRank == ''){
		    $Error = true;
		}
		if($ResponseLogin['LAS'] != 'MainMember'){
		    $Error = true;
		}else if($ResponseLogin['LORT'] != 'Main'){
			$Error = true;
		}else{
			if($ResponseRank != 1){
			    $Error = true;
			}
		}
	}
	
	if($Error == true){
	    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	    header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{
	    echo '<b>Wellcome '.$ResponseLogin['msg']['Fullname'].'</b><br/><br/><br/>';
	}
	
    $AllErrorStore = '';
    
	$stmt = $PdoOrganizationUserSetting->prepare("SELECT table_name FROM information_schema.tables WHERE table_type = 'base table' AND table_schema='topicste_organization_user_setting'");
	//$stmt->bindValue(":EncodeAndEncryptPass", $EncodeAndEncryptPass, PDO::PARAM_STR);
	if($stmt->execute()){
		if($stmt->rowCount() == 0){
		    $AllErrorStore +=  ['TaskName'=>'topicste_organization_user_setting','ErrorDes'=>'Get zero rows','ErrorReason'=>$stmt->errorinfo()];
		}
	}else{
	   $AllErrorStore +=  ['TaskName'=>'topicste_organization_user_setting','ErrorDes'=>'Stetment not execute','ErrorReason'=>$stmt->errorinfo()];
	}
	if($AllErrorStore == ''){
	    foreach ($stmt->fetchAll() as $Mainkey => $Mainvalue){
		foreach ($Mainvalue as $key => $value){
		    
		    $Response = FetchReuiredDataByGivenData("SettingKeyUnique::::SearchSensitiveDataMemberRankUpTo",'SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
			if($Response['status'] != 'Success' || $Response['code'] != 200){
				$Response = UpdateGivenData("SettingKeyUnique::::SearchSensitiveDataMemberRankUpTo::,::SettingValue::::1,2","CreateType::::Main::,::SettingKeyUnique::,::SettingValue",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				if($Response['status'] != 'Success' || $Response['code'] != 200){
					$Response = InsertGivenData("SettingKeyUnique::::SearchSensitiveDataMemberRankUpTo::,::SettingValue::::1,2::,::CreateType::::Main",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
				    if($Response['msg'] != 'Success' && $Response['code'] != 200){
				        $AllErrorStore +=  ['TaskName'=>'SearchSensitiveDataMemberRankUpTo','ErrorDes'=>'Data not insert','ErrorReason'=>$Response['Reason']];
				    }
				}
			}else{
				if($Response['msg']->SettingValue != '1,2'){
					$Response = UpdateGivenData("SettingValue::::e,e","CreateType::::Main::,::SettingKeyUnique::::SearchSensitiveDataMemberRankUpTo",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				    if($Response['msg'] != 'Success' && $Response['code'] != 200){
				        $AllErrorStore +=  ['TaskName'=>'SearchSensitiveDataMemberRankUpTo','ErrorDes'=>'Data not insert','ErrorReason'=>$Response['Reason']];
				    }  
				}
			}
		    
			/*$stmt = $PdoOrganizationUserSetting->prepare("SELECT NULL FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= 'topicste_organization_user_setting' AND TABLE_NAME='$value' AND COLUMN_NAME='UpdateAble'");
			if($stmt->execute()){
				if($stmt->rowCount() == 0){
					$stmt = $PdoOrganizationUserSetting->prepare("ALTER TABLE $value ADD UpdateAble VARCHAR(100) NOT NULL AFTER CreateType");
					$stmt->execute();
				}else{
					$stmt = $PdoOrganizationUserSetting->prepare("ALTER TABLE $value MODIFY COLUMN UpdateAble VARCHAR(100) NOT NULL AFTER CreateType");
					$stmt->execute();
				}
			}

			$Response = FetchReuiredDataByGivenData("UpdateAble::::NullAndNothing::,::CreateType::::Organization",NULL,$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',NULL,'all'); 
			if($Response['status'] === 'Success' && $Response['code'] === 200){
				foreach ($Response['msg'] as $Tempkey => $Tempvalue){
					foreach ($Tempvalue as $Temp1key => $Temp1value){
						$Response = UpdateGivenData("UpdateAble::::Yes","CreateType::::Organization",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all');
					}
				}
			}

			$Response = FetchReuiredDataByGivenData("CreateType::::Main",'SettingKeyUnique::::SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',NULL,'all');
			if($Response['status'] === 'Success' && $Response['code'] === 200){
				
				foreach ($Response['msg'] as $Tempkey => $Tempvalue){
					foreach ($Tempvalue as $Temp1key => $Temp1value){
						if($Temp1value == 'ChangeMemberRankUpTo' || $Temp1value == 'AddMemberRankUpTo' || $Temp1value == 'SearchMemberRankUpTo'){
							$Response = UpdateGivenData("UpdateAble::::No","CreateType::::Main::,::SettingKeyUnique::::$Temp1value",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all');
						}else{
							$Response = UpdateGivenData("UpdateAble::::Yes","CreateType::::Main::,::SettingKeyUnique::::$Temp1value",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true);
						}
					}
				}
			}
			
			$Response = FetchReuiredDataByGivenData("SettingKeyUnique::::ChangeMemberRankUpTo",'SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
			if($Response['status'] != 'Success' || $Response['code'] != 200){
				$Response = UpdateGivenData("SettingKeyUnique::::ChangeMemberRankUpTo::,::SettingValue::::1,2","CreateType::::Main::,::SettingKeyUnique::,::SettingValue",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				if($Response['status'] != 'Success' || $Response['code'] != 200){
					$Response = InsertGivenData("SettingKeyUnique::::ChangeMemberRankUpTo::,::SettingValue::::0,2::,::CreateType::::Main",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
				}
			}else{
				if($Response['msg']->SettingValue != '1,2'){
					$Response = UpdateGivenData("SettingValue::::1,2","CreateType::::Main::,::SettingKeyUnique::::ChangeMemberRankUpTo",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				}
			}

			$Response = FetchReuiredDataByGivenData("SettingKeyUnique::::AddMemberRankUpTo",'SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
						
			if($Response['status'] != 'Success' || $Response['code'] != 200){
				$Response = UpdateGivenData("SettingKeyUnique::::AddMemberRankUpTo::,::SettingValue::::1,e","CreateType::::Main::,::SettingKeyUnique::,::SettingValue",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				if($Response['status'] != 'Success' || $Response['code'] != 200){
					$Response = InsertGivenData("SettingKeyUnique::::AddMemberRankUpTo::,::SettingValue::::1,e::,::CreateType::::Main",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
				}
			}else{
				if($Response['msg']->SettingValue != '1,e'){
					$Response = UpdateGivenData("SettingValue::::1,e","CreateType::::Main::,::SettingKeyUnique::::AddMemberRankUpTo",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				}
			}

			$Response = FetchReuiredDataByGivenData("SettingKeyUnique::::SearchMemberRankUpTo",'SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);

			if($Response['status'] != 'Success' || $Response['code'] != 200){
				$Response = UpdateGivenData("SettingKeyUnique::::SearchMemberRankUpTo::,::SettingValue::::e,e","CreateType::::Main::,::SettingKeyUnique::,::SettingValue",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				if($Response['status'] != 'Success' || $Response['code'] != 200){
					$Response = InsertGivenData("SettingKeyUnique::::SearchMemberRankUpTo::,::SettingValue::::e,e::,::CreateType::::Main",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass);
				}
			}else{
				if($Response['msg']->SettingValue != 'e,e'){
					$Response = UpdateGivenData("SettingValue::::e,e","CreateType::::Main::,::SettingKeyUnique::::SearchMemberRankUpTo",$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'all',true,1);
				}
			}
			
			$Response = FetchReuiredDataByGivenData("SettingKeyUnique::::",'SettingKeyUnique::::SettingValue',$PdoOrganizationUserSetting,$value,$EncodeAndEncryptPass,'NotEqualAll',null,'all');

			if($Response['status'] == 'Success' && $Response['code'] == 200){
					return_response($Response['msg']);
			}*/
		}
	}
	}
	
	if($AllErrorStore == ''){
	    return_response('Perform all operation successfully');
	}else{
	    return_response($AllErrorStore);
	}
?>