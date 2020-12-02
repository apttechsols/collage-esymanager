<?php
	/*

	*@filename CheckGivenDataAvailability/index.php
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

		if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
			header("Location: " . DomainName . "/PageNotAvailable/index.php");
			die();
			exit();
		}
		
		function CheckGivenDataAvailability($SearchData,$DatabaseConnection,$DbTableName,$EncodeAndEncryptPass,$CheckFor = 'any' ,$CheckUserStatus = NULL){
			if(($CheckFor !== 'any' && $CheckFor !== 'all') || strlen($SearchData) == 0){
				return ["status"=>"Error","msg"=>"Process failed! Try again later1"];
				exit();
			}
			
			$SearchDataArray = explode("::,::",$SearchData);
			$StmtSearchKey = array(); 
			$StmtSearchValue = array();
			$i = 0;
			foreach ($SearchDataArray as $value) {
				$i++;
				if(strpos($value, "::::") !== false){
				   $TmpSearchDataArray = explode("::::",$value);
				} else{
				   return ["status"=>"Error","msg"=>"Process failed! Try again later2","code"=>400]; exit();
				}
					
				if(preg_replace("/[^A-Za-z0-9_]/","",$TmpSearchDataArray[0]) !== "" && preg_replace("/^[ ]/","",$TmpSearchDataArray[1]) !== ""){
					if($i === 1){
						if($CheckFor === 'any' || $CheckFor === 'all'){
							$StmtSearchKeyAndPreparedKey = $TmpSearchDataArray[0]." = AES_ENCRYPT(:".$TmpSearchDataArray[0].", :EncodeAndEncryptPass)";
						}else{
							return ["status"=>"Error","msg"=>"Process failed! Try again later3","code"=>400];
						}
					}else{
						if($CheckFor === 'any'){
							$StmtSearchKeyAndPreparedKey = $StmtSearchKeyAndPreparedKey." || ".$TmpSearchDataArray[0]." = AES_ENCRYPT(:".$TmpSearchDataArray[0].", :EncodeAndEncryptPass)";
						}else if($CheckFor === 'all'){
							$StmtSearchKeyAndPreparedKey = $StmtSearchKeyAndPreparedKey." && ".$TmpSearchDataArray[0]." = AES_ENCRYPT(:".$TmpSearchDataArray[0].", :EncodeAndEncryptPass)";
						}else{
							return ["status"=>"Error","msg"=>"Process failed! Try again later3","code"=>400];
						}
					}
					array_push($StmtSearchKey, $TmpSearchDataArray[0]);
					array_push($StmtSearchValue, $TmpSearchDataArray[1]);
				}else{
					return ["status"=>"Error","msg"=>"Process failed! Try again later4".$TmpSearchDataArray[1],"code"=>400];
				}
			}

			if(isset($DatabaseConnection) && isset($DbTableName) && isset($StmtSearchKeyAndPreparedKey) && isset($StmtSearchValue) && isset($StmtSearchKey) && isset($EncodeAndEncryptPass)){

				if($CheckUserStatus !== NULL){
					$StmtSearchKeyAndPreparedKey = '('.$StmtSearchKeyAndPreparedKey.')  && Status = AES_ENCRYPT(:Status, :EncodeAndEncryptPass)';
				}

				// Check and remove user if account created but Status is pending
				$stmt = $DatabaseConnection->prepare("SELECT NULL FROM $DbTableName WHERE $StmtSearchKeyAndPreparedKey");

				$stmt->bindValue(":EncodeAndEncryptPass", $EncodeAndEncryptPass, PDO::PARAM_STR);
				$i = 0;
				foreach ($StmtSearchValue as $value) {
					$stmt->bindValue(":".$StmtSearchKey[$i] , $value, PDO::PARAM_STR);
					$i++;
				}
				if($CheckUserStatus !== NULL){
					$stmt->bindValue(':Status', $CheckUserStatus, PDO::PARAM_STR);
				}
				if($stmt->execute()){
					if($stmt->rowCount() > 0){
						return ["status"=>"Success","msg"=>'Available','totalrows'=>$stmt->rowCount(),"code"=>200];
					}else{
						return ["status"=>"Success","msg"=>'NotAvailable','totalrows'=>$stmt->rowCount(),"code"=>200];
					}
				}else{
					return ["status"=>"Error","msg"=>"Process failed! Try again later5",'reason'=>json_encode($stmt->errorinfo()),"code"=>400];
				}
			}else{
				return ["status"=>"Error","msg"=>"Process failed! Try again later6","code"=>400];
			}
		}
?>