<?php
	/*
	@Note-> User ( //foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'NotUnsetVarName'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);  ob_end_clean(); // Unset all vars ) before call return_response function to unset all veriables
	*/
	error_reporting(0);
	function return_response($response_msg, $exit_request = true, $response_status = "Error", $response_code = null, $SVDS_Storage = null){
		if($response_msg === null){
			$response_status = "Error";
			$response_msg = "No response msg found";
		}
		unset($Response);
		$Response = array();
		$Response['status'] = $response_status;
		$Response['msg'] = $response_msg;
		$Response['code'] = $response_code;
		$Response['SVDS_Storage'] = $SVDS_Storage;
		unset($response_msg,$response_status,$response_code,$SVDS_Storage);
		ob_end_clean();
		if($exit_request == true){
			unset($exit_request);
			echo json_encode($Response);
			exit();
		}else{
			unset($exit_request);
			echo json_encode($Response);
		}
	}
	//return_response("Unknown error occurred",false);
	if(defined('RootPath')){
		require_once (RootPath."LibraryStore/SiteComponents/CommonPage/index.php");
	}
?>