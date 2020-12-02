<?php
    
    error_reporting(0);
    // Get server port type (exampale - http:// or https://)
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
        $HeaderSecureType = "https://";
    }else{
        $HeaderSecureType = "http://";
    }
    // Create Domain name and save it in const variable
    define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);

    if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
        header("Location: " . DomainName . "/PageNotAvailable/index.php");
        die();
        exit();
    }

    function AvailableOnePlanActiveForServiceUseReport($DataForActiveAvailablePlan = array()){
        foreach ($DataForActiveAvailablePlan as $key=>$value){
            ${ $key } = $value;
        }

        date_default_timezone_set('Asia/Kolkata');
        $CurrentTime = time();

        if($PdoMainUserAccountDb == '' || $PdoServiceManage == '' || $ServiceCode == '' || $EPass == '' || $OrgUrl == '' || $CurrentTime == '' || $CurrentTime != preg_replace("/[^0-9]/","",$CurrentTime)){
            return ["status"=>"Error","msg"=>"Invalid Data format detect [ Service Status Use Report ]","code"=>400,'AAPC'=>0];
        }

        $GetAvailablePlan = AptPdoFetchWithAes(['Condtion'=> "ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl::,::PaymentStatus::::Paid::,::Priority::::null::::NotEqual", 'FetchData'=>'Status::::TransferStatus::::BuyId::::Priority::::VldPlnReqNo::::VldPlnValidity::::NVldPlnReqNo', 'DbCon'=> $PdoServiceManage, 'TbName'=> 'service_buy_for_feature_record', 'EPass'=> $EPass,'DataOrder'=>'ASC|Priority']);

        if($GetAvailablePlan['code'] != 200 && $GetAvailablePlan['code'] != 404){
            return ["status"=>"Error","msg"=>"Available plan not fetch due to an technical error occur [ Service Status Use Report ]","code"=>400,'AAPC'=>1];
        }else if($GetAvailablePlan['code'] == 404){
            return ["status"=>"Error","msg"=>"There is no plan fount for auto active [ Service Status Use Report ]","code"=>404,'AAPC'=>2];
        }else if($GetAvailablePlan['msg']->Status != 'Active'){
            return ["status"=>"Error","msg"=>"Plan for auto update is not active by organization [ Service Status Use Report ]","code"=>404,'AAPC'=>3];
        }else if($GetAvailablePlan['msg']->TransferStatus != 'ready'){
             return ["status"=>"Error","msg"=>"Plan Transfer Status not ready so please resolve it to auto active plan [ Service Status Use Report ]","code"=>404,'AAPC'=>4];
        }
        
        $NextNVldPlnReqNo = $GetAvailablePlan['msg']->NVldPlnReqNo;
        $NextVldPlnReqNo = $GetAvailablePlan['msg']->VldPlnReqNo;
        if($GetAvailablePlan['msg']->VldPlnValidity == 0){
            $NextVldPlnValidity = $GetAvailablePlan['msg']->VldPlnValidity;
        }else{
            $NextVldPlnValidity = $GetAvailablePlan['msg']->VldPlnValidity + $CurrentTime;
        }
        $NextBuyId = $GetAvailablePlan['msg']->BuyId;
        $NextPriority = $GetAvailablePlan['msg']->Priority;

        if($NextBuyId == ''){
            return ["status"=>"Error","msg"=>"Invalid buy id detect [ Service Status Use Report ]","code"=>400,'AAPC'=>4];
        }else if($NextPriority == ''){
            return ["status"=>"Error","msg"=>"Inavlid Priority no detect [ Service Status Use Report ]","code"=>400,'AAPC'=>5];
        }

        if($NextPriority != 1){
            if($NextPriority > 0){
                $TempPriorityStr = "Priority::::$NextPriority::::decrement";
            }else if($NextPriority < 0){
                $TempPriority = (0 - $NextPriority);
                $TempPriorityStr = "Priority::::$TempPriority::::increment";
            }else{
                $TempPriorityStr = false;
            }
        }
        
        $GetCurrentPlnDtls = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EPass,'OrgUrl'=>$OrgUrl,'CurrentTime'=>$CurrentTime]);
        if($GetCurrentPlnDtls['code'] != 200){
            return ["status"=>"Error","msg"=>"Service Status Can not be feched [ Service Status Use Report ]","code"=>400,'AAPC'=>6];
        }

        $PreNVldPlnReqNo = $GetCurrentPlnDtls['msg']['CurrentNVldPlnReqNo'];
        $PreVldPlnReqNo = $GetCurrentPlnDtls['msg']['CurrentVldPlnReqNo'];
        $PreVldPlnValidity = $GetCurrentPlnDtls['msg']['CurrentVldPlnValidity'];
        $PrePlanUpdateDate = $GetCurrentPlnDtls['msg']['CurrentPlanUpdateDate'];
        $PreBuyId = $GetCurrentPlnDtls['msg']['CurrentBuyId'];

        $UpdateNewPlanInBuyService = AptPdoUpdateWithAes(['Update'=>"BuyId::::$NextBuyId::,::VldPlnReqNo::::$NextVldPlnReqNo::,::VldPlnValidity::::$NextVldPlnValidity::,::NVldPlnReqNo::::$NextNVldPlnReqNo::,::PlanUpdateDate::::$CurrentTime",'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_record','EPass'=>$EPass]);
        if($UpdateNewPlanInBuyService['code'] != 200){
            return ["status"=>"Error","msg"=>"Plan can not update in buy record due to a technical error [ Service Status Use Report ]","code"=>400,'AAPC'=>7];
        }

        if($TempPriorityStr != false){
            $UpdateAvailablePlanPriority = AptPdoUpdateWithAes(['Update'=>$TempPriorityStr,'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl::,::PaymentStatus::::Paid::,::Priority::::null::::NotEqual",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_for_feature_record','EPass'=>$EPass]);
            if($UpdateAvailablePlanPriority['code'] != 200){
                $UpdateNewPlanInBuyService = AptPdoUpdateWithAes(['Update'=>"BuyId::::$PreBuyId::,::VldPlnReqNo::::$PreVldPlnReqNo::,::VldPlnValidity::::$PreVldPlnValidity::,::NVldPlnReqNo::::$PreNVldPlnReqNo::,::PlanUpdateDate::::$CurrentTime",'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_record','EPass'=>$EPass]);
                if($UpdateNewPlanInBuyService['code'] != 200){
                    AptPdoDeleteWithAes(['Condtion'=> "BuyId::::$NextBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=>'service_buy_for_feature_record', 'EPass'=> $EPass]);
                }
                return ["status"=>"Error","msg"=>"Plan can not update in buy record due to a technical error [ Service Status Use Report ]","code"=>400,'AAPC'=>8];
            }
        }
        
        $DeleteUsedPlanFromBuyForFeature = AptPdoDeleteWithAes(['Condtion'=> "BuyId::::$NextBuyId", 'DbCon'=> $PdoServiceManage, 'TbName'=>'service_buy_for_feature_record', 'EPass'=> $EPass]);

        if($DeleteUsedPlanFromBuyForFeature['code'] != 200){
            $UpdateNewPlanInBuyService = AptPdoUpdateWithAes(['Update'=>"BuyId::::$PreBuyId::,::VldPlnReqNo::::$PreVldPlnReqNo::,::VldPlnValidity::::$PreVldPlnValidity::,::NVldPlnReqNo::::$PreNVldPlnReqNo::,::PlanUpdateDate::::$CurrentTime",'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_record','EPass'=>$EPass]);
            $UpdateAvailablePlanPriority = AptPdoUpdateWithAes(['Update'=>"Priority::::1::::increment",'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_for_feature_record','EPass'=>$EPass]);
            return ["status"=>"Error","msg"=>"Plan can not update in buy record due to a technical error [ Service Status Use Report ]","code"=>400,'AAPC'=>9];
        }
        return ["status"=>"Success","msg"=>"Plan Successfully Active [ Service Status Use Report ]","code"=>200,'AAPC'=>10];
    }
    
    function ServiceUseReport($Data = array()){
        date_default_timezone_set('Asia/Kolkata');
        $CurrentTime = time(); $RequestNo = 1; $ReqType = 'Charge';

        foreach ($Data as $key=>$value){
            ${ $key } = $value;
        }

        if($PdoMainUserAccountDb == '' || $PdoServiceManage == '' || $ServiceCode == '' || $EPass == '' || $OrgUrl == '' || $CurrentTime == '' || $CurrentTime != preg_replace("/[^0-9]/","",$CurrentTime) || $RequestNo <= 0 || $RequestNo != preg_replace("/[^0-9]/","",$RequestNo) || ($ReqType != 'Charge' && $ReqType != 'Refund')){
            return ["status"=>"Error","msg"=>"Invalid Data format detect [ Service Status Use Report ]","code"=>400,'surc'=>0];
        }

        if(!function_exists('AvailableOnePlanActiveForServiceUseReport') || !function_exists('AptPdoDeleteWithAes') || !function_exists('AptPdoFetchWithAes') || !function_exists('AptPdoUpdateWithAes') || !function_exists('CreateDbConnection') || !function_exists('ServiceStatusForOrg')){
            return ["status"=>"Error","msg"=>"Required function not found [ Service Status Use Report ]","code"=>400,'surc'=>0];
        }

        while (true) {
            $ServiceStatusForOrg = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EPass,'OrgUrl'=>$OrgUrl,'CurrentTime'=>$CurrentTime]);
            if($ServiceStatusForOrg['code'] != 200){
                return ["status"=>"Error","msg"=>"Service Status Can not be feched [ Service Status Use Report ]","code"=>400,'surc'=>0]; break;
            }
            
            if($ServiceStatusForOrg['msg']['IsServiceBuyed'] != true || $ServiceStatusForOrg['msg']['IsServiceSetUp'] != true || $ServiceStatusForOrg['msg']['IsServiceStatusActive'] != true){
                return ["status"=>"Error","msg"=>"Currently service Can not active for this organization [ Service Status Use Report ]","code"=>404,'surc'=>1]; break;
            }

            $NeedUpdateOnServiceReport = true;
            if($ReqType == 'Charge'){
                if($ServiceStatusForOrg['msg']['CurrentUsablePlnReqNo'] !== 'Unlimited'){
                    if($ServiceStatusForOrg['msg']['Validity'] >= $CurrentTime || $ServiceStatusForOrg['msg']['Validity'] == 'Unlimited'){
                        if($ServiceStatusForOrg['msg']['CurrentUsablePlnReqNo'] < $RequestNo){
                            $AvailableOnePlanActiveForServiceUseReport =  AvailableOnePlanActiveForServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EPass,'OrgUrl'=>$OrgUrl]);
                            if($AvailableOnePlanActiveForServiceUseReport['AAPC'] != 8 && $AvailableOnePlanActiveForServiceUseReport['AAPC'] != 10){
                                return ["status"=>"Error","msg"=>"Insufficient plan balance detect, please recharge for process this request [ Service Status Use Report ]","code"=>404,'surc'=>2]; break;
                            }else{
                                continue;
                            }
                        }else{
                            $NeedUpdateOnServiceReport = true;
                        }

                        if($ServiceStatusForOrg['msg']['CurrentNVldPlnReqNo'] >= $RequestNo){
                            $Update = "NVldPlnReqNo::::$RequestNo::::decrement::,::TotalRequest::::$RequestNo::::increment";
                        }else if($ServiceStatusForOrg['msg']['CurrentVldPlnReqNo'] >= $RequestNo){
                            $Update = "VldPlnReqNo::::$RequestNo::::decrement::,::TotalRequest::::$RequestNo::::increment";
                        }else{
                            return ["status"=>"Error","msg"=>"Currently this feature not available [ Service Status Use Report ]","code"=>404,'surc'=>-1]; break;
                        }
                    }else{
                        $AvailableOnePlanActiveForServiceUseReport =  AvailableOnePlanActiveForServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EPass,'OrgUrl'=>$OrgUrl]);
                        if($AvailableOnePlanActiveForServiceUseReport['AAPC'] != 8 && $AvailableOnePlanActiveForServiceUseReport['AAPC'] != 10){
                            return ["status"=>"Error","msg"=>"Insufficient plan balance detect, please recharge for process this request [ Service Status Use Report ]","code"=>404,'surc'=>2]; break;
                        }else{
                            continue;
                        }
                    }
                }else if($ServiceStatusForOrg['msg']['Validity'] >= $CurrentTime && $ServiceStatusForOrg['msg']['CurrentUsablePlnReqNo'] === 'Unlimited'){
                    $NeedUpdateOnServiceReport = false;
                    $Update = "TotalRequest::::$RequestNo::::increment";
                }else{
                    $AvailableOnePlanActiveForServiceUseReport =  AvailableOnePlanActiveForServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>$ServiceCode,'EPass'=>$EPass,'OrgUrl'=>$OrgUrl]);
                    if($AvailableOnePlanActiveForServiceUseReport['AAPC'] != 8 && $AvailableOnePlanActiveForServiceUseReport['AAPC'] != 10){
                        return ["status"=>"Error","msg"=>"Insufficient plan balance detect, please recharge for process this request [ Service Status Use Report ]","code"=>404,'surc'=>2]; break;
                    }else{
                        continue;
                    }
                }
            }else{
                if($ServiceStatusForOrg['msg']['CurrentUsablePlnReqNo'] !== 'Unlimited'){
                    $NeedUpdateOnServiceReport = true;
                    if($ServiceStatusForOrg['msg']['Validity'] !== 'Unlimited'){
                       $Update = "VldPlnReqNo::::$RequestNo::::increment::,::TotalRequest::::$RequestNo::::decrement";
                    }else{
                        $Update = "NVldPlnReqNo::::$RequestNo::::increment::,::TotalRequest::::$RequestNo::::decrement";
                    }
                }else{
                    $NeedUpdateOnServiceReport = false;
                    $Update = "TotalRequest::::$RequestNo::::decrement";
                }
            }
            break;
        }
        
        if($NeedUpdateOnServiceReport == true){
            $UpdateServiceUseReport = AptPdoUpdateWithAes(['Update'=>$Update,'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_record','EPass'=>$EPass]);
            if($UpdateServiceUseReport['code'] == 200){
                return ["status"=>"Success","msg"=>"Your $ReqType request execute successfully Code -1 [ Service Status Use Report ]","code"=>200,'surc'=>200];
            }else{
                return ["status"=>"Error","msg"=>"Your  $ReqType request execution failed [ Service Status Use Report ]","code"=>404,'reason'=>json_encode($UpdateServiceUseReport),'surc'=>400];
            }
        }else{
            $UpdateServiceUseReport = AptPdoUpdateWithAes(['Update'=>$Update,'Condtion'=>"ServiceCode::::$ServiceCode::,::Organization::::$OrgUrl",'DbCon'=>$PdoServiceManage,'TbName'=>'service_buy_record','EPass'=>$EPass]);
            return ["status"=>"Success","msg"=>"Your $ReqType request execute successfully Code -2 [ Service Status Use Report ]","code"=>200,'surc'=>200];
        }
	}
?>