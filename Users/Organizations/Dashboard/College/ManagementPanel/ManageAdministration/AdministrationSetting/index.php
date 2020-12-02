<?php
	/*
	*@FileName AdministrationSetting/index.php
	*@Des ---
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
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	/*-------------- Apt Library -----------------------*/
	require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	$OrgSetting = AptPdoFetchWithAes(['AcceptNullCondtion'=>true, 'FetchData'=>'SettingKeyUnique::::SettingValue::::UpdateAble', 'DbCon'=> $PdoOrganizationUserSetting, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass,'FetchRowNo'=>'All']);

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'OrgSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
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
			if($ResponseRank != 1 && $ResponseRank != 2){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}
	if($OrgSetting['status'] != 'Success' || $OrgSetting['code'] != 200){
		FullPageErrorMessageDisplay('Organization setting can not fetch due to an technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}

	foreach ($OrgSetting['msg'] as $value) {
		${'OrgSetting'. $value->SettingKeyUnique } = $value->SettingValue;
		${'OrgSetting'.$value->SettingKeyUnique.'UpdateAble'} = $value->UpdateAble;
	}
	
	define("PageTitle", "Administration : Setting");
	define("CssFile", "AdministrationSetting");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class='PageTitle'>Administration : Setting</div>
	<div class = "Container">
		<div class='FormA'>
			<div class='SettingnBox'>
				<div class="NewInputDiv PositionBox">
					<div class='SettingName'>Position & Rank</div>
					<div class='NewInputDiv PositionBoxA SettingBox-1'>
						<?php
							$OrgSettingPositionArray = explode('@', $OrgSettingPosition);
							$GetPositionRank = array();
							foreach ($OrgSettingPositionArray as $value) {
								$TempOrgSettingPosition = explode(':', $value);
								if($TempOrgSettingPosition[2] == 'NotUpdateAble'){
									echo "<div class='SettingBox-1AA'>
											<input type='text' name='Position' placeholder='Position' value='$TempOrgSettingPosition[0]' disabled>
											<input type='number' name='Rank' placeholder='Rank' value='$TempOrgSettingPosition[1]' disabled>
										</div>";
								}else{
									echo "<div class='SettingBox-1A'>
											<input type='text' name='Position' placeholder='Position' value='$TempOrgSettingPosition[0]' onkeyup='defaultFun();'>
											<input type='number' name='Rank' placeholder='Rank' value='$TempOrgSettingPosition[1]' onkeyup='defaultFun();'>
											<img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
										</div>";
								}
								array_push($GetPositionRank, $TempOrgSettingPosition[1]);
							}
							$GetOrderdPositionRank = $GetPositionRank;
							sort($GetOrderdPositionRank);
						?>
					</div>
				</div>
				<div class='AddNewBtn' id='AddNewPositionBtn'>Add New Position</div>
				<div class='SmtBtn' id='UpdatePositionSmtBtn'>Update<span class="loader_round_main UpdatePositionSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
		</div>
		<div class='FormB'>
			<div class='SettingnBox'>
				<div class="StudySemesterBox">
					<div class='SettingName'>Study Semester</div>
					<?php
						$OrgSettingStudySemesterArray = explode('@', $OrgSettingStudySemester);
						echo "<div class='NewInputDiv StudySemesterBoxA SettingBox-1'>";
						foreach ($OrgSettingStudySemesterArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='number' name='StudySemester' placeholder='Study Semester' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewStudySemesterBtn'>Add New Study Semester</div>
				<div class='SmtBtn' id='UpdateStudySemesterSmtBtn'>Update<span class="loader_round_main UpdateStudySemesterSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="StudyYearBox">
					<div class='SettingName'>Study Year</div>
					<?php
						$OrgSettingStudyYearArray = explode('@', $OrgSettingStudyYear);
						echo "<div class='NewInputDiv StudyYearBoxA SettingBox-1'>";
						foreach ($OrgSettingStudyYearArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='number' name='StudyYear' placeholder='Study Year' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";		
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewStudyYearBtn'>Add New Year</div>
				<div class='SmtBtn' id='UpdateStudyYearSmtBtn'>Update<span class="loader_round_main UpdateStudyYearSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="BranchBox">
					<div class='SettingName'>Branch</div>
					<?php
						$OrgSettingBranchArray = explode('@', $OrgSettingBranch);
						echo "<div class='NewInputDiv BranchBoxA SettingBox-1'>";
						foreach ($OrgSettingBranchArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='text' name='Branch' placeholder='Branch' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewBranchBtn'>Add New Branch</div>
				<div class='SmtBtn' id='UpdateBranchSmtBtn'>Update<span class="loader_round_main UpdateBranchSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="DepartmentBox">
					<div class='SettingName'>Department</div>
					<?php
						$OrgSettingDepartmentArray = explode('@', $OrgSettingDepartment);
						echo "<div class='NewInputDiv DepartmentBoxA SettingBox-1'>";
						foreach ($OrgSettingDepartmentArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='text' name='Department' placeholder='Department' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewDepartmentBtn'>Add New Department</div>
				<div class='SmtBtn' id='UpdateDepartmentSmtBtn'>Update<span class="loader_round_main UpdateDepartmentSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="PrimaryBatchIdBox">
					<div class='SettingName'>Primary Batch Id</div>
					<?php
						$OrgSettingPrimaryBatchIdArray = explode('@', $OrgSettingPrimaryBatchId);
						echo "<div class='NewInputDiv PrimaryBatchIdBoxA SettingBox-1'>";
						foreach ($OrgSettingPrimaryBatchIdArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='text' name='PrimaryBatchId' placeholder='Primary Batch Id' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewPrimaryBatchIdBtn'>Add New Primary Batch Id</div>
				<div class='SmtBtn' id='UpdatePrimaryBatchIdSmtBtn'>Update<span class="loader_round_main UpdatePrimaryBatchIdSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
			<div class='SettingnBox'>
				<div class="SecondaryBatchIdBox">
					<div class='SettingName'>Secondary Batch Id</div>
					<?php
						$OrgSettingSecondaryBatchIdArray = explode('@', $OrgSettingSecondaryBatchId);
						echo "<div class='NewInputDiv SecondaryBatchIdBoxA SettingBox-1'>";
						foreach ($OrgSettingSecondaryBatchIdArray as $value){
							echo "<div class='SettingBox-1B'>
									<input type='text' name='SecondaryBatchId' placeholder='Secondary Batch Id' value='$value' onkeyup='defaultFun();'>
								    <img src=".RootPath."Image_store/RemoveIconRedColor48px.png class='NewInputRemove'/>
								</div>";
						}
						echo "</div>";
					?>
				</div>
				<div class='AddNewBtn' id='AddNewSecondaryBatchIdBtn'>Add New Secondary Batch Id</div>
				<div class='SmtBtn' id='UpdateSecondaryBatchIdSmtBtn'>Update<span class="loader_round_main UpdateSecondaryBatchIdSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
		</div>
		<div class='FormA'>
			<div class='SettingnBox'>
				<div class="NewInputDiv MemberOperationPermissionRankUpToBox">
					<div class='SettingName'>Member Operation Permission By Rank</div>
					<div class='NewInputDiv MemberOperationPermissionRankUpToBoxA SettingBox-1'>
						<?php
							$OrgSettingMemberOperationPermissionRankUpToArray = explode('@', $OrgSettingMemberOperationPermissionRankUpTo);
							foreach ($OrgSettingMemberOperationPermissionRankUpToArray as $value) {
								$TempOrgSettingMemberOperationPermissionRankUpTo = explode(':', $value);
								$Temp2OrgSettingMemberOperationPermissionRankUpTo = explode(',', $TempOrgSettingMemberOperationPermissionRankUpTo[1]);
								echo "<div class='SettingBox-1'>";
									if($TempOrgSettingMemberOperationPermissionRankUpTo[0] == 'ChangeMemberPermissionRankUpTo'){
										$GetChangeMemberPermissionRankUpToStart = $Temp2OrgSettingMemberOperationPermissionRankUpTo[0];
										$GetChangeMemberPermissionRankUpToEnd = $Temp2OrgSettingMemberOperationPermissionRankUpTo[1];
										echo "<div class='DtTl'>Update Member</div>
											<div class='SettingBox-1C' style='padding:0px;'>
											<select class='ChangeMemberPermissionRankUpToStart'>";
												echo "<option value='1'>1</option>";
											echo "</select> To 
											<select class='ChangeMemberPermissionRankUpToEnd'>
											<option value='e'>&infin;</option>
											";
											foreach ($GetOrderdPositionRank as $value){
												if($value > 1){
													echo "<option value='$value'>$value</option>";
												}
											}
											echo "</select>
										</div>";
									}else if($TempOrgSettingMemberOperationPermissionRankUpTo[0] == 'AddMemberPermissionRankUpTo'){
										$GetAddMemberPermissionRankUpToStart = $Temp2OrgSettingMemberOperationPermissionRankUpTo[0];
										$GetAddMemberPermissionRankUpToEnd = $Temp2OrgSettingMemberOperationPermissionRankUpTo[1];
										echo "<div class='DtTl'>Add Member</div>
											<div class='SettingBox-1C' style='padding:0px;'>
											<select class='AddMemberPermissionRankUpToStart'>";
												echo "<option value='1'>1</option>";
											echo "</select> To 
											<select class='AddMemberPermissionRankUpToEnd'>
											<option value='e'>&infin;</option>";
											foreach ($GetOrderdPositionRank as $value){
												if($value > 1){
													echo "<option value='$value'>$value</option>";
												}
											}
											echo "</select>
										</div>";
									}else if($TempOrgSettingMemberOperationPermissionRankUpTo[0] == 'SearchMemberPermissionRankUpTo'){
										$GetSearchMemberPermissionRankUpToStart = $Temp2OrgSettingMemberOperationPermissionRankUpTo[0];
										$GetSearchMemberPermissionRankUpToEnd = $Temp2OrgSettingMemberOperationPermissionRankUpTo[1];
										echo "<div class='DtTl'>Search Normal</div>
											<div class='SettingBox-1C' style='padding:0px;'>
											<select class='SearchMemberPermissionRankUpToStart'>";
											foreach ($GetOrderdPositionRank as $value){
												if($value > -2 && $value != 0){
													echo "<option value='$value'>$value</option>";
												}
											}
											echo "</select> To 
											<select class='SearchMemberPermissionRankUpToEnd'>
											<option value='e'>&infin;</option>";
											foreach ($GetOrderdPositionRank as $value){
												if($value > 1){
													echo "<option value='$value'>$value</option>";
												}
											}
											echo "</select>
										</div>";
									}else if($TempOrgSettingMemberOperationPermissionRankUpTo[0] == 'SearchMemberSensitiveDataPermissionRankUpTo'){
										$GetSearchMemberSensitiveDataPermissionRankUpToStart = $Temp2OrgSettingMemberOperationPermissionRankUpTo[0];
										$GetSearchMemberSensitiveDataPermissionRankUpToEnd = $Temp2OrgSettingMemberOperationPermissionRankUpTo[1];
										echo "<div class='DtTl'>Search Advance</div>
											<div class='SettingBox-1C' style='padding:0px;'>
											<select class='SearchMemberSensitiveDataPermissionRankUpToStart'>";
												echo "<option value='1'>1</option>";
											echo "</select> To 
											<select class='SearchMemberSensitiveDataPermissionRankUpToEnd'>
											<option value='e'>&infin;</option>";
											foreach ($GetOrderdPositionRank as $value){
												if($value > 1){
													echo "<option value='$value'>$value</option>";;
												}
											}
											echo "</select>
										</div>";
									}else if($TempOrgSettingMemberOperationPermissionRankUpTo[0] == 'DeleteMemberPermissionRankUpTo'){
										$GetDeleteMemberPermissionRankUpToStart = $Temp2OrgSettingMemberOperationPermissionRankUpTo[0];
										$GetDeleteMemberPermissionRankUpToEnd = $Temp2OrgSettingMemberOperationPermissionRankUpTo[1];
										echo "<div class='DtTl'>Delete Member</div>
											<div class='SettingBox-1C' style='padding:0px;'>
											<select class='DeleteMemberPermissionRankUpToStart'>";
												echo "<option value='1'>1</option>";
											echo "</select> To 
											<select class='DeleteMemberPermissionRankUpToEnd'>
											<option value='e'>&infin;</option>";
											foreach ($GetOrderdPositionRank as $value){
												if($value > 1){
													echo "<option value='$value'>$value</option>";;
												}
											}
											echo "</select>
										</div>";
									}else{
										continue;
									}
								echo "</div>";
							}
						?>
					</div>
				</div>
				<div class='SmtBtn' id='UpdateMemberOperationPermissionRankUpToSmtBtn'>Update<span class="loader_round_main UpdateMemberOperationPermissionRankUpToSmtBtnLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
			</div>
		</div>
	</div>	
</body>
<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function() {
		{
			var x=0;
			$(`#AddNewPositionBtn`).click(function(){
				$('.PositionBoxA').append('<div class="SettingBox-1A"><input type="text" name="Position" placeholder="Position" onkeyup="defaultFun();"><input type="number" name="Rank" placeholder="Rank" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewStudyYearBtn`).click(function(){
				$('.StudyYearBoxA').append('<div class="SettingBox-1B"><input type="number" name="StudyYear" placeholder="Study Year" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewBranchBtn`).click(function(){
				$('.BranchBoxA').append('<div class="SettingBox-1B"><input type="text" name="Branch" placeholder="Branch" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewDepartmentBtn`).click(function(){
				$('.DepartmentBoxA').append('<div class="SettingBox-1B"><input type="text" name="Department" placeholder="Department" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewStudySemesterBtn`).click(function(){
				$('.StudySemesterBoxA').append('<div class="SettingBox-1B"><input type="number" name="StudySemester" placeholder="Study Semester" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewPrimaryBatchIdBtn`).click(function(){
				$('.PrimaryBatchIdBoxA').append('<div class="SettingBox-1B"><input type="text" name="Primary Batch Id" placeholder="Primary Batch Id" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
			$(`#AddNewSecondaryBatchIdBtn`).click(function(){
				$('.SecondaryBatchIdBoxA').append('<div class="SettingBox-1B"><input type="text" name="Secondary Batch Id" placeholder="Secondary Batch Id" onkeyup="defaultFun();"><img src="'+RootPath+'Image_store/RemoveIconRedColor48px.png" class="NewInputRemove"/></div>');
			});
		}

		window.SmtBtnProcess = false;
		$('.SmtBtn').click(function(){
			if(window.SmtBtnProcess != false){
				swal('Update button already clicked'); return false;
			}
			var GetId = this.id;
			SmtStartSubmit();
			if(GetId == 'UpdatePositionSmtBtn'){
				var PositionArray = [];
				var countPosition = $(".PositionBoxA > div").length;
				
		    	for(var i=1; i<= countPosition; i++){
		    		var TempPositionName = $('.PositionBoxA div:nth-child('+i+') input:nth-child(1)');
		    		var TempPositionRank = $('.PositionBoxA div:nth-child('+i+') input:nth-child(2)');
		    		if(TempPositionName.val() == ''){
		    			TempPositionName.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempPositionName).position().top- 70});
						$(TempPositionName).focus();
		    			SmtSubmitReset(); return false;
		    		}

		    		if(TempPositionRank.val() == ''){
		    			TempPositionRank.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempPositionName).position().top- 70});
						$(TempPositionName).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		PositionArray.push(TempPositionName.val()+'&'+TempPositionRank.val());
		    	}
		    	if(countPosition == 0){
		    		swal('','Position look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'Position':PositionArray};
			}else if(GetId == 'UpdateStudyYearSmtBtn'){
				var StudyYearArray = [];
				var countStudyYear = $(".StudyYearBoxA > div").length;
				
		    	for(var i=1; i<= countStudyYear; i++){
		    		var TempStudyYearBoxA = $('.StudyYearBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempStudyYearBoxA.val() == ''){
		    			TempStudyYearBoxA.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempStudyYearBoxA).position().top- 70});
						$(TempStudyYearBoxA).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		StudyYearArray.push(TempStudyYearBoxA.val());
		    	}
		    	if(countStudyYear == 0){
		    		swal('','Study year look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'StudyYear':StudyYearArray};
			}else if(GetId == 'UpdateBranchSmtBtn'){
				var BranchArray = [];
				var countBranch = $(".BranchBoxA > div").length;
				
		    	for(var i=1; i<= countBranch; i++){
		    		var TempBranch = $('.BranchBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempBranch.val() == ''){
		    			TempBranch.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempBranch).position().top- 70});
						$(TempBranch).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		BranchArray.push(TempBranch.val());
		    	}
		    	if(countBranch == 0){
		    		swal('','Branch look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'Branch':BranchArray};
			}else if(GetId == 'UpdateDepartmentSmtBtn'){
				var DepartmentArray = [];
				var countDepartment = $(".DepartmentBoxA > div").length;
				
		    	for(var i=1; i<= countDepartment; i++){
		    		var TempDepartment = $('.DepartmentBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempDepartment.val() == ''){
		    			TempDepartment.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempDepartment).position().top- 70});
						$(TempDepartment).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		DepartmentArray.push(TempDepartment.val());
		    	}
		    	if(countDepartment == 0){
		    		swal('','Department look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'Department':DepartmentArray};
			}else if(GetId == 'UpdateStudySemesterSmtBtn'){
				var StudySemesterArray = [];
				var countStudySemester = $(".StudySemesterBoxA > div").length;
				
		    	for(var i=1; i<= countStudySemester; i++){
		    		var TempStudySemester = $('.StudySemesterBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempStudySemester.val() == ''){
		    			TempStudySemester.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempStudySemester).position().top- 70});
						$(TempStudySemester).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		StudySemesterArray.push(TempStudySemester.val());
		    	}
		    	if(countStudySemester == 0){
		    		swal('','Study Semester look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'StudySemester':StudySemesterArray};
			}else if(GetId == 'UpdatePrimaryBatchIdSmtBtn'){
				var PrimaryBatchIdArray = [];
				var countPrimaryBatchId = $(".PrimaryBatchIdBoxA > div").length;
				
		    	for(var i=1; i<= countPrimaryBatchId; i++){
		    		var TempPrimaryBatchId = $('.PrimaryBatchIdBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempPrimaryBatchId.val() == ''){
		    			TempPrimaryBatchId.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempPrimaryBatchId).position().top- 70});
						$(TempPrimaryBatchId).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		PrimaryBatchIdArray.push(TempPrimaryBatchId.val());
		    	}
		    	if(countPrimaryBatchId == 0){
		    		swal('','PrimaryBatchId look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'PrimaryBatchId':PrimaryBatchIdArray};
			}else if(GetId == 'UpdateSecondaryBatchIdSmtBtn'){
				var SecondaryBatchIdArray = [];
				var countSecondaryBatchId = $(".SecondaryBatchIdBoxA > div").length;
				
		    	for(var i=1; i<= countSecondaryBatchId; i++){
		    		var TempSecondaryBatchId = $('.SecondaryBatchIdBoxA div:nth-child('+i+') input:nth-child(1)');

		    		if(TempSecondaryBatchId.val() == ''){
		    			TempSecondaryBatchId.css({'border' : '2px solid red'});
		    			$('html, body').animate({'scrollTop' : $(TempSecondaryBatchId).position().top- 70});
						$(TempSecondaryBatchId).focus();
		    			SmtSubmitReset(); return false;

		    		}
		    		SecondaryBatchIdArray.push(TempSecondaryBatchId.val());
		    	}
		    	if(countSecondaryBatchId == 0){
		    		swal('','SecondaryBatchId look like empty ','warning');
		    		SmtSubmitReset(); return false;
		    	}
				var SettingData = {'SecondaryBatchId':SecondaryBatchIdArray};
			}else if(GetId == 'UpdateMemberOperationPermissionRankUpToSmtBtn'){
				var SettingData = {'MemberOperationPermissionRankUpTo':{'ChangeMemberPermissionRankUpToStart':$('.ChangeMemberPermissionRankUpToStart').val(),'ChangeMemberPermissionRankUpToEnd':$('.ChangeMemberPermissionRankUpToEnd').val(),'AddMemberPermissionRankUpToStart':$('.AddMemberPermissionRankUpToStart').val(),'AddMemberPermissionRankUpToEnd':$('.AddMemberPermissionRankUpToEnd').val(),'SearchMemberPermissionRankUpToStart':$('.SearchMemberPermissionRankUpToStart').val(),'SearchMemberPermissionRankUpToEnd':$('.SearchMemberPermissionRankUpToEnd').val(),'SearchMemberSensitiveDataPermissionRankUpToStart':$('.SearchMemberSensitiveDataPermissionRankUpToStart').val(),'SearchMemberSensitiveDataPermissionRankUpToEnd':$('.SearchMemberSensitiveDataPermissionRankUpToEnd').val(),'DeleteMemberPermissionRankUpToStart':$('.DeleteMemberPermissionRankUpToStart').val(),'DeleteMemberPermissionRankUpToEnd':$('.DeleteMemberPermissionRankUpToEnd').val()}};
			}else{
				swal('','Invalid click detect','warning'); SmtSubmitReset(); return false;
			}

	    	var client = new ClientJS();
			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					

					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					// append data which we want to send data on targeted page
					var formdata = new FormData();
					formdata.append("SettingData", JSON.stringify(SettingData));
					formdata.append('SettingId', GetId);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",SettingResponse,false);
						ajax.open("POST", "AdministrationSetting.php");
						ajax.send(formdata);
					}catch(error){
						swal('','An technical error occur','warning');
						SmtSubmitReset(); return false;
					}

					function SettingResponse(event){
						SmtSubmitReset();
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
							swal('Update',response['msg'], "success")
							.then(() => {
								window.location.reload();
							});
						}else if(response['code'] === 404){
							swal('Update',response['msg'],'warning');
						}else{
							swal('Update',response['msg'],'error');
						}
					}
				});
		    });	

	    	function SmtStartSubmit(){
	    		window.SmtBtnProcess = true;
	    		$("input").prop("disabled",true);
				$("select").prop("disabled",true);
				$('.SmtBtn').css("pointer-events","none");
				$('#'+GetId).css("background","linear-gradient(skyblue, pink)");
				$(".SmtBtn").css("cursor","default");
				$('.'+GetId+"Loader").prop('hidden',false);
			}
			function  SmtSubmitReset(){
				window.SmtBtnProcess = false;
				$("input").prop("disabled",false);
				$("select").prop("disabled",false);
				$('.SmtBtn').css("pointer-events","auto");
				$('#'+GetId).css("background","green");
				$(".SmtBtn").css("cursor","pointer");
				$('.'+GetId+"Loader").prop('hidden',true);
			}
	    });

		(function(){
			$('.ChangeMemberPermissionRankUpToStart').val('<?php echo $GetChangeMemberPermissionRankUpToStart; ?>');
			$('.ChangeMemberPermissionRankUpToEnd').val('<?php echo $GetChangeMemberPermissionRankUpToEnd; ?>');
			$('.AddMemberPermissionRankUpToStart').val('<?php echo $GetAddMemberPermissionRankUpToStart; ?>');
			$('.AddMemberPermissionRankUpToEnd').val('<?php echo $GetAddMemberPermissionRankUpToEnd; ?>');
			$('.SearchMemberPermissionRankUpToStart').val('<?php echo $GetSearchMemberPermissionRankUpToStart; ?>');
			$('.SearchMemberPermissionRankUpToEnd').val('<?php echo $GetSearchMemberPermissionRankUpToEnd; ?>');
			$('.SearchMemberSensitiveDataPermissionRankUpToStart').val('<?php echo $GetSearchMemberSensitiveDataPermissionRankUpToStart; ?>');
			$('.SearchMemberSensitiveDataPermissionRankUpToEnd').val('<?php echo $GetSearchMemberSensitiveDataPermissionRankUpToEnd; ?>');
			$('.DeleteMemberPermissionRankUpToStart').val('<?php echo $GetDeleteMemberPermissionRankUpToStart; ?>');
			$('.DeleteMemberPermissionRankUpToEnd').val('<?php echo $GetDeleteMemberPermissionRankUpToEnd; ?>');
		})();
	});
	function defaultFun(){
    	$('input').css({'border' : '2px solid #aaa'});
    }
    $(".NewInputDiv").on("click",".NewInputRemove",function(){   
    	$(this).parent('div').remove();
	});
</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>




