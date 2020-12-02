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

	define("RootPath", "../../../../../");

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

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{

		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'MainMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'Main'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank <= 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}
	define("PageTitle", "Search Plan");
	define("CssFile", "SearchPlan");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "MainContainer">
			<div class = "SearchBoxMain">
				<div>
					<input type="text" class = "SearchInput" id="SearchInput" placeholder="Enter Service name" value="<?php echo $_GET['target']; ?>" autocomplete="off">
				</div>
				<div class=SearchBoxIcon>
					<img class = "SearchIcon" src="<?php echo RootPath; ?>Image_store/SearchIcionWhite48px.png">
				</div>
			</div>
			<div class="SearchResultBox">
				<div class = "NewResponseMainBox">Plans Appear Here</div>
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
						var BrowserClientId1 = "<?php echo $SessionEncryptPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass2; ?>";
						

						var BrowserClientId2 = "<?php echo $SessionEncryptPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass4; ?>";

						var SearchDataKey = $('#SearchInput').val();

						// append data which we want to send data on targetd page
						var formdata = new FormData();
						formdata.append('SearchDataKey', SearchDataKey);
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						// Check Internet connection
						if(navigator.onLine == false){
							swal("It seems that you are offline. Please check your internet connection", "", "warning");
							$("#Signup_response").css("color","red");
							$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
							return false;
						}

						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",ResponceHandler,false);
							ajax.open("POST", "SearchPlanBackend.php");
							ajax.send(formdata);
						}catch(error){
							swal(error,'','error');
							return false;
						}

						//function run on complete login ajax request
						function ResponceHandler(event)
						{
							var responce = $.parseJSON(event.target.responseText);
		                    $(".SearchResultBox").empty();
							if(responce['status'] == "Success" && responce['code'] == "200")
							{	
								for(var i = 0; i < responce['msg']['totalrows']; i++){
									$('.SearchResultBox').append('<div class="NewSearchResponseContainer'+i+'"><div class = "NewResponseMainBox" style="grid-template-columns : repeat(8,1fr); padding-top : 0px;"><div class="StatusBox"><p>Status</p><p>'+responce['msg']['msg'][i]['Status']+'</p></div><div class="PriceBox"><p>Price</p><p>'+responce['msg']['msg'][i]['Price']+'</p></div><div class="ValidityBox"><p>Validity</p><p>'+responce['msg']['msg'][i]['Validity']+'</p></div><div class="MaxRequestBox"><p>Max Request</p><p>'+responce['msg']['msg'][i]['MaxRequestLimit']+'</p></div><div class="StartTimeBox"><p>Start Time</p><p>'+responce['msg']['msg'][i]['StartTime']+'</p></div><div class="ExpTimeBox"><p>Expire Time</p><p>'+responce['msg']['msg'][i]['ExpTime']+'</p></div><div class="LastUpdate"><p>Last Update</p><p>'+responce['msg']['msg'][i]['LastUpdateTime']+'</p></div><div class="TotalSelledPackBox"><p>Total Selled Pack</p><p>'+responce['msg']['msg'][i]['TotalSelledPack']+'</p></div><div class="PlanCodeBox" hidden><p>Plan Code</p><p>'+responce['msg']['msg'][i]['PlanCode']+'</p></div><div class="PlanForBox" hidden><p>Plan For</p><p>'+SearchDataKey+'</p></div></div><div class="SearchResultButtonBox"><div class="ViewServices" onclick="ViewServices('+i+')">View</div><div class="AddServices" onclick="AddServices('+i+')">Add</div><div class="UpdateServices" onclick="UpdateServices('+i+')">Update</div><div class="DeletePlans" onclick="DeletePlans('+i+')">Delete</div></div></div>');
								}
							}
							else
							{
								$(".SearchResultBox").html('<div class = "NewResponseMainBox" style="grid-template-columns : 1fr; color : #ff0000; padding-top : 84px;">'+responce['msg']+'</div>')
							}

						}
					});
			    });	
			});
			
			if($(".SearchInput").val().length > 0){
				$(".SearchBoxIcon").click();
			}
		});
		function ViewServices(getData){
			window.location.href = "../ViewService/index.php?target="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanCodeBox p:eq(1)').html();

		}

		function AddServices(getData){
			//window.location.href = "../AddServices/index.php?target="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanCodeBox p:eq(1)').html();

		}

		function UpdateServices(getData){
			window.location.href = "../UpdatePlan/index.php?target="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanCodeBox p:eq(1)').html();

		}

		function DeletePlans(getData){

			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $SessionEncryptPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass2; ?>";
					

					var BrowserClientId2 = "<?php echo $SessionEncryptPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass4; ?>";

					swal("Are you sure you want to delete? Beause this action can not be undo", {
						buttons: {
							cancel: "Cancel",
							Next: true,
						},
					  	closeOnClickOutside: false,
					  	closeOnEsc: false,
					})
					.then((value) => {
						if(value === "Next"){
							var TempNum1 = Math.floor(Math.random() * 1000 + 1);
							var TempNum2 = Math.floor(Math.random() * 1000 + 1);
							swal("Add these two number "+ TempNum1 + ", "+ TempNum2 +" and enter answer in given box", {
								buttons: {
									cancel: "Cancel",
									Next: true,
								},
								content: {
									element: "input",
									attributes: {
										placeholder: "Enter answer here",
										type: "text",
										className: "CheckResult",
									},
								},
							  	closeOnClickOutside: false,
							  	closeOnEsc: false,
							})
							.then((value) => {
								if(value === "Next"){
									if($(".CheckResult").val() == TempNum1+TempNum2){
										swal('Enter your Security Code to Delete this plan', {
											buttons: {
												cancel: "Cancel",
												Next: true,
											},
											content: {
												element: "input",
												attributes: {
													placeholder: "Type your password",
													type: "password",
													className: "VirtualSecurityCode",
												},
											},
										  	closeOnClickOutside: false,
										  	closeOnEsc: false,
										})
										.then((value) => {
											if(value === "Next"){

												// append data which we want to send data on targetd page
												var formdata = new FormData();
												formdata.append('target', "<?php echo $_GET['target']; ?>");
												formdata.append("PlanFor", $('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanForBox p:eq(1)').html());
												formdata.append("PlanCode", $('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanCodeBox p:eq(1)').html());
												formdata.append("SecurityCode", $(".VirtualSecurityCode").val());
												formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
												formdata.append("BrowserClientId1", BrowserClientId1);
												formdata.append("BrowserClientId2", BrowserClientId2);

												// Check Internet connection
												if(navigator.onLine == false){
													swal("It seems that you are offline. Please check your internet connection", "", "warning");
													$("#Signup_response").css("color","red");
													$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
													return false;
												}

												try{
													var ajax = new XMLHttpRequest();
													ajax.addEventListener("load",ResponceHandler,false);
													ajax.open("POST", "../DeletePlan/index.php");
													ajax.send(formdata);
												}catch(error){
													swal(error,'','error');
													return false;
												}

												//function run on complete login ajax request
												function ResponceHandler(event){
													var responce = $.parseJSON(event.target.responseText);
													if(responce['status'] == "Success" && responce['code'] == "200"){
														swal('',responce['msg'],'success')
														.then(()=>{
															window.location.replace("<?php echo RootPath; ?>Users/Main/Dashboard/ManageServices/SearchPlan/index.php?target="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PlanForBox p:eq(1)').html()); return false;
														});	
													}else{
														swal('',responce['msg'],'error');
													}
												}
											}else{
												return false;
											}
										});
									}else{
										swal('','Wrong answer detect! Try again','warning');
									}
								}else{
									return false;
								}
							});
						}else{
							return false;
						}
					});
				});
		    });

		}
	</script>
<!-- Remove all vars of php -->
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>