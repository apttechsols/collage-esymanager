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

	if(isset($FileAccessCode) && $FileAccessCode === 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
			define('AES_256_CBC', 'aes-256-cbc');
			class EncodeAndEncrypt
			{	
				private static function encode_string($data){
					$data = str_split($data); 
					$newencoded_string = "";
					for($i = 0; $i<sizeof($data); $i++){
						$newencoded_char = base64_encode($data[$i]);
						$newencoded_string = "$newencoded_string$newencoded_char";
					}
					return $newencoded_string;
				}

				private static function decode_string($data){
					$newdecoded_string = "";
					$i = 0;
					while($i < strlen($data)){
						$newdecoded_char = base64_decode(substr($data, $i, 4));
						$newdecoded_string = "$newdecoded_string$newdecoded_char";
						$i = $i+4;
					}
					return $newdecoded_string;
				}
				private static function encrypt_method($data, $key, $get_PADDING){
					$AutoKey = 'crWRWYxZVrQ3%*$UZrFwALJ4b^k%u#4MjG6-CuWwXjh?L';
					$iv = "7%nJCh?cH4=*64^w";
					$encryption_key = hash_hmac("sha512","$key$AutoKey$iv","$key$iv$AutoKey$iv$key", true);
					// Encrypt $data using aes-256-cbc cipher with the given encryption key and
					// our initialization vector. The 0 gives us the default options, but can
					// be changed to OPENSSL_RAW_DATA or OPENSSL_ZERO_PADDING
					//openssl_encrypt
					$encrypted = openssl_encrypt($data, AES_256_CBC, $encryption_key, $get_PADDING, $iv);
					return $encrypted;
				}
				private static function decrypt_method($data, $key, $get_PADDING){
					$AutoKey = 'crWRWYxZVrQ3%*$UZrFwALJ4b^k%u#4MjG6-CuWwXjh?L';
					$iv = "7%nJCh?cH4=*64^w";
					$decryption_key = hash_hmac("sha512","$key$AutoKey$iv","$key$iv$AutoKey$iv$key", true);
					// Encrypt $data using aes-256-cbc cipher with the given encryption key and
					// our initialization vector. The 0 gives us the default options, but can
					// be changed to OPENSSL_RAW_DATA or OPENSSL_ZERO_PADDING
					//openssl_decrypt
					$decrypted = openssl_decrypt($data, AES_256_CBC, $decryption_key, $get_PADDING, $iv);
					return $decrypted;
				}
				private static function ShowEncodeAndEncryptErrorMsg(){
					return ['status'=>'Error','msg'=>'Process failed! Try again later','code'=>'400'];
				}

				public static function exe_task_private($getTask, $getData, $getKey, $get_PADDING){
					
					if(strlen($getTask) < 1){
						EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();

					}else{
						$getTask_Array = explode(":",$getTask);
						$getTask_ArraySize = sizeof($getTask_Array);
					}
					if($get_PADDING !== "true" && $get_PADDING !== "false"){
						EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
					}else{
						if($get_PADDING == "true"){
							$get_PADDING = 1;
						}else{
							$get_PADDING = 0;
						}
					}
					
					for($i = 0; $i < $getTask_ArraySize; $i++){
						if($getTask_Array[$i] == "encode_string"){
							$getData = EncodeAndEncrypt::encode_string($getData);
							if($getData == null || $getData == ""){
								EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
							}
						}else if($getTask_Array[$i] == "decode_string"){
							$getData =  EncodeAndEncrypt::decode_string($getData);
							if($getData == null || $getData == ""){
								EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
							}
						}else{
							if(strlen($getKey) < 32 || strlen($getKey) > 256){
								EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
							}else if($getTask_Array[$i] == "encrypt_method"){
								$getData =  EncodeAndEncrypt::encrypt_method($getData, $getKey, $get_PADDING);
								if($getData == null || $getData == ""){
									EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
								}
							}else if($getTask_Array[$i] == "decrypt_method"){
								$getData =  EncodeAndEncrypt::decrypt_method($getData, $getKey, $get_PADDING);
								if($getData == null || $getData == ""){
									EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
								}
							}else{
								EncodeAndEncrypt::ShowEncodeAndEncryptErrorMsg();
							}
						}
					}
					return ['status'=>'Success','msg'=>$getData,'code'=>200];
					// Variable_Name = ob_get_contents();
					//ob_end_clean();   Required for right output
				}
			}
			// Call function doc
			//EncodeAndEncrypt::exe_task_private("encode_string:encrypt_method" ,$Take_current_time, $EncodeAndEncryptPass,"false"); // Encrypt Encode Take current time
			//$Save_VarName = ob_get_contents();
			//ob_end_clean();
	}else{
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
	}
?>				