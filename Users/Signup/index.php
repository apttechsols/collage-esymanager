<?php 
	/*
	*@FileName Signup/index.php
	*@Des Provide signup layout or interface
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

	define("RootPath", "../../");

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

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars

	if($ResponseLogin['status'] === 'Success' || $ResponseLogin['code'] === 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php");
		die();
	}
	
	$Task = 'Signup';
	define("PageTitle", "Signup");
	define("CssFile", "Signup");
	require_once RootPath."Site_Header/index.php";
?>
	<body class="SelectEventStop" style="margin: 0px; height: -webkit-fill-available; min-height: 100%;">
		<div class="MainContainer">
			<div class="SubContainer">
				<div class="signup_image_round_border">
					<img class="signup_image" id="signup_image" src="<?php echo RootPath; ?>Image_store/cute_dog.jpg">
					<div>
					<label for="Signup_image_file_input" class="change_signup_profile_image">Change Profile</label>
					</div>
					<input type="file" class="Signup_image_file_input" id="Signup_image_file_input" name="Signup_image_file_input" accept="image/*" hidden/>
				</div>
				<h1 class="Signup_text_under_signup_image">Signup</h1>
				<div class='Form1'>
					<div class="SignupForBox">
						<select class="SignupType" id="SignupType">
							<option value="Organization">Organization</option>
							<option value="Main">Main</option>
						</select>
					</div>
					<div class="Signup_username_main_box">
						<input type="text" class="Signup_username" id="Signup_username" placeholder="Username" maxlength="18" autocomplete="none" spellcheck="false" onselectstart="return true" />
						<p class="signup_error_text_show" id="Signup_username_error_text"></p>
					</div>
					<div class="Signup_fullname_main_box">
						<input type="text" class="Signup_fullname" id="Signup_fullname" placeholder="Full Name" maxlength="30" autocomplete="on" spellcheck="false" onselectstart="return true" />
						<p class="signup_error_text_show" id="Signup_fullname_error_text"></p>
					</div>
					<div class="Signup_gender_main_box">
						<select class="Signup_gender" id="Signup_gender">
							<option value="Default_Gender">Select gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Organization">Organization</option>
						</select>
						<p class="signup_error_text_show" id="Signup_gender_error_text"></p>
					</div>
					<div class="Signup_organization_type_main_box">
						<select class="Signup_organization_type" id="Signup_organization_type">
							<option value="Default_organization_type">Select Organization Type</option>
							<option value="College">College</option>
						</select>
						<p class="signup_error_text_show" id="Signup_organization_type_error_text"></p>
					</div>
					<div class="MainPostionRequestType" style="display: none;">
						<select class="PostionRequest" id="PostionRequest">
							<option value="">Postion Request</option>
							<option value="Manager">Manager</option>
							<option value="ServiceManager">Service Manager</option>
							<option value="SalesManager">Sales Manager</option>
							<option value="CustomerCare">Customer Care</option>
						</select>
						<p class="signup_error_text_show" id="PostionRequestError"></p>
					</div>
					<div class="BioBox" style="display: none;">
						<input type="text" class="Bio" id="Bio" placeholder="Bio" spellcheck="false" autocomplete="none" onselectstart="return true" maxlength="80" />
						<p class="signup_error_text_show" id="BioError"></p>
					</div>
					<div class="Signup_gmail_main_box">
						<input type="email" class="Signup_gmail" id="Signup_gmail" placeholder="Gmail" spellcheck="false" autocomplete="on" onselectstart="return true" />
						<p class="signup_error_text_show" id="Signup_gmail_error_text"></p>
					</div>
					<div class="Signup_mobile_number_main_box">
						<input type="tel" class="Signup_mobile_number" id="Signup_mobile_number" placeholder="Mobile Number" spellcheck="false" pattern="\d*" maxlength="20" autocomplete="on" onselectstart="return true" />
						<p class="signup_error_text_show" id="Signup_mobile_number_error_text"></p>
					</div>
					<div class="Signup_organization_name_main_box">
						<input type="text" class="Signup_organization_name" id="Signup_organization_name" placeholder="Organization Name" spellcheck="false" autocomplete="on" onselectstart="return true" />
						<p class="signup_error_text_show" id="Signup_organization_name_error_text"></p>
					</div>
					<div class="AddressBox">
						<input type="text" class="Address" id="Address" placeholder="Organization Address" spellcheck="false" autocomplete="on" onselectstart="return true" maxlength="50" />
						<p class="signup_error_text_show" id="AddressError"></p>
					</div>
					<div class="CityBox">
						<input type="text" class="City" id="City" placeholder="City" spellcheck="false" autocomplete="on" onselectstart="return true" maxlength="30"/>
						<p class="signup_error_text_show" id="CityError"></p>
					</div>
					<div class="PincodeBox">
						<input type="number" class="Pincode" id="Pincode" placeholder="Pincode" spellcheck="false" autocomplete="on" onselectstart="return true"/>
						<p class="signup_error_text_show" id="PincodeError"></p>
					</div>
					<div class="StateBox">
						<input type="text" class="State" id="State" placeholder="State" spellcheck="false" autocomplete="on" onselectstart="return true" maxlength="30"/>
						<p class="signup_error_text_show" id="StateError"></p>
					</div>
					<div class="CountryBox">
						<input type="text" class="Country" id="Country" placeholder="Country" spellcheck="false" autocomplete="on" onselectstart="return true" maxlength="30"/>
						<p class="signup_error_text_show" id="CountryError"></p>
					</div>
					<div class="Signup_password_main_box">
						<input type="password" class="Signup_password" id="Signup_password" placeholder="Password" autocomplete="none" spellcheck="false"/>
						<p class="signup_error_text_show" id="Signup_password_error_text"></p>
					</div>
					<div class="Signup_confirm_password_main_box">
						<input type="password" class="Signup_confirm_password" id="Signup_confirm_password" placeholder="Confirm Password" autocomplete="none" spellcheck="false"/>
						<p class="signup_error_text_show" id="Signup_confirm_password_error_text"></p>
					</div>
					<div class="SecurityCodeBox">
						<input type="number" class="SecurityCode" id="SecurityCode" placeholder="Create Security Code" autocomplete="none" spellcheck="false"/>
						<p class="signup_error_text_show" id="SecurityCodeError"></p>
					</div>
				</div>
				<div class="SendOTPBtn" id="SendOTPBtn">Send OTP<span class="signup_loader_round_main SendOTPLoader" hidden="true"><span class="signup_loader_round Signup_button_center"><span></span></span></span></div>
				<div class='MobOTPBox' id='MobOTPBox' hidden="true">
					<input type="number" class="MobOTP" id="MobOTP" placeholder="Mobile OTP" autocomplete="none" spellcheck="false"/>
				</div>
				<div class='EmailOTPBox' id='EmailOTPBox' hidden="true">
					<input type="number" class="EmailOTP" id="EmailOTP" placeholder="Email OTP" autocomplete="none" spellcheck="false"/>
				</div>
				<div class="Signup_response_main_box" id='Signup_response_main_box' hidden="true">
					<p class="Signup_response SelectEventStartAsText" id="Signup_response" onselectstart="return true"></p>
				</div>
				<div class="Signup_button" id="Signup_button" hidden="true">Signup <span class="signup_loader_round_main" hidden="true"><span class="signup_loader_round Signup_button_center"><span></span></span></span></div>
				<p class="Create_new_account_text">Already have an account? <span class="Goto_login_page">Login</span></p>
				<section class="Signup_bottom_all_links">
					<div class="Signup_TAndC">Terms & conditaions</div>
					<div class="Signup_privacy">Privacy</div>
					<div class="Signup_help">Need help</div>
					<div class="Signup_how_it_works">How it works?</div>
				</section> 
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script src="<?php echo RootPath; ?>MainJavascript/Live_Javascript/UserBrowser_detection.js"></script>
<script>
	$(document).ready(function(){

		// Signup username validations
	    $("#Signup_username").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z0-9_]/g,'').toLowerCase();
			if(this.value.length >= 5 && this.value.length <= 18){
				$("#Signup_username_error_text").html("");
			}
			$("#Signup_response").html("");
	    });
		$("#Signup_username").blur(function(){
			if(this.value.length < 5 || this.value.length > 18){
				$("#Signup_username_error_text").html("Username must be between 5 to 18 characters long");
			}
		});
		
		// Signup fullname validations 
		$("#Signup_fullname").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z ]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase();
			if(this.value.length >= 6 && this.value.length <= 30){
				Signup_fullname_check_contain_space = this.value.replace(/[^ ]/g,"").length;
				if(Signup_fullname_check_contain_space > 0){
					if(this.value.split(" ")[0].length > 0 && this.value.split(" ")[1].length > 0){
						$("#Signup_fullname_error_text").html("");
					}
				}
			}
			$("#Signup_response").html("");
	    });
		$("#Signup_fullname").blur(function(){
			if(this.value.length < 6 || this.value.length > 30){
				$("#Signup_fullname_error_text").html("Full name must be between 6 to 30 characters long");
			}else if(this.value.replace(/[^ ]/g,"").length < 1){
				$("#Signup_fullname_error_text").html("It's look like first name");
			}else if(this.value.split(" ")[0].length < 1){
				$("#Signup_fullname_error_text").html("It's look like first name");
			}else if(this.value.split(" ")[1].length < 1){
				$("#Signup_fullname_error_text").html("It's look like first name");
			}
		});
		
		// Signup Gender Validation
		$("#Signup_gender").blur(function(){
			if($("#Signup_gender").val() == "Default_Gender"){
				$("#Signup_gender_error_text").html("Gender must required");
			}else if($("#Signup_gender").val() != "Male" && $("#Signup_gender").val() != "Female" && $("#Signup_gender").val() != "Organization"){
				$("#Signup_gender_error_text").html("Gender contains invaild characters");
			}
		});
		$("#Signup_gender").change(function(){
			$("#Signup_gender option[value='Default_Gender']").prop('disabled',true);
			if($("#Signup_gender").val() != "Default_Gender"){
				if($("#Signup_gender").val() != "Male" && $("#Signup_gender").val() != "Female" && $("#Signup_gender").val() != "Organization"){
					$("#Signup_gender_error_text").html("Gender contains invaild characters");
				}else{
					$("#Signup_gender_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});
		
		// Signup Select Organization Type Validation
		$("#Signup_organization_type").blur(function(){
			if($("#Signup_organization_type").val() == "Default_organization_type"){
				$("#Signup_organization_type_error_text").html("Organization catagory must required");
			}else if($("#Signup_organization_type").val() != "College" && $("#Signup_organization_type").val() != "School"){
				$("#Signup_organization_type_error_text").html("Organization Type contains invaild characters");
			}
		});
		$("#Signup_organization_type").change(function(){
			$("#Signup_organization_type option[value='Default_organization_type']").prop('disabled',true);
			if($("#Signup_organization_type").val() != "Default_organization_type"){
				if($("#Signup_organization_type").val() != "College" && $("#Signup_organization_type").val() != "School"){
					$("#Signup_organization_type_error_text").html("Organization Type contains invaild characters");
				}else{
					$("#Signup_organization_type_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});

		$("#SignupType").change(function(){
			if($("#SignupType").val() == "Main"){
				$(".Signup_organization_type_main_box").css({'display':'none'});
				$(".Signup_organization_name_main_box").css({'display':'none'});
				$(".MainPostionRequestType").css({'display':'block'});
				$(".BioBox").css({'display':'block'});
				$('.Address').attr('placeholder', 'Your Address');
			}else{
				$(".Signup_organization_type_main_box").css({'display':'block'});
				$(".Signup_organization_name_main_box").css({'display':'block'});
				$(".MainPostionRequestType").css({'display':'none'});
				$(".BioBox").css({'display':'none'});
				$('.Address').attr('placeholder', 'Organization Address');
			}
			$("#Signup_response").html("");
		});

		$("#PostionRequest").blur(function(){
			if($("#PostionRequest").val() == ""){
				$("#PostionRequestError").html("Postion request must required");
			}else if($("#PostionRequest").val() != "Admin" && $("#PostionRequest").val() != "Manager" && $("#PostionRequest").val() != "ServiceManager" && $("#PostionRequest").val() != "SalesManager" && $("#PostionRequest").val() != "CustomerCare"){
				$("#PostionRequestError").html("Postion request contains invaild characters");
			}
		});
		$("#PostionRequest").change(function(){
			$("#PostionRequest option[value='']").prop('disabled',true);
			if($("#PostionRequest").val() != ""){
				if($("#PostionRequest").val() != "Admin" && $("#PostionRequest").val() != "Manager" && $("#PostionRequest").val() != "ServiceManager" && $("#PostionRequest").val() != "SalesManager" && $("#PostionRequest").val() != "CustomerCare"){
					$("#PostionRequestError").html("Postion request contains invaild characters");
				}else{
					$("#PostionRequestError").html("");
				}
			}
			$("#Signup_response").html("");
		});
		
		/*// Signup gmail validations
		$("#Signup_gmail").keyup(function(){
			var user_input_gmail_data = $("#Signup_gmail").val();
			if(user_input_gmail_data.length > 15){
				var user_gmail_address_length = user_input_gmail_data.substring(0,user_input_gmail_data.length-10).length;
				var user_gmail_address_length_after_validations = user_input_gmail_data.substring(0,user_input_gmail_data.length-10).replace(/[^A-Za-z0-9.]/g,"").length;
				if(user_gmail_address_length == user_gmail_address_length_after_validations && user_gmail_address_length_after_validations >= 6 && user_gmail_address_length_after_validations <= 30){
					if(user_input_gmail_data.substring(user_input_gmail_data.length-10,user_input_gmail_data.length) == "@gmail.com"){
						$("#Signup_gmail_error_text").html("");
					}
				}
			}
			$("#Signup_response").html("");
		});
		$("#Signup_gmail").blur(function(){
			var user_input_gmail_data = $("#Signup_gmail").val();
			if(user_input_gmail_data.length > 10){
				var user_gmail_address_length = user_input_gmail_data.substring(0,user_input_gmail_data.length-10).length;
				var user_gmail_address_length_after_validations = user_input_gmail_data.substring(0,user_input_gmail_data.length-10).replace(/[^A-Za-z0-9.]/g,"").length;
				if(user_gmail_address_length == user_gmail_address_length_after_validations && user_gmail_address_length_after_validations >= 6 && user_gmail_address_length_after_validations <= 30){
					if(user_input_gmail_data.substring(user_input_gmail_data.length-10,user_input_gmail_data.length) != "@gmail.com"){
						$("#Signup_gmail_error_text").html("Your gmail is invalid");
					}
				}else{
					$("#Signup_gmail_error_text").html("Your gmail is invalid");
				}
			}else{
				$("#Signup_gmail_error_text").html("Your gmail is invalid");
			}
		});*/
		
		// Mobile number validations
		$("#Signup_mobile_number").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g, "");
			var user_input_mobile_number_data = $("#Signup_mobile_number").val();
			var user_input_mobile_number_data_after_validations = user_input_mobile_number_data.replace(/[^0-9]/g,"");
			if(user_input_mobile_number_data.length == user_input_mobile_number_data_after_validations.length){
				if(user_input_mobile_number_data_after_validations.length == 10){
					$("#Signup_mobile_number_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});
		$("#Signup_mobile_number").blur(function(){
			var user_input_mobile_number_data = $("#Signup_mobile_number").val();
			var user_input_mobile_number_data_after_validations = user_input_mobile_number_data.replace(/[^0-9]/g,"");
			if(user_input_mobile_number_data.length != user_input_mobile_number_data_after_validations.length){
				$("#Signup_mobile_number_error_text").html("Invalid Mobile number");
			}else{
				if(user_input_mobile_number_data_after_validations.length != 10){
					$("#Signup_mobile_number_error_text").html("Mobile number must be 10 digits");
				}
			}
		});
		
		// Organization Name validations
		$("#Signup_organization_name").keyup(function (){
			this.value = this.value.replace(/[^A-Za-z]/g,"").charAt(0).toUpperCase()+this.value.replace(/[^A-Za-z0-9- _.]/g,"").slice(1).toLowerCase();
			var user_input_organization_name_number_data = $("#Signup_organization_name").val();
			var user_input_organization_name_data_after_validations = user_input_organization_name_number_data.replace(/[^A-Za-z0-9]/g,"");
			if(user_input_organization_name_number_data.length == user_input_organization_name_data_after_validations.length){
				$("#Signup_organization_name_error_text").html("");
			}else{
				if(user_input_organization_name_data_after_validations.length <= 50 && user_input_organization_name_data_after_validations.length >= 3){
					$("#Signup_organization_name_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});
		$("#Signup_organization_name").blur(function (){
			var user_input_organization_name_number_data = $("#Signup_organization_name").val();
			var user_input_organization_name_data_after_validations = user_input_organization_name_number_data.replace(/[^A-Za-z0-9- _.]/g,"");
			if(user_input_organization_name_number_data.length != user_input_organization_name_data_after_validations.length){
				$("#Signup_organization_name_error_text").html("Organization name have invaild characterSet");
			}else{
				if(user_input_organization_name_data_after_validations.length > 50 || user_input_organization_name_data_after_validations.length < 3){
					$("#Signup_organization_name_error_text").html("Organization name must be between 3 and 50 characters long");
				}
			}
		});

		// Bio validations
		$("#Bio").keyup(function (){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z- _.,]/g,'').slice(1).toLowerCase().replace(/\s\s+/g, ' ');
			if(this.value.length <= 80 && this.value.length >= 30){
					$("#BioError").html("");
				}
			$("#Signup_response").html("");
		});
		$("#Bio").blur(function (){
			if(this.value.length > 80 || this.value.length < 30){
				$("#BioError").html("Bio must be between 30 and 80 characters long");
			}
		});
		
		// Signup address validations
		$("#Address").keyup(function (){
			this.value = this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z- _,.]/g,'').slice(1).toLowerCase().replace(/\s\s+/g, ' ');
			if(this.value.length <= 80 && this.value.length >= 10){
				$("#AddressError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#Address").blur(function (){
			if(this.value.length > 80 || this.value.length < 10){
				$("#AddressError").html("Address must be between 10 to 80 characters long");
			}
		});

		// Signup City validations
		$("#City").keyup(function (){
			this.value = this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase().replace(/\s\s+/g, ' ');
			if(this.value.length <= 50 && this.value.length >= 3){
				$("#CityError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#City").blur(function (){
			if(this.value.length > 50 || this.value.length < 3){
				$("#CityError").html("City name must be between 3 to 50 characters long");
			}
		});

		// Signup Pincode validations
		$("#Pincode").keyup(function (){
			this.value = this.value.replace(/[^0-9]/g,"");
			if(this.value.length <= 80 && this.value.length >= 10){
				$("#PincodeError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#Address").blur(function (){
			if(this.value.length > 80 || this.value.length < 10){
				$("#PincodeError").html("Pincode must be 6 characters long");
			}
		});

		// Signup State validations
		$("#State").keyup(function (){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase().replace(/\s\s+/g, ' ');
			if(this.value.length <= 30 && this.value.length >= 3){
				$("#StateError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#State").blur(function (){
			if(this.value.length > 30 || this.value.length < 3){
				$("#StateError").html("State name must be between 3 to 30 characters long");
			}
		});

		// Signup Country validations
		$("#Country").keyup(function (){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0).toUpperCase() + this.value.replace(/[^A-Za-z ]/g,'').slice(1).toLowerCase().replace(/\s\s+/g, ' ');
			if(this.value.length <= 30 && this.value.length >= 3){
				$("#CountryError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#Country").blur(function (){
			if(this.value.length > 30 || this.value.length < 3){
				$("#CountryError").html("Country name must be between 3 to 30 characters long");
			}
		});

		// Signup Pincode validations
		$("#Pincode").keyup(function (){
			this.value = this.value.replace(/[^0-9]/g,"");
			if(this.value.length <= 80 && this.value.length >= 10){
				$("#PincodeError").html("");
			}
			$("#Signup_response").html("");
		});
		$("#Address").blur(function (){
			if(this.value.length > 80 || this.value.length < 10){
				$("#PincodeError").html("Pincode must be 6characters long");
			}
		});
		
		// Signup password validations
		$("#Signup_password").keyup(function (){
			var user_input_signup_password_data = $("#Signup_password").val();
			if(user_input_signup_password_data.length <= 32 && user_input_signup_password_data.length >= 8){
				$("#Signup_password_error_text").html("");
				if(user_input_signup_password_data == $("#Signup_confirm_password").val()){
					$("#Signup_confirm_password_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});
		$("#Signup_password").blur(function (){
			var user_input_signup_password_data = $("#Signup_password").val();
			if(user_input_signup_password_data.length > 32 || user_input_signup_password_data.length < 8){
				$("#Signup_password_error_text").html("Password must be between 8 and 32 characters long");
			}else{
				if(user_input_signup_password_data != $("#Signup_confirm_password").val()){
					$("#Signup_confirm_password_error_text").html("Password or Confirm password not mached");
				}
			}
		});
		
		// Signup password validations
		$("#Signup_confirm_password").keyup(function (){
			var user_input_signup_confirm_password_data = $("#Signup_confirm_password").val();
			if(user_input_signup_confirm_password_data == $("#Signup_password").val()){
				if(user_input_signup_confirm_password_data.length <= 32 && user_input_signup_confirm_password_data.length >= 8){
					$("#Signup_confirm_password_error_text").html("");
				}
			}
			$("#Signup_response").html("");
		});
		$("#Signup_confirm_password").blur(function (){
			var user_input_signup_confirm_password_data = $("#Signup_confirm_password").val();
			if(user_input_signup_confirm_password_data == $("#Signup_password").val()){
			if(user_input_signup_confirm_password_data.length > 32 || user_input_signup_confirm_password_data.length < 8){
				$("#Signup_confirm_password_error_text").html("Confirm password must be between 8 and 32 characters long");
			}
			}else{
				$("#Signup_confirm_password_error_text").html("Password or Confirm password not mached");
			}
		});

		// Signup password validations
		$("#SecurityCode").keyup(function (){
			this.value = this.value.replace(/[^0-9]/g,"");
			if($("#SecurityCode").val().length >= 4 &&  $("#SecurityCode").val().length <= 6){
				$("#SecurityCodeError").html("");
			}
		});

		$("#SecurityCode").blur(function (){
			if($("#SecurityCode").val().length < 4 ||  $("#SecurityCode").val().length > 6){
				$("#SecurityCodeError").html("Security Code must be between 4 to 6 character long");
			}
		});
		
		// Signup image change
		$("#Signup_image_file_input").change(function(e){
			if(this.files.length == 1){
				var file = this.files[0];
				var fileType = file["type"];
				var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
				if ($.inArray(fileType, validImageTypes) < 0) {
					swal("Invalid file type", "", "error")
					.then((value) => {
						$("#Signup_image_file_input").click();
					});
					return false;
				}else{
					if((this.files[0].size/1024).toFixed(2) < 2048){
						if (this.files && this.files[0]) {
							var reader = new FileReader();
							reader.onload = function (e) {
								$('#signup_image').attr('src', e.target.result);
							}
							reader.readAsDataURL(this.files[0]);
						}
					}else{
						swal("Image size must be under 2 mb", "", "warning")
						.then((value) => {
							$('#signup_image').attr('src', "../../../../Image_store/cute_dog.jpg");
							$("#Signup_image_file_input").click();
						});
					}
				}
			}else{
				if(this.files.length > 1){
					swal("Select only one Profile image", "", "warning")
					.then((value) => {
						$('#signup_image').attr('src', "../../../../Image_store/cute_dog.jpg");
						$("#Signup_image_file_input").click();
					});
				}else{
					swal("Profile image must required", "", "warning")
					.then((value) => {
						$('#signup_image').attr('src', "../../../../Image_store/cute_dog.jpg");
						$("#Signup_image_file_input").click();
					});
				}
				return false;
			}
			$("#Signup_response").html("");
			
		});
		
		// Signup button click
		window.signup_button_on_process = false;
		
		$("#Signup_button").click(function(){
			// Signup Type revalidation
			var SignupType = $("#SignupType").val();

			// Signup username revalidation
			var Signup_username = $("#Signup_username").val();
			if(Signup_username.length == 0){
				$("#Signup_username_error_text").html("Username must be between 5 to 18 characters long");
				return false;
			}
			
			// Signup fullname revalidation
			Signup_fullname = $("#Signup_fullname").val();
			if(Signup_username.length == 0){
				$("#Signup_fullname_error_text").html("Fullname must be between 5 to 18 characters long");
				return false;
			}
			
			// Signup Gender revalidation
			Signup_gender = $("#Signup_gender").val();
			if(Signup_gender == "Default_Gender"){
				$("#Signup_gender_error_text").html("Gender is required");
				return false;
			}
			
			// Signup Organization Type revalidation
			Signup_organization_type = $("#Signup_organization_type").val();
			if(SignupType == 'Organization'){
				if(Signup_organization_type == "Default_organization_type"){
					$("#Signup_organization_type_error_text").html("Organization Type is required");
					return false;
				}
			}else{
				// Signup PostionRequest revalidation
				PostionRequest = $("#PostionRequest").val();
				if(PostionRequest == ""){
					$("#PostionRequestError").html("Postion request is required");
					return false;
				}
			}
			
			// Signup Gmail revalidation
			Signup_gmail = $("#Signup_gmail").val();
			if(Signup_gmail.length  == 0){
				$("#Signup_gmail_error_text").html("Gmail is required");
				return false;
			}

			// Signup Gmail revalidation
			EmailOTP = $("#EmailOTP").val();
			if(EmailOTP.length  == 0){
				swal('',"Email OTP is required",'warning'); return false;
			}
			
			// Signup mobile number revalidations
			Signup_mobile_number = $("#Signup_mobile_number").val();
			if(Signup_mobile_number.length == 0){
				$("#Signup_mobile_number_error_text").html("Mobile number is required");
				return false;
			}

			// Signup Gmail revalidation
			MobOTP = $("#MobOTP").val();
			if(MobOTP.length  == 0){
				swal('',"Mobile OTP is required",'warning'); return false;
			}

			// Signup organization name revalidation
			Signup_organization_name = $("#Signup_organization_name").val();
			if(SignupType == 'Organization'){
				if(Signup_organization_name.length == 0){
					$("#Signup_organization_name_error_text").html("Organization name is required");
					return false;
				}
			}else{
				// Signup Bio revalidation
				Bio = $("#Bio").val();
				if(Bio.length == 0){
					$("#BioError").html("Bio is required");
					return false;
				}
			}
			
			// Signup address revalidation
			Address = $("#Address").val();
			if(Address.length == 0){
				$("#AddressError").html("Address is required");
				return false;
			}

			// Signup City revalidation
			City = $("#City").val();
			if(City.length == 0){
				$("#CityError").html("City name is required");
				return false;
			}

			// Signup Pincode revalidation
			Pincode = $("#Pincode").val();
			if(Pincode.length == 0){
				$("#PincodeError").html("Pincode number is required");
				return false;
			}

			// Signup State revalidation
			State = $("#State").val();
			if(State.length == 0){
				$("#StateError").html("State name is required");
				return false;
			}

			// Signup Country revalidation
			Country = $("#Country").val();
			if(Country.length == 0){
				$("#CountryError").html("Country name is required");
				return false;
			}
			
			// Signup password revalidation
			Signup_password = $("#Signup_password").val();
			if(Signup_password.length == 0){
				$("#Signup_password_error_text").html("Password is required");
				return false;
			}
			
			// Signup  Confirm Password revalidation
			Signup_confirm_password = $("#Signup_confirm_password").val();
			if(Signup_confirm_password.length == 0){
				$("#Signup_confirm_password_error_text").html("Confirm password is required");
				return false;
			}	

			// Signup  Confirm Password revalidation
			SecurityCode = $("#SecurityCode").val();
			if(SecurityCode.length < 4 || SecurityCode.length > 6){
				$("#SecurityCodeError").html("Security Code must be between 4 to 6 characters long");
				return false;
			}	
			
			// Signup image revalidation
			if(document.getElementById("Signup_image_file_input").files.length == 1){
				Signup_image_file = $("#Signup_image_file_input")[0].files[0];
				if((Signup_image_file.size/1024).toFixed(2) > 2048){ // Signup image Size in mb
					swal("Image size must be under 5 mb")
					.then((value) => {
						$("#Signup_image_file_input").click();
					});
					return false;
				}
			}else{
				if(document.getElementById("Signup_image_file_input").files.length > 1){
					swal("Select only one Profile image")
					.then((value) => {
						$("#Signup_image_file_input").click();
					});
				}else{
					swal("Profile image must required")
					.then((value) => {
						$("#Signup_image_file_input").click();
					});
				}
				return false;
			}
			
			if(window.signup_button_on_process == false){
				SubmitStart();
				var client = new ClientJS();

				imprint.test(browserTests).then(function(result){
					var fingerprint_1 = new Fingerprint().get();
					var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
					audioFingerprint.run(function (fingerprint_2) {
						var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
						

						var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

						// append data which we want to send data on targeted page
						var formdata = new FormData();
						formdata.append("SignupType", SignupType);
						formdata.append("Username", Signup_username);
						formdata.append("Fullname", Signup_fullname);
						formdata.append("Gender", Signup_gender);
						formdata.append("OrganizationType", Signup_organization_type);
						formdata.append("PostionRequest", PostionRequest);
						formdata.append("Email", Signup_gmail);
						formdata.append("EmailOTP", EmailOTP);
						formdata.append("MobileNumber", Signup_mobile_number);
						formdata.append("MobOTP", MobOTP);
						formdata.append("OrganizationName", Signup_organization_name);
						formdata.append("Bio", Bio);
						formdata.append("Address", Address);
						formdata.append("City", City);
						formdata.append("State", State);
						formdata.append("Pincode", Pincode);
						formdata.append("Country", Country);
						formdata.append("Password", Signup_password);
						formdata.append("ConfirmPassword", Signup_confirm_password);
						formdata.append("SecurityCode", SecurityCode);
						formdata.append("ProfileImage", Signup_image_file);
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						// Check Internet connection
						if(navigator.onLine == false){
							swal("It seems that you are offline. Please check your internet connection", "", "warning");
							$("#Signup_response").css("color","red");
							$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
							SubmitReset();
							return false;
						}
						// Send data on sigup backend page for uploading on the server
						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",SignupHandler,false);
							ajax.open("POST", "SignupBackend.php");
							ajax.send(formdata);
						}catch(error){
							$("#Signup_response").css("color","red");
							$("#Signup_response").html(error);
							SubmitReset();
							return false;
						}

						//function run on complete signup request
						function SignupHandler(event){
							var response = $.parseJSON(event.target.responseText);
							if(response['status'] === "Success"){
								swal(response['msg'], {
									icon: "success",
									buttons: {
										cancel: "Not Now",
										Login: true,
									},
								})
								.then((value) => {
									if(value === "Login"){
										DoLogin();
										return false;
									}else{
										window.location.replace("<?php echo RootPath; ?>LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php");
										return false;
									}
								});
							}else{
								$("#Signup_response").css("color","red");
								$("#Signup_response").html(response['msg']);
								swal(response['msg'], "", "error");
								SubmitReset();
								return false;
							}
						}

						function DoLogin(){
							// append data which we want to send data on targeted page
							var formdata = new FormData();
							formdata.append("Organization", "<?php echo $_GET['Organization']; ?>");
							formdata.append("LoginType", SignupType);
							formdata.append("LoginFor", Signup_username);
							formdata.append("LoginData", Signup_username);
							formdata.append("LoginPass", Signup_password);
							formdata.append("LoginPeriodTime", 0);
							formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
							formdata.append("BrowserClientId1", BrowserClientId1);
							formdata.append("BrowserClientId2", BrowserClientId2);
							formdata.append("ClientOS", fingerprint_os());
							formdata.append("ClientTouch", fingerprint_touch());
							formdata.append("ClientBrowser", client.getBrowser());
							formdata.append("ClientBrowserVersion", client.getBrowserVersion());
							formdata.append("ClientCPU", client.getCPU());
							formdata.append("ClientTimeZoneName", client.getTimeZone());
							formdata.append("ClientUserAgent", navigator.userAgent);
							formdata.append("ClientLanguage", client.getLanguage());

							// Check Internet connection
							if(navigator.onLine == false){
								swal("It seems that you are offline. Please check your internet connection", "", "warning");
								$("#Signup_response").css("color","red");
								$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
								SubmitReset();
								return false;
							}
							
							// Send data on sigup backend page for uploading on the server
							try{
								var ajax = new XMLHttpRequest();
								ajax.addEventListener("load",LoginHandler,false);
								ajax.open("POST", "../Login/LoginBackend.php");
								ajax.send(formdata);
							}catch(error){
								$("#Signup_response").css("color","red");
								$("#Signup_response").html(error);
								return false;
							}

							//function run on complete login ajax request
							function LoginHandler(event){
								try{
									var response = $.parseJSON(event.target.responseText);
									if(response['status'] === "Success" && response['code'] === 200){
										swal(response['msg']['msg'], "", "success")
										.then(() => {
											window.location.replace("<?php echo RootPath; ?>LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php");
										});
									}else{
										$("#Signup_response").css("color","red");
										$("#Signup_response").html(response['msg']);
										swal(response['msg'], "", "error");
										SubmitReset();
										return false;
									}
								}catch(error){
									$("#Signup_response").css("color","red");
									$("#Signup_response").html(response['msg']);
									SubmitReset();
									return false;
								}
							}
						}
					});
				});
			}

			function SubmitStart(){
				window.signup_button_on_process = true;
				$("input").prop("disabled",true);
				$("select").prop("disabled",true);
				$('.Signup_button').css("pointer-events","none");
				$(".Goto_login_page").css("pointer-events","none");
				$(".Signup_button").css("background","linear-gradient(skyblue, pink)");
				$(".Signup_button").css("color","white");
				$(".Signup_button").css("cursor","default");
				$(".signup_loader_round_main").prop('hidden',false);
			}

			function SubmitReset(){
				$("input").prop("disabled",false);
				$("select").prop("disabled",false);
				$('.Signup_button').css("pointer-events","auto");
				$(".Goto_login_page").css("pointer-events","auto");
				$(".Signup_button").css("background","white");
				$(".Signup_button").css("color","black");
				$(".Signup_button").css("cursor","pointer");
				$(".signup_loader_round_main").prop('hidden',true);
				window.signup_button_on_process = false;
			}
		});

		window.SubmitSendOTPBtn = false;
		$(".SendOTPBtn").click(function(){
			
			if(window.SubmitSendOTPBtn != false){
				swal('','Button already clicked','error');return false;
			}
			StartSubmitSendOTPBtn();

			if(navigator.onLine == false){
				swal('','Please check your internet connection','warning'); SubmitResetSendOTPBtn(); return false;
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
					formdata.append("MobileNo", $('#Signup_mobile_number').val());
					formdata.append("Email", $('#Signup_gmail').val());
					formdata.append("Token_CSRF", '<?php echo $Token_CSRF; ?>');
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);

					// Send data on AddNewMemberBackend page
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",SendOTPResponse,false);
						ajax.open("POST", "SignupSendOTPBackend.php");
						ajax.send(formdata);
					}catch(error){
						swal('','There is an error occur','warning'); SubmitResetSendOTPBtn(); return false;
					}

					//function run on complete login ajax request
					function SendOTPResponse(event){
						SubmitResetSendOTPBtn();
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
						   swal('',response['msg'],'success')
						   .then(() => {
							$('#SendOTPBtn').prop('hidden',true);
							$('#MobOTPBox').prop('hidden',false);
							$('#EmailOTPBox').prop('hidden',false);
							$('#Signup_response_main_box').prop('hidden',false);
							$('#Signup_button').prop('hidden',false);
						   });
						}else{
							swal('',response['msg'],'error');
						}
						return false;
					}
				});
			});

			function StartSubmitSendOTPBtn(){
				window.SubmitSendOTPBtn = true;
				$('.SendOTPLoader').prop('hidden',false);
			}

			function SubmitResetSendOTPBtn(){
				window.SubmitSendOTPBtn = false;
				$('.SendOTPLoader').prop('hidden',true);
			}
		});

		$(".Goto_login_page").click( function(){
			window.location.href='../Login/index.php';
		});
	});
</script>
<!-- Remove all vars of php -->
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ?>