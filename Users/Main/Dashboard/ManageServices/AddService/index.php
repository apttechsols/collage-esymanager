<?php
	/*
	*@FileName AddNewMember/index.php
	*@Desc - Add new services
	*@Author Arpit sharma
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
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
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
	define("PageTitle", "Add Service");
	define("CssFile", "AddService");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class='Container'>
		<p class='PageTitle'>ADD SERVICE</p>
		<div class='Form'>
			<div class='Form1'>
				<div class='ServiceStatusBox'>
					<span class='InputSpanTitle'>Service Status*</span>
					<select class='ServiceStatus'>
						<option value="Active">Active</option>
						<option value="Hold">Hold</option>
					</select>
				</div>
				<div class='ServiceNameBox'>
					<span class='InputSpanTitle'>Service name*</span>
					<input type="text" name="ServiceName" spellcheck="false" class="ServiceName" maxlength="50" placeholder="Service Name"/>
				</div>
				<div class='ServiceStartTimeBox'>
					<span class='InputSpanTitle'>Service start time*</span>
					<span></span>
					<input type="number" spellcheck="false" class="ServiceStartTime" maxlength="6" placeholder="Start Time">
					<select class='ServiceStartTimeType'>
						<option value='Manually'>Manually</option>
						<option value='Days'>Day</option>
						<option value='Hours'>Hour</option>
						<option value='Minutes'>Min </option>
						<option value='Seconds'>Sec</option>
					</select>
				</div>
				<div class='ServiceExpTimeBox'>
					<span class='InputSpanTitle'>Service expire time*</span>
					<span></span>
					<input type="number" spellcheck="false" class="ServiceExpTime" maxlength="6" placeholder="Exp Time">
					<select class='ServiceExpTimeType'>
						<option value='Manually'>Manually</option>
						<option value='Days'>Day</option>
						<option value='Hours'>Hour</option>
						<option value='Minutes'>Min </option>
						<option value='Seconds'>Sec</option>
					</select>
				</div>
				<div class='ServiceForBox'>
					<span class='InputSpanTitle'>Service for*</span>
					<select class='ServiceFor'>
						<option value=''>Service For</option>
						<option value='All'>All</option>
						<option value='College'>College</option>
					</select>
				</div>
				<div class='ServiceMemberBox'>
					<span class='InputSpanTitle'>Service Member allow*</span>
					<select class='ServiceMember'>
						<option value=''>Service Member</option>
						<option value='Yes'>Yes</option>
						<option value='No'>No</option>
					</select>
				</div>
				<div class='DemoClassBox'>
					<span class='InputSpanTitle'>Demo input</span>
					<input type="text" name="DemoClass" spellcheck="false" maxlength="50" class="DemoClass" placeholder="Demo input" disabled="true" />
				</div>
				<div class='MaxSellLimitBox'>
					<span class='InputSpanTitle'>Max Sell Limit*</span>
					<input type="text" name="MaxSellLimit" spellcheck="false" maxlength="50" class="MaxSellLimit" placeholder="Max sell limit" value="<?php echo $ResponseData['msg']->MaxSellLimit; ?>" />
				</div>
				<div class='AllOffersPermissionBox'>
					<span class='InputSpanTitle'>All offers permission</span>
					<select class='AllOffersPermission'>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='SpecialOffersPermissionBox'>
					<span class='InputSpanTitle'>Special offers permission</span>
					<select class='SpecialOffersPermission'>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='PrivateOffersPermissionBox'>
					<span class='InputSpanTitle'>Private offers permission</span>
					<select class='PrivateOffersPermission'>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='AllOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>All offers max discount amount</span>
					<input type="number" name="AllOffersMaxDiscountAmount" spellcheck="false" class="AllMaxDiscountAmount" maxlength="6" placeholder="All Offers Max Discount Amount"/>
				</div>
				<div class='SpecialOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>Special offers max discount amount</span>
					<input type="number" name="SpecialOffersMaxDiscountAmount" spellcheck="false" class="SpecialOffersMaxDiscountAmount" maxlength="6" placeholder="Special Offers Max Discount Amount"/>
				</div>
				<div class='PrivateOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>Private offers max discount amount</span>
					<input type="number" name="PrivateOffersMaxDiscountAmount" spellcheck="false" class="PrivateOffersMaxDiscountAmount" maxlength="6" placeholder="Private Offers Max Discount Amount"/>
				</div>
				<div class='AllOffersMaxDiscountPersentageBox'>
					<span class='InputSpanTitle'>All offers max discount persentage</span>
					<input type="number" name="AllOffersMaxDiscountPersentage" spellcheck="false" class="AllMaxDiscountPercentage" maxlength="4" placeholder="All Offers Max Discount Percentage"/>
				</div>
				<div class='SpecialOffersMaxDiscountPercentageBox'>
					<span class='InputSpanTitle'>Special offers max discount percentage</span>
					<input type="number" name="SpecialOffersMaxDiscountPercentage" spellcheck="false" class="SpecialOffersMaxDiscountPercentage" maxlength="4" placeholder="Special Offers Max Discount percentage"/>
				</div>
				<div class='PrivateOffersMaxDiscountPercentageBox'>
					<span class='InputSpanTitle'>Private offers max discount percentage</span>
					<input type="number" name="PrivateOffersMaxDiscountPercentage" spellcheck="false" class="PrivateOffersMaxDiscountPercentage" maxlength="4" placeholder="Private Offers Max Discount percentage"/>
				</div>
				<div class='VersionBox'>
					<span class='InputSpanTitle'>Version</span>
					<input type="text" name="Version" spellcheck="false" maxlength="50" class="Version" placeholder="Version" disabled="true" />
				</div>
			</div>
			<div class='FormLast'>
				<div class='ServicePackWorkBox'>
					<span class='InputSpanTitle'>Service pack work*</span>
					<textarea class='ServicePackWork' spellcheck="false" maxlength="80" placeholder="Service Pack Work"></textarea>
				</div>
				<div class='ServiceDescriptionBox'>
					<span class='InputSpanTitle'>Service description*</span>
					<textarea class='ServiceDescription' spellcheck="false" maxlength="1200" placeholder="Service Description"></textarea>
				</div>
				<div class='ServiceTablesAndColumnsBox'>
					<span class='InputSpanTitle'>Services Tables and Columns*</span>
					<textarea class='ServiceTablesAndColumns' spellcheck="false" maxlength="11000" placeholder="Services Tables and Columns"></textarea>
					<!--
						table1=Column1(Type>INT@Length>255@Default>@Null>False@Index>PRIMARY@AI>True),column2(Type>INT@Length>255@Default>@Null>True@Index>UNIQUE@AI>False)&table2=column1(Type>INT@Length>255@Default>@Null>False@Index>PRIMARY@AI>True)
					-->
				</div>
				<div class='TablesDefaultValuesBox'>
					<span class='InputSpanTitle'>Tables Default Values</span>
					<textarea class='TablesDefaultValues' spellcheck="false" maxlength="11000" placeholder="Tables Default Values"></textarea>
					<!--
						table1=column1::::arpit#column2::::sharma@column1::::hello&table2=column1::::arpit#column2::::sharma@column1::::hello
					-->
				</div>

				<input type="password" name="SecurityCode" spellcheck="false" maxlength="6" class="SecurityCode" placeholder="Security Code">
				<div class="AddServiceButton">Add Service<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span></div>
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

		$(".ServiceTablesAndColumns").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0) + this.value.replace(/[^A-Za-z0-9,=&)(@>_]/g,'').slice(1);
		});

		$(".TablesDefaultValues").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0) + this.value.replace(/[^A-Za-z0-9=&@:#-_ ]/g,'').slice(1);
		});
		// User Click Button Full Validation
		window.Submit_process = false;
		$(".AddServiceButton").click(function(){
			$(".loader_round_main").prop('hidden',false);
			const AllInputClassStore = ["ServiceStatus","ServiceName","ServiceStartTimeType","ServiceExpTimeType","ServiceFor",'ServiceMember',"MaxSellLimit","AllOffersPermission","SpecialOffersPermission","PrivateOffersPermission","ServicePackWork","ServiceDescription","SecurityCode"];
			for(var i=0; i<AllInputClassStore.length; i++){
				if($("."+AllInputClassStore[i].split("&")[0]).val().length == 0){
					$("."+AllInputClassStore[i].split("&")[0]).css('border','2px solid red');
					$('html, body').animate({'scrollTop' : $("."+AllInputClassStore[i].split("&")[0]).position().top- 70});
					$("."+AllInputClassStore[i].split("&")[0]).focus();
					$(".loader_round_main").prop('hidden',true);
					return false;
				}else{
					$("."+AllInputClassStore[i].split("&")[0]).css('border','1px solid darkgray');
				}
			}
			
			if(window.Submit_process == false){

				// Create Variable of input Data
				var ServiceStatus = $(".ServiceStatus").val();
				var ServiceName = $(".ServiceName").val();
				var ServiceStartTime = $(".ServiceStartTime").val();
				var ServiceStartTimeType = $(".ServiceStartTimeType").val();
				var ServiceExpTime = $(".ServiceExpTime").val();
				var ServiceExpTimeType = $(".ServiceExpTimeType").val();
				var ServiceFor = $(".ServiceFor").val();
				var ServiceMember = $(".ServiceMember").val();
				var MaxSellLimit = $(".MaxSellLimit").val();
				var AllOffersPermission = $(".AllOffersPermission").val();
				var SpecialOffersPermission = $(".SpecialOffersPermission").val();
				var PrivateOffersPermission = $(".PrivateOffersPermission").val();
				var AllMaxDiscountAmount = $(".AllMaxDiscountAmount").val();
				var SpecialOffersMaxDiscountAmount = $(".SpecialOffersMaxDiscountAmount").val();
				var PrivateOffersMaxDiscountAmount = $(".PrivateOffersMaxDiscountAmount").val();
				var AllMaxDiscountPercentage = $(".AllMaxDiscountPercentage").val();
				var SpecialOffersMaxDiscountPercentage = $(".SpecialOffersMaxDiscountPercentage").val();
				var PrivateOffersMaxDiscountPercentage = $(".PrivateOffersMaxDiscountPercentage").val();
				var ServicePackWork = $(".ServicePackWork").val();
				var ServiceDescription = $(".ServiceDescription").val();
				var ServiceTablesAndColumns = $(".ServiceTablesAndColumns").val();
				var TablesDefaultValues = $(".TablesDefaultValues").val();
				var SecurityCode = $(".SecurityCode").val();
				
				//SubmitStart();
				var client = new ClientJS();

				imprint.test(browserTests).then(function(result){
					var fingerprint_1 = new Fingerprint().get();
					var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
					audioFingerprint.run(function (fingerprint_2) {
						var BrowserClientId1 = "<?php echo $SessionEncryptPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass2; ?>";
						

						var BrowserClientId2 = "<?php echo $SessionEncryptPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $SessionEncryptPass4; ?>";

						// append data which we want to send data on targeted page
						var formdata = new FormData();
						formdata.append("ServiceStatus", ServiceStatus);
						formdata.append("ServiceName", ServiceName);
						formdata.append("ServiceStartTime", ServiceStartTime);
						formdata.append("ServiceStartTimeType", ServiceStartTimeType);
						formdata.append("ServiceExpTime", ServiceExpTime);
						formdata.append("ServiceExpTimeType", ServiceExpTimeType);
						formdata.append("ServiceFor", ServiceFor);
						formdata.append("ServiceMember", ServiceMember);
						formdata.append("MaxSellLimit", MaxSellLimit);
						formdata.append("AllOffersPermission", AllOffersPermission);
						formdata.append("SpecialOffersPermission", SpecialOffersPermission);
						formdata.append("PrivateOffersPermission", PrivateOffersPermission);
						formdata.append("AllMaxDiscountAmount", AllMaxDiscountAmount);
						formdata.append("SpecialOffersMaxDiscountAmount", SpecialOffersMaxDiscountAmount);
						formdata.append("PrivateOffersMaxDiscountAmount", PrivateOffersMaxDiscountAmount);
						formdata.append("AllMaxDiscountPercentage", AllMaxDiscountPercentage);
						formdata.append("SpecialOffersMaxDiscountPercentage", SpecialOffersMaxDiscountPercentage);
						formdata.append("PrivateOffersMaxDiscountPercentage", PrivateOffersMaxDiscountPercentage);
						formdata.append("ServicePackWork", ServicePackWork);
						formdata.append("ServiceDescription", ServiceDescription);
						formdata.append("ServiceTablesAndColumns", ServiceTablesAndColumns);
						formdata.append("TablesDefaultValues", TablesDefaultValues);
						formdata.append("SecurityCode", SecurityCode);
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						window.Submit_process = true;

						// Send data on AddNewMemberBackend page
						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",Response,false);
							ajax.open("POST", "AddServiceBackend.php");
							ajax.send(formdata);
						}catch(error){
							swal(error,'','error');
							window.Submit_process = false;
							$(".loader_round_main").prop('hidden',true);
							return false;
						}
					});
			    });	
			}else{
				swal('','Process already in queue','warning');
			}

			//function run on complete login ajax request
			function Response(event)
			{
				window.Submit_process = false;
				$(".loader_round_main").prop('hidden',true);
				var response = $.parseJSON(event.target.responseText);
				if(response['status'] === "Success" && response['code'] === 200){
					swal(response['msg'],'','success');
				}else{
					swal(response['msg'],'','error');
				}
			}
		});
	});
</script>
<?php /*Remove all vars of php*/ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ?>