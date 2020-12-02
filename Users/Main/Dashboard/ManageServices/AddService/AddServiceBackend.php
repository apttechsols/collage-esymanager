<?php
	/*
	@FileName AddNewwMemberBackend.php
	@Des This procees add new members in orgnization database
	@Author arpit sharma
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

	define("RootPath", "../../../../../");

if(isset($_POST['ServiceStatus']) && isset($_POST['ServiceName']) && isset($_POST['ServiceStartTime']) && isset($_POST['ServiceStartTimeType']) && isset($_POST['ServiceExpTime']) && isset($_POST['ServiceExpTimeType']) && isset($_POST['ServiceFor']) && isset($_POST['ServiceMember']) && isset($_POST['MaxSellLimit']) && isset($_POST['AllOffersPermission']) && isset($_POST['SpecialOffersPermission']) && isset($_POST['PrivateOffersPermission']) && isset($_POST['AllMaxDiscountAmount']) && isset($_POST['SpecialOffersMaxDiscountAmount']) && isset($_POST['PrivateOffersMaxDiscountAmount']) && isset($_POST['AllMaxDiscountPercentage']) && isset($_POST['SpecialOffersMaxDiscountPercentage']) && isset($_POST['PrivateOffersMaxDiscountPercentage']) && isset($_POST['ServicePackWork']) && isset($_POST['ServiceDescription']) && isset($_POST['ServiceTablesAndColumns']) && isset($_POST['TablesDefaultValues']) && isset($_POST['SecurityCode']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){

	require_once (RootPath."JsonShowError/index.php"); // Require Show error file

	// Verify data send from same page or not
	if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/AddService/index.php" || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Main/Dashboard/ManageServices/AddService/"){
		session_start();
		if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

			// Create variable from get data by request (example Post and Get methos)

			$ServiceStatus = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceStatus']));
			$ServiceName = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceName']));
			$ServiceStartTime = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceStartTime']));
			$ServiceStartTimeType = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceStartTimeType']));
			$ServiceExpTime = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceExpTime']));
			$ServiceExpTimeType = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceExpTimeType']));
			$ServiceFor = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceFor']));
			$ServiceMember = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceMember']));
			$MaxSellLimit = preg_replace('!\s+!', ' ',strip_tags($_POST['MaxSellLimit']));
			$AllOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['AllOffersPermission']));
			$SpecialOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersPermission']));
			$PrivateOffersPermission = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersPermission']));
			$AllMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['AllMaxDiscountAmount']));
			$SpecialOffersMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersMaxDiscountAmount']));
			$PrivateOffersMaxDiscountAmount = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersMaxDiscountAmount']));
			$AllMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['AllMaxDiscountPercentage']));
			$SpecialOffersMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['SpecialOffersMaxDiscountPercentage']));
			$PrivateOffersMaxDiscountPercentage = preg_replace('!\s+!', ' ',strip_tags($_POST['PrivateOffersMaxDiscountPercentage']));
			$ServicePackWork = preg_replace('!\s+!', ' ',strip_tags($_POST['ServicePackWork']));
			$ServiceDescription = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceDescription']));
			$ServiceTablesAndColumns = preg_replace('!\s+!', ' ',strip_tags($_POST['ServiceTablesAndColumns']));
			$TablesDefaultValues = preg_replace('!\s+!', ' ',strip_tags($_POST['TablesDefaultValues']));
			$SecurityCode = preg_replace('!\s+!', ' ',strip_tags($_POST['SecurityCode']));
			if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
				foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
				return_response("Process failed!");
			}else{

				// Create New BrowserUniqueDetails
				$BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));

				$BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
			}

			if($ServiceName == "undefined"){
				return_response("Invalid data received");
			}

			class AddServices{
				public static function ValidedData($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceStartTimeType,$ServiceExpTime,$ServiceExpTimeType,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2){

					// Service status validation
					if($ServiceStatus != 'Active' && $ServiceStatus != 'Hold'){
						return_response("Service Status contains invalid characters");
					}

					// Service name validation
					if($ServiceName != preg_replace("/[^A-Za-z0-9_ -]/","",$ServiceName)){
						return_response("Service Name contains invalid characters");

					}else if(strlen(preg_replace("/^[ ]/","",$ServiceName)) < 1){
						return_response("Service Name look like empty");

					}else if(strlen($ServiceName) < 3 || strlen($ServiceName) > 50){
						return_response("Service Name must be between 3 and 50 characters long");
					}else if($ServiceName[0] != preg_replace("/[^A-Z]/","",$ServiceName[0])){
						return_response("Service Name first latter must a be Capital word");
					}

					// ServiceStartTimeType validation
					if($ServiceStartTimeType != 'Manually' && $ServiceStartTimeType != 'Days' && $ServiceStartTimeType != 'Hours' && $ServiceStartTimeType != 'Minutes' && $ServiceStartTimeType != 'Seconds'){
						return_response("Service Start Time Type contains invalid characters");
					}else{
						if($ServiceStartTimeType === 'Manually'){
							$ServiceStartTime = -1;
							$ServiceStatus = 'Hold';
						}else{
							// ServiceStartTime validation
							if($ServiceStartTime != preg_replace("/[^0-9]/","",$ServiceStartTime)){
								return_response("Service Start Time contains invalid characters");
							}

							$ServiceStartTime = $CurrentTime + $ServiceStartTime;
							if($ServiceStartTime > $CurrentTime+31104000){
								return_response("Max Service Start time can be ".date('d-m-Y, H:i:s',$CurrentTime+31104000));  exit();
							}
						}
					}

					// ServiceExpTimeType validation
					if($ServiceExpTimeType != 'Manually' && $ServiceExpTimeType != 'Days' && $ServiceExpTimeType != 'Hours' && $ServiceExpTimeType != 'Minutes' && $ServiceExpTimeType != 'Seconds'){
						return_response($ServiceExpTimeType);
						return_response("Service Exp Time Type contains invalid characters");
					}else{
						if($ServiceExpTimeType === 'Manually'){
							$ServiceExpTime = -1;
						}else{
							// ServiceExpTime validation
							if($ServiceExpTime != preg_replace("/[^0-9]/","",$ServiceExpTime)){
								return_response("Service Exp Time contains invalid characters");
							}
							
							$ServiceExpTime = $CurrentTime + $ServiceExpTime;
							if($ServiceExpTime > $CurrentTime+31104000){
								return_response("Max Service Exp time can be ".date('d-m-Y, H:i:s',$CurrentTime+31104000));  exit();
							}
						}
					}
					
					if($ServiceFor != 'All'){
						$ServiceFor = trim($ServiceFor,',');
						$ServiceForArray = explode(',', $ServiceFor);
						foreach ($ServiceForArray as $key => $value) {
							if($value != 'College'){
								return_response('ServiceFor contains invalid characters');
							}
						}
						$ServiceFor = ','.$ServiceFor.',';
					}

					if($ServiceMember != 'Yes' && $ServiceMember !='No'){
						return_response('Service member must be Yes Or No'); exit();
					}

					if(strlen($MaxSellLimit) == 0){
						return_response('Max Sell Limit Required'); exit();
					}else if($MaxSellLimit != preg_replace("/[^0-9-]/","",$MaxSellLimit)){
						return_response('Max Sell Limit contains invalid characters'); exit();
					}else{
						if($MaxSellLimit != -1 && $MaxSellLimit != preg_replace("/[^0-9]/","",$MaxSellLimit)){
							return_response('Max Sell Limit must be -1 or positive number'); exit();
						}
					}

					if($AllOffersPermission != 'Allow' && $AllOffersPermission != 'Deny'){
						return_response('All Offers Permission contains invalid characters');
					}

					if($SpecialOffersPermission != 'Allow' && $SpecialOffersPermission != 'Deny'){
						return_response('Special Offers Permission contains invalid characters');
					}

					if($PrivateOffersPermission != 'Allow' && $PrivateOffersPermission != 'Deny'){
						return_response('Private Offers Permission contains invalid characters');
					}

					if($AllMaxDiscountAmount != preg_replace("/[^0-9]/","",$AllMaxDiscountAmount)){
						return_response('All Max Discount Amount contains invalid characters');
					}else if($AllMaxDiscountAmount > 100000 || $AllMaxDiscountAmount < 0){
						return_response('All Max Discount Amount cross maximum or minimum discount limit');
					}else if($AllMaxDiscountAmount == 0){
						$AllMaxDiscountAmount = null;
					}

					if($SpecialOffersMaxDiscountAmount != preg_replace("/[^0-9]/","",$SpecialOffersMaxDiscountAmount)){
						return_response('Special Max Discount Amount contains invalid characters');
					}else if($SpecialOffersMaxDiscountAmount > 100000 || $SpecialOffersMaxDiscountAmount < 0){
						return_response('Special Max Discount Amount cross maximum or minimum discount limit');
					}else if($SpecialOffersMaxDiscountAmount == 0){
						$SpecialOffersMaxDiscountAmount = null;
					}

					if($PrivateOffersMaxDiscountAmount != preg_replace("/[^0-9]/","",$PrivateOffersMaxDiscountAmount)){
						return_response('Private Max Discount Amount contains invalid characters');
					}else if($PrivateOffersMaxDiscountAmount > 100000 || $PrivateOffersMaxDiscountAmount < 0){
						return_response('Private Max Discount Amount cross maximum or minimum discount limit');
					}else if($PrivateOffersMaxDiscountAmount == 0){
						$PrivateOffersMaxDiscountAmount = null;
					}

					if($AllMaxDiscountPercentage != preg_replace("/[^0-9]/","",$AllMaxDiscountPercentage)){
						return_response('All Max Discount Percentage contains invalid characters');
					}else if($AllMaxDiscountPercentage > 100 || $AllMaxDiscountPercentage < 0){
						return_response('All Max Discount Percentage cross maximum or minimum discount limit');
					}else if($AllMaxDiscountPercentage == 0){
						$AllMaxDiscountPercentage = null;
					}

					if($SpecialOffersMaxDiscountPercentage != preg_replace("/[^0-9]/","",$SpecialOffersMaxDiscountPercentage)){
						return_response('Special Max Discount Percentage contains invalid characters');
					}else if($SpecialOffersMaxDiscountPercentage > 100 || $SpecialOffersMaxDiscountPercentage < 0){
						return_response('Special Max Discount Percentage cross maximum or minimum discount limit');
					}else if($SpecialOffersMaxDiscountPercentage == 0){
						$SpecialOffersMaxDiscountPercentage = null;
					}

					if($PrivateOffersMaxDiscountPercentage != preg_replace("/[^0-9]/","",$PrivateOffersMaxDiscountPercentage)){
						return_response('Private Max Discount Percentage contains invalid characters');
					}else if($PrivateOffersMaxDiscountPercentage > 100 || $PrivateOffersMaxDiscountPercentage < 0){
						return_response('Private Max Discount Percentage cross maximum or minimum discount limit');
					}else if($PrivateOffersMaxDiscountPercentage == 0){
						$PrivateOffersMaxDiscountPercentage = null;
					}

					if(strlen($ServicePackWork) < 3 || strlen($ServicePackWork) > 80){
						return_response('Service Pack Work must be between 3 to 80 characters long');
					}else if($ServicePackWork != preg_replace("/[^A-Za-z0-9 .,-]/","",$ServicePackWork)){
						return_response('Service Pack Work contains invalid characters');
					}else if(strlen(preg_replace("/^[ ]/","",$ServicePackWork)) < 1){
						return_response("Service Pack Work look like empty");
					}

					if(strlen($ServiceDescription) < 10 || strlen($ServiceDescription) > 1200){
						return_response('Service description must be between 10 to 1200 characters long');
					}else if($ServiceDescription != preg_replace("/[^A-Za-z0-9 .,-]/","",$ServiceDescription)){
						return_response('Service description contains invalid characters');
					}else if(strlen(preg_replace("/^[ ]/","",$ServiceDescription)) < 6){
						return_response("Service description look like empty or contains more spaces");
					}

					function get_string_between($string, $start, $end){
					    $string = ' ' . $string;
					    $ini = strpos($string, $start);
					    if ($ini == 0) return '';
					    $ini += strlen($start);
					    $len = strpos($string, $end, $ini) - $ini;
					    return substr($string, $ini, $len);
					    //Use -> get_string_between($fullstring, '[tag]', '[/tag]');
					}

					$TablesAndColumnsArray = array();
					if(strlen($ServiceTablesAndColumns) > 0){
						if(strlen($ServiceTablesAndColumns) <= 11000){
							if($ServiceTablesAndColumns != preg_replace("/[^A-Za-z0-9,=&)(@>_]/","",$ServiceTablesAndColumns)){
								return_response('Service Tables And Columns contains invalid characters 1.0');
							}else{
								$TempArray = explode('&', $ServiceTablesAndColumns);
								foreach ($TempArray as $key => $TempArrayValue) {
									$ColumnNameArray = array();
									$ColumnsNameStore = '';
									$PrimaryCount = 0;
									$PrimaryKeyStore = '';
									$AutoIncrement = 0;
									if(substr_count($TempArrayValue,'=') !=  1){
										return_response('Invalid Service Tables And Columns found 1.1');
									}
									$Temp2Array =  explode('=', $TempArrayValue);

									if (array_key_exists(strtolower($Temp2Array[0]),$TablesAndColumnsArray)){
										return_response('Multiple time same table name used at Table=> '.$Temp2Array[0].' 1.1.0');
									}

									if(strlen($TempArrayValue) == 0 || strlen($Temp2Array[0]) == 0 || strlen($Temp2Array[1]) == 0 || $Temp2Array[0] != preg_replace("/[^a-z0-9_]/","",$Temp2Array[0]) || $Temp2Array[1] != preg_replace("/[^A-Za-z0-9,)(@>_]/","",$Temp2Array[1])){
										return_response('Invalid Service Tables And Columns found at Table=> '.$Temp2Array[0].' 1.2');
									}
									$Temp3Array =  explode(',', $Temp2Array[1]);
									foreach ($Temp3Array as $key1 => $Temp3ArrayValue){
										if($Temp3ArrayValue != preg_replace("/[^A-Za-z0-9)(@>_]/","",$Temp3ArrayValue) || strlen($Temp3ArrayValue) == 0){
											return_response('Columns contains invalid char at Table=> '.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.3');
										}
										if(substr_count($Temp3ArrayValue,'(') !=  1 || substr_count($Temp3ArrayValue,')') !=  1){
											return_response('Multiple times details provide at Table=> '.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.4');
										}
										$TempString =  get_string_between($Temp3ArrayValue , '(', ')');
										if(strlen($TempString) == 0 || substr_count($TempString,'@') < 1 ){
											return_response('Invalid Service not provide sufficient details about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.5');
										}

										$Temp2String = substr($Temp3ArrayValue, 0, strpos($Temp3ArrayValue, "("));

										if (array_key_exists(strtolower($Temp2String),$ColumnNameArray)){
											return_response('Multiple time same column name used at Table=> '.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.5.0.0');
										}

										if($TempString != str_replace(')','',str_replace('(','',str_replace($Temp2String,'',$Temp3ArrayValue)))){
											return_response('Provide details contaion invalid char about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.5.0');
										}

										if($Temp2String != preg_replace("/[^A-Za-z0-9_]/","",$Temp2String)){
											return_response('Provide details contaion invalid char about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.5.1');
										}

										$TempType = 0;
										$TempLength = 0;
										$TempDefault = 0;
										$TempNull = 0;
										$TempIndex = 0;
										$TempAI = 0;
										$TempTypeStore = '';
										$TempLengthStore = 0;
										$TempDefaultStore = '';
										$TempNULLStore = '';
										$TempIndexStore = '';
										$TempAIStore = '';
										$Temp4Array =  explode('@', $TempString);
										foreach ($Temp4Array as $key2 => $Temp4ArrayValue){
											$Temp5Array =  explode('>', $Temp4ArrayValue);
											if(sizeof($Temp5Array) > 2){
												return_response(return_response('Provide wrong details about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.6.0'));
											}
											if($Temp5Array[0] != 'Type' && $Temp5Array[0] != 'Length' && $Temp5Array[0] != 'Default' && $Temp5Array[0] != 'Null' && $Temp5Array[0] != 'Index' && $Temp5Array[0] != 'AI'){
												return_response('Provide wrong details about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.6');
											}
											if($Temp5Array[0] === 'Type'){
												if($TempType != 0 || $TempLength != 0 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
													return_response('Wrong order of column detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.7');
												}
												if($TempType === 0){
													$TempType = $TempType+1;
													if($Temp5Array[1] === 'INT' || $Temp5Array[1] === 'VARCHAR' || $Temp5Array[1] === 'TEXT'){
														$TempTypeStore = $Temp5Array[1];
														if($Temp5Array[1] === 'INT'){
															if($Temp3ArrayValue == 'String' || $Temp3ArrayValue == 'string' || $Temp3ArrayValue == 'STRING' || $Temp3ArrayValue == 'char' || $Temp3ArrayValue == 'Chare' || $Temp3ArrayValue == 'CHAR'){
																return_response('INT cant use String or Char as column name at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.8');
															}
														}else{
															if($Temp3ArrayValue == 'id' || $Temp3ArrayValue == 'ID' || $Temp3ArrayValue == 'Id'){
																return_response('Only INT can use Id as column name at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.9');
															}
														}
													}else{
														return_response('Provide details contaion invalid Type at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.10');
													}
												}else{
													return_response('Invalid Service contaion dublicate Type about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.11');
												}
											}else if($Temp5Array[0] === 'Length'){
												if($TempType != 1 || $TempLength != 0 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
													return_response('Wrong order of column detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.7');
												}
												if($TempLength === 0){
													$TempLength = $TempLength+1;
													$TempLengthStore = $Temp5Array[1];
													if($TempTypeStore === 'INT'){
														if($Temp5Array[1] < 11 || $Temp5Array[1] > 255){
															return_response('INT Type maximum length must be between 11 to 255 at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.13');
														} 
													}else if($TempTypeStore === 'VARCHAR'){
														if($Temp5Array[1] < 30 || $Temp5Array[1] > 400){
															return_response('VARCHAR Type maximum length must be between 30 to 400 at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.14');
														}
													}else if($TempTypeStore === 'TEXT'){
														if($Temp5Array[1] < 30 || $Temp5Array[1] > 60000){
															return_response('VARCHAR Type maximum length must be between 30 to 60000 at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.15');
														}
													}else{
														return_response('Invalid Service contaion invalid Type about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.16');
													}
												}else{
													return_response('Invalid Service contaion dublicate Length about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.17');
												}
											}else if($Temp5Array[0] === 'Default'){
												if($TempType != 1 || $TempLength != 1 || $TempDefault != 0 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
													return_response('Wrong order of column detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.18');
												}
												if($TempDefault === 0){
													$TempDefault = $TempDefault+1;
													if(strlen($Temp5Array[1]) > $TempLengthStore){
														return_response('Default not be larger then size at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.19');
													}

													if($TempTypeStore === 'INT'){
														if($Temp5Array[1] != preg_replace("/[^0-9]/","",$Temp5Array[1])){
															return_response('Only INT use as Default value with INT type at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.19');
														}
													}
												}else{
													return_response('Invalid Service contaion dublicate Default about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.20');
												}
												$TempDefaultStore = $Temp5Array[1];
											}else if($Temp5Array[0] === 'Null'){
												if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 0 || $TempIndex != 0 || $TempAI != 0){
													return_response('Wrong order of column detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.21');
												}
												if($TempNull === 0){
													$TempNull = $TempNull+1;
													if($Temp5Array[1] != 'True' && $Temp5Array[1] != 'False'){
														return_response('Invalid Service contaion wrong NULL details at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.22');
													}else{
														$TempNULLStore = $Temp5Array[1];
													}
												}else{
													return_response('Invalid Service contaion dublicate Null about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.23');
												}
											}else if($Temp5Array[0] === 'Index'){
												if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 1 || $TempIndex != 0 || $TempAI != 0){
													return_response('Wrong order of column detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.24');
												}
												if($TempIndex === 0){
													$TempIndex = $TempIndex+1;
													if($Temp5Array[1] === 'PRIMARY'){
														if($PrimaryCount === 0 && $AutoIncrement === 0 && $PrimaryKeyStore === ''){
															$PrimaryCount = $PrimaryCount+1;
															$PrimaryKeyStore = $Temp2String;
															if($TempNULLStore == 'True'){
																return_response('We do not use Primary index with null value at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.25');
															}
														}else{
															return_response('Multiple PRIMARY Column Detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.26');
														}
													}else if($Temp5Array[1] === 'UNIQUE'){

													}else if($Temp5Array[1] === ''){

													}else{
														return_response('Wrong Index found at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.27');
													}
													$TempIndexStore = $Temp5Array[1];
												}else{
													return_response('Dublicate Index found  at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.28');
												}
											}else if($Temp5Array[0] === 'AI'){
												if($TempType != 1 || $TempLength != 1 || $TempDefault != 1 || $TempNull != 1 || $TempIndex != 1 || $TempAI != 0){
													return_response('Wrong details order Detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.29');
												}
												$TempAI = $TempAI+1;
												
												if($Temp5Array[1] === 'True'){
													if($TempDefaultStore != ''){
														return_response('We can not use Default value with AutoIncrement at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.29.0');
													}
													if($PrimaryCount != 1 || $TempIndexStore != 'PRIMARY' || $PrimaryKeyStore != $Temp2String){
														return_response('PRIMARY Index required for AutoIncrement at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.30');
													}
													if($AutoIncrement === 0){
														$AutoIncrement = $AutoIncrement+1;
														if($TempTypeStore != 'INT'){
															return_response('Only INT Type can use auto Increment at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.31');
														}

													}else{
														return_response('Multiple AI detect at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.32'.$AutoIncrement);
													}
												}else if($Temp5Array[1] === 'False'){

												}else{
													return_response('Wrong AI details Provide at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.33');
												}
												$TempAIStore = $Temp5Array[1];
											}else{
												return_response('Wrong details Provide at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.34');
											}
										}
										if($TempType == 0 || $TempLength == 0 || $TempDefault == 0 || $TempNull == 0 || $TempIndex == 0 || $TempAI  == 0 || $TempTypeStore == '' || $TempLengthStore == 0 || $TempNULLStore == '' || $TempAIStore == ''){
											return_response('Invalid Service not provide sufficient details about column at Table=>'.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' 1.35');
										}
										$ColumnNameArray[strtolower($Temp2String)] = $TempString;
										$ColumnsNameStore .= ','.$Temp2String;
									}
									$TablesAndColumnsArray[strtolower($Temp2Array[0])] = $ColumnsNameStore.',';
								}
							}
						}else{
							return_response('Service Tables And Columns maximum length is 11000 characters');
						}
					}else{
						$ServiceTablesAndColumns = '';
						$ServiceStatus = 'Hold';
					}


					$TablesArray2 = array();
					if(strlen($ServiceTablesAndColumns) > 0 && strlen($TablesDefaultValues) > 0){
						if(strlen($TablesDefaultValues) <= 11000){
							if($ServiceTablesAndColumns != preg_replace("/[^A-Za-z0-9=&@:,*#-_ ]/","",$ServiceTablesAndColumns)){
								return_response('Tables Default Values contains invalid characters 2.0');
							}else{
								$TempArray = explode('&', $TablesDefaultValues);
								foreach ($TempArray as $key => $TempArrayValue) {
									
									if(substr_count($TempArrayValue,'=') !=  1){
										return_response('Invalid Tables Default Values found 2.1');
									}
									$Temp2Array =  explode('=', $TempArrayValue);
									if (array_key_exists(strtolower($Temp2Array[0]),$TablesArray2)){
										return_response('Multiple time same table name used at Table=> '.$Temp2Array[0].' 2.1.0');
									}

									if (!array_key_exists(strtolower($Temp2Array[0]),$TablesAndColumnsArray)){
										return_response('this name table not exist error occur at Table=> '.$Temp2Array[0].' 2.1.1');
									}

									if(strlen($TempArrayValue) == 0 || strlen($Temp2Array[0]) == 0 || strlen($Temp2Array[1]) == 0 || $Temp2Array[0] != preg_replace("/[^a-z0-9_]/","",$Temp2Array[0]) || $Temp2Array[1] != preg_replace("/[^A-Za-z0-9@:,*#-_ ]/","",$Temp2Array[1])){
										return_response('Invalid Service Tables And Columns or Values found at Table=> '.$Temp2Array[0].' And Column => '.$Temp2Array[1].' And Syntex => '.json_encode($Temp2Array).' 2.2');
									}

									$Temp3Array =  explode('@', $Temp2Array[1]);

									foreach ($Temp3Array as $key => $Temp3ArrayValue){

										if($Temp3ArrayValue != preg_replace("/[^A-Za-z0-9.,:*#-_ ]/","",$Temp3ArrayValue) || strlen($Temp3ArrayValue) == 0){
											return_response('Columns or Values contains invalid char at Table=> '.$Temp2Array[0].' And Column => '.$Temp3ArrayValue.' And Syntex => '.json_encode($Temp3ArrayValue).' 2.3');
										}

										$TempColumnStoreArray = array();
										$Temp4Array =  explode('#', $Temp3ArrayValue);

										foreach ($Temp4Array as $key => $Temp4ArrayValue){
											if(substr_count($Temp4ArrayValue,'::::') !=  1){
												return_response('Columns or Values contains invalid char at Table=> '.$Temp2Array[0].' And Column => '.$Temp4ArrayValue.' And Syntex => '.json_encode($Temp4ArrayValue).' 2.4');
											}

											$Temp5Array =  explode('::::', $Temp4ArrayValue);
											if(strlen($Temp4ArrayValue) == 0 || strlen($Temp5Array[0]) == 0 || strlen($Temp5Array[1]) == 0 || $Temp5Array[0] != preg_replace("/[^A-Za-z0-9_]/","",$Temp5Array[0]) || $Temp5Array[1] != preg_replace("/[^A-Za-z0-9-.,:*_ ]/","",$Temp5Array[1])){
												return_response('Columns or Values contains invalid char at Table=> '.$Temp2Array[0].' And Column => '.$Temp5Array[0].' And Syntex => '.json_encode($Temp5Array).' 2.5');
											}

											if(substr_count($TablesAndColumnsArray[$Temp2Array[0]],','.$Temp5Array[0].',') !=  1){
												return_response('This column not exist at Table=> '.$Temp2Array[0].' And Column => '.$Temp5Array[0].' And Syntex => '.json_encode($Temp5Array).' 2.6');
											}

											if (array_key_exists(strtolower($Temp5Array[0]),$TempColumnStoreArray)){
												return_response('Multiple time same column not use in one block at Table=> '.$Temp2Array[0].' And Column => '.$Temp5Array[0].' And Syntex => '.json_encode($Temp5Array).' 2.7');
											}
											$TempColumnStoreArray[strtolower($Temp5Array[0])] = '';

										}
										//return_response($Temp3ArrayValue); for insert default data in tables and columns 
									}
								}
							}
						}else{
							return_response('Tables Default Values maximum length is 11000 characters');
						}
					}else{
						$TablesDefaultValues = '';
						$ServiceStatus = 'Hold';
					}
					$TablesDefaultValues = base64_encode($TablesDefaultValues);
					if(strlen($SecurityCode) < 4 || strlen($SecurityCode) > 6 || $SecurityCode != preg_replace("/[^0-9]/","",$SecurityCode)){
						return_response('Invalid Security code');
					}

					AddServices::EncryptData($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
				}

				private static function EncryptData($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2){
					$EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';

					// Create Hash Password
					$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

					AddServices::CkeckLoginAndAuthenticate($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
				}

				private static function CkeckLoginAndAuthenticate($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){

					//Secrate code for access database file
					$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

					//Secrate code for access otherfiles file
					$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";
					
					// Access main_db file to access data base connection ($PdoMainUserAccountDb)
					require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

					// Access main_db file to access data base connection($PdoOrganizationUserSetting)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

					// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
					require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

					// Access main_db file to access data base connection ($PdoServiceManage)
					require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

					// Access base connection file to access data base connection ($DbConnectionWithoutDbName)
					require_once (RootPath."DatabaseConnections/Normal/DbConnectionWithoutDbName.php");

					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/InsertGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/UpdateGivenData/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteDataFromTable/index.php");
					require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/DeleteTable/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/DirectoryDeleteWithFiles/index.php");
					require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
					require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
					require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");


					// Check user login
					$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);
					if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
						return_response("User currently not login or session expired"); exit();
					}else{
						if($ResponseLogin['LAS'] != 'MainMember'){
							return_response('You are not authorized to take this action'); exit();
						}
					}
					$LgUserUrl = $ResponseLogin['msg']['UserUrl'];
					$LgPosition = $ResponseLogin['msg']['Position'];
					$LgSecurityCode = $ResponseLogin['msg']['SecurityCode'];


					// Verify Login user position Rank
					$LgPositionRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

					if($LgPositionRank == ''){
						return_response('Org Setting data not fetched!'); exit();
					}

					if($LgSecurityCode === $SecurityCode){
						AddServices::AddServicesProccess($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$DbConnectionWithoutDbName,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank);
					}else{
						return_response('Invalid Security code'); exit();
					}
				}

				private static function AddServicesProccess($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceExpTime,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,$PdoServiceManage,$DbConnectionWithoutDbName,$LgUserUrl,$LgPosition,$ResponseLogin,$LgPositionRank){
					
					// Create isset time according Asia/Kolkata
					date_default_timezone_set('Asia/Kolkata');
					
					$CurrentTime = time(); // Take current time in sec

					/* 
					*@Method name rand_string
					*@Des Rndom string genrater
					*/
					function rand_string( $length ) {  
						$RandStr = "";
						$chars = "abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz";
						$size = strlen( $chars );
						for( $i = 0; $i < $length; $i++ ) {  
						$RandStr = $RandStr . "" . $chars[ rand( 0, $size - 1 ) ];   
						} 
						return $RandStr;
					}

					$Number1 = floor((29 - strlen($CurrentTime))/2);
					$Number2 = (29 - strlen($CurrentTime)) - $Number1;
					$ServiceCode = "a".rand_string($Number1).$CurrentTime.rand_string($Number2);
					$NameSearch = strtolower(trim(preg_replace('/\s+/', '', $ServiceName)));
					$Response = CheckGivenDataAvailability("Name::::$ServiceName::,::NameSearch::::$NameSearch::,::Code::::$ServiceCode",$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
					if($Response['status'] != "Success" || $Response['msg'] != "NotAvailable"){
						$Response = CheckGivenDataAvailability("Name::::$ServiceName::,::NameSearch::::$NameSearch",$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
						if($Response['status'] != "Success" || $Response['msg'] != "NotAvailable"){
							return_response('This service name already exist'); exit();
						}
						return_response('Some data found duplicate, Please try again'); exit();
					}

					$AllMaxOfferDiscount = serialize(['Amount'=>$AllMaxDiscountAmount,'Percentage'=>$AllMaxDiscountPercentage]);

					$SpecialMaxOfferDiscount = serialize(['Amount'=>$SpecialOffersMaxDiscountAmount,'Percentage'=>$SpecialOffersMaxDiscountPercentage]);

					$PrivateMaxOfferDiscount = serialize(['Amount'=>$PrivateOffersMaxDiscountAmount,'Percentage'=>$PrivateOffersMaxDiscountPercentage]);
					
					$GivenData = "Status::::Pending::,::ServiceMember::::$ServiceMember::,::Name::::$ServiceName::,::NameSearch::::$NameSearch::,::ShortDescription::::$ServicePackWork::,::Description::::$ServiceDescription::,::Code::::$ServiceCode::,::ServiceFor::::$ServiceFor::,::StartTime::::$ServiceStartTime::,::ExpTime::::$ServiceExpTime::,::CreateBy::::$LgUserUrl::,::CreateTime::::$CurrentTime::,::CreatePosition::::$LgPosition::,::CreateRank::::$LgPositionRank::,::LastUpdateBy::::$LgUserUrl::,::LastUpdateTime::::$CurrentTime::,::LastUpdatePosition::::$LgPosition::,::LastUpdateRank::::$LgPositionRank::,::AllOffersPermission::::$AllOffersPermission::,::SpecialOffersPermission::::$SpecialOffersPermission::,::PrivateOffersPermission::::$PrivateOffersPermission::,::AllMaxOfferDiscount::::$AllMaxOfferDiscount::,::SpecialMaxOfferDiscount::::$SpecialMaxOfferDiscount::,::PrivateMaxOfferDiscount::::$PrivateMaxOfferDiscount::,::TablesAndColumns::::$ServiceTablesAndColumns::,::TablesAndColumnsDefaultValues::::$TablesDefaultValues::,::TotalSelledPack::::0::,::MaxSellLimit::::$MaxSellLimit::,::Version::::1.0.0";

					$Response = InsertGivenData($GivenData,$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
					if($Response['status'] === 'Success' && $Response['code'] === 200){
						if($DbConnectionWithoutDbName->query("CREATE DATABASE service_create_$ServiceCode")){
							$Response = UpdateGivenData("Status::::$ServiceStatus","Status::::Pending::,::Code::::$ServiceCode",$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

							if($Response['status'] === 'Success' && $Response['code'] === 200){
								foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
								 return_response('Service created successfully',true,'Success',200);
							}else{
								$Response = DeleteDataFromTable("Status::::Pending::,::Code::::$ServiceCode",$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
								$DbConnectionWithoutDbName->query("DROP DATABASE service_create_$ServiceCode");
								 return_response("Service creation failed");
							}
						}else{
							$Response = DeleteDataFromTable("Status::::Pending::,::Code::::$ServiceCode",$PdoServiceManage,'service_list',$EncodeAndEncryptPass);
						    return_response("Error creating database");
						}
					}else{
						return_response($Response['msg']);
					}
				}
			}
			AddServices::ValidedData($ServiceStatus,$ServiceName,$ServiceStartTime,$ServiceStartTimeType,$ServiceExpTime,$ServiceExpTimeType,$ServiceFor,$ServiceMember,$MaxSellLimit,$AllOffersPermission,$SpecialOffersPermission,$PrivateOffersPermission,$AllMaxDiscountAmount,$SpecialOffersMaxDiscountAmount,$PrivateOffersMaxDiscountAmount,$AllMaxDiscountPercentage,$SpecialOffersMaxDiscountPercentage,$PrivateOffersMaxDiscountPercentage,$ServicePackWork,$ServiceDescription,$ServiceTablesAndColumns,$TablesDefaultValues,$SecurityCode,$BrowserClientId1,$BrowserClientId2);
		}else{
			return_response("Invalid Token Id! Refresh page");
		}
	}else{
		header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
	}
}else{
	header('Location: ' .DomainName.'/PageNotAvailable/index.php'); die();
}
?>