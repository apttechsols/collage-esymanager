<?php
	// Not show any error
	error_reporting(0);
	define("RootPath", "../../");
	header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php");
	die();
?>