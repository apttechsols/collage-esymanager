<?php
	/*
	*@FileName Login/index.php
	*@Des Provide login layout or interface
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
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}

	if(!isset($_GET['Organization'])){
		header("Location: " . RootPath . 'Users/Login/index.php?Organization='); die();
	}else if($_GET['Organization'] == '' && isset($_COOKIE['LORG'])){
		header("Location: " . RootPath . 'Users/Login/index.php?Organization='.base64_decode($_COOKIE['LORG'])); die();
	}

	$Task = 'Login';
	define("PageTitle", "Login");
	define("CssFile", "Login");
	require_once RootPath."Site_Header/index.php";
?>
	<body class="No_Select_Strat">
		<div class="main_Login_container">
			<div class="sub_main_Login_container">
				<div class="Login_image_round_border">
					<img class="Login_image" id="Login_image" src="<?php echo RootPath; ?>Image_store/NoImageFound400_264px.png">
				</div>
				<h1 class="Login_text_under_Login_image">Login</h1>
				<div class="LoginTypeBox">
					<select class='LoginType' id='LoginType'>
						<option value='Organization'>Organization</option>
						<option value='Main'>Main</option>
					</select>
				</div>
				<div class="LoginForBox">
					<input type="text" class="LoginFor" value="<?php if(isset($_GET['Organization']) && $_GET['Organization'] !== ''){ echo $_GET['Organization']; }else{ echo base64_decode($_COOKIE['OrganizationName']); } ?>"  id="LoginFor" placeholder="Organization Name" maxlength="18" autocomplete="off" spellcheck="false" />
					<p class='LoginForError Error' style="display: none;"></p>
				</div>
				<div class="Login_username_main_box">
					<input type="text" class="Login_username" value="<?php echo base64_decode($_COOKIE['UNM']); ?>"  id="Login_username" placeholder="Username" maxlength="18" autocomplete="off" spellcheck="false" />
				</div>
				<div class="Login_password_main_box">
					<input type="password" class="Login_password" id="Login_password" placeholder="Password" autocomplete="off" spellcheck="false"/>
				</div>
				<div class="Login_response_main_box">
					<span class="Login_response" id="Login_response" style="display: none;"><span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span>
				</div>
				<div class="Login_button" id="Login_button" >Login<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></div>
				<div class='Form2'>
					<p class='FPass'>Forget Password?</p>
					<p class='CAccount'>Create Account?</p>
				</div>
				<section class="Login_bottom_all_links">
					<div class="Login_TAndC">Terms & conditaions</div>
					<div class="Login_privacy">Privacy</div>
					<div class="Login_help">Need help</div>
					<div class="Login_how_it_works">How it works?</div>
				</section> 
			</div>
		</div>
	</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){
        
		$("#LoginFor").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z0-9_]/g,'').toLowerCase();
			$("#Login_response").css("display",'none');
	    });
	    
	    $("#Login_username").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z0-9_]/g,'').toLowerCase();
			$("#Login_response").css("display",'none');
	    });

		$("#Login_password").keyup(function(){
			$("#Login_response").css("display",'none');
	    });

		$("#LoginType").change(function(){
			if($("#LoginType").val() === 'Main'){
				$(".LoginForBox").css({'display':'none'});
			}else{
				$(".LoginForBox").css({'display':'block'});
			}
			$("#Login_response").css("display",'none');
		});
		
		var LoginForCheckBtn = false;
		$("#LoginFor").blur(function(){
			if(LoginForCheckBtn === false){
				LoginType = $('#LoginType').val();
				LoginFor = $('#LoginFor').val();

				// append data which we want to send data on targeted page
				var formdata = new FormData();
				formdata.append("LoginType", LoginType);
				formdata.append("LoginFor", LoginFor);
				formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");

				// Check Internet connection
				if(navigator.onLine == false){
					swal("It seems that you are offline. Please check your internet connection", "", "warning");
					$("#Signup_response").css("color","red");
					$("#Signup_response").html("It seems that you are offline. Please check your internet connection");
					return false;
				}
				LoginForCheckBtn = true;

				// Send data on sigup backend page for uploading on the server
				try{
					var ajax = new XMLHttpRequest();
					ajax.addEventListener("load",ResponseHandler,false);
					ajax.open("POST", "<?php echo RootPath; ?>LibraryStore/PhpLibrary/GetUserData/index.php");
					ajax.send(formdata);
				}catch(error){
					LoginForCheckBtn = false;
					return false;
				}

				//function run on complete login ajax request
				function ResponseHandler(event){
					try{
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success" && response['code'] === 200){
							$('.LoginForError').css('display','none');
							$('.LoginForError').html('');
							$("#Login_image").attr('src',"<?php echo RootPath; ?>Users/UserDataStore/ProfileImage/Organization/"+response['msg']['UserUrl']+'/'+response['msg']['ProfileUrl']);
							LoginForCheckBtn = false;
							return false;
						}else{
							$("#Login_image").attr('src',"../../Image_store/NoImageFound400_264px.png");
							$('.LoginForError').html(response['msg']);
							$('.LoginForError').css('display','block');
							LoginForCheckBtn = false;
							return false;
						}
					}catch(error){
						LoginForCheckBtn = false;
						return false;
					}
				}   
			}

	    });
		// Signup button click
		window.login_button_on_process = false;
		
		$("#Login_button").click(function(){
			$("#Login_response").css("display",'none');
			// Signup username revalidation
			var LoginData = $("#Login_username").val();
			if(Login_username.length < 5 || Login_username.length > 18){
				$("#Login_response").css("display",'block');
				$("#Login_response").html("Invalid username or password!");
				return false;
			}
			
			// Signup password revalidation
			var LoginPass = $("#Login_password").val();
			if(Login_password.length > 32 || Login_password.length < 8){
				$("#Login_response").css("display",'block');
				$("#Login_response").html("Invalid username or password!");
				return false;
			}

			LoginType = $('#LoginType').val();
			LoginFor = $('#LoginFor').val();
			
			if(window.login_button_on_process == false){
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
						formdata.append("Organization", "<?php echo $_GET['Organization']; ?>");
						formdata.append("LoginType", LoginType);
						formdata.append("LoginFor", LoginFor);
						formdata.append("LoginData", LoginData);
						formdata.append("LoginPass", LoginPass);
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
							$("#Login_response").html("It seems that you are offline. Please check your internet connection");
							$("#Login_response").css("display",'block');
							SubmitReset();
							return false;
						}
						
						// Send data on sigup backend page for uploading on the server
						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",LoginHandler,false);
							ajax.open("POST", "LoginBackend.php");
							ajax.send(formdata);
						}catch(error){
							$("#Login_response").css("display","block");
							$("#Login_response").html(error);
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
									$("#Login_response").css("display","block");
									$("#Login_response").html(response['msg']);
									swal(response['msg'], "", "error");
									SubmitReset();
									return false;
								}
							}catch(error){
								swal('', error, "error"); SubmitReset(); return false;
							}
						}
					});
			    });
			}

			function SubmitStart(){
				window.login_button_on_process = true;
				$("input").prop("disabled",true);
				$('.Login_button').css("pointer-events","none");
				$(".Login_button").css("background","linear-gradient(skyblue, pink)");
				$(".Login_button").css("color","white");
				$(".Login_button").css("cursor","default");
				$(".loader_round_main").prop('hidden',false);
			}

			function SubmitReset(){
				$("input").prop("disabled",false);
				$('.Login_button').css("pointer-events","auto");
				$(".Login_button").css("background","white");
				$(".Login_button").css("color","black");
				$(".Login_button").css("cursor","pointer");
				$(".loader_round_main").prop('hidden',true);
				window.login_button_on_process = false;
			}

		});
		if($("#LoginFor").val().length > 0){
			$("#LoginFor").blur();
		}

		$('.FPass').click(function(){
			window.location.href = RootPath+'LibraryStore/SiteComponents/ResetPassword/index.php';
		});

		$('.CAccount').click(function(){
			window.location.href = RootPath+'Users/Signup/index.php';
		});

	});
</script>
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>