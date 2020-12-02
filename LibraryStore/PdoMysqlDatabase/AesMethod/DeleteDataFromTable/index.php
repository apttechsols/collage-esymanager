<?php
	/*

	*@filename DeleteDataFromTable/index.php
	*@des It return succees status if Data alredy exixt
	*@Author Arpit sharma
	*/

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
			exit();
		}

		function DeleteDataFromTable($GivenConditionData,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass, $NullValueSupport=false,$ConditionType='Equal', $ConditionFor='all',$AllRowDataEffected=false){
			if(strlen($GivenConditionData) == 0 && $AllRowDataEffected==false){
				return ["status"=>"Error","msg"=>"Process failed! Try again later1"]; exit();
			}
			
			
			$GivenConditionData = explode("::,::",$GivenConditionData);
			$StmtGivenDataKey = array();
			$StmtGivenDataVal = array();
			if($ConditionType === 'Equal'){
				$ConditionType = '=';
			}else if($ConditionType === 'NotEqual'){
				$ConditionType = '!=';
			}else{
				 return ["status"=>"Error","msg"=>"Process failed! Try again later2","code"=>400]; exit();
			}

			if($ConditionFor ==='all'){
				$ConditionFor = '&&';
			}else if ($ConditionFor ==='any') {
				$ConditionFor = '||';
			}else{
				 return ["status"=>"Error","msg"=>"Process failed! Try again later3","code"=>400]; exit();
			}
			$i = 0;
			foreach ($GivenConditionData as $value) {
				$i++;
				if(strpos($value, "::::") != false || $NullValueSupport=true){
				   $TmpGivenConditionData = explode("::::",$value);
				} else{
				   return ["status"=>"Error","msg"=>"Process failed! Try again later4","code"=>400]; exit();
				}
				
				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpGivenConditionData[0]) != ""){
					if(preg_replace("/^[ ]/","",$TmpGivenConditionData[1]) != "" || $NullValueSupport === true){
						if($i === 1){
							$StmtCondtionKey = $TmpGivenConditionData[0].' '.$ConditionType.' AES_ENCRYPT(:'.$TmpGivenConditionData[0].', :EncodeAndEncryptPass)';
						}else{
							$StmtCondtionKey = $StmtCondtionKey.' '.$ConditionFor.' '.$TmpGivenConditionData[0].' '.$ConditionType. ' AES_ENCRYPT(:'.$TmpGivenConditionData[0].', :EncodeAndEncryptPass)';
						}
						array_push($StmtGivenDataKey, $TmpGivenConditionData[0]);
						array_push($StmtGivenDataVal, $TmpGivenConditionData[1]);
					}
				}else{
					return ["status"=>"Error","msg"=>"Process failed! Try again later5","code"=>400];
				}
			}

			if(isset($DatabaseConnection) && isset($DbTableName) && isset($StmtCondtionKey) && isset($StmtGivenDataKey) && isset($StmtGivenDataVal) && isset($EncodeAndEncryptPass)){

				// Check and remove user if account created but Status is pending
				$stmt = $DatabaseConnection->prepare("DELETE FROM $DbTableName WHERE $StmtCondtionKey");
				$stmt->bindValue(":EncodeAndEncryptPass", $EncodeAndEncryptPass, PDO::PARAM_STR);
				$i = 0;
				foreach ($StmtGivenDataVal as $value) {
					$stmt->bindValue(":".$StmtGivenDataKey[$i] , $value, PDO::PARAM_STR);
					$i++;
				}

				if($stmt->execute()){
					if($stmt->rowCount() > 0){
						return ["status"=>"Success","msg"=>'Delete Data successfully',"code"=>200];
					}else{
						return ["status"=>"Error","msg"=>'Given Conditions Not Match for deleting data',"code"=>204];
					}
				}else{
					return ["status"=>"Error","msg"=>"Data Not deleted Or Given Column not found",'reason'=>json_encode($stmt->errorinfo()),"code"=>404];
				}
			}else{
				return ["status"=>"Error","msg"=>"Process failed! Try again later6","code"=>400];
			}
		}
?>