<?php
	/*

	*@filename ServiceStatusForOrg/index.php
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

	function ServiceStatusForOrg($Data = array()){
		// Create isset time according Asia/Kolkata
		date_default_timezone_set('Asia/Kolkata');
		$CurrentTime = time();

		foreach ($Data as $key=>$value){
			${ $key } = $value;
		}
		
		if($PdoMainUserAccountDb == '' || $PdoServiceManage == '' || $ServiceCode == '' || $EPass == '' || $OrgUrl == '' || $CurrentTime == '' || $CurrentTime != preg_replace("/[^0-9]/","",$CurrentTime)){
			return ["status"=>"Error","msg"=>"Invalid Data format detect [ Service Status For Org ]","code"=>400];
		}

		if(!function_exists('AptPdoFetchWithAes') || !function_exists('CreateDbConnection')){
			return ["status"=>"Error","msg"=>"Required function not found [ Service Status For Org ]","code"=>400];
		}

		$ServiceStatusForOrgDbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.$ServiceCode);
		if($ServiceStatusForOrgDbConnection['status'] === 'Success' && $ServiceStatusForOrgDbConnection['code'] === 200){
			$ServiceStatusForOrgDbConnection = $ServiceStatusForOrgDbConnection['msg'];
		}else{
			return ['status'=>'Error','msg'=>'Database connection failed, due to technical error!',"code"=>400];
		}
		
		$GetServiceBuyDtls = AptPdoFetchWithAes(['Condtion'=> "ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl", 'FetchData'=>'Status::::SetupStatus::::ServiceMember::::VldPlnReqNo::::VldPlnValidity::::NVldPlnReqNo::::TotalRequest', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_record', 'EPass'=> $EPass]);

		$GetSetUpDtlsByTblName = $ServiceStatusForOrgDbConnection->query("SHOW TABLES LIKE '".$OrgUrl."_%'");

		if($GetServiceBuyDtls['code'] == 200){ $IsServiceBuyed = true; }else{ $IsServiceBuyed = false; }
		if($GetSetUpDtlsByTblName->rowCount() > 0 && $GetServiceBuyDtls['msg']->SetupStatus == 'Active'){ $IsServiceSetUp = true; }else{ $IsServiceSetUp = false; }
		
		if($GetServiceBuyDtls['msg']->Status == 'Active'){ $IsServiceStatusActive = true; }
		if((($GetServiceBuyDtls['msg']->VldPlnReqNo > 0 || $GetServiceBuyDtls['msg']->VldPlnReqNo == 'Unlimited') && $GetServiceBuyDtls['msg']->VldPlnValidity >= $CurrentTime) || $GetServiceBuyDtls['msg']->NVldPlnReqNo > 0){
			$IsServiceRecharged = true; 
		}else{
			$IsServiceRecharged = false; 
		}
		if($GetServiceBuyDtls['msg']->VldPlnValidity == 0){
			$CurrentUsablePlnReqNo = $GetServiceBuyDtls['msg']->NVldPlnReqNo;
			$Validity = 'Unlimited';
		}else{
			$CurrentUsablePlnReqNo = $GetServiceBuyDtls['msg']->VldPlnReqNo;
			$Validity = $GetServiceBuyDtls['msg']->VldPlnValidity;
		}

		$CurrentNVldPlnReqNo = $GetServiceBuyDtls['msg']->NVldPlnReqNo;
		$CurrentVldPlnReqNo = $GetServiceBuyDtls['msg']->VldPlnReqNo;
		$CurrentVldPlnValidity = $GetServiceBuyDtls['msg']->VldPlnValidity;
		$CurrentPlanUpdateDate = $GetServiceBuyDtls['msg']->PlanUpdateDate;
		$CurrentBuyId = $GetServiceBuyDtls['msg']->BuyId;
		$TotalUsedRequest = $GetServiceBuyDtls['msg']->TotalRequest;

		if($IsServiceBuyed == true){
			return ["status"=>"Success","msg"=>array('IsServiceBuyed'=>$IsServiceBuyed,'IsServiceSetUp'=>$IsServiceSetUp,'IsServiceStatusActive'=>$IsServiceStatusActive,'IsServiceRecharged'=>$IsServiceRecharged,'CurrentUsablePlnReqNo'=>$CurrentUsablePlnReqNo,'Validity'=>$Validity,'CurrentNVldPlnReqNo'=>$CurrentNVldPlnReqNo,'CurrentVldPlnReqNo'=>$CurrentVldPlnReqNo,'CurrentVldPlnValidity'=>$CurrentVldPlnValidity,'CurrentPlanUpdateDate'=>$CurrentPlanUpdateDate,'CurrentBuyId'=>$CurrentBuyId,'TotalUsedRequest'=>$TotalUsedRequest),'code'=>200];
		}else{
			return ["status"=>"Success","msg"=>array('IsServiceBuyed'=>false,'IsServiceSetUp'=>false,'IsServiceStatusActive'=>false,'IsServiceRecharged'=>false,'CurrentUsablePlnReqNo'=>0,'Validity'=>0,'CurrentNVldPlnReqNo'=>0,'CurrentVldPlnReqNo'=>0,'CurrentVldPlnValidity'=>0,'CurrentPlanUpdateDate'=>0,'CurrentBuyId'=>0,'TotalUsedRequest'=>0),'code'=>200];
		}
	}
?>