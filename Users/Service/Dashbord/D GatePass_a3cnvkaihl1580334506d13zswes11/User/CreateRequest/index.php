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
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");
	
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
				$ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
				$GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::GroupSetting::,::SettingKeyUnique::::ServiceActiveSchedule::,::SettingKeyUnique::::SmsUpdatePermission::,::SettingKeyUnique::::GeneralSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
			}
		}
	}

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars

	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	
	$CurrentTime = time();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	if($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}else if($ServiceMemberData['msg']->Status != 'Active'){
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

	foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
		$Temp =  explode(':', $value);
		${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
	}

	$TempGetServiceSettingSmsUpdatePermission = explode(',', $GetServiceSettingSmsUpdatePermission);
	foreach ($TempGetServiceSettingSmsUpdatePermission as $value) {
		$Temp =  explode('-', $value);
		${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
	}
	$LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
	if($LgUserServicePositionRank == ''){
		foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
		FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	if($LgUserServicePositionRank != 0){
		header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
	}

	$TempAutoNextTime = $CurrentTime+$GetServiceSettingGeneralSettingMinRequestSubmitAndOutGoingTimeDiff+298;
	$Temp2AutoNextTime = $TempAutoNextTime+1800;
	define("PageTitle", "D GatePass : REQUEST");
	define("CssFile", "CreateRequest");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "Request_Main_Container">
			<p class = "Request_Title" >CREATE REQUEST</p>
			<div class = "Request_Container">
				<div>
					<!-- <span>Where you wanna go?</span> -->
					<input type="text" class = "Request_Container_Venue Request_Container_input_box" id="Venue" placeholder="Venue" maxlength="100" spellcheck="false" />
					<p id="Request_venue_error" class="Request_error"></p>
				</div>
				<div>
					<!-- <span>Why are you go there?</span> -->
					<textarea class = "Request_Container_Reason Request_Container_input_box" id="Reason" placeholder="Reason" maxlength="250" spellcheck="false"></textarea>
					<p id="Request_Reason_error" class="Request_error"></p>
				</div>
				<?php if($GetServiceSettingGeneralSettingOutGoingTimeTrack == 'Yes'){ ?>
					<div class='Request_Container_DateTimeTl' style='margin:18px auto -22px auto;color:#fff;'>What is Your OutGoing Time (Approx)</div>
					<div class = "Request_Container_DateTime">
						<div class="Request_Container_DateTime_input1" style='display: flex;'>
							<?php
								echo '<select id="OutGoingDay">';
								for($i=1; $i<=31; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="OutGoingMonth">';
								for($i=1; $i<=12; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="OutGoingYear">';
								for($i=0; $i<2; $i++){
									$Temp = 2020+$i;
									echo "<option value='$Temp'>$Temp</option>";
								}
								echo '</select>';
							?>
						</div>
						<div class="Request_Container_DateTime_input2" style='display: flex;'>
							<?php
								echo '<select id="OutGoingHour">';
								for($i=0; $i<=12; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="OutGoingMin">';
								for($i=0; $i<=59; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="OutGoingAmPm">';
									echo "<option value='AM'>AM</option>";
									echo "<option value='PM'>PM</option>";
								echo '</select>';
							?>
						</div>
					</div>
				<?php } ?>
				<?php if($GetServiceSettingGeneralSettingInComingTimeTrack == 'Yes'){ ?>
					<div class='InComingDateAndTimeTl' style='margin:14px auto -22px auto;color:#fff;'>What is Your InComing Time</div>
					<div class = "InComingDateAndTime">
						<div class="InComingDate" style='display: flex;'>
							<?php
								echo '<select id="InComingDay">';
								for($i=1; $i<=31; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="InComingMonth">';
								for($i=1; $i<=12; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="InComingYear">';
								for($i=0; $i<2; $i++){
									$Temp = 2020+$i;
									echo "<option value='$Temp'>$Temp</option>";
								}
								echo '</select>';
							?>
						</div>	
						<div class="InComingTime" style='display: flex;'>
							<?php
								echo '<select id="InComingHour">';
								for($i=0; $i<=12; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="InComingMin">';
								for($i=0; $i<=59; $i++){
									if($i < 10){
										echo "<option value='0$i'>0$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								echo '</select>';
								echo '<select id="InComingAmPm">';
									echo "<option value='AM'>AM</option>";
									echo "<option value='PM'>PM</option>";
								echo '</select>';
							?>
						</div>
					</div>
				<?php } ?>
				<div>
					<input type="password" class = "SecurityCode Request_Container_input_box" id="SecurityCode" placeholder="Security Code" maxlength="6" />
					<p id="Request_Security_code_error" class="Request_error"></p>
				</div>
				<div class = "SubmitButton" id="SubmitButton">Submit<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
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

		$("#Venue").keyup(function(){
		    this.value = this.value = this.value.replace(/[^A-Za-z0-9]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z0-9,-. ]/g,'').slice(1).toLowerCase();
			if(this.value.length >= 3 || this.value.length <= 100)
			{
				$("#Request_venue_error").html("");
			}
		});
		$("#Venue").blur(function(){
			if(this.value.length < 3 || this.value.length > 100){
				$("#Request_venue_error").html("Venue length must lie between 3 to 100");
			}
		});
		$("#Reason").keyup(function(){
		    this.value = this.value = this.value.replace(/[^A-Za-z0-9]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z0-9,-. ]/g,'').slice(1).toLowerCase();
			if(this.value.length < 10 || this.value.length > 250){
				$("#Request_Reason_error").html("");
			}
		});
		$("#Reason").blur(function(){
			if(this.value.length < 10 || this.value.length > 250){
				$("#Request_Reason_error").html("Reason length must lie between 10 to 250");
			}
		});
		$("#SecurityCode").keyup(function(){
			if(this.value.length >3 && this.value.length <7){
				$("#Request_Security_code_error").html("");
			}
		});
		$("#SecurityCode").blur(function(){
			if(this.value.length < 4 || this.value.length > 6){
				$("#Request_Security_code_error").html("Invalid Security Code");
			}
		});

		window.Submit_process = false;
		$("#SubmitButton").click(function(){
			if(window.Submit_process != false){
				swal('','Process in queue','warning'); return false;
			}
			SubmitStart();
			var Venue = $('#Venue').val();
			var Reason = $('#Reason').val();
			if(document.getElementById("OutGoingDay")){
				var GivenDate = $('#OutGoingDay').val()+'-'+$('#OutGoingMonth').val()+'-'+$('#OutGoingYear').val();
			}else{
				var GivenDate =  '';
			}
			var GivenTime =  $('#OutGoingHour').val()+':'+$('#OutGoingMin').val()+':'+$('#OutGoingAmPm').val();
			if(document.getElementById("InComingDay")){
				var InComingDate = $('#InComingDay').val()+'-'+$('#InComingMonth').val()+'-'+$('#InComingYear').val();
			}else{
				var InComingDate =  '';
			}

			var InComingTime =  $('#InComingHour').val()+':'+$('#InComingMin').val()+':'+$('#InComingAmPm').val();
			var SecurityCode = $('#SecurityCode').val();

			if(!isDate(GivenDate) && GivenDate != ''){
				swal('','Inavlid OutGoing Date found','warning'); SubmitReset(); return false;
			}
			if(!isDate(InComingDate) && InComingDate != ''){
				swal('','Inavlid InComing Date found','warning'); SubmitReset(); return false;
			}
			if(Venue.length < 3 || Venue.length > 50){
				swal('','Venue must be between 3 to 50 char long','warning'); SubmitReset(); return false;
			}

			if(Reason.length < 10 ||Reason.length > 250){
				swal('','Reason must be between 10 to 100 char long','warning'); SubmitReset(); return false;
			}

			if(GivenTime.length < 6){
				swal('','Invalid time found','warning'); SubmitReset(); return false;
			}

			if(SecurityCode.length < 1){
				swal('','Invalid Security Code found','warning'); SubmitReset(); return false;
			}

			// Check Internet connection
			if(navigator.onLine == false){
				swal('',"It seems that you are offline. Please check your internet connection", "warning"); SubmitReset(); return false;
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
					formdata.append("Venue", Venue);
					formdata.append("Reason", Reason);
					formdata.append("GivenDate", GivenDate);
					formdata.append("GivenTime", GivenTime);
					formdata.append("InComingDate", InComingDate);
					formdata.append("InComingTime", InComingTime);
					formdata.append("SecurityCode", SecurityCode);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",ResponceHandler,false);
						ajax.open("POST", "CreateRequestBackend.php");
						ajax.send(formdata);
					}catch(error){
						swal(error,'','error');
						window.Submit_process = false;
						return false;
					}

					//function run on complete login ajax request
					function ResponceHandler(event){
						SubmitReset();
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
							swal('',response['msg'], "success")
							.then(() => {
								window.location.replace("<?php echo RootPath; ?>Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/User/RequestStatus/index.php");
							});
			               }else{
							swal('',response['msg'],'error');
						}

					}
				});
		    });
		});

		function SubmitStart(){
			window.Submit_process = true;
			$("input").prop("disabled",true);
			$("textarea").prop("disabled",true);
			$('.SubmitButton').css("pointer-events","none");
			$(".SubmitButton").css("background","linear-gradient(skyblue, pink)");
			$(".SubmitButton").css("cursor","default");
			$(".loader_round_main").prop('hidden',false);
		}

		function SubmitReset(){
			$("input").prop("disabled",false);
			$("textarea").prop("disabled",false);
			$('.SubmitButton').css("pointer-events","auto");
			$(".SubmitButton").css("background","rbg(255,255,255)");
			$(".SubmitButton").css("cursor","pointer");
			$(".loader_round_main").prop('hidden',true);
			window.Submit_process = false;
		}

		(function(){
		    $("#OutGoingDay option[value='<?php echo date('d', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#OutGoingMonth option[value='<?php echo date('m', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#OutGoingYear option[value='<?php echo date('Y', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#OutGoingHour option[value='<?php echo date('h', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#OutGoingMin option[value='<?php echo date('i', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#OutGoingAmPm option[value='<?php echo date('A', $TempAutoNextTime); ?>']").prop('selected',true);
		    $("#InComingDay option[value='<?php echo date('d', $Temp2AutoNextTime); ?>']").prop('selected',true);
		    $("#InComingMonth option[value='<?php echo date('m', $Temp2AutoNextTime); ?>']").prop('selected',true);
		    $("#InComingYear option[value='<?php echo date('Y', $Temp2AutoNextTime); ?>']").prop('selected',true);
		    $("#InComingHour option[value='<?php echo date('h', $Temp2AutoNextTime); ?>']").prop('selected',true);
		    $("#InComingMin option[value='<?php echo date('i', $Temp2AutoNextTime); ?>']").prop('selected',true);
		    $("#InComingAmPm option[value='<?php echo date('A', $Temp2AutoNextTime); ?>']").prop('selected',true);
		}());	
	});
</script>
</html>