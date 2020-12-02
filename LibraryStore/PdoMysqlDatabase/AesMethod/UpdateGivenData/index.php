<?php
	/*

	*@filename InsertGivenData/index.php
	*@des It return Available if Data alredy exixt
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

		function UpdateGivenData($GivenData,$Conditions,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass,$CheckFor = 'all',$AcceptNullCondtion=false,$Limit=null,$SettingArray=array()){
			$SettingKeyAcceptNullGivenData = false;
			foreach ($SettingArray as $key => $value) {
				${'SettingKey' . $key} = $value;
			}
			if(strlen($GivenData) == 0){
				return ["status"=>"Error","msg"=>"Process failed! Try again later 1.0","code"=>400];
			}

			if($Limit != preg_replace("/[^0-9]/","",$Limit) && $Limit != null){
				return ["status"=>"Error","msg"=>"Limit contain invalid character","code"=>400];
			}else if($Limit <= 0 && $Limit != null){
				return ["status"=>"Error","msg"=>"Limit must be grater then 0","code"=>400];
			}
			
			$GivenDataArray = explode("::,::",$GivenData);
			$StmtGivenDataKey = array();
			$StmtGivenDataVal = array();
			$i = 0;
			foreach ($GivenDataArray as $value) {
				if($value == ''){
					return ["status"=>"Error","msg"=>"Invalid Update data detect","code"=>400];
				}
				$i++;
				
				if(strpos($value, "::::") !== false || $SettingKeyAcceptNullGivenData == true){
				   $TmpGivenDataArray = explode("::::",$value);
				} else{
				   return ["status"=>"Error","msg"=>"Process failed! Try again later 1.1","code"=>400];
				}
				
				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpGivenDataArray[0]) !== ""){
					if(preg_replace("/^[ ]/","",$TmpGivenDataArray[1]) !== "" || $SettingKeyAcceptNullGivenData == true){
						if($i === 1){
							$UpdateString = $TmpGivenDataArray[0] . ' = AES_ENCRYPT(:'.$TmpGivenDataArray[0].'Data, :EncodeAndEncryptPass)';
						}else{
							$UpdateString = $UpdateString.', '.$TmpGivenDataArray[0] . ' = AES_ENCRYPT(:'.$TmpGivenDataArray[0].'Data, :EncodeAndEncryptPass)';
						}
						array_push($StmtGivenDataKey, $TmpGivenDataArray[0].'Data');
						if(preg_replace("/^[ ]/","",$TmpGivenDataArray[1]) == ''){
							array_push($StmtGivenDataVal, null);
						}else{
							array_push($StmtGivenDataVal, $TmpGivenDataArray[1]);
						}
					}else{
						return ["status"=>"Error","msg"=>"You can not use null value without AcceptNullGivenData","code"=>400];
					}
				}else{
					return ["status"=>"Error","msg"=>"You can not use null column name","code"=>400];
				}
			}
			
			$ConditionsArray = explode("::,::",$Conditions);
			//return_response($ConditionsArray);
			$ConditionsDataKey = array();
			$ConditionsDataVal = array();
			$i = 0;
			foreach ($ConditionsArray as $value) {
				$i=$i+1;

				if(strpos($value, "::::") !== false || $AcceptNullCondtion === true){
				   $TmpGivenDataArray = explode("::::",$value);
				}else{
				   return ["status"=>"Error","msg"=>"Process failed! Try again later 2.0","code"=>400];
				}

				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpGivenDataArray[0]) !== ""){
					if(preg_replace("/^[ ]/","",$TmpGivenDataArray[1]) !== "" || $AcceptNullCondtion === true){
						if($CheckFor === 'all'){
							$TempConnector = '&&';
						}else if($CheckFor === 'any'){
							$TempConnector = '||';
						}else{
							return ["status"=>"Error","msg"=>"Process failed! Try again later 3.0","code"=>400];
						}

						if($i === 1){
							if($TmpGivenDataArray[1] == ''){
								$UpdateCondition = $TmpGivenDataArray[0]." is null";
							}else if($TmpGivenDataArray[1] === 'NullAndNothing'){
								$UpdateCondition = $TmpGivenDataArray[0]." = ''";
							}else{
								$UpdateCondition = $TmpGivenDataArray[0] .' = AES_ENCRYPT(:'.$TmpGivenDataArray[0].'Cnd, :EncodeAndEncryptPass)';
							}
						}else{
							if($TmpGivenDataArray[1] == ''){
								$UpdateCondition = $UpdateCondition.' '.$TempConnector.' '.$TmpGivenDataArray[0]." is null";
							}else if($TmpGivenDataArray[1] === 'NullAndNothing'){
								$UpdateCondition = $TmpGivenDataArray[0]." = ''";
							}else{
								$UpdateCondition = $UpdateCondition.' '.$TempConnector.' '.$TmpGivenDataArray[0] .' = AES_ENCRYPT(:'.$TmpGivenDataArray[0].'Cnd, :EncodeAndEncryptPass)';
							}
						}

						if($TmpGivenDataArray[1] != '' && $TmpGivenDataArray[1] != 'NullAndNothing'){
							array_push($ConditionsDataKey, $TmpGivenDataArray[0].'Cnd');
							array_push($ConditionsDataVal, $TmpGivenDataArray[1]);
						}
					}else{
						return ["status"=>"Error","msg"=>"Process failed! Try again later 4.0","code"=>400];
					}
				}else{
					return ["status"=>"Error","msg"=>"Process failed! Try again later 5.0","code"=>400];
				}
			}
			
			if(isset($DatabaseConnection) && isset($DbTableName)){

				if(strlen($UpdateCondition) > 0){
					$UpdateCondition = "WHERE $UpdateCondition";
				}

				if($Limit != null){
					$Limit = "LIMIT $Limit";
				}
				
				// Check and remove user if account created but Status is pending
				$stmt = $DatabaseConnection->prepare("UPDATE $DbTableName SET $UpdateString $UpdateCondition $Limit");
				$stmt->bindValue(":EncodeAndEncryptPass", $EncodeAndEncryptPass, PDO::PARAM_STR);
				$i = 0;
				foreach ($StmtGivenDataVal as $value) {
					$stmt->bindValue(":".$StmtGivenDataKey[$i] , $value, PDO::PARAM_STR);
					$i++;
				}
				$i = 0;
				foreach ($ConditionsDataVal as $value) {
					$stmt->bindValue(":".$ConditionsDataKey[$i] , $value, PDO::PARAM_STR);
					$i++;
				}
				if($stmt->execute()){
    				if($stmt->rowCount() > 0){
    					return ["status"=>"Success","msg"=>'Data Update Successfully',"code"=>200];
    				}else{
    					return ["status"=>"Error","msg"=>"Data Not Update",'reason'=>json_encode($stmt->errorinfo()),"code"=>404];
    				}
				}else{
				    return ["status"=>"Error","msg"=>"Process failed! Try again later 5.0.1",'reason'=>json_encode($stmt->errorinfo()),"code"=>400];
				}
			}else{
				return ["status"=>"Error","msg"=>"Process failed! Try again later 6.0","code"=>400];
			}
		}
?>
<!--
	Use ->
	$Response = InsertGivenData($GivenData,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass);
	Check Response -> 
	if($Response['status'] === 'Success' && $Response['code'] === 200){}
-->