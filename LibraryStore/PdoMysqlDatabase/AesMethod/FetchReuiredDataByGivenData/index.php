<?php
	/*

	*@filename FetchReuiredDataByGivenData/index.php
	*@des It return data if Data exist otherwise it return error
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

	function FetchReuiredDataByGivenData($Condtion,$FetchColumn,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass,$CheckFor = 'any' ,$CheckUserStatus = NULL,$FetchCount = NULL,$AcceptNullCondtion=false){
		if((strlen($Condtion) == 0 && $Condtion != 'none') || (strlen($FetchColumn) == 0 && $FetchColumn != NULL)){
			return ["status"=>"Error","msg"=>"Invalid Given Data formet detect!","code"=>400];
		}

		if($Condtion != 'none'){
			// Get Condtion data in array
			$CondtionArray = explode("::,::",$Condtion);
			$StmtCondtionKey = array();
			$StmtCondtionValue = array();
			$i = 0;
			foreach ($CondtionArray as $value) {
				$i++;
				
				if(strpos($value, "::::") !== false || $CheckFor === 'NotEqualAny' || $CheckFor === 'NotEqualAll' || $AcceptNullCondtion === true){
				   $TmpCondtionArray = explode("::::",$value);
				} else{
				   return ["status"=>"Error","msg"=>"Invalid given data format detect!","code"=>400];
				}
					
				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpCondtionArray[0]) !== "" && preg_replace("/[^A-Za-z0-9_]/","",$TmpCondtionArray[0]) === $TmpCondtionArray[0] && (preg_replace("/^[ ]/","",$TmpCondtionArray[1]) !== "" || $CheckFor === 'NotEqualAny' || $CheckFor === 'NotEqualAll' || $AcceptNullCondtion === true)){
					if($TmpCondtionArray[1] == '' && ($CheckFor == 'StartLike' || $CheckFor == 'LikeLast' || $CheckFor == 'StartLikeLast')){
						return ["status"=>"Error","msg"=>"Null condtion value  not support with StartLike, LikeLast or StartLikeLast","code"=>400];
					}
					if($i === 1){
						if($CheckFor === 'any' || $CheckFor === 'all'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." is null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else if($CheckFor === 'StartLike' || $CheckFor === 'LikeLast' || $CheckFor === 'StartLikeLast'){
							$StmtCondtionKeyAndPreparedKey = "AES_DECRYPT(".$TmpCondtionArray[0].", :EncodeAndEncryptPass) LIKE :".$TmpCondtionArray[0].$i.'Srh';
						}else if($CheckFor === 'NotEqualAny' || $CheckFor === 'NotEqualAll'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." is not null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." != AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else{
							return ["status"=>"Error","msg"=>"Invalid CheckFor details detect!","code"=>400];
						}
					}else{
						if($CheckFor === 'any'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." || ".$TmpCondtionArray[0]." is null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." || ".$TmpCondtionArray[0]." = AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else if($CheckFor === 'all'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." && ".$TmpCondtionArray[0]." is null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." && ".$TmpCondtionArray[0]." = AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else if($CheckFor === 'StartLike' || $CheckFor === 'LikeLast' || $CheckFor === 'StartLikeLast'){
							$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." || AES_DECRYPT(".$TmpCondtionArray[0].", :EncodeAndEncryptPass) LIKE :".$TmpCondtionArray[0].$i.'Srh';
						}else if($CheckFor === 'NotEqualAny'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." || ".$TmpCondtionArray[0]." is not null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." || ".$TmpCondtionArray[0]." != AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else if($CheckFor === 'NotEqualAll'){
							if($TmpCondtionArray[1] == ''){
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." && ".$TmpCondtionArray[0]." is not null";
							}else if($TmpCondtionArray[1] === 'NullAndNothing'){
								$StmtCondtionKeyAndPreparedKey = $TmpCondtionArray[0]." = ''";
							}else{
								$StmtCondtionKeyAndPreparedKey = $StmtCondtionKeyAndPreparedKey." && ".$TmpCondtionArray[0]." != AES_ENCRYPT(:".$TmpCondtionArray[0].$i."Srh, :EncodeAndEncryptPass)";
							}
						}else{
							return ["status"=>"Error","msg"=>"Invalid CheckFor details detect!","code"=>400];
						}
					}
					
					if($TmpCondtionArray[1] != '' && $TmpCondtionArray[1] != 'NullAndNothing'){
						array_push($StmtCondtionKey, $TmpCondtionArray[0].$i.'Srh');
						array_push($StmtCondtionValue, $TmpCondtionArray[1]);
					}
				}else{
					return ["status"=>"Error","msg"=>"NULL key and value not support without AcceptNullCondtion","code"=>400];
				}
				
			}
		}else{
			$StmtCondtionKeyAndPreparedKey = '0=0';
			$StmtCondtionKey = array();
			$StmtCondtionValue = array();
		}
		
		if($FetchColumn != NULL){
			// Get required data in array
			$FetchColumnArray = explode("::::",$FetchColumn);
			$i = 0;
			foreach ($FetchColumnArray as $value) {
				$i++;
					
				if(preg_replace("/[^A-Za-z0-9_]/","",$value) !== "" && preg_replace("/[^A-Za-z0-9_]/","",$value) === $value){
					if($i === 1){
						$StmtFetchColumnKey ="AES_DECRYPT(".$value.", :EncodeAndEncryptPass) AS ".$value;
					}else{
						$StmtFetchColumnKey = $StmtFetchColumnKey.", AES_DECRYPT(".$value.", :EncodeAndEncryptPass) AS ".$value;
					}
				}else{
					return ["status"=>"Error","msg"=>"Invalid Data Fatch column name detect","code"=>400];
				}
			}
		}else{
			$StmtFetchColumnKey = NULL;
		}

		if(isset($DatabaseConnection) && isset($DbTableName) && (isset($StmtFetchColumnKey) || $FetchColumn == NULL) && isset($StmtCondtionValue) && isset($StmtCondtionKey) && isset($StmtCondtionKeyAndPreparedKey) && isset($EncodeAndEncryptPass)){
			if($CheckUserStatus !== NULL){
				$StmtCondtionKeyAndPreparedKey = '('.$StmtCondtionKeyAndPreparedKey.')  && Status = AES_ENCRYPT(:Status, :EncodeAndEncryptPass)';
			}
			//return_response("SELECT $StmtFetchColumnKey FROM $DbTableName WHERE $StmtCondtionKeyAndPreparedKey");
			if($FetchColumn == NULL){
				$stmt = $DatabaseConnection->prepare("SELECT NULL FROM $DbTableName WHERE $StmtCondtionKeyAndPreparedKey");
			}else{
				$stmt = $DatabaseConnection->prepare("SELECT $StmtFetchColumnKey FROM $DbTableName WHERE $StmtCondtionKeyAndPreparedKey");
			}

			$stmt->bindValue(':EncodeAndEncryptPass', $EncodeAndEncryptPass, PDO::PARAM_STR);
			$i = 0;
			if($StmtCondtionKeyAndPreparedKey != '0=0'){
				if($CheckFor === 'any' || $CheckFor === 'all' || $CheckFor === 'NotEqualAny' || $CheckFor === 'NotEqualAll'){
					foreach ($StmtCondtionValue as $value) {
						$stmt->bindValue(':'.$StmtCondtionKey[$i] , $value, PDO::PARAM_STR);
						$i++;
					}
				}else if($CheckFor === 'StartLike'){
					foreach ($StmtCondtionValue as $value) {
						$stmt->bindValue(':'.$StmtCondtionKey[$i] , '%'.$value, PDO::PARAM_STR);
						$i++;
					}
				}else if($CheckFor === 'LikeLast'){
					foreach ($StmtCondtionValue as $value) {
						$stmt->bindValue(':'.$StmtCondtionKey[$i] , $value.'%', PDO::PARAM_STR);
						$i++;
					}
				}else if($CheckFor === 'StartLikeLast'){
					foreach ($StmtCondtionValue as $value) {
						$stmt->bindValue(':'.$StmtCondtionKey[$i] , '%'.$value.'%', PDO::PARAM_STR);
						$i++;
					}
				}else{
					return ["status"=>"Error","msg"=>"Invalid CheckFor details detect!","code"=>400];
				}
			}
			if($CheckUserStatus !== NULL){
				$stmt->bindValue(':Status', $CheckUserStatus, PDO::PARAM_STR);
			}
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					if($FetchCount === NULL){
						return ['status'=>'Success','msg'=>$stmt->fetch(),'totalrows'=>$stmt->rowCount(),"code"=>200];
					}else if($FetchCount === 'all'){
						return ['status'=>'Success','msg'=>$stmt->fetchAll(),'totalrows'=>$stmt->rowCount(),"code"=>200];
					}else{
						return ["status"=>"Error","msg"=>"Invalid FetchCount details detect!","code"=>400];
					}
				}else{
					return ['status'=>'Error','msg'=>'Given Data not found','reason'=>json_encode($stmt->errorinfo()),"code"=>404];
				}
			}else{
				return ["status"=>"Error","msg"=>"Process executetion failed",'reason'=>json_encode($stmt->errorinfo()),"code"=>400];
			}
		}else{
			return ["status"=>"Error","msg"=>"Some technical error occur","code"=>400];
		}
	}
?>