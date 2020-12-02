<?php
	/*

	*@filename CheckServiceBuyStatus/index.php
	*@Author Arpit sharma
	*/

	// Not show any error
	error_reporting(0);
	if(!DomainName){
		// Get server port type (exampale - http:// or https://)
		if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
			$HeaderSecureType = "https://";
		}else{
			$HeaderSecureType = "http://";
		}
		// Create Domain name and save it in const variable
		define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
	}
	
	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
		exit();
	}

	function CheckServiceBuyStatus($ServiceCode,$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LFR,$CurrentTime){
		if(strlen($ServiceCode) == 0 || $ServiceCode != preg_replace("/[^A-Za-z0-9]/","",$ServiceCode) || !isset($EncodeAndEncryptPass) || !isset($LFR) || !isset($PdoServiceManage) || !isset($PdoMainUserAccountDb) || strlen($LFR) != 30 || !function_exists('CheckGivenDataAvailability') || !function_exists('FetchReuiredDataByGivenData') || !function_exists('CreateDbConnection')){
			return ["status"=>"Error","msg"=>"Process failed! Try again later 1.0","code"=>400];
		}

		if(!function_exists('get_string_between')){
			function get_string_between($string, $start, $end){
			    $string = ' ' . $string;
			    $ini = strpos($string, $start);
			    if ($ini == 0) return '';
			    $ini += strlen($start);
			    $len = strpos($string, $end, $ini) - $ini;
			    return substr($string, $ini, $len);
			    //Use -> get_string_between($fullstring, '[tag]', '[/tag]');
			}
		}

		$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.$ServiceCode);
		if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
			$DbConnection = $DbConnection['msg'];
		}else{
			return ['status'=>'Error','msg'=>'Database connection failed!',"code"=>400];
		}

		$Response = $DbConnection->query("SHOW TABLES LIKE '".$LFR."_%'");
		if($Response->rowCount() > 0){
			$ServiceRegister = True;
		}else{
			$ServiceRegister = False;
		}
		
		$ResponseBuyRecord = FetchReuiredDataByGivenData("Organization::::$LFR::,::ServiceCode::::$ServiceCode::,::ServiceAndOrganization::::".$ServiceCode.'_'.$LFR,'Status::::SetupStatus::::VldPlnReqNo::::VldPlnValidity::::NVldPlnReqNo::::TotalRequest::::StartTime::::ExpTime::::ServiceVersion',$PdoServiceManage,"service_buy_record",$EncodeAndEncryptPass,'all');
		
		if($ResponseBuyRecord['status'] === 'Success' && $ResponseBuyRecord['code'] === 200){
			$ServiceBuy = True;
			$ServiceBuyDetails = $ResponseBuyRecord['msg'];
		}else{
			$ServiceBuy = False;
			$ServiceBuyDetails = '';
			$IsServiceActiveted = False;
		}

		if($ServiceBuy == True){
			if(((($ResponseBuyRecord['msg']->VldPlnReqNo > 0 || $ResponseBuyRecord['msg']->VldPlnReqNo == 'Unlimited') && $ResponseBuyRecord['msg']->VldPlnValidity >= $CurrentTime) || $ResponseBuyRecord['msg']->NVldPlnReqNo > 0) && $ResponseBuyRecord['msg']->Status == 'Active' && $ResponseBuyRecord['msg']->SetupStatus == 'Active'){
				$IsServiceActiveted = true; 
			}else{
				$IsServiceActiveted = false; 
			}
			if($ResponseBuyRecord['msg']->VldPlnValidity == 0){
				$CurrentUsablePlnReqNo = $ResponseBuyRecord['msg']->NVldPlnReqNo;
				$Validity = 'Unlimited';
			}else{
				$CurrentUsablePlnReqNo = $ResponseBuyRecord['msg']->VldPlnReqNo;
				$Validity = $ResponseBuyRecord['msg']->VldPlnValidity;
			}
		}

		return ["status"=>"Success","msg"=>array('ServiceRegister'=>$ServiceRegister,'ServiceBuy'=>$ServiceBuy,'ServiceBuyDetails'=>$ServiceBuyDetails,'IsServiceActiveted'=>$IsServiceActiveted,'CurrentUsablePlnReqNo'=>$CurrentUsablePlnReqNo,'Validity'=>$Validity,'IsUpdateAvailable'=>False),'code'=>200];
	}
?>