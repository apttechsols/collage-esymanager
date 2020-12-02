<?php
	/*
	*@FileName College/index.php
	*@Des Provide dashboard layout or interface
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

	define("RootPath", "../../../../../");

	if(!isset($_GET['target'])){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die(); exit();
	}

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

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
	
	$ResponseData = FetchReuiredDataByGivenData("Code::::".$_GET['target'],"Name::::ShortDescription::::Description::::ServiceFor::::StartTime::::ExpTime",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

	$ResponseData2 = FetchReuiredDataByGivenData("Status::::Active::,::PlanFor::::".$_GET['target'],"PlanCode::::Price::::Validity::::MaxRequestLimit::::TotalSelledPack::::MaxSellLimit::::StartTime::::LastUpdateTime::::ExpTime",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all',NULL,'all');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseData' && $SetVarKey != 'ResponseData2' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank != 1 && $ResponseRank != 2){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}

	// Create isset time according Asia/Kolkata
	date_default_timezone_set('Asia/Kolkata');
	$CurrentTime = time();

	define("PageTitle", "Service Open");
	define("CssFile", "ServiceOpen");
	require_once RootPath."Site_Header/index.php";

?>
<body>
	<div class='Container'>
		<?php
			if($ResponseData['status'] != 'Success' || $ResponseData['code'] != 200){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>This service not found</p>"; exit();
			}

			if($ResponseData2['status'] != 'Success' || $ResponseData2['code'] != 200){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>There is no plan available for ". $ResponseData['msg']->Name." Service</p>"; exit();
			}
			
			if($ResponseData['msg']->ServiceFor != 'All' && strpos($ResponseData['msg']->ServiceFor, ','.$ResponseLogin['LORT'].',') !== 0){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>". $ResponseData['msg']->Name." Service not for ".$ResponseLogin['LORT']."</p>"; exit();
			}

			if($ResponseData['msg']->StartTime != -1 && $ResponseData['msg']->StartTime >= $CurrentTime){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>Currently Service is not active</p>"; exit();
			}else if($ResponseData['msg']->ExpTime != -1 && $ResponseData['msg']->ExpTime <= $CurrentTime){
				echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>This service is expired</p>"; exit();
			}

			function ConvertToDayFromsec($seconds){
				$dt1 = new DateTime("@0");
				$dt2 = new DateTime("@$seconds");
				return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
			}
		?>
		<div class='ServiceBox'>
			<div class='ServiceOne'>
				<p class='ServiceNameBox'><b>Name </b>&#10148; <span><?php echo $ResponseData['msg']->Name; ?></span></p>
				<p class='ServicePlansBox'><span><b>Available Plans </b>&#10148; <span><?php echo $ResponseData2['totalrows']; ?> packs</span></span></p>
			</div>
			<div class='ServiceSecond'>
				<p><b>Short Discription </b>&#10148; <span><?php echo $ResponseData['msg']->ShortDescription; ?></span></p>
				<p><b>Full Discription </b>&#10148; <span><?php echo $ResponseData['msg']->Description; ?></span></p>
			</div>
		</div>
		<div><b>Available Plans</b> &#10148; <?php echo $ResponseData2['totalrows']; ?> Plans</div>
		<?php
			$Temp = 0;
			foreach ($ResponseData2['msg'] as $key => $value){
				if(($ResponseData2['msg'][$key]->StartTime != -1 && $ResponseData2['msg'][$key]->StartTime >= $CurrentTime) || ($ResponseData2['msg'][$key]->ExpTime != -1 && $ResponseData2['msg'][$key]->ExpTime <= $CurrentTime)){
					continue;
				}
				if($ResponseData2['msg'][$key]->MaxSellLimit > $ResponseData2['msg'][$key]->TotalSelledPack || $ResponseData2['msg'][$key]->MaxSellLimit == -1){
		?>
		<div class='ServiceBox'>
			<div class='PlanOne'>
				<p><b>Price : </b> <?php echo $ResponseData2['msg'][$key]->Price; ?> Rs</p>
				<p><b>Validty : </b><?php if($ResponseData2['msg'][$key]->Validity != -1){ echo ConvertToDayFromsec($ResponseData2['msg'][$key]->Validity); }else{ echo 'Unlimited'; } ?></p>
				<p><b>Request Allowed : </b> <?php if($ResponseData2['msg'][$key]->MaxRequestLimit == -1){echo "Unlimited";}else{echo $ResponseData2['msg'][$key]->MaxRequestLimit;} ?></p>
				<p class='BuyBtn' id='<?php echo  $ResponseData2['msg'][$key]->PlanCode; ?>' onclick="BuyService(this.id)">Buy<span class="loader_round_main <?php echo  $ResponseData2['msg'][$key]->PlanCode; ?>" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span></p>
			</div>
		</div>
		<?php
				}else{
					$Temp += 1;
				}
			}
		if($ResponseData2['totalrows'] == $Temp){
			echo "<p style='padding-top: 50px; text-align: center; font-weight: bold;'>Currently there is no plan open for ". $ResponseData['msg']->Name." Service</p>"; exit();
		}		
		?>
	</div>
</body>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</html>
<script>
	$(document).ready(function(){
	});
	// User Click Button Full Validation
	window.Submit_process = false;
	function BuyService(GetId){
		
		$("."+GetId).prop('hidden',false);
		if(GetId.length == ''){
			swal('Invalid plan id detect! Refresh please');
			$("."+GetId).prop('hidden',true); return false;
		}

		$('#'+GetId).css({'background':'#fff','border': '2px solid green','color':'green'});
		
		if(window.Submit_process == false){


			var client = new ClientJS();

			imprint.test(browserTests).then(function(result){
				var fingerprint_1 = new Fingerprint().get();
				var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
				audioFingerprint.run(function (fingerprint_2) {
					var BrowserClientId1 = "<?php echo $SessionEncryptPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass2; ?>";
					

					var BrowserClientId2 = "<?php echo $SessionEncryptPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass4; ?>";
					
					var ActiveType = 'Now';
					swal('Enter your Security Code to Delete this plan', {
						buttons: {
							cancel: "Cancel",
							Next: true,
						},
						content: {
							element: "input",
							attributes: {
								placeholder: "Security Code",
								type: "password",
								className: "VirtualSecurityCode",
								autocomplete: "off",
							},
						},
					  	closeOnClickOutside: false,
					  	closeOnEsc: false,
					})
					.then((value) => {
						if(value === "Next"){

							// append data which we want to send data on targetd page
							var formdata = new FormData();
							formdata.append("target", "<?php echo $_GET['target']; ?>");
							formdata.append("PlanId", GetId);
							formdata.append("ActiveType", ActiveType);
							formdata.append("SecurityCode", $(".VirtualSecurityCode").val());
							formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
							formdata.append("BrowserClientId1", BrowserClientId1);
							formdata.append("BrowserClientId2", BrowserClientId2);

							window.Submit_process = true;

							// Check Internet connection
							if(navigator.onLine == false){
								swal("It seems that you are offline. Please check your internet connection", "", "warning");
								$("."+GetId).prop('hidden',true); return false;
							}

							try{
								var ajax = new XMLHttpRequest();
								ajax.addEventListener("load",ResponceHandler,false);
								ajax.open("POST", "BuyServiceBackend.php");
								ajax.send(formdata);
							}catch(error){
								swal('',error,'error');
								$("."+GetId).prop('hidden',true);
								window.Submit_process = false; return false;
							}

							//function run on complete login ajax request
							function ResponceHandler(event){
								window.Submit_process = false;
								$("."+GetId).prop('hidden',true);
								var response = $.parseJSON(event.target.responseText);
								if(response['status'] === "Success" && response['code'] === 200){
									swal(response['msg'],'','success')
									.then(() => {
									    window.location.replace(RootPath+'Users/Organizations/Dashboard/College/ManagementPanel/ManageService/ManageBuyedService/index.php');
									});
									return false;
								}else{
									swal(response['msg'],'','error'); return false;
								}
							}
						}else{
							$("."+GetId).prop('hidden',true);
							return false;
						}
					});
				});
		    });	
		}else{
			swal('','A Buy process already in queue','warning');
			$("."+GetId).prop('hidden',true);
		}
	}
</script>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>