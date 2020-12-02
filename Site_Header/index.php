<?php 
	error_reporting(0);
	$RandMsg = ['Hello!','Hi!','Welcome!','Namaskar!','Howdy!','Good day!',"What's up!",'Hey!'];
	$RandMsg = $RandMsg[rand(0,7)];
	require (RootPath."LibraryStore/SiteComponents/CommonPage/index.php");
	define('PageName','SiteHeader');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo PageTitle; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo CssFile; ?>.css">
	<style>
		body{
			background: #224579!important;
			margin: 0px! important;
			padding: 0px! important;
			-webkit-touch-callout: none; /* iOS Safari */
		    -webkit-user-select: none; /* Safari */
		     -khtml-user-select: none; /* Konqueror HTML */
		       -moz-user-select: none; /* Firefox */
		        -ms-user-select: none; /* Internet Explorer/Edge */
		            user-select: none; /* Non-prefixed version, currently
		                                  supported by Chrome and Opera */
		}
		.Header_Container{
			width:100%;
			height:50px;
			top:0;
		}
		.Header_head{
			border-bottom:1px solid #ccc;
			width:100%;
			height:50px;
			display:grid;
			grid-template-columns: 120px 1fr;
			float:left;
			position:fixed;
			background:white;
			z-index: 100;
			overflow: hidden;
		}
		.Header_Item{
			font-size: 24px;
		}
		.Header_Site_Name{
			margin-left:2%;
			margin-top:12px;
			font-weight:bold;
			color:#471f87;
			cursor: pointer;
		}
		.HeaderLogo{
		    width: 100%;
		    margin-top: -10px;
		    height: 40px;
		}
		.Header_Menu_Icon{
			margin-left: calc(100% - 45px);
		    height: 40px;
		    margin-top: 5px;
		    cursor: pointer;
		}
		.Select_Menu{
			width:100%;
			height:100%;
		}
		.Header_Menu_Item_Box{
		    border-left: 1px solid darkgrey;
		    width: 100%;
		    max-width: 380px;
		    position: fixed;
		    right: 0;
		    max-height: calc(100% - 50px);
		    background: white;
		    z-index: 100;
		    overflow-y: auto;
		}
		.Header_Menu_Items{
			height: 30px;
		    font-size: 18px;
		    margin-top: 5px;
		    padding-left: 15px;
		    border-bottom: 1px solid darkgray;
		    display: grid;
		    grid-template-columns: 30px 1fr;
		    color: #471f87;
		}
		.Header_Menu_Items:hover{
			cursor:pointer;
		}
		.Header_Item_Image{
			height:22px;
		}
		.Header_Item_Text{
		    font-size: 18px;
		    font-weight: bold;
		    margin-top: 4px;0
		}
		/*
        important changes  
         */
        .LogOutSpinnerAnimationBox {
        	height: 32px;
        	width: 32px;
        	position: absolute;
            margin: -5px -10px 0px 15px;
        }
        .LogOutSpinnerAnimationBox::after {
        	content: "";
        	display: block;
        	position: absolute;
        	top: 0; left: 0;
        	bottom: 0; right: 0;
        	margin: auto;
        	width: 12px;
        	height: 12px;
        	top: 0; left: 0;
        	bottom: 0; right: 0;
        	margin: auto;
        	background: #FFF;
        	border-radius: 50%;
        	-webkit-animation: LogOutSpinnerAnimationBox-1 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        	animation: LogOutSpinnerAnimationBox-1 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        }
        @-webkit-keyframes LogOutSpinnerAnimationBox-1 {
        	0%   { -webkit-transform: scale(0); opacity: 0; }
        	50%  { -webkit-transform: scale(1); opacity: 1; }
        	100% { -webkit-transform: scale(0); opacity: 0; }
        }
        @keyframes LogOutSpinnerAnimationBox-1 {
        	0%   { transform: scale(0); opacity: 0; }
        	50%  { transform: scale(1); opacity: 1; }
        	100% { transform: scale(0); opacity: 0; }
        }
        .LogOutSpinnerAnimationBox span {
        	display: block;
        	position: absolute;
        	top: 0; left: 0;
        	bottom: 0; right: 0;
        	margin: auto;
        	height: 32px;
        	width: 32px;
        	-webkit-animation: LogOutSpinnerAnimationBox-2 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        	        animation: LogOutSpinnerAnimationBox-2 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        }
        @-webkit-keyframes LogOutSpinnerAnimationBox-2 {
        	0%   { -webkit-transform: rotate(0deg); }
        	50%  { -webkit-transform: rotate(180deg); }
        	100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes LogOutSpinnerAnimationBox-2 {
        	0%   { transform: rotate(0deg); }
        	50%  { transform: rotate(180deg); }
        	100% { transform: rotate(360deg); }
        }
        .LogOutSpinnerAnimationBox span::before,
        .LogOutSpinnerAnimationBox span::after {
        	content: "";
        	display: block;
        	position: absolute;
        	top: 0; left: 0;
        	bottom: 0; right: 0;
        	margin: auto;
        	height: 12px;
        	width: 12px;
        	background: blue;
        	border-radius: 50%;
        	-webkit-animation: LogOutSpinnerAnimationBox-3 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        	        animation: LogOutSpinnerAnimationBox-3 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        }
        @-webkit-keyframes LogOutSpinnerAnimationBox-3 {
        	0%   { -webkit-transform: translate3d(0, 0, 0) scale(1); }
        	50%  { -webkit-transform: translate3d(-16px, 0, 0) scale(.5); }
        	100% { -webkit-transform: translate3d(0, 0, 0) scale(1); }
        }
        @keyframes LogOutSpinnerAnimationBox-3 {
        	0%   { transform: translate3d(0, 0, 0) scale(1); }
        	50%  { transform: translate3d(-16px, 0, 0) scale(.5); }
        	100% { transform: translate3d(0, 0, 0) scale(1); }
        }
        .LogOutSpinnerAnimationBox span::after {
        	-webkit-animation: LogOutSpinnerAnimationBox-4 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        	        animation: LogOutSpinnerAnimationBox-4 2s cubic-bezier(0.770, 0.000, 0.175, 1.000) infinite;
        }
        @-webkit-keyframes LogOutSpinnerAnimationBox-4 {
        	0%   { -webkit-transform: translate3d(0, 0, 0) scale(1); }
        	50%  { -webkit-transform: translate3d(16px, 0, 0) scale(.5); }
        	100% { -webkit-transform: translate3d(0, 0, 0) scale(1); }
        }
        @keyframes LogOutSpinnerAnimationBox-4 {
        	0%   { transform: translate3d(0, 0, 0) scale(1); }
        	50%  { transform: translate3d(16px, 0, 0) scale(.5); }
        	100% { transform: translate3d(0, 0, 0) scale(1); }
        }
        .loader_button_center {
        	position: absolute;
            margin: -3px 0px 0px 10px;
        }
		@media(max-width: 450px){
			.Header_head{
				grid-template-columns:60% 40%;
			}
		}
	</style>
	<!-- Javascript js file-->
	<script src="<?php echo RootPath; ?>MainJavascript/JqueryGoogleDNS/3.4.1/jquery.min.js"></script>
	<!-- User Browser Detection js file-->
	<script src="<?php echo RootPath; ?>MainJavascript/Live_Javascript/UserBrowser_detection.js"></script>
	<!-- Include sweetalert js file-->
	<script src="<?php echo RootPath; ?>MainJavascript/Live_Javascript/sweetalert.min.js"></script>
</head>
<header>
	<div class="Header_Container">
		<div class ="Header_head">
			<div class ="Header_Item">
				<p class="Header_Site_Name"><img class='HeaderLogo' src="<?php echo RootPath; ?>Image_store/EsyManagerLogo3.jpg"/></p> 
			</div>
			<div class ="Header_Item">
				<img class="Header_Menu_Icon" id = "Header_Menu_Icon" src="<?php echo RootPath; ?>Image_store/MenuBlueIcon_64px.png">		
			</div>
		</div>
	</div>
	
	<nav class="Header_Menu_Item_Box" id="Header_Menu_Item_Box" style="display:none">
	    <?php if($ResponseLogin['status'] === 'Success' && $ResponseLogin['code'] === 200){ 
	    	if($ResponseLogin['LAS'] == 'MainMember'){
	    		$PreProfilePath = 'Users/UserDataStore/ProfileImage/Main/';
	    	}else{
	    		$PreProfilePath = 'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/';
	    	}
	    	?>
    		<div class="Header_Menu_Items" style='height:auto; min-height:30px;'>
    			<img class="Header_Item_Image" style='border-radius: 50%;' src="<?php echo RootPath.$PreProfilePath.$ResponseLogin['msg']['ProfileUrl']; ?>"/>
    			<p class="Header_Item_Text"><?php echo $RandMsg.' '.$ResponseLogin['msg']['Fullname'].' ('.$ResponseLogin['msg']['Position'].')' ?></p>
    		</div>
		<?php } ?>
		<div class="Header_Menu_Items HMHome">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/HomeBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Home</p>
		</div>
		<?php if($ResponseLogin['status'] === 'Success' && $ResponseLogin['code'] === 200 &&  $ResponseRank != 0){ ?>
		<div class="Header_Menu_Items HMSearch">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/SearchBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Search</p>
		</div>
		<?php } ?>
		<?php if($ResponseLogin['status'] === 'Success' && $ResponseLogin['code'] === 200){ ?>
			<div class="Header_Menu_Items HMDashboard">
				<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/DashboardBlueIcon_48px.png"/>
				<p class="Header_Item_Text">Dashboard</p>
			</div>
		<?php } ?>
		<div class="Header_Menu_Items">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/SettingBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Setting</p>
		</div>
		<!-- <div class="Header_Menu_Items">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/FAQBlueIcon_48px.png"/>
			<p class="Header_Item_Text">FAQ</p>
		</div>
		<div class="Header_Menu_Items">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/Why_UsBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Why Us</p>
		</div> -->
		<div class="Header_Menu_Items HMTermsAndCondtion">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/DisclaimerBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Terms And Condtions</p>
		</div>
		<div class="Header_Menu_Items HMPrivacyPolicy">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/Privacy_PolicyBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Privacy Policy</p>
		</div>
		<div class="Header_Menu_Items HMContactUs">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/ContactBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Contact Us</p>
		</div>
		<?php if(($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200) && $Task != 'Login'){ ?>
		<div class="Header_Menu_Items HMLogin">
			<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/Log_InBlueIcon_48px.png"/>
			<p class="Header_Item_Text">Log In</p>
		</div>

		<?php } if(($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200) && $Task != 'Signup'){ ?>
			<div class="Header_Menu_Items HMSignup">
				<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/Sign_UpBlueIcon_48px.png"/>
				<p class="Header_Item_Text">Sign Up</p>
			</div>
		<?php } ?>
		
		<?php if($ResponseLogin['status'] === 'Success' && $ResponseLogin['code'] === 200){ ?>
			<div class="Header_Menu_Items LogOut">
				<img class="Header_Item_Image" src="<?php echo RootPath; ?>Image_store/LogOutIconCustom0066ffColor48px.png"/>
				<p class="Header_Item_Text">Logout<span class="LogOutSpinnerAnimationBox" hidden="true"><span class="LogOutSpinnerAnimationBox loader_button_center"><span></span></span></span></p>
			</div>
		<?php } ?>
	</nav>
<?php if(isset($_COOKIE['LUID'])){ ?>
    <script>
    	(function(){
    	    var client = new ClientJS();
            
    	    imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
					
					var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

					// append data which we want to send data on targeted page
					var formdata = new FormData();
					formdata.append("Token_CSRF", '<?php echo $Token_CSRF; ?>');
					formdata.append("BrowserClientId1", BrowserClientId1);
					formdata.append("BrowserClientId2", BrowserClientId2);
					
					try{
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load",AuthBrowserLoginResponseHandler,false);
						ajax.open("POST", RootPath+"LibraryStore/SiteComponents/CommonPage/AuthBrowserLogin.php");
						ajax.send(formdata);
					}catch(error){
						location.reload();
					}
                    
					//function run on complete login ajax request
					function AuthBrowserLoginResponseHandler(event){
					    var responce = $.parseJSON(event.target.responseText);
						if(responce['status'] != "Success" || responce['code'] != "200"){
						    location.reload();
						}
					}
				});
		    });
    	}());
    </script>
<?php } ?>
	<script type="text/javascript">
		const RootPath = '<?php echo RootPath; ?>';
		$(document).ready(function(){

			$(".Header_Site_Name").click(function(){
				window.location.href = "<?php echo RootPath; ?>LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php";
			});

			$("#Header_Menu_Icon").click(function(){
            	$("#Header_Menu_Item_Box").animate({width: "toggle"});
			});

			$(".HMHome").click(function(){
				window.location.href = "<?php echo RootPath; ?>Users";
			});

			$(".HMSearch").click(function(){
				window.location.href = "<?php echo RootPath; ?>Users/Organizations/Dashboard/College/ManagementPanel/ManageMembers/SearchMember/index.php";
			});

			$(".HMDashboard").click(function(){
				window.location.href = "<?php echo RootPath; ?>LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php";
			});

			$(".HMLogin").click(function(){
            	window.location.href = "<?php echo RootPath; ?>Users/Login/index.php";
			});
			
			$(".HMSignup").click(function(){
            	window.location.href = "<?php echo RootPath; ?>Users/Signup/index.php";
			});

			$('.HMTermsAndCondtion').click(()=>{
				window.location.href = RootPath+'Page/TermsAndCondtions/index.php';
			});

			$('.HMPrivacyPolicy').click(()=>{
				window.location.href = RootPath+'Page/PrivacyPolicy/index.php';
			});

			var logOutBtn = false;
			$(".LogOut").click(function(){
				if(logOutBtn != false){
					return false;
				}
				StartSubmit();
            	// Check Internet connection
				if(navigator.onLine == false){
					swal("It seems that you are offline. Please check your internet connection", "", "warning"); logOutBtn = false; return false;
				}

				// append data which we want to send data on targeted page
				var formdata = new FormData();
				formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
				
				// Send data on sigup backend page for uploading on the server
				try{
					var ajax = new XMLHttpRequest();
					ajax.addEventListener("load",ResponseMenuLogOut,false);
					ajax.open("POST", "<?php echo RootPath; ?>LibraryStore/PhpLibrary/LogOut/index.php");
					ajax.send(formdata);
				}catch(error){
					swal('', error,'error'); SubmitReset(); return false;
				}
				function ResponseMenuLogOut(event){
					try{
						var response = $.parseJSON(event.target.responseText);
						if(response['status'] === "Success"){
							swal("",response['msg']['msg'], "success")
							.then(() => {
								window.location.replace("<?php echo RootPath; ?>Users/Login/index.php");
							});
						}else{
							swal("", response['msg']['msg'], "error"); SubmitReset(); return false;
						}
					}catch(error){
						swal('', error, "error"); SubmitReset(); return false;
					}
				}
			});
			
			function StartSubmit(){
    			window.logOutBtn = true;
    			$(".LogOut").css({"display":"flex",'background':'#aaa'});
    			$(".LogOutSpinnerAnimationBox").prop('hidden',false);
    		}
    		function SubmitReset(){
    			window.logOutBtn = false;
    			$(".LogOut").css({"display":"block",'background':'#fff'});
    			$(".LogOutSpinnerAnimationBox").prop('hidden',true);
    		}
		});
	</script>
</header>