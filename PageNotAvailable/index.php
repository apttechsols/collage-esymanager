<?php
	error_reporting(0);
	require_once ("../JsonShowError/index.php"); // Require Show error file
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey !== 'Response'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); // Unset all vars
	return_response("This page not available");
?>