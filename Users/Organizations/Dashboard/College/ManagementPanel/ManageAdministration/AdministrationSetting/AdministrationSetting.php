 <?php 
/*
*@FileName AdministrationSetting.php
*@Des This procees update setting of organization
*@Author arpit sharma
*/

// Not show any error
error_reporting(0);
// Get server port type (exampale - http:// or https://)
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
	$HeaderSecureType = "https://";
}else{
	$HeaderSecureType = "http://";
}
// Create Domain name and save it in const variable
define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
define("RootPath", "../../../../../../../");

// Get all requested data
if(isset($_POST['SettingData']) && isset($_POST['SettingId']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Organizations/Dashboard/College/ManagementPanel/ManageAdministration/AdministrationSetting/index.php"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$SettingData = preg_replace('!\s+!', ' ',strip_tags($_POST['SettingData']));
			$SettingId = preg_replace('!\s+!', ' ',strip_tags($_POST['SettingId']));

			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
				
				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}


			class UpdateSetting{
				public static function ValidedData($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2){
					UpdateSetting::ValidedDataSecure($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2);
				}
				private static function ValidedDataSecure($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2){
					
					date_default_timezone_set('Asia/Kolkata');
					
					// SettingId valided in backend
					if($SettingId != "UpdatePositionSmtBtn" && $SettingId != "UpdateStudyYearSmtBtn" && $SettingId != "UpdateBranchSmtBtn" && $SettingId != "UpdateDepartmentSmtBtn" && $SettingId != "UpdateStudySemesterSmtBtn" && $SettingId != "UpdatePrimaryBatchIdSmtBtn" && $SettingId != "UpdateSecondaryBatchIdSmtBtn" && $SettingId != "UpdateMemberOperationPermissionRankUpToSmtBtn"){
						return_response("Invalid click detect"); exit();
					}
					
					if(gettype(json_decode($SettingData)) != 'object'){
						return_response('Invalid setting Data format detect');exit();
					}
					
					$SettingData = json_decode($SettingData);
					foreach ($SettingData as $key => $value) {
						if($key != 'Position' && $key != 'StudyYear' && $key != 'Branch' && $key != 'Department' && $key != 'StudySemester' && $key != 'PrimaryBatchId' && $key != 'SecondaryBatchId' && $key != 'MemberOperationPermissionRankUpTo'){
							return_response('Invalid setting Data detect');exit();
						}
						${$key} = $value;
					}
					
					# Valided Data with Normal Logics

					if($SettingId == "UpdatePositionSmtBtn"){
						$TempPositionString = '@Owner@Admin@Student@ReadOnly@ServiceUserOnly@';
						$TempPositionRankString = '@1@2@0@-1@-2@';
						$PositionString = 'Owner:1:NotUpdateAble@Admin:2:NotUpdateAble@Student:0:NotUpdateAble@ReadOnly:-1:NotUpdateAble@ServiceUserOnly:-2:NotUpdateAble';
						foreach ($SettingData->Position as $value){
							$TempPositionArray = explode('&', $value);
							if($TempPositionArray[1] >= -2 && $TempPositionArray[1] <= 2){
								continue;
							}
							if($TempPositionArray[0] != preg_replace("/[^A-za-z]/","",$TempPositionArray[0])){
								return_response('Position can contain only alphabate');exit();
							}else if(strlen($TempPositionArray[0]) < 1 || strlen($TempPositionArray[0]) > 20){
								return_response('Position length must be between 1 to 20 characters');exit();
							}else if($TempPositionArray[1] != preg_replace("/[^0-9]/","",$TempPositionArray[1])){
								return_response('Position can contain only positive number');exit();
							}else if($TempPositionArray[1] < 3 || $TempPositionArray[1] > 70){
								return_response('Rank must be between 3 to 20 characters');exit();
							}

							if(stripos(preg_replace('!\s+!', '',$TempPositionString),'@'.$TempPositionArray[0].'@') !== false){
								return_response('You provide '.$TempPositionArray[0].' which is duplicate position'); exit();
							}else if(stripos(preg_replace('!\s+!', '',$TempPositionRankString),'@'.$TempPositionArray[1].'@') !== false){
								return_response('You provide '.$TempPositionArray[1].' which is duplicate position rank'); exit();
							}		
							$TempPositionString .= $TempPositionArray[0].'@';
							$TempPositionRankString .= $TempPositionArray[1].'@';
							$PositionString .= '@'.$TempPositionArray[0].':'.$TempPositionArray[1].':'.'UpdateAble';
						}
						$PositionString = preg_replace("!@+!","@",preg_replace("!:+!",":",$PositionString));
					}else if($SettingId == "UpdateStudyYearSmtBtn"){
						$TempStudyYearString = '';
						$StudyYearString = '';
						foreach ($SettingData->StudyYear as $value){
							if($value != preg_replace("/[^0-9]/","",$value)){
								return_response('Study Year can contain only positive number');exit();
							}else if($value < 1 || $value > 20){
								return_response('Study Year must be between 1 to 20 number');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempStudyYearString),'@'.$value.'@') !== false){
								return_response('You provide '.$value.' which is duplicate Study year'); exit();
							}
							$TempStudyYearString .= '@'.$value.'@';
							$StudyYearString .= $value.'@';
						}
						$StudyYearString = trim(preg_replace("!@+!","@",$StudyYearString),'@');
					}else if($SettingId == "UpdateBranchSmtBtn"){
						$TempBranchString = '';
						$BranchString = '';
						foreach ($SettingData->Branch as $value){
							if($value != preg_replace("/[^A-Za-z ]/","",$value)){
								return_response('Branch can contaion only alphabate and space');exit();
							}else if(strlen($value) < 1 || strlen($value) > 20){
								return_response('Branch length must be between 1 to 20 characters long');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempBranchString),'@'.preg_replace("! +!","",$value).'@') !== false){
								return_response('You provide '.$value.' which is duplicate Branch'); exit();
							}
							$TempBranchString .= '@'.$value.'@';
							$BranchString .= $value.'@';
						}
						$BranchString = trim(preg_replace("!@+!","@",$BranchString),'@');
					}else if($SettingId == "UpdateDepartmentSmtBtn"){
						$TempDepartmentString = '';
						$DepartmentString = '';
						foreach ($SettingData->Department as $value){
							if($value != preg_replace("/[^A-Za-z ]/","",$value)){
								return_response('Department can contaion only alphabate and space');exit();
							}else if(strlen($value) < 1 || strlen($value) > 20){
								return_response('Department length must be between 1 to 20 characters long');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempDepartmentString),'@'.preg_replace("! +!","",$value).'@') !== false){
								return_response('You provide '.$value.' which is duplicate Department'); exit();
							}
							$TempDepartmentString .= '@'.$value.'@';
							$DepartmentString .= $value.'@';
						}
						$DepartmentString = trim(preg_replace("!@+!","@",$DepartmentString),'@');
					}else if($SettingId == "UpdateStudySemesterSmtBtn"){
						$TempStudySemesterString = '';
						$StudySemesterString = '';
						foreach ($SettingData->StudySemester as $value){
							if($value != preg_replace("/[^0-9]/","",$value)){
								return_response('Study Semester can contain only positive number');exit();
							}else if($value < 1 || $value > 20){
								return_response('Study Semester must be between 1 to 20 number');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempStudySemesterString),'@'.$value.'@') !== false){
								return_response('You provide '.$value.' which is duplicate Study Semester'); exit();
							}
							$TempStudySemesterString .= '@'.$value.'@';
							$StudySemesterString .= $value.'@';
						}
						$StudySemesterString = trim(preg_replace("!@+!","@",$StudySemesterString),'@');
					}else if($SettingId == "UpdatePrimaryBatchIdSmtBtn"){
						$TempPrimaryBatchIdString = '';
						$PrimaryBatchIdString = '';
						foreach ($SettingData->PrimaryBatchId as $value){							
							if($value != preg_replace("/[^A-Za-z0-9-)(_]/","",$value)){
								return_response('Primary Batch Id can contaion only alphabate and Special character [ - ) ( _ ]');exit();
							}else if(strlen($value) < 1 || strlen($value) > 30){
								return_response('Primary Batch Id length must be between 1 to 30 characters long');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempPrimaryBatchIdString),'@'.preg_replace("! +!","",$value).'@') !== false){
								return_response('You provide '.$value.' which is duplicate Primary Batch Id'); exit();
							}
							$TempPrimaryBatchIdString .= '@'.$value.'@';
							$PrimaryBatchIdString .= $value.'@';
						}
						$PrimaryBatchIdString = trim(preg_replace("!@+!","@",$PrimaryBatchIdString),'@');
					}else if($SettingId == "UpdateSecondaryBatchIdSmtBtn"){
						$TempSecondaryBatchIdString = '';
						$SecondaryBatchIdString = '';
						foreach ($SettingData->SecondaryBatchId as $value){							
							if($value != preg_replace("/[^A-Za-z0-9-)(_]/","",$value)){
								return_response('Secondary Batch Id can contaion only alphabate and Special character [ - ) ( _ ]');exit();
							}else if(strlen($value) < 1 || strlen($value) > 30){
								return_response('Secondary Batch Id length must be between 1 to 30 characters long');exit();
							}
							if(stripos(preg_replace('!\s+!', '',$TempSecondaryBatchIdString),'@'.preg_replace("! +!","",$value).'@') !== false){
								return_response('You provide '.$value.' which is duplicate Secondary Batch Id'); exit();
							}
							$TempSecondaryBatchIdString .= '@'.$value.'@';
							$SecondaryBatchIdString .= $value.'@';
						}
						$SecondaryBatchIdString = trim(preg_replace("!@+!","@",$SecondaryBatchIdString),'@');
					}else if($SettingId == "UpdateMemberOperationPermissionRankUpToSmtBtn"){
						$TempMemberOperationPermissionRankUpTo = $SettingData->MemberOperationPermissionRankUpTo;

						if($TempMemberOperationPermissionRankUpTo->ChangeMemberPermissionRankUpToStart != 1){
							return_response('Invalid Update Member Permision by rank [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->ChangeMemberPermissionRankUpToEnd < 2 && $TempMemberOperationPermissionRankUpTo->ChangeMemberPermissionRankUpToEnd != 'e'){
							return_response('Invalid Update Member Permision by rank [Max]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->AddMemberPermissionRankUpToStart != 1){
							return_response('Invalid Add Member Permision by rank [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->AddMemberPermissionRankUpToEnd < 2 && $TempMemberOperationPermissionRankUpTo->AddMemberPermissionRankUpToEnd != 'e'){
							return_response('Invalid Add Member Permision by rank [Max]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToStart < 1 && $TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToStart != -1 && $TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToStart != -2){
							return_response('Invalid Search Normal Permision by rank [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToStart > 1){
							return_response('For Search Normal Permision minimum rank must me equal or lower then rank 1 [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToEnd < 2 && $TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToEnd != 'e'){
							return_response('Invalid Search Normal Permision by rank [Max]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->SearchMemberSensitiveDataPermissionRankUpToStart != 1){
							return_response('Invalid Search Advance Permision by rank [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->SearchMemberSensitiveDataPermissionRankUpToEnd < 2 && $TempMemberOperationPermissionRankUpTo->SearchMemberSensitiveDataPermissionRankUpToEnd != 'e'){
							return_response('Invalid Search Advance Permision by rank [Max]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->DeleteMemberPermissionRankUpToStart!= 1){
							return_response('Invalid Delete Member Permision by rank [Min]'); exit();
						}else if($TempMemberOperationPermissionRankUpTo->DeleteMemberPermissionRankUpToEnd < 2 && $TempMemberOperationPermissionRankUpTo->DeleteMemberPermissionRankUpToEnd != 'e'){
							return_response('Invalid Delete Member Permision by rank [Max]'); exit();
						}
						$MemberOperationPermissionRankUpTo = "ChangeMemberPermissionRankUpTo:$TempMemberOperationPermissionRankUpTo->ChangeMemberPermissionRankUpToStart,$TempMemberOperationPermissionRankUpTo->ChangeMemberPermissionRankUpToEnd@AddMemberPermissionRankUpTo:$TempMemberOperationPermissionRankUpTo->AddMemberPermissionRankUpToStart,$TempMemberOperationPermissionRankUpTo->AddMemberPermissionRankUpToEnd@SearchMemberPermissionRankUpTo:$TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToStart,$TempMemberOperationPermissionRankUpTo->SearchMemberPermissionRankUpToEnd@SearchMemberSensitiveDataPermissionRankUpTo:$TempMemberOperationPermissionRankUpTo->SearchMemberSensitiveDataPermissionRankUpToStart,$TempMemberOperationPermissionRankUpTo->SearchMemberSensitiveDataPermissionRankUpToEnd@DeleteMemberPermissionRankUpTo:$TempMemberOperationPermissionRankUpTo->DeleteMemberPermissionRankUpToStart,$TempMemberOperationPermissionRankUpTo->DeleteMemberPermissionRankUpToEnd";
						$StoreTempData = $TempMemberOperationPermissionRankUpTo;
					}else{
						return_response("Invalid click detect"); exit();
					}

					# Create structure Form Of Update Data

					if($SettingId == "UpdatePositionSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$PositionString";
					}else if($SettingId == "UpdateBranchSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$BranchString";
					}else if($SettingId == "UpdateDepartmentSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$DepartmentString";
					}else if($SettingId == "UpdateStudyYearSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$StudyYearString";
					}else if($SettingId == "UpdateStudySemesterSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$StudySemesterString";
					}else if($SettingId == "UpdatePrimaryBatchIdSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$PrimaryBatchIdString";
					}else if($SettingId == "UpdateSecondaryBatchIdSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$SecondaryBatchIdString";
					}else if($SettingId == "UpdateMemberOperationPermissionRankUpToSmtBtn"){
						$TrueSettingDataWithFormat = "SettingValue::::$MemberOperationPermissionRankUpTo";
					}else{
						return_response("Invalid click detect"); exit();
					}

					UpdateSetting::EncryptData($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$BrowserClientId1,$BrowserClientId2);
				}

				// Encode data by self design method
				private static function EncryptData($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$BrowserClientId1,$BrowserClientId2){
					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
					// Call profile_imageResize function
					UpdateSetting::CkeckLoginAndAuthenticate($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

					//Secrate code for access database file
					$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

					//Secrate code for access otherfiles file
					$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
					
					// Access main_db file to access data base connection ($PdoMainUserAccountDb)
					require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

					// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

					// Access main_db file to access data base connection($PdoOrganizationUserSetting)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/SiteComponents/IsLogin/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

					/*-------------- Apt Library -----------------------*/
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
					require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

					// Check user login
					$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass,'FetchDtls'=>'Position::::UserUrl::::SecurityCode','ClientData'=>['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2],'CheckType'=>'ClientAndServer']);
					
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('Oops! Client not logined'); exit();
					}

					if($ResponseLogin['LAS'] === 'OrganizationMember' && $ResponseLogin['LORT'] === 'College'){
						$OrgSetting = AptPdoFetchWithAes(['Condtion'=>'SettingKeyUnique::::Position', 'FetchData'=>'SettingValue', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass]);
						if($OrgSetting['status'] != 'Success' || $OrgSetting['code'] != 200){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Organization setting can not fetched due to technical error'); exit();
						}
						$ResponseRank = GetSubStringBetweenTwoCharacter($OrgSetting['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
						if($ResponseRank == ''){
							foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
							return_response('Org setting data not fetched!'); exit();
						}
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized for update College setting'); exit();
					}

					if($ResponseRank != 1 && $ResponseRank != 2){
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response('You are not authorized for update organization setting'); exit();
					}

					UpdateSetting::UpdateSettingProccess($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$ResponseLogin,$ResponseRank);
				}
				
				private static function UpdateSettingProccess($TrueSettingDataWithFormat,$StoreTempData,$SettingId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$ResponseLogin,$ResponseRank){

					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time();

					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgUserPosition = $ResponseLogin['msg']['Position'];
					$LgPositionRank = $ResponseRank;
					$LgFor = $ResponseLogin['LFR'];

					# Valided Data with PdoOrganizationUserSetting database

					$OrgSetting = AptPdoFetchWithAes(['AcceptNullCondtion'=>true, 'FetchData'=>'SettingKeyUnique::::SettingValue::::UpdateAble', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $LgFor, 'EPass'=> $EncodeAndEncryptPass,'FetchRowNo'=>'All']);

					if($OrgSetting['status'] != 'Success' || $OrgSetting['code'] != 200){
						return_response('Organization setting can not fetch due to an technical error'); exit();
					}

					foreach ($OrgSetting['msg'] as $value) {
						${'OrgSetting'. $value->SettingKeyUnique } = $value->SettingValue;
						${'OrgSetting'.$value->SettingKeyUnique.'UpdateAble'} = $value->UpdateAble;
					}

					if($SettingId == "UpdateMemberOperationPermissionRankUpToSmtBtn"){
						$TempOrgPositionRank = ':e:';
						foreach (explode('@', $OrgSettingPosition) as $value){
							$TempOrgSettingPosition = explode(':', $value);
							$TempOrgPositionRank .= $TempOrgSettingPosition[1].':';
						}

						if(strpos($TempOrgPositionRank,':'.$StoreTempData->ChangeMemberPermissionRankUpToStart.':') === false){
							return_response('Invalid Update Member Permision by rank [Min Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->ChangeMemberPermissionRankUpToEnd.':') === false){
							return_response('Invalid Update Member Permision by rank [Max Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->AddMemberPermissionRankUpToStart.':') === false){
							return_response('Invalid Add Member Permision by rank [Min Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->AddMemberPermissionRankUpToEnd.':') === false){
							return_response('Invalid Add Member Permision by rank [Max Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->SearchMemberPermissionRankUpToStart.':') === false){
							return_response('Invalid Search Normal Permision by rank [Min Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->SearchMemberPermissionRankUpToEnd.':') === false){
							return_response('Invalid Search Normal Permision by rank [Max Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->SearchMemberSensitiveDataPermissionRankUpToStart.':') === false){
							return_response('Invalid Search Advance Permision by rank [Min Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->SearchMemberSensitiveDataPermissionRankUpToEnd.':') === false){
							return_response('Invalid Search Advance Permision by rank [Max Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->DeleteMemberPermissionRankUpToStart.':') === false){
							return_response('Invalid Delete Member Permision by rank [Min Not Found]'); exit();
						}else if(strpos($TempOrgPositionRank,':'.$StoreTempData->DeleteMemberPermissionRankUpToEnd.':') === false){
							return_response('Invalid Delete Member Permision by rank [Max Not Found]'); exit();
						}
					}
					
					if($SettingId == 'UpdatePositionSmtBtn'){
						$SettingKeyUnique = 'Position';
					}else if($SettingId == 'UpdateStudyYearSmtBtn'){
						$SettingKeyUnique = 'StudyYear';
					}else if($SettingId == 'UpdateBranchSmtBtn'){
						$SettingKeyUnique = 'Branch';
					}else if($SettingId == 'UpdateDepartmentSmtBtn'){
						$SettingKeyUnique = 'Department';
					}else if($SettingId == 'UpdateStudySemesterSmtBtn'){
						$SettingKeyUnique = 'StudySemester';
					}else if($SettingId == 'UpdatePrimaryBatchIdSmtBtn'){
						$SettingKeyUnique = 'PrimaryBatchId';
					}else if($SettingId == 'UpdateSecondaryBatchIdSmtBtn'){
						$SettingKeyUnique = 'SecondaryBatchId';
					}else if($SettingId == 'UpdateMemberOperationPermissionRankUpToSmtBtn'){
						$SettingKeyUnique = 'MemberOperationPermissionRankUpTo';
					}else{
						foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
						return_response("Invalid click detect"); exit();
					}
					
					$UpdateSettingData =AptPdoUpdateWithAes(['Update'=>$TrueSettingDataWithFormat,'Condtion'=>"SettingKeyUnique::::$SettingKeyUnique",'DbCon'=>$PdoOrganizationUserSetting,'TbName'=>$LgFor,'EPass'=>$EncodeAndEncryptPass]);
					
					if($UpdateSettingData['status'] === 'Success' && $UpdateSettingData['code'] === 200){
						return_response('Setting Data Updated Successfully',true,'Success',200); exit();
					}else if($UpdateSettingData['code'] == 404){
						return_response('Change Setting data to perform updation',true,'Warning',404); exit();
					}else{
						return_response('Setting Updatedtion failed due to technical error'); exit();
					}
				}	
			}
			
			// Call classname public function 
			UpdateSetting::ValidedData($SettingData,$SettingId,$BrowserClientId1,$BrowserClientId2);
		}else{
			return_response("Invalid Token Id! Refresh page");
		}
	}else{
		header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
	}
}else{
	header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
}	
?>