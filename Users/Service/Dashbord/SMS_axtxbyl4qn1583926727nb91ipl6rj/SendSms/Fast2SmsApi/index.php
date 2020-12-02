<?php
	/*
	*@filename Fast2SmsApi/index.php
	*@des It can send SMS and response (Usinf Fast2Sms sms service)
	*@Author Arpit sharma
	*/
?>
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

		if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
			header("Location: " . DomainName . "/PageNotAvailable/index.php");
			die();
			exit();
		}

		function MsgIdGeneratorForSendSmsByFast2Sms( $length ){
			$RandStr = "";
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
			$size = strlen( $chars ); 
			for( $i = 0; $i < $length; $i++ ) {  
			$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
			} 
			return $RandStr;
		}
		

		function SendSmsByFast2Sms($Data=array()){
			$UsedBy = 'Organization';
			foreach ($Data as $key => $value){
				${$key} = $value;
			}

			$ApiKey = '0CilgRBPSw1y3EdJFcb2mA6xnXTrjaqGkLVYupzeUtDIO9hN749qKCOdISur40peRJti1yQl8YWNcZjE';

			if($PdoMainUserAccountDb == '' || $PdoServiceManage == '' || $EncodeAndEncryptPass == '' || $OrgUrl == '' || $CurrentTime == '' || $SmsBody == '' || $SendTo == '' || $sender_id == '' || $route == '' || $MsgType == '' || $MsgLable == '' || $SendBy == '' || ($UsedBy != 'Organization' && $UsedBy != 'Main')){
				return ["status"=>"Error","msg"=>"Invalid data format send [ SendSmsByFast2Sms ]","code"=>400];
			}

			if($UsedBy == 'Main'){
				if($OrgUrl != 'main'){
					return ["status"=>"Error","msg"=>"Invalid data format send [ SendSmsByFast2Sms ]","code"=>400];
				}
			}

			if($UsedBy != 'Main'){
				if(!function_exists('MsgIdGeneratorForSendSmsByFast2Sms') || !function_exists('InsertGivenData') || !function_exists('AptPdoDeleteWithAes') || !function_exists('AptPdoFetchWithAes') || !function_exists('AptPdoUpdateWithAes') || !function_exists('ServiceUseReport') || !function_exists('CreateDbConnection') || !function_exists('ServiceStatusForOrg')/* || !function_exists('CheckServiceBuyStatus')*/){
		            return ["status"=>"Error","msg"=>"Required function not found","code"=>400];
		        }
			}else{
				if(!function_exists('MsgIdGeneratorForSendSmsByFast2Sms') || !function_exists('InsertGivenData') || !function_exists('AptPdoDeleteWithAes') || !function_exists('AptPdoFetchWithAes') || !function_exists('AptPdoUpdateWithAes') || !function_exists('CreateDbConnection')){
		            return ["status"=>"Error","msg"=>"Required function not found","code"=>400];
		        }
			}
			
			if($UsedBy != 'Main'){
				$SmsServiceBuyStatus = ServiceStatusForOrg(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$OrgUrl,'CurrentTime'=>$CurrentTime]);
				if($SmsServiceBuyStatus['status'] != 'Success' || $SmsServiceBuyStatus['code'] != 200 || $SmsServiceBuyStatus['msg']['IsServiceBuyed'] != True || $SmsServiceBuyStatus['msg']['IsServiceSetUp'] != True){
					return ["status"=>"Error","msg"=>"Service data can not feched! Try again later","code"=>400];
				}
			}

			if($MsgType == 'QuickTransactional'){
				if($variables =='' || $variables_values == '' || $ExtMsg == ''){
					return ["status"=>"Error","msg"=>"Invalid data sent for QuickTransactional MsgType","code"=>400];
				}
				foreach (explode('|', $variables) as $value) {
					$variablesLength = 0;
					if($value != '{#AA#}' && $value != '{#BB#}' && $value != '{#CC#}' && $value != '{#DD#}' && $value != '{#EE#}' && $value != '{#FF#}'){
						return ["status"=>"Error","msg"=>"Invalid data sent for QuickTransactional variables","code"=>400];
					}else{
						if($value == '{#AA#}'){
							$variablesLength += 5;
						}else if($value == '{#BB#}'){
							$variablesLength += 10;
						}else if($value == '{#CC#}'){
							$variablesLength += 15;
						}else if($value == '{#DD#}'){
							$variablesLength += 20;
						}else if($value == '{#EE#}'){
							$variablesLength += 25;
						}else if($value == '{#FF#}'){
							$variablesLength += 30;
						}
					}
				}
				
				foreach (explode('|', $variables_values) as $value){
					$variables_valuesLength = 0;
					if(strlen($value) > 0){
						$variables_valuesLength += strlen($value);
					}
				}

				$ExtMsgLen = strlen($ExtMsg)+10;
				$SmsRequestNo = ceil($ExtMsgLen/160);
				if($SmsRequestNo == 0){
					return ["status"=>"Error","msg"=>"Invalid SmsRequestNo detect","code"=>400];
				}

				$field = array(
				    "sender_id" => $sender_id,
				    "language" => 'english',
				    "route" => $route,
				    "numbers" => $SendTo,
				    "message" => $SmsBody,
				    "variables" => $variables,
				    "variables_values" => $variables_values
				);
			}else if($route == 'BulkSMS'){
				if($language==null){
					return ["status"=>"Error","msg"=>"Invalid data sent for BulkSMS MsgType! Try again","code"=>400];
				}else if(strlen($SmsBody) == 0){
					return ["status"=>"Error","msg"=>"Invalid Msg Body sent for BulkSMS MsgType! Try again","code"=>400];
				}

				$ExtMsg = strlen($SmsBody);
				$ExtMsgLen = strlen($ExtMsg)+10;
				$SmsRequestNo = ceil($ExtMsgLen/160);
				if($SmsRequestNo == 0){
					return ["status"=>"Error","msg"=>"Invalid SmsRequestNo detect","code"=>400];
				}

				$fields = array(
				    "sender_id" => $sender_id,
				    "message" => $SmsBody,
				    "language" => $language,
				    "route" => $route,
				    "numbers" => $SendTo,
				);
			}else{
				return ["status"=>"Error","msg"=>"Invalid route detect","code"=>400];
			}
			
			if($UsedBy != 'Main'){
				$ServiceUseReport = ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$OrgUrl,'RequestNo'=>$SmsRequestNo,'ReqType'=>'Charge']);
				
				if($ServiceUseReport['code'] != 200){
					if($ServiceUseReport['surc'] == 1){
						$ErrorDes = 'Currently service is not active for this organization!';
					}else if($ServiceUseReport['surc'] == 2){
						$ErrorDes = 'Currently service is not active due to Insufficient SMS balance';
						return ["status"=>"Error","msg"=>$ErrorDes,"code"=>400,'surc'=>2];
					}else{
						$ErrorDes = 'Request Not Created due to technical error!';
					}
					return ["status"=>"Error","msg"=>$ErrorDes,"code"=>400];
				}
			}

			$SMSServiceConnectionFast2sms = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_aXTxByL4Qn1583926727NB91IPL6rj');
			if($SMSServiceConnectionFast2sms['status'] === 'Success' && $SMSServiceConnectionFast2sms['code'] === 200){
				$SMSServiceConnectionFast2sms = $SMSServiceConnectionFast2sms['msg'];
			}else{
				return ['status'=>'Error','msg'=>'Database connection failed, due to technical error!',"code"=>400];
			}

			// Create isset time according Asia/Kolkata
			date_default_timezone_set('Asia/Kolkata');
			$ExectCurrentTime = time();

			$Number1 = floor((29 - strlen($ExectCurrentTime))/2);
			$Number2 = (29 - strlen($ExectCurrentTime)) - $Number1;

			while (true) {
				$MsgId = "a".MsgIdGeneratorForSendSmsByFast2Sms($Number1).$CurrentTime.MsgIdGeneratorForSendSmsByFast2Sms($Number2);
				$CheckMsgId = AptPdoFetchWithAes(['Condtion'=> "MsgId::::$MsgId", 'DbCon'=> $SMSServiceConnectionFast2sms, 'TbName'=> $OrgUrl.'_report', 'EPass'=> $EncodeAndEncryptPass]);
				if($CheckMsgId['code'] == 404){
					break;
				}else if($CheckMsgId['code'] == 400){
					return ['status'=>'Error','msg'=>'An technical error occur at MsgId create time',"code"=>400];
					break;
				}
			}

			$InsertMsgReport = InsertGivenData("Status::::Sent::,::MsgId::::$MsgId::,::SendTime::::$ExectCurrentTime::,::MsgLength::::$ExtMsgLen::,::MsgCount::::$SmsRequestNo::,::SendTo::::$SendTo::,::MsgBody::::$ExtMsg::,::SendBy::::$SendBy::,::MsgType::::$MsgType::,::MsgLable::::$MsgLable::,::MsgSendByService::::Fast2Sms",$SMSServiceConnectionFast2sms,$OrgUrl.'_report',$EncodeAndEncryptPass);
			if($InsertMsgReport['status'] != 'Success' || $InsertMsgReport['code'] != 200){
				ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$OrgUrl,'RequestNo'=>$SmsRequestNo,'ReqType'=>'Refund']);
				return ['status'=>'Error','msg'=>'Msg data not insert due to technical error',"code"=>400];
			}

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($field),
				CURLOPT_HTTPHEADER => array(
				"authorization: $ApiKey",
				"cache-control: no-cache",
				"accept: */*",
				"content-type: application/json"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			$ResponseObj = json_decode($response);
			curl_close($curl);
			if ($err) {
				if($UsedBy != 'Main'){
					ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$OrgUrl,'RequestNo'=>$SmsRequestNo,'ReqType'=>'Refund']);
				}
				AptPdoDeleteWithAes(['Condtion'=> "MsgId::::$MsgId",'DbCon'=> $SMSServiceConnectionFast2sms, 'TbName'=> $OrgUrl.'_report', 'EPass'=> $EncodeAndEncryptPass]);
				if($err == 'Could not resolve host: www.fast2sms.com'){
					return ["status"=>"Error","msg"=>"Message not send due to techncal error Code - 1",'F2SC'=>400,"code"=>400];
				}
				return ["status"=>"Error","msg"=>"Message not send due to techncal error Code - 1","code"=>400];
			} else if(json_decode($response)->return == true) {
				$AptPdoUpdateWithAes = AptPdoUpdateWithAes(['Update'=>"MsgServiceId::::Fast2Sms&".$ResponseObj->request_id,'Condtion'=>"MsgId::::$MsgId",'DbCon'=>$SMSServiceConnectionFast2sms,'TbName'=>$OrgUrl.'_report','EPass'=>$EncodeAndEncryptPass]);
				$GetSmsReport = AptPdoFetchWithAes(['AcceptNullCondtion'=>true, 'DbCon'=> $SMSServiceConnectionFast2sms, 'TbName'=> $OrgUrl.'_report', 'EPass'=> $EncodeAndEncryptPass]);
				if($GetSmsReport['code'] == 200){
					if($GetSmsReport['totalrows'] > 50){
						$TempLimit = $GetSmsReport['totalrows'] - 50;
						$AptPdoDeleteWithAes = AptPdoDeleteWithAes(['AcceptNullCondtion'=>true,'DbCon'=> $SMSServiceConnectionFast2sms, 'TbName'=> $OrgUrl.'_report', 'EPass'=> $EncodeAndEncryptPass,'DataOrder'=> 'ASC|SendTime','Limit'=>$TempLimit]);
					}
				}
				return ["status"=>"Success","msg"=>"Message send successfully",'SmsProviderResponse'=>json_decode($response)->message,"code"=>200];
			}else{
				if($UsedBy != 'Main'){
					ServiceUseReport(['PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'ServiceCode'=>'aXTxByL4Qn1583926727NB91IPL6rj','EPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$OrgUrl,'RequestNo'=>$SmsRequestNo,'ReqType'=>'Refund']);
				}
				AptPdoDeleteWithAes(['Condtion'=> "MsgId::::$MsgId",'DbCon'=> $SMSServiceConnectionFast2sms, 'TbName'=> $OrgUrl.'_report', 'EPass'=> $EncodeAndEncryptPass]);
				return ["status"=>"Error","msg"=>"Message not send due to techncal error Code - 2",'reason'=>json_decode($response)->status_code,"code"=>400];
			}

		} 
?>
