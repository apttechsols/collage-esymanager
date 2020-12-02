<?php
	/*
	*@FileName SearchMember/index.php
	*@Des Search members of organitaion and perform task for Hostal Digital Gate Pass Service
	*@Author Ankit Sharma
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

				$GetDataOfServiceSetting = FetchReuiredDataByGivenData("Position::::NULL::,::SettingKeyUnique::::NULL",'Position::::PositionRank::::SettingKeyUnique::::SettingValue',$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'NotEqualAny',NULL,'all');

				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::GroupSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
			}
		}
	}


	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != 'GetDataOfServiceSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}else{
		if($ResponseRank != 1 && $ResponseRank != 2){
				$CheckManager = True;
		}
	}

	if($ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200){
		return_response('Some Error occur for this service! Please try again later 1.2');
	}

	if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
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

	define("PageTitle", "Search Member");
	define("CssFile", "SearchMember");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "MainContainer">
			<div class = "SearchBoxMain">
				<div>
					<input type="text" class = "SearchInput" id="SearchInput" placeholder='Enter here' autocomplete="off">
				</div>
				<div class=SearchBoxIcon>
					<img class = "SearchIcon" src="<?php echo RootPath; ?>Image_store/SearchIcionWhite48px.png">
				</div>
			</div>
			<div class="SearchResultBox">
				<div class = "NewResponseMainBox" style='padding-top: 80px;'>Search Results Appear Here</div>
			</div>
		</div>
		<div Id='ShowDetailsBox' style='display: none;'>
			<div class='CloseShowDetailsBox'>Close</div>
			<div class='Form'>
				<div class="ShowDetailsImageBox">
					<div class="ProfileBox"><img src="" class="Profile"></div>
				</div>
				<div class="Form1">
					<div class="StatusBoxF1"><span class='InputSpanTitle'>status : </span><Select class='Status'>
						<option value="" class='OpStatus'>Status</option>
						<option value="Active">Active</option>
						<option value="Hold">Hold</option>
						<option value="Block">Block</option>
					</Select></div>
					<div class="FullnameBoxF1"><span class='InputSpanTitle'>Name : </span><div></div></div>
					<div class="GenderBoxF1"><span class='InputSpanTitle'>Gender : </span><div></div></div>
					<div class="OrgPositionBoxF1"><span class='InputSpanTitle'>Org Position : </span><div></div></div>
					<div class="PositionBoxF1"><span class='InputSpanTitle'>Position : </span><Select class='Position'>
						<option value="" class='OpPosition'>Position</option>
						<?php
							foreach (explode('*', $GetServiceSettingPosition) as $value){
								$TempPosition = explode(':', $value);
								echo "<option value= $TempPosition[0] >$TempPosition[0] ($TempPosition[1])</option>";
							}
						?>
					</Select></div>
					<div class='ActiveScheduleBoxF1' hidden="true"><span class='InputSpanTitle'>Active Schedule : </span><input disabled='true'></input></div>
					<div class="SearchUserUrlBoxF1" hidden="true"><span class='InputSpanTitle'>User Url : </span><div class='Form1UserUrl'></div></div>
					<?php
						foreach (explode(',', $GetServiceSettingGroupSetting) as $value) {
							$Temp = explode('-', $value);
							${'GetServiceSettingGroupSetting' . $Temp[0]} = $Temp[1];
						}
					?>
					<div class="GroupIdBoxF1"><span class='InputSpanTitle'>GroupId : </span><Select class='GroupId'>
						<option value="">GroupId</option>
						<?php
							foreach(explode(':', $GetServiceSettingGroupSettingGroupId) as $value){
								echo "<option value= ".explode('*', $value)[0]." >".explode('*', $value)[0]."</option>";
							}
						?>
					</Select></div>
					<div class="GroupTypeBoxF1"><span class='InputSpanTitle'>Group Type : </span>
						<Select class='GroupType'>
							<option value="">GroupType</option>
							<?php
								foreach(explode(':', $GetServiceSettingGroupSettingGroupType) as $value){
									echo "<option value= ".explode('*', $value)[0]." >".explode('*', $value)[0]."</option>";
								}
							?>
						</Select>
					</div>
					<div class="MemberOfGroupBoxF1" hidden="true"><span class='InputSpanTitle'>Member Of Group : </span><input disabled='true'></input></div>
				</div>
				<div class='FormLast'>
					<input type="password" name="SecurityCode" spellcheck="false" maxlength="6" class="SecurityCode" id='SecurityCode' placeholder="Security Code" style='display: none;'>
					<span class="ResponseBox" id="ResponseBox" style="display: none;"></span>
					<div id="ResponseButton" style='display: none;'><span id='ResponseButtonName'></span><span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span></div>
				</div>
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
	<script>
		$(document).ready(function(){
			
			$(".SearchBoxIcon").click(function(){
				$(".SearchResultBox").empty();
			   	$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #0066ff; padding-top : 84px;">Searching...</div>');

				var client = new ClientJS();

				imprint.test(browserTests).then(function(result){
					var fingerprint_1 = new Fingerprint().get();
					var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
					audioFingerprint.run(function (fingerprint_2) {
						var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
						var d1 = new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX");
						

						var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

						// append data which we want to send data on targeted page
						var formdata = new FormData();
						formdata.append('SearchDataKey', $('#SearchInput').val());
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						// Check Internet connection
						if(navigator.onLine == false){
							$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">It seems that you are offline. Please check your internet connection</div>')
							swal("It seems that you are offline. Please check your internet connection", "", "warning");
							$("#Signup_response").css("color","red");
							$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
							return false;
						}

						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",ResponceHandler,false);
							ajax.open("POST", "SearchMemberBackend.php");
							ajax.send(formdata);
						}catch(error){
							swal("Profile image required",'','error');
							return false;
						}

						//function run on complete login ajax request
						function ResponceHandler(event)
						{
							var responce = $.parseJSON(event.target.responseText);
		                    $(".SearchResultBox").empty();
							if(responce['status'] == "Success" && responce['code'] == "200"){
								if(responce['msg']['ResultRows'] > 0){
								for(var i = 0; i < responce['msg']['ResultRows']; i++){
									var Temp = "'"+responce['msg']['Result'][i]['ProfileUrl']+"','"+responce['msg']['Result'][i]['Status']+"','"+responce['msg']['Result'][i]['Fullname']+"','"+responce['msg']['Result'][i]['Gender']+"','"+responce['msg']['Result'][i]['OrgPosition']+"','"+responce['msg']['Result'][i]['Position']+"','"+responce['msg']['Result'][i]['ActiveSchedule']+"','"+responce['msg']['Result'][i]['SearchUserUrl']+"','"+responce['msg']['Result'][i]['GroupId']+"','"+responce['msg']['Result'][i]['GroupType']+"','"+responce['msg']['Result'][i]['MemberOfGroup']+"'";
									if(responce['msg']['Result'][i]['Position'] == 'Student'){
										var Temp4thBtn = 'Request';
									}else{
										var Temp4thBtn = '';
									}
									$('.SearchResultBox').append('<div class="NewSearchResponseContainer'+i+' '+responce['msg']['Result'][i]['SearchUserUrl']+'"><div class = "NewResponseMainBox NewResponseMainBox2" style=""><div class="ImageBox"><img class="SearchProfileImage" src="<?php echo RootPath; ?>Users/UserDataStore/ProfileImage/Organization/<?php echo $ResponseLogin['LFR']; ?>/'+responce['msg']['Result'][i]['ProfileUrl']+'"></img></div><div class="StatusBox"><p>Status</p><p>'+responce['msg']['Result'][i]['Status']+'</p></div><div class="FullNameBox"><p>Name</p><p>'+responce['msg']['Result'][i]['Fullname']+'</p></div><div class="GenderBox"><p>Gender</p><p>'+responce['msg']['Result'][i]['Gender']+'</p></div><div class="OrgPositionBox"><p>Org Position</p><p>'+responce['msg']['Result'][i]['OrgPosition']+'</p></div><div class="ServicePositionBox"><p>Service Position</p><p>'+responce['msg']['Result'][i]['Position']+'</p></div><div class="ActiveScheduleBox"><p>Active Schedule</p><p>'+responce['msg']['Result'][i]['ActiveSchedule']+'</p></div><div class="SearchUserUrlBox" hidden><p>SearchUserUrl</p><p>'+responce['msg']['Result'][i]['SearchUserUrl']+'</p></div></div><div class="SearchResultButtonBox"><div class="ViewMember" onclick="ShowDetails('+"'View',"+Temp+')">View</div><div class="UpdateMember" onclick="ShowDetails('+"'Update',"+Temp+')">Update</div><div class="DeleteMember" onclick="ShowDetails('+"'Delete',"+Temp+')">Delete</div><div class="BlockMember" onclick="ShowDetails('+"'"+Temp4thBtn+"',"+Temp+')">'+Temp4thBtn+'</div></div>');
								}
								}else{
									$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">No result found</div>');
								}
							}
							else
							{
								$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">'+responce['msg']+'</div>');
							}

						}
					});
			    });
			});

			$('#SearchInput').val("<?php echo $_GET['Search']; ?>");
			if($('#SearchInput').val().length > 0){
				$('.SearchBoxIcon').trigger('click');
			}

			$('.CloseShowDetailsBox').click(function(){
				$('#ShowDetailsBox').css('display','none');
				$('#SecurityCode').val('').css({'display':'none'});
				$('#ResponseButton').css({'display':'none'});
				$('#ResponseButtonName').html('');
				$("#ResponseBox").html('').css({'display':'none',"color":"red"});
			});

			$('#SecurityCode').keyup(function(){
				$("#ResponseBox").html('');
			});
		});

		function ShowDetails(RequestType,ProfileUrl,Status,Fullname,Gender,OrgPosition,Position,ActiveSchedule,SearchUserUrl,GroupId,GroupType,MemberOfGroup){
			$('.Profile').attr('src',RootPath+'Users/UserDataStore/ProfileImage/Organization/<?php echo $ResponseLogin['LFR']; ?>/'+ProfileUrl);
			$(".StatusBoxF1 option[value="+Status+"]").prop('selected',true);
			$('.FullnameBoxF1 div').html(Fullname);
			$('.GenderBoxF1 div').html(Gender);
			$('.OrgPositionBoxF1 div').html(OrgPosition);
			$(".PositionBoxF1 option[value="+Position+"]").prop('selected',true);
			$('.ActiveScheduleBoxF1 input').html(ActiveSchedule);
			$('.SearchUserUrlBoxF1 div').html(SearchUserUrl);
			$(".GroupIdBoxF1 option[value="+GroupId+"]").prop('selected',true);
			$(".GroupTypeBoxF1 option[value="+GroupType+"]").prop('selected',true);
			$('.MemberOfGroupBoxF1 input').html(MemberOfGroup);
			if(RequestType != 'View'){
				if(RequestType == 'Update'){
					$('#ResponseButtonName').html('Update');
				}else if(RequestType == 'Delete'){
					$('#ResponseButtonName').html('Delete');
				}else if(RequestType == 'Request'){
					window.location.href = RootPath+'Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Manager/RequestStatus/index.php?u='+SearchUserUrl;
					return false;
				}else{
					return false;
				}
				if(RequestType == 'Update'){
					$('select').css({'-webkit-appearance':'','-moz-appearance':'','text-indent':'','text-overflow':''}).prop('disabled',false);
				}else{
					$('select').css({'-webkit-appearance':'none','-moz-appearance':'none','text-indent':'1px','text-overflow':''}).prop('disabled',true);
				}
				$('#SecurityCode').css({'display':'block'});
				$('#ResponseButton').css({'display':'block'});
			}else{
				$('select').css({'-webkit-appearance':'none','-moz-appearance':'none','text-indent':'1px','text-overflow':''}).prop('disabled',true);
			}
			$('#ShowDetailsBox').css('display','block');
		}

		$("#ResponseButton").click(function(){

			if(window.SubmitButton == true){
				swal('','A process already in queue','warning'); return false;
			}

			SubmitStart();

			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					var d1 = new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX");
					

					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					// append data which we want to send data on targeted page
					var formdata = new FormData();
					var RequestType = $('#ResponseButtonName').html();

					if(RequestType == 'Update'){
						formdata.append('Status', $('.Status').val());
						formdata.append('Position', $('.Position').val());
						formdata.append('GroupId', $('.GroupId').val());
						formdata.append('GroupType', $('.GroupType').val());
					}else if(RequestType == 'Delete'){
						// Continue
					}else if(RequestType == 'Block'){
						formdata.append('Status','Block');
						formdata.append('Position', $('.Position').val());
						formdata.append('GroupId', $('.GroupId').val());
						formdata.append('GroupType', $('.GroupType').val());
					}else{
						swal('','Invalid request type detect','warning'); SubmitReset(); return false;
					}
					var UserUrl = $('.Form1UserUrl').html();
					formdata.append('UserUrl', UserUrl);
					formdata.append('SecurityCode', $('#SecurityCode').val());
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Check Internet connection
					if(navigator.onLine == false){
						$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">It seems that you are offline. Please check your internet connection</div>');
						swal("It seems that you are offline. Please check your internet connection", "", "warning");
						$("#Signup_response").css("color","red");
						$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
						SubmitReset(); return false;
					}
					
					try{
						var ajax = new XMLHttpRequest();
						if(RequestType == 'Update'){
							ajax.addEventListener("load",UpdateHandler,false);
							ajax.open("POST", '../../UpdateMemberBackend.php');
						}else if(RequestType == 'Delete'){
							ajax.addEventListener("load",DeleteHandler,false);
							ajax.open("POST", '../../DeleteMemberBackend.php');
						}else{
							swal("",'Invalid button it detect','error'); SubmitReset(); return false;
						}
						ajax.send(formdata);
					}catch(error){
						swal("",'Response can not sent Error('+error+')','error'); SubmitReset(); return false;
					}

					//function run on listion response from ajax
					function UpdateHandler(event){
						SubmitReset();
						var responce = $.parseJSON(event.target.responseText);
						if(responce['status'] === 'Success' && responce['code'] === 200){
							swal('Update',responce['msg'],'success')
							.then((value) => {
								$('.CloseShowDetailsBox').click();
								$('#SearchInput').val(UserUrl);
								$('.SearchIcon').click();
							});
						}else if(responce['status'] === 'Warning' && responce['code'] === 404){
							swal('Update',responce['msg'],'warning');
						}else{
							swal('Update',responce['msg'],'error');
						}
						return false;
					}

					function BlockHandler(event){
						SubmitReset();
						var responce = $.parseJSON(event.target.responseText);
						if(responce['status'] === 'Success' && responce['code'] === 200){
							swal('Block','User blocked successfully','success')
							.then((value) => {
								$('.CloseShowDetailsBox').click();
								$('#SearchInput').val(UserUrl);
								$('.SearchIcon').click();
							});
						}else if(responce['status'] === 'Warning' && responce['code'] === 404){
							swal('Update','User already blocked','warning');
						}else{
							swal('Update','User block process failed! May be SecurityCode is wrong','error');
						}
						return false;
					}

					function DeleteHandler(event){
						SubmitReset();
						var responce = $.parseJSON(event.target.responseText);
						if(responce['status'] === 'Success' && responce['code'] === 200){
							swal('Delete','User Delete successfully','success')
							.then((value) => {
								$('.CloseShowDetailsBox').click();
								$('.'+UserUrl).remove();
							});
						}else if(responce['status'] === 'Warning' && responce['code'] === 404){
							swal('Delete','User already Delete','warning');
						}else{
							swal('Delete',responce['msg'],'error');
						}
						return false;
					}
				});
		    });

			function SubmitStart(){
				window.SubmitButton = true;
				$("input").prop("disabled",true);
				$("select").prop("disabled",true);
				$('#ResponseButton').css("pointer-events","none");
				$("#ResponseButton").css("background","linear-gradient(skyblue, pink)");
				$("#ResponseButton").css("cursor","default");
				$(".loader_round_main").prop('hidden',false);
			}

			function SubmitReset(){
				$("input").prop("disabled",false);
				$("select").prop("disabled",false);
				$('#ResponseButton').css("pointer-events","auto");
				$("#ResponseButton").css("background","transparent");
				$("#ResponseButton").css("cursor","pointer");
				$(".loader_round_main").prop('hidden',true);
				window.SubmitButton = false;
			}
		});
	</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>