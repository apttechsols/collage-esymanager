<?php
	// Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}

	// Create Domain name and save it in const variable
	define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
	define("RootPath",  '../');

	//Secrate code for access otherfiles file
	$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

	require_once (RootPath."JsonShowError/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");
	
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != '_SERVER' && $SetVarKey != 'RootPath' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	$TempUrl = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "?") + 1);
	if($TempUrl != '' && $TempUrl != 'SPRBC/'){
		$TempData = explode('&', $TempUrl);
		$i = 0;
		foreach ($TempData as $value) {
			${'D'} .= 'D'.$i.'='.$value.'&';
			$i++;
		}
		$D = trim($D, '&');
		header("Location: " . RootPath . "Users/Organizations/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/Guardian/Request/index.php?$D"); die();
	}else{
		header("Location: " . DomainName . "/LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();	
	}																				
?>