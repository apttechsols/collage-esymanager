<?php
	/*
	*@FileName AddNewMember/index.php
	*@Desc - Add new Plans
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

	if(!isset($_GET['target']) || strlen($_GET['target']) == 0){
		return_response('Invalid target detect'); exit();
	}else{
		$target = $_GET['target'];
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

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	$ResponseData = FetchReuiredDataByGivenData("none","Name::::Code",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all',NULL,'all');

	$ResponseData2 = FetchReuiredDataByGivenData("PlanCode::::$target","Status::::PlanFor::::Price::::Validity::::MaxRequestLimit::::StartTime::::ExpTime::::MaxSellLimit::::SameOrgCanBuyMaxTimeByPlaneCode::::CSPCode::::SameOrgCanBuyMaxTimeByCSP::::AllOffersPermission::::SpecialOffersPermission::::PrivateOffersPermission::::AllMaxOfferDiscount::::SpecialMaxOfferDiscount::::PrivateMaxOfferDiscount",$PdoServiceManage,'service_plans',$EncodeAndEncryptPass,'all');

	$ResponseData3 = FetchReuiredDataByGivenData("Code::::".$ResponseData2['msg']->PlanFor,"Name",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank'  && $SetVarKey != 'ResponseData'  && $SetVarKey != 'ResponseData2'  && $SetVarKey != 'ResponseData3' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
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

	if($ResponseData['status'] != 'Success' || $ResponseData['code'] != 200 || $ResponseData3['status'] != 'Success' || $ResponseData3['code'] != 200){
		return_response('Somthing going wrong! Try again later'.json_encode($ResponseData3)); exit();
	}

	if($ResponseData2['status'] != 'Success' || $ResponseData2['code'] != 200){
		return_response('Invalid target detect'); exit();
	}
	define("PageTitle", "Update Plan");
	define("CssFile", "UpdatePlan");
	require_once RootPath."Site_Header/index.php";
?>
<body class="No_Select_Strat">
	<div class='Container'>
		<p class='PageTitle'>UPDATE PLAN</p>
		<div class='Form'>
			<div class='Form1'>
				<div class='PlanStatusBox'>
					<span class='InputSpanTitle'>Plan Status*</span>
					<select class='PlanStatus'>
						<option value="<?php echo $ResponseData2['msg']->Status; ?>"><?php echo $ResponseData2['msg']->Status; ?></option>
						<option value="Active">Active</option>
						<option value="Hold">Hold</option>
					</select>
				</div>
				<div class='PlanForBox'>
					<span class='InputSpanTitle'>Plan for*</span>
					<select class='PlanFor'>
						<option value="<?php echo $ResponseData3['msg']->Name; ?>"><?php echo $ResponseData3['msg']->Name; ?></option>
						<option value=''>Plan For</option>
						<?php
							foreach($ResponseData['msg'] as $value){if($value->Name != null){?>
								<option value="<?php echo $value->Name; ?>"><?php echo $value->Name; ?></option>
						<?php }} ?>
					</select>
				</div>
				<div class='PlanPriceBox'>
					<span class='InputSpanTitle'>Plan price*</span>
					<input type="text" name="PlanPrice" spellcheck="false" maxlength="50" class="PlanPrice" placeholder="Plan price" value="<?php echo $ResponseData2['msg']->Price; ?>"/>
				</div>
				<div class='PlanValidityBox'>
					<span class='InputSpanTitle'>Plan Validity*</span>
					<span></span>
					<input type="number" spellcheck="false" class="PlanValidity" maxlength="6" placeholder="Plan validity" value="<?php echo $ResponseData2['msg']->Validity; ?>"/>
					<select class='PlanValidityType'>
						<option value='Seconds'>Sec</option>
					</select>
				</div>
				<div class='MaxRequestBox'>
					<span class='InputSpanTitle'>Max Request*</span>
					<input type="number" spellcheck="false" class="MaxRequest" maxlength="6" placeholder="Max request" value="<?php echo $ResponseData2['msg']->MaxRequestLimit; ?>"/>
				</div>
				<div class='DemoClassBox'>
					<span class='InputSpanTitle'>Demo input</span>
					<input type="text" name="DemoClass" spellcheck="false" maxlength="50" class="DemoClass" placeholder="Demo input" disabled="true" />
				</div>
				<div class='PlanStartDateBox'>
					<span class='InputSpanTitle'>Plan start date*</span>
					<div class = "DateAndTimeBox" style='display:flex;'>
						<?php
							echo '<select id="PlanStartDateDay">';
							for($i=1; $i<=31; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanStartDateMonth">';
							for($i=1; $i<=12; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanStartDateYear">';
							for($i=date('Y')+1; $i>=1970; $i--){
								echo "<option value='$i'>$i</option>";
							}
							echo '</select>';
						?>
					</div>
				</div>
				<div class='PlanStartTimeBox'>
					<span class='InputSpanTitle'>Plan start time*</span>
					<div class = "DateAndTimeBox" style='display: flex;'>
						<?php
							echo '<select id="PlanStartTimeHour">';
							for($i=0; $i<=23; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanStartTimeMin">';
							for($i=0; $i<=59; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanStartTimeSec">';
							for($i=0; $i<=59; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
						?>
					</div>
				</div>
				<div class='PlanExpDateBox'>
					<span class='InputSpanTitle'>Plan Exp date*</span>
					<div class = "DateAndTimeBox" style='display:flex;'>
						<?php
							echo '<select id="PlanExpDateDay">';
							for($i=1; $i<=30; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanExpDateMonth">';
							for($i=1; $i<=12; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanExpDateYear">';
							for($i=date('Y')+1; $i>=1970; $i--){
								echo "<option value='$i'>$i</option>";
							}
							echo '</select>';
						?>
					</div>
				</div>
				<div class='PlanExpTimeBox'>
					<span class='InputSpanTitle'>Plan Exp time*</span>
					<div class = "DateAndTimeBox" style='display: flex;'>
						<?php
							echo '<select id="PlanExpTimeHour">';
							for($i=0; $i<=23; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanExpTimeMin">';
							for($i=0; $i<=59; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
							echo '<select id="PlanExpTimeSec">';
							for($i=0; $i<=59; $i++){
								if($i < 10){
									echo "<option value='0$i'>0$i</option>";
								}else{
									echo "<option value='$i'>$i</option>";
								}
							}
							echo '</select>';
						?>
					</div>
				</div>
				<div class='PlanExpTimeBox'>
					<span class='InputSpanTitle'>Plan expire time*</span>
						<input type="number" spellcheck="false" class="PlanExpTime" maxlength="6" placeholder="Exp Time" value="<?php echo $ResponseData2['msg']->ExpTime; ?>" />
				</div>
				<div class='MaxSellLimitBox'>
					<span class='InputSpanTitle'>Max Sell Limit*</span>
					<input type="text" name="MaxSellLimit" spellcheck="false" maxlength="50" class="MaxSellLimit" placeholder="Max sell limit" value="<?php echo $ResponseData2['msg']->MaxSellLimit; ?>" />
				</div>
				<div class='SameOrgCanBuyMaxTimeByPlaneCodeBox'>
					<span class='InputSpanTitle'>Same Org Can Buy By Plan Code</span>
					<input type="number" name="SameOrgCanBuyMaxTimeByPlaneCode" spellcheck="false" maxlength="50" class="SameOrgCanBuyMaxTimeByPlaneCode" placeholder="Same Org Can Buy By Plan Code" value="<?php echo $ResponseData2['msg']->SameOrgCanBuyMaxTimeByPlaneCode; ?>" />

				</div>
				<div class='CSPCodeBox'>
					<span class='InputSpanTitle'>Custom Service Plan Code</span>
					<input type="text" name="CSPCode" spellcheck="false" maxlength="130" class="CSPCode" placeholder="Custom Service Plan Code" value="<?php echo $ResponseData2['msg']->CSPCode; ?>" />
				</div>
				<div class='SameOrgCanBuyMaxTimeByCSPBox'>
					<span class='InputSpanTitle'>Same Org Can Buy By Custom Code</span>
					<input type="number" name="SameOrgCanBuyMaxTimeByCSP" spellcheck="false" maxlength="50" class="SameOrgCanBuyMaxTimeByCSP" placeholder="Same Org Can Buy By Custom Code" value="<?php echo $ResponseData2['msg']->SameOrgCanBuyMaxTimeByCSP; ?>" />
				</div>
				<div class='AllOffersPermissionBox'>
					<span class='InputSpanTitle'>All offers permission</span>
					<select class='AllOffersPermission'>
						<option value='<?php echo $ResponseData2['msg']->AllOffersPermission; ?>'><?php echo $ResponseData2['msg']->AllOffersPermission; ?></option>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='SpecialOffersPermissionBox'>
					<span class='InputSpanTitle'>Special offers permission</span>
					<select class='SpecialOffersPermission'>
						<option value='<?php echo $ResponseData2['msg']->SpecialOffersPermission; ?>'><?php echo $ResponseData2['msg']->SpecialOffersPermission; ?></option>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='PrivateOffersPermissionBox'>
					<span class='InputSpanTitle'>Private offers permission</span>
					<select class='PrivateOffersPermission'>
						<option value='<?php echo $ResponseData2['msg']->PrivateOffersPermission; ?>'><?php echo $ResponseData2['msg']->PrivateOffersPermission; ?></option>
						<option value='Allow'>Allow</option>
						<option value='Deny'>Deny</option>
					</select>
				</div>
				<div class='AllOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>All offers max discount amount</span>
					<input type="number" name="AllOffersMaxDiscountAmount" spellcheck="false" class="AllMaxDiscountAmount" maxlength="6" placeholder="All Offers Max Discount Amount" value="<?php echo unserialize($ResponseData2['msg']->AllMaxOfferDiscount)['Amount']; ?>" />
				</div>
				<div class='SpecialOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>Special offers max discount amount</span>
					<input type="number" name="SpecialOffersMaxDiscountAmount" spellcheck="false" class="SpecialOffersMaxDiscountAmount" maxlength="6" placeholder="Special Offers Max Discount Amount" value="<?php echo unserialize($ResponseData2['msg']->SpecialMaxOfferDiscount)['Amount']; ?>"/>
				</div>
				<div class='PrivateOffersMaxDiscountAmountBox'>
					<span class='InputSpanTitle'>Private offers max discount amount</span>
					<input type="number" name="PrivateOffersMaxDiscountAmount" spellcheck="false" class="PrivateOffersMaxDiscountAmount" maxlength="6" placeholder="Private Offers Max Discount Amount" value="<?php echo unserialize($ResponseData2['msg']->PrivateMaxOfferDiscount)['Amount']; ?>"/>
				</div>
				<div class='AllOffersMaxDiscountPersentageBox'>
					<span class='InputSpanTitle'>All offers max discount persentage</span>
					<input type="number" name="AllOffersMaxDiscountPersentage" spellcheck="false" class="AllMaxDiscountPercentage" maxlength="4" placeholder="All Offers Max Discount Percentage" value="<?php echo unserialize($ResponseData2['msg']->AllMaxOfferDiscount)['Percentage']; ?>"/>
				</div>
				<div class='SpecialOffersMaxDiscountPercentageBox'>
					<span class='InputSpanTitle'>Special offers max discount percentage</span>
					<input type="number" name="SpecialOffersMaxDiscountPercentage" spellcheck="false" class="SpecialOffersMaxDiscountPercentage" maxlength="4" placeholder="Special Offers Max Discount percentage" value="<?php echo unserialize($ResponseData2['msg']->SpecialMaxOfferDiscount)['Percentage']; ?>"/>
				</div>
				<div class='PrivateOffersMaxDiscountPercentageBox'>
					<span class='InputSpanTitle'>Private offers max discount percentage</span>
					<input type="number" name="PrivateOffersMaxDiscountPercentage" spellcheck="false" class="PrivateOffersMaxDiscountPercentage" maxlength="4" placeholder="Private Offers Max Discount percentage" value="<?php echo unserialize($ResponseData2['msg']->PrivateMaxOfferDiscount)['Percentage']; ?>"/>
				</div>
			</div>
			<div class='FormLast'>
				<input type="password" name="SecurityCode" spellcheck="false" maxlength="6" class="SecurityCode" placeholder="Security Code">
				<div class="UpdatePlanButton">Update Plan<span class="loader_round_main" hidden="true"><span class="loader_round loader_button_center"><span></span></span></span></span></div>
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

		(function(){
			$('#PlanStartDateDay').val('<?php echo date('d',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanStartDateMonth').val('<?php echo date('m',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanStartDateYear').val('<?php echo date('Y',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanStartTimeHour').val('<?php echo date('H',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanStartTimeMin').val('<?php echo date('i',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanStartTimeSec').val('<?php echo date('s',$ResponseData2['msg']->StartTime); ?>');
			$('#PlanExpDateDay').val('<?php echo date('d',$ResponseData2['msg']->ExpTime); ?>');
			$('#PlanExpDateMonth').val('<?php echo date('m',$ResponseData2['msg']->ExpTime); ?>');
			$('#PlanExpDateYear').val('<?php echo date('Y',$ResponseData2['msg']->ExpTime); ?>');
			$('#PlanExpTimeHour').val('<?php echo date('H',$ResponseData2['msg']->ExpTime); ?>');
			$('#PlanExpTimeMin').val('<?php echo date('i',$ResponseData2['msg']->ExpTime); ?>');
			$('#PlanExpTimeSec').val('<?php echo date('s',$ResponseData2['msg']->ExpTime); ?>');
		})();

		$(".PlanTablesAndColumns").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0) + this.value.replace(/[^A-Za-z0-9,=&)(@>_]/g,'').slice(1);
		});

		$(".TablesDefaultValues").keyup(function(){
			this.value = this.value.replace(/[^A-Za-z]/g,'').charAt(0) + this.value.replace(/[^A-Za-z0-9=&@:#-_ ]/g,'').slice(1);
		});
		// User Click Button Full Validation
		window.Submit_process = false;
		$(".UpdatePlanButton").click(function(){
			$(".loader_round_main").prop('hidden',false);
			const AllInputClassStore = ["PlanStatus&Status","PlanFor&Plan for required","PlanPrice&Plan price Required","PlanValidity&Plan validity Required","MaxRequest&Max request required","MaxSellLimit&Max sell limit required","AllOffersPermission&All offers permission","SpecialOffersPermission&Special offers permission","PrivateOffersPermission&Private offers permission","SecurityCode&Security Code"];
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

			if($('#PlanStartDateDay').val() == 1 && $('#PlanStartDateMonth').val() == 1 && $('#PlanStartDateYear').val() == 1970 && $('#PlanStartTimeHour').val() <= 5 && $('#PlanStartTimeMin').val() < 30){
				var PlanStartTime = -1;
			}else{
				var PlanStartDateTemp = $('#PlanStartDateDay').val()+'-'+$('#PlanStartDateMonth').val()+'-'+$('#PlanStartDateYear').val();
				var PlanStartDate = $('#PlanStartDateYear').val()+'-'+$('#PlanStartDateMonth').val()+'-'+$('#PlanStartDateDay').val();
				if(!isDate(PlanStartDateTemp)){
					swal('','Inavlid Plan start Date found','warning'); $(".loader_round_main").prop('hidden',true); return false;
				}
				var PlanStartTime = $('#PlanStartTimeHour').val()+':'+$('#PlanStartTimeMin').val()+':'+$('#PlanStartTimeSec').val();
				var PlanStartTime = new Date(PlanStartDate+' '+PlanStartTime).valueOf()/1000;
			}

			if($('#PlanExpDateDay').val() == 1 && $('#PlanExpDateMonth').val() == 1 && $('#PlanExpDateYear').val() == 1970 && $('#PlanExpTimeHour').val() <= 5 && $('#PlanExpTimeMin').val() < 30){
				var PlanExpTime = -1;
			}else{
				var PlanExpDateTemp = $('#PlanExpDateDay').val()+'-'+$('#PlanExpDateMonth').val()+'-'+$('#PlanExpDateYear').val();
				var PlanExpDate = $('#PlanExpDateYear').val()+'-'+$('#PlanExpDateMonth').val()+'-'+$('#PlanExpDateDay').val();
				if(!isDate(PlanExpDateTemp)){
					swal('','Inavlid Plan Exp Date found','warning'); $(".loader_round_main").prop('hidden',true); return false;
				}
				var PlanExpTime = $('#PlanExpTimeHour').val()+':'+$('#PlanExpTimeMin').val()+':'+$('#PlanExpTimeSec').val();
				var PlanExpTime = new Date(PlanExpDate+' '+PlanExpTime).valueOf()/1000;
			}
			
			if(window.Submit_process == false){

				// Create Variable of input Data
				var PlanStatus = $(".PlanStatus").val();
				var PlanFor = $(".PlanFor").val();
				var PlanPrice = $(".PlanPrice").val();
				var PlanValidity = $(".PlanValidity").val();
				var MaxRequest = $(".MaxRequest").val();
				var PlanValidityType = $(".PlanValidityType").val();
				var MaxSellLimit = $(".MaxSellLimit").val();
				var SameOrgCanBuyMaxTimeByPlaneCode = $(".SameOrgCanBuyMaxTimeByPlaneCode").val();
				var CSPCode = $(".CSPCode").val();
				var SameOrgCanBuyMaxTimeByCSP = $(".SameOrgCanBuyMaxTimeByCSP").val();
				var AllOffersPermission = $(".AllOffersPermission").val();
				var SpecialOffersPermission = $(".SpecialOffersPermission").val();
				var PrivateOffersPermission = $(".PrivateOffersPermission").val();
				var AllMaxDiscountAmount = $(".AllMaxDiscountAmount").val();
				var SpecialOffersMaxDiscountAmount = $(".SpecialOffersMaxDiscountAmount").val();
				var PrivateOffersMaxDiscountAmount = $(".PrivateOffersMaxDiscountAmount").val();
				var AllMaxDiscountPercentage = $(".AllMaxDiscountPercentage").val();
				var SpecialOffersMaxDiscountPercentage = $(".SpecialOffersMaxDiscountPercentage").val();
				var PrivateOffersMaxDiscountPercentage = $(".PrivateOffersMaxDiscountPercentage").val();
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
						formdata.append("PlanCode", "<?php echo $_GET['target']; ?>");
						formdata.append("PlanStatus", PlanStatus);
						formdata.append("PlanFor", PlanFor);
						formdata.append("PlanPrice", PlanPrice);
						formdata.append("PlanValidity", PlanValidity);
						formdata.append("MaxRequest", MaxRequest);
						formdata.append("PlanValidityType", PlanValidityType);
						formdata.append("PlanStartTime", PlanStartTime);
						formdata.append("PlanExpTime", PlanExpTime);
						formdata.append("MaxSellLimit", MaxSellLimit);
						formdata.append("SameOrgCanBuyMaxTimeByPlaneCode", SameOrgCanBuyMaxTimeByPlaneCode);
						formdata.append("CSPCode", CSPCode);
						formdata.append("SameOrgCanBuyMaxTimeByCSP", SameOrgCanBuyMaxTimeByCSP);
						formdata.append("AllOffersPermission", AllOffersPermission);
						formdata.append("SpecialOffersPermission", SpecialOffersPermission);
						formdata.append("PrivateOffersPermission", PrivateOffersPermission);
						formdata.append("AllMaxDiscountAmount", AllMaxDiscountAmount);
						formdata.append("SpecialOffersMaxDiscountAmount", SpecialOffersMaxDiscountAmount);
						formdata.append("PrivateOffersMaxDiscountAmount", PrivateOffersMaxDiscountAmount);
						formdata.append("AllMaxDiscountPercentage", AllMaxDiscountPercentage);
						formdata.append("SpecialOffersMaxDiscountPercentage", SpecialOffersMaxDiscountPercentage);
						formdata.append("PrivateOffersMaxDiscountPercentage", PrivateOffersMaxDiscountPercentage);
						formdata.append("SecurityCode", SecurityCode);
						formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
						formdata.append("BrowserClientId1", BrowserClientId1);
						formdata.append("BrowserClientId2", BrowserClientId2);

						window.Submit_process = true;

						// Send data on AddNewMemberBackend page
						try{
							var ajax = new XMLHttpRequest();
							ajax.addEventListener("load",Response,false);
							ajax.open("POST", "UpdatePlanBackend.php");
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
					swal(response['msg'],'','success')
					.then(function(){
						location.reload();
					});
				}else{
					swal(response['msg'],'','error');
				}
			}
		});
	});
</script>
<?php /*Remove all vars of php*/ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== ''){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ?>