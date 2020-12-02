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

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php?RequestFrom=OrganizationMember&&LoginStatus=Logout"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'College'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php?RequestFrom=OrganizationMember&&LoginStatus=Login&&LoginAs=".$ResponseLogin['LAS'].'&&LORT='.$ResponseLogin['LORT']); die();
		}else{
			if($ResponseRank == 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}
	define("PageTitle", "Search Member");
	define("CssFile", "SearchMember");
	require_once RootPath."Site_Header/index.php";
?>
	<body>
		<div class = "MainContainer">
			<div class = "SearchBoxMain">
				<div>
					<input type="text" class = "SearchInput" id="SearchInput" autocomplete="off">
				</div>
				<div class=SearchBoxIcon>
					<img class = "SearchIcon" src="<?php echo RootPath; ?>Image_store/SearchIcionWhite48px.png">
				</div>
			</div>
			<div class="SearchResultBox">
				<div class = "NewResponseMainBox">Search Results Appear Here</div>
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
				//SubmitStart();
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
							SubmitReset();
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
							if(responce['status'] == "Success" && responce['code'] == "200")
							{	
								for(var i = 0; i < responce['msg']['totalrows']; i++){
									$('.SearchResultBox').append('<div class="NewSearchResponseContainer'+i+'"><div class = "NewResponseMainBox" style="grid-template-columns : repeat(6,1fr); padding-top : 0px;"><div class="ImageBox"><img class="SearchProfileImage" src="<?php echo RootPath; ?>Users/UserDataStore/ProfileImage/Organization/<?php echo $ResponseLogin['LFR']; ?>/'+responce['msg']['msg'][i]['ProfileUrl']+'"></img></div><div class="StatusBox"><p>Status</p><p>'+responce['msg']['msg'][i]['Status']+'</p></div><div class="FullNameBox"><p>Name</p><p>'+responce['msg']['msg'][i]['Fullname']+'</p></div><div class="MobileNumberBox"><p>MobileNumber</p><p>'+responce['msg']['msg'][i]['Mobile']+'</p></div><div class="GenderBox"><p>Gender</p><p>'+responce['msg']['msg'][i]['Gender']+'</p></div><div class="PositionBox"><p>Position</p><p>'+responce['msg']['msg'][i]['Position']+'</p></div><div class="UserUrlBox" hidden><p>UserUrl</p><p>'+responce['msg']['msg'][i]['UserUrl']+'</p></div></div><div class="SearchResultButtonBox"><div class="ViewMember" onclick="ViewMember('+i+')">View</div><div class="UpdateMember" onclick="UpdateMember('+i+')">Update</div><div class="DeleteMember" onclick="DeleteMember('+i+')">Delete</div><div class="BlockMember" onclick="BlockMember('+i+')">Block</div></div></div>');
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

		});
		function ViewMember(getData){
			swal('','This feature currently not available','warning');
			//window.location.href = "ViewMember/index.php?"+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .UserUrlBox p:eq(1)').html();

		}

		function UpdateMember(getData){
			window.location.href = "../UpdateMember/index.php?UserUrl="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .UserUrlBox p:eq(1)').html();

		}

		function DeleteMember(getData){
			window.location.href = "../DeleteMember/index.php?UserUrl="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .UserUrlBox p:eq(1)').html();

		}
		
		function BlockMember(getData){
			swal('','This feature currently not available','warning');
			//window.location.href = "../BlockMember/index.php?UserUrl="+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .UserUrlBox p:eq(1)').html()+'&&ProfileUrl='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .ImageBox img').attr('src')+'&&Fullname='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .FullNameBox p:eq(1)').html()+'&&Mobile='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .MobileNumberBox p:eq(1)').html()+'&&Position='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .PositionBox p:eq(1)').html()+'&&Gender='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .GenderBox p:eq(1)').html()+'&&Status='+$('.NewSearchResponseContainer'+getData+' .NewResponseMainBox .StatusBox p:eq(1)').html();

		}
	</script>
<!-- Remove all vars of php -->
<?php foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>