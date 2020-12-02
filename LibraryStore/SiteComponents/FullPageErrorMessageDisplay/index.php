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

	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
	}
	function FullPageErrorMessageDisplay($msg,$exit=true,$style=array()){
		$textalign='center'; $position='fixed'; $padding='0px'; $margin='0px'; $top='0px'; $right='0'; $bottom='0'; $left='0';
		$MSGtextalign='center'; $MSGpadding='0px'; $MSGmargin='0px'; $MSGColor='#fff';
		foreach ($style as $key => $value) {
			$$key = $value;
		}
		echo "<div style='width:100vw; height:100vh; background: #224579 !important; font-size: 20px; font-weight: bold; position: ".$position."; padding: ".$padding."; margin: ".$margin."; top: ".$top."; right: ".$right."; bottom: ".$bottom."; left: ".$left."; text-align: ".$textalign."'>
			<p style='color:".$MSGColor."; font-size: 20px; font-weight: bold; padding: ".$MSGpadding."; margin: ".$MSGmargin."; text-align: ".$MSGtextalign.";'> $msg </p>
		</div>";
		if($exit == true){
			exit();
		}
	}
?>