<?php
	/*

	*@Filename - InsertGivenData/index.php
	*@Des - We can insert data in mysql Database with Aes encryption using this function it return response after insert data into datanbase or return error if any error occur during data insert into mysql database
	*@Author - Arpit sharma
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

		function InsertGivenData($GivenData,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass,$NullValueSupport=false){
			if(strlen($GivenData) == 0){
				return ["status"=>"Error","msg"=>"Process failed! Try again later1"];
				exit();
			}
			
			
			$GivenDataArray = explode("::,::",$GivenData);
			$StmtGivenDataKey = array(); 
			$GivenDataOptions = array(); 
			$StmtGivenDataVal = array();
			$i = 0;
			foreach ($GivenDataArray as $value) {
				$i++;
				
				if(strpos($value, "::::") != false || $NullValueSupport=true){
				   $TmpGivenDataArray = explode("::::",$value);
				} else{
				   return ["status"=>"Error","msg"=>"Process failed! Try again later2","code"=>400]; exit();
				}
				
				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpGivenDataArray[0]) !== ""){
					if(preg_replace("/^[ ]/","",$TmpGivenDataArray[1]) != "" || $NullValueSupport === true){
						if($i === 1){
							$StmtGivenDataPreparedKey = $TmpGivenDataArray[0];
							$StmtGivenDataPreparedVal = 'AES_ENCRYPT(:'.$TmpGivenDataArray[0].', :EncodeAndEncryptPass)';
						}else{
							$StmtGivenDataPreparedKey = $StmtGivenDataPreparedKey.', '.$TmpGivenDataArray[0];
							$StmtGivenDataPreparedVal = $StmtGivenDataPreparedVal.', AES_ENCRYPT(:'.$TmpGivenDataArray[0].', :EncodeAndEncryptPass)';
						}
						array_push($StmtGivenDataKey, $TmpGivenDataArray[0]);
						if(preg_replace("/^[ ]/","",$TmpGivenDataArray[1]) == ''){
							array_push($StmtGivenDataVal, null);
						}else{
							array_push($StmtGivenDataVal, $TmpGivenDataArray[1]);
						}
					}else{
						return ["status"=>"Error","msg"=>"You can not use null value without NullValueSupport","code"=>400];
					}
				}else{
					return ["status"=>"Error","msg"=>"Process failed! Try again later3","code"=>400];
				}
			}
			
			if(isset($DatabaseConnection) && isset($DbTableName) && isset($StmtGivenDataPreparedKey) && isset($StmtGivenDataPreparedVal) && isset($StmtGivenDataKey) && isset($StmtGivenDataVal) && isset($EncodeAndEncryptPass)){

				// Check and remove user if account created but Status is pending
				$stmt = $DatabaseConnection->prepare("INSERT INTO $DbTableName ($StmtGivenDataPreparedKey) VALUES ($StmtGivenDataPreparedVal)");

				$stmt->bindValue(":EncodeAndEncryptPass", $EncodeAndEncryptPass, PDO::PARAM_STR);
				$i = 0;
				foreach ($StmtGivenDataVal as $value) {
					$stmt->bindValue(":".$StmtGivenDataKey[$i] , $value, PDO::PARAM_STR);
					$i++;
				}

				if($stmt->execute()){
					return ["status"=>"Success","msg"=>'Data Insert Successfully',"code"=>200];
				}else{
					return ["status"=>"Error","msg"=>"Data Not Insert",'reason'=>json_encode($stmt->errorinfo()),"code"=>400];
				}
			}else{
				return ["status"=>"Error","msg"=>"Process failed! Try again later4","code"=>400];
			}
		}
		/*  Use ->
			$Response = InsertGivenData($GivenData,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass);
			Check Response -> 
			if($Response['status'] === 'Success' && $Response['code'] === 200){}
		*/
?>