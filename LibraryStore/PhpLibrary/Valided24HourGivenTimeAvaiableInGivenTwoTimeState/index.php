<?php
	/*
	*@filename Valided24HourGivenTimeAvaiableInGivenTwoTimeState/index.php
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
	function Valided24HourGivenTimeAvaiableInGivenTwoTimeState($Data = array()){
		$CheckForThisHour = date('H');
		$CheckForThisMin  = date('i');

		foreach ($Data as $key => $value){
			${$key} = $value;
		}

		if($StartTimeHour == '' || $EndTimeHour == '' || $StartTimeMin == '' || $EndTimeMin == '' || $CheckForThisHour == '' || $CheckForThisMin == ''){
			return ['status'=>'Error','msg'=>'Invalid data found Or Data Not Found 1.0'.$StartTimeHour,'code'=>404];
		}

		if($StartTimeHour < $EndTimeHour){
			# Time Start time Lower (Lower) To End Time Grater (Grater)
			$TimeBehaviour = 'LTG';
		}else if($StartTimeHour > $EndTimeHour){
			# Time Start time Grater (Grater) To End Time Lower (Lower)
			$TimeBehaviour = 'GTL';
		}else if($StartTimeMin < $EndTimeMin){
			# Time Start time Lower (Lower) To End Time Grater (Grater)
			$TimeBehaviour = 'LTG';
		}else if($StartTimeMin > $EndTimeMin){
			# Time Start time Grater (Grater) To End Time Lower (Lower)
			$TimeBehaviour = 'GTL';
		}else if($StartTimeHour == $EndTimeHour && $StartTimeMin == $EndTimeMin){
			# Time Start time Equal To End Time Grater (Equal To Equal)
			$TimeBehaviour = 'ETE';
		}else{
			return ['status'=>'Error','msg'=>'Invalid data found 2.0','code'=>400];
		}

		if($TimeBehaviour == 'LTG'){
			if(($CheckForThisHour > $StartTimeHour && $CheckForThisHour < $EndTimeHour) || (($CheckForThisHour == $StartTimeHour && $CheckForThisMin >= $StartTimeMin) && ($CheckForThisHour < $EndTimeHour)) || (($CheckForThisHour > $StartTimeHour) && ($CheckForThisHour == $EndTimeHour && $CheckForThisMin <= $EndTimeMin)) || (($CheckForThisHour == $StartTimeHour && $CheckForThisMin >= $StartTimeMin) && ($CheckForThisHour == $EndTimeHour && $CheckForThisMin <= $EndTimeMin))){
				return ['status'=>'Success','msg'=>'It is Valid time according given or default time (LTG)','code'=>200];
			}else{
				return ['status'=>'Error','msg'=>'It is Invalid time according given or default time (LTG)','code'=>400];
			}
		}else if($TimeBehaviour == 'GTL'){
			if(($CheckForThisHour > $StartTimeHour) || ($CheckForThisHour == $StartTimeHour && $CheckForThisMin >= $StartTimeMin) || ($CheckForThisHour < $EndTimeHour) || ($CheckForThisHour == $EndTimeHour && $CheckForThisMin <= $EndTimeMin)){
				return ['status'=>'Success','msg'=>'It is Valid time according given or default time (GTL)','code'=>200];
			}else{
				return ['status'=>'Error','msg'=>'It is Invalid time according given or default time (GTL)','code'=>400];
			}
		}else if($TimeBehaviour == 'ETE'){
			return ['status'=>'Error','msg'=>'It is Invalid time according given or default time (ETE)','code'=>400];
			#return ['status'=>'Success','msg'=>'It is Valid time according given or default time (ETE)','code'=>200];
		}else{
			return ['status'=>'Error','msg'=>'Invalid data found 3.0','code'=>400];
		}
	}
?>