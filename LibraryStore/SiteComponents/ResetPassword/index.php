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
	
	if($ResponseLogin['status'] == 'Success' || $ResponseLogin['code'] == 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}
	
	define("PageTitle", "Reset Password");
	define("CssFile", "ResetPassword");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class="container">
		<div class="add_member_text">RESET PASSWORD</div>
		<div class="SubContainer">
			<!-- <div class='Form0'>
				<div class="UsernameBox">
			    	<input class='DtlTxt Username' type="text" name="Username" placeholder="Enter Mobile Or Email or Unique Id"/>
			    	<p class='DtlTl'>Mobile Or Email Or Unique Id</p>
				</div>
			</div> -->
			<div class="Form1">
				<div class="UsernameBox">
			    	<input class='DtlTxt Mobile' type="text" name="Mobile" placeholder="Enter Mobile Number"/>
			    	<p class='DtlTl'>Mobile</p>
				</div>
				<div class="OrgNameBox">
			    	<input class='DtlTxt OrgName' type="text" name="OrgName" placeholder="Enter Organization Name"/>
			    	<p class='DtlTl'>Organization</p>
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
				<div class="GetOtpBox">
					<div class='GetOtp'>Get OTP<span class="loader_round_main GetOtpLoader" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
				</div>
				<div class="OtpBox" hidden="true">
					<input class='DtlTxt Otp' type="text" name="Otp" placeholder="Enter Otp"/>
					<p class='DtlTl'>Enter OTP</p>
				</div>
				<div class="ChangePassBox" hidden="true">
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
		window.SubmitGetOtp = false;
		$(".GetOtp").click(function(){

			if(window.SubmitGetOtp != false){
				swal('','Button already clicked','error');return false;
			}

			StartSubmitGetOtp();
			
			var Mobile = $(".Mobile").val();
			var OrgName = $(".OrgName").val();

			// Mobile Number Validataion
			if(Mobile == ""){ swal('','Invalid mobile number detect','warning'); }

			if(navigator.onLine == false){
				swal('','Please check your internet connection','warning'); SubmitResetGetOtp(); return false;
			}
			
			// append data which we want to send data on targeted page
			var formdata = new FormData();
			formdata.append("Mobile", Mobile);
			formdata.append("OrgName", OrgName);
			formdata.append("Token_CSRF", '<?php echo $Token_CSRF; ?>');

			// Send data on AddNewMemberBackend page
			try{
				var ajax = new XMLHttpRequest();
				ajax.addEventListener("load",GetRestPasswordOtpResponse,false);
				ajax.open("POST", "GetRestPasswordOtp.php");
				ajax.send(formdata);
			}catch(error){
				swal('','There is an error occur','warning'); SubmitResetGetOtp(); return false;
			}

			//function run on complete login ajax request
			function GetRestPasswordOtpResponse(event){
				SubmitResetGetOtp();
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
					window.SubmitGetOtp = true;
				   swal('',response['msg'],'success')
				   .then(() => {
				   		$('.GetOtpBox').prop('hidden',true);
				   		$('.OtpBox').prop('hidden',false);
				   		$('.ChangePassBox').prop('hidden',false);
				   });
				}else if(response['code'] === 404){
					swal('',response['msg'],'warning');
				}else{
					swal('',response['msg'],'error');
				}
				return false;
			}
			function StartSubmitGetOtp(){
				window.SubmitGetOtp = true;
				$('.GetOtpLoader').prop('hidden',false);
			}
			function SubmitResetGetOtp(){
				window.SubmitGetOtp = false;
				$('.GetOtpLoader').prop('hidden',true);
			}
		});

		window.SubmitChangePass = false;
		$(".ChangePass").click(function(){
			
			if(window.SubmitChangePass != false){
				swal('','Button already clicked','error');return false;
			}

			StartSubmitChangePass();
			
			var Mobile = $(".Mobile").val();
			var OrgName = $(".OrgName").val();
			var NewPass = $(".NewPass").val();
			var ConNewPass = $(".ConNewPass").val();
			var NewPin = $(".NewPin").val();
			var ConNewPin = $(".ConNewPin").val();
			var Otp = $(".Otp").val();

			if(NewPass !== ConNewPass){
				swal('','Password Or Confirm Password not matched','error'); SubmitResetChangePass(); return false;
			}

			if(NewPin !== ConNewPin){
				swal('','Pin Or Confirm Pin not matched','error'); SubmitResetChangePass(); return false;
			}

			// Mobile Number Validataion
			if(Mobile == ""){ swal('','Invalid mobile number detect','error'); }
			if(OrgName == ""){ swal('','Invalid Org Name detect','error'); }
			if(NewPass == ""){ swal('','Invalid New Password detect','error'); }
			if(NewPin == ""){ swal('','Invalid New Pin detect','error'); }
			if(Otp == ""){ swal('','Invalid Otp detect','error'); }

			if(navigator.onLine == false){
				swal('','Please check your internet connection','warning'); SubmitResetChangePass(); return false;
			}
			
			// append data which we want to send data on targeted page
			var formdata = new FormData();
			formdata.append("Mobile", Mobile);
			formdata.append("OrgName", OrgName);
			formdata.append("NewPass", NewPass);
			formdata.append("NewPin", NewPin);
			formdata.append("Otp", Otp);
			formdata.append("Token_CSRF", '<?php echo $Token_CSRF; ?>');

			// Send data on AddNewMemberBackend page
			try{
				var ajax = new XMLHttpRequest();
				ajax.addEventListener("load",ChangePassResponse,false);
				ajax.open("POST", "ChangePassBackend.php");
				ajax.send(formdata);
			}catch(error){
				swal('','There is an error occur','warning'); SubmitResetChangePass(); return false;
			}

			//function run on complete login ajax request
			function ChangePassResponse(event){
				SubmitResetChangePass();
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
				   swal('',response['msg'],'success')
				   .then(() => {
				   	window.location.replace(RootPath+'Users/Login/index.php?Organization='+OrgName);
				   });
				}else{
					swal('',response['msg'],'error');
				}
				return false;
			}
			function StartSubmitChangePass(){
				window.SubmitChangePass = true;
				$('.ChangePassLoader').prop('hidden',false);
			}
			function SubmitResetChangePass(){
				window.SubmitChangePass = false;
				$('.ChangePassLoader').prop('hidden',true);
			}
		});
	});
</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>