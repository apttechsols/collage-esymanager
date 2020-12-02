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
	header("Location: " . DomainName . "/LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php");
	die();
    /*
    
	ChangeMemberPermissionRankUpTo :- (... organization_user_setting ) Database
	
	    - It used to define who can change/update existing member in organization. 
	    - Formate - 0,2 or 0,e or e,e, e,2 etc
	    - Here we give to position. Members who belong b/w these to postion can able to change/update existing member
	    
    AddMemberRankUpTo :- (... organization_user_setting ) Database

    - It used to define who can add new member in organization. 
    - Formate - 0,2 or 0,e or e,e, e,2 etc
    - Here we give to position. Members who belong b/w these to postion can able to add new member
    
    SearchMemberRankUpTo :- (... organization_user_setting ) Database

    - It used to define who can search member in organization. 
    - Formate - 0,2 or 0,e or e,e, e,2 etc
    - Here we give to position. Members who belong b/w these to postion can search member
    
    
    ---------------  *** Functions *** -----------------
    
    get_string_between :- Syntex : GetSubStringBetweenTwoCharacter($string, $start, $end)
    Des :- It return substring between to charters from a string
          $string - Given string, $start - Staring character from where substring start, $end - Ending character where substring ended
    Use :- GetSubStringBetweenTwoCharacter($fullstring, '[tag]', '[/tag]'); 

    --------------- **** Services *** ------------------
    D GatePass :- 
    	> DbName - topicste_service_create_a3cnvkaihl1580334506d13zswes11
    	> Code - a3cnvkaihl1580334506d13zswes11

    SMS :- 
    	> DbName - topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj
    	> Code - aXTxByL4Qn1583926727NB91IPL6rj


    ---------------  *** Full Function Define *** -----------------
    ConvertToDayFromsec :-
    Des :- It return seconds as datw : hour : min : sec
    function ConvertToDayFromsec($seconds){
        $dt1 = new DateTime("@0");
        $dt2 = new DateTime("@$seconds");
        return $dt1->diff($dt2)->format('%a Day : %h Hour : %i Min : %s sec');
    }

	*/
?>