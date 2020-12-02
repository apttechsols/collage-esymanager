<?php
	/*
	*@FileName ChangePassword/index.php
	*@Des ---
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

	define("RootPath", "../../../");

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

	$ResponseLogin = IsLogin(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoOrganizationUserAccount'=>$PdoOrganizationUserAccount,'EPass'=>$EncodeAndEncryptPass]);

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'GetOrganizationData' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'GetUpdateUserData' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}
	
	define("PageTitle", "ChangePassword And Pin");
	define("CssFile", "ChangePasswordAndPin");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class="container">
		<div class="add_member_text">CHANGE PASSWORD & PIN</div>
		<div class="SubContainer">
			<!-- <div class='Form0'>
				<div class="UsernameBox">
			    	<input class='DtlTxt Username' type="text" name="Username" placeholder="Enter Mobile Or Email or Unique Id"/>
			    	<p class='DtlTl'>Mobile Or Email Or Unique Id</p>
				</div>
			</div> -->
			<div class="Form1">
				<div class="OldPassBox">
			    	<input class='DtlTxt OldPass' type="text" name="OldPass" placeholder="Enter Old Password"/>
			    	<p class='DtlTl'>Enter Old Password</p>
				</div>
				<div class="OldPinBox">
			    	<input class='DtlTxt OldPin' type="text" name="OldPin" placeholder="Enter Old Pin"/>
			    	<p class='DtlTl'>Enter Old Pin</p>
				</div>
				<div class="NewPassBox">
			    	<input class='DtlTxt NewPass' type="text" name="NewPass" placeholder="Enter New Password"/>
			    	<p class='DtlTl'>Enter New Password</p>
				</div>

				<div class="NewConfirmPassBox">
			    	<input class='DtlTxt ConNewPass' type="text" name="ConNewPass" placeholder="Confirm Password"/>
			    	<p class='DtlTl'>Confirm Password</p>
				</div>

				<div class="NewPinBox">
			    	<input class='DtlTxt NewPin' type="text" name="NewPin" placeholder="Enter New Pin"/>
			    	<p class='DtlTl'>Enter New Pin</p>
				</div>

				<div class="NewConfirmPinBox">
			    	<input class='DtlTxt ConNewPin' type="text" name="ConNewPin" placeholder="Confirm Pin"/>
			    	<p class='DtlTl'>Confirm Pin</p>
				</div>
			</div>
			<div class='Form3'>
				<div class="ChangePassBox">
					<div class='ChangePass'>Change Password<span class="loader_round_main ChangePassLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
				</div>
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

		window.SubmitChangePassAndPin = false;
		$(".ChangePass").click(function(){
			
			if(window.SubmitChangePassAndPin != false){
				swal('','Button already clicked','error');return false;
			}

			StartSubmitChangePass();

			var OldPass = $(".OldPass").val();
			var OldPin = $(".OldPin").val();
			var NewPass = $(".NewPass").val();
			var ConNewPass = $(".ConNewPass").val();
			var NewPin = $(".NewPin").val();
			var ConNewPin = $(".ConNewPin").val();

			if(NewPass !== ConNewPass){
				swal('','Password Or Confirm Password not matched','error'); SubmitResetChangePass(); return false;
			}

			if(NewPin !== ConNewPin){
				swal('','Pin Or Confirm Pin not matched','error'); SubmitResetChangePass(); return false;
			}

			// Mobile Number Validataion
			if(NewPass == ""){ swal('','Invalid New Password detect','error'); }
			if(NewPin == ""){ swal('','Invalid New Pin detect','error'); }

			if(navigator.onLine == false){
				swal('','Please check your internet connection','warning'); SubmitResetChangePass(); return false;
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
					formdata.append("OldPass", OldPass);
					formdata.append("OldPin", OldPin);
					formdata.append("NewPass", NewPass);
					formdata.append("NewPin", NewPin);
					formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",ChangePassAndPinResponse,false);
						ajax.open("POST", "ChangePasswordAndPinBackend.php");
						ajax.send(formdata);
					}catch(error){
						swal('','There is an error occur','warning'); SubmitResetChangePass(); return false;
					}

					//function run on complete login ajax request
					function ChangePassAndPinResponse(event){
						SubmitResetChangePass();
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
						   swal('',response['msg'],'success')
						   .then(() => {
						   	window.location.replace(RootPath+'Users/Login/index.php?Organization=');
						   });
						}else{
							swal('',response['msg'],'error');
						}
						return false;
					}
				});
			});
			function StartSubmitChangePass(){
				window.SubmitChangePassAndPin = true;
				$('.ChangePassLoader').prop('hidden',false);
			}
			function SubmitResetChangePass(){
				window.SubmitChangePassAndPin = false;
				$('.ChangePassLoader').prop('hidden',true);
			}
		});
	});
</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>