<?php
	/*
	*@FileName College/index.php
	*@Des Provide dashboard layout or interface
	*@Author arpit sharma
	*/
?>
<?php
	// Not show any error
	error_reporting(0);
	// Get server port type (exampale - http:// or https://)
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
		$HeaderSecureType = "https://";
	}else{
		$HeaderSecureType = "http://";
	}

	define("RootPath", "../../../../../");

	session_start();
	$Token_CSRF = md5(rand(1345694, 9893456));
	$RandomPass1 = md5(rand(13456, 9893456));
	$RandomPass2 = md5(rand(13456, 9893456));
	$RandomPass3 = md5(rand(13456, 9893456));
	$RandomPass4 = md5(rand(13456, 9893456));
	$RandomPass5 = md5(rand(13456, 9893456));
	$_SESSION['Token_CSRF'] = $Token_CSRF;
	$_SESSION['RandomPass1'] = $RandomPass1;
	$_SESSION['RandomPass2'] = $RandomPass2;
	$_SESSION['RandomPass3'] = $RandomPass3;
	$_SESSION['RandomPass4'] = $RandomPass4;
	$_SESSION['RandomPass5'] = $RandomPass5;

	//Secrate code for access main_db file
	$DatabaseAccessCode = "Granted_Permisition_w65!X2GsD6t*P_B&BU_EUH94MvN_xNbZ";

	//Secrate code for access otherfiles file
	$FileAccessCode = "Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH";

	// Encryption pass for all data
	$EncodeAndEncryptPass ="DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx";
	require_once (RootPath."JsonShowError/index.php"); // Require Show error file
	// Access main_db file to access data base connection ($PdoMainUserAccountDb)
	require_once (RootPath."DatabaseConnections/Main/UserAccount/main_db.php");

	// Access main_db file to access data base connection ($PdoOrganizationUserAccount)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_account.php");

	// Access organization_user_setting file to access data base connection ($PdoOrganizationUserSetting)
	require_once (RootPath."DatabaseConnections/Organizations/UserAccount/organization_user_setting.php");

	// Access main_db file to access data base connection ($PdoServiceManage)
	require_once (RootPath."DatabaseConnections/Main/Services/MainServicesManage.php");

	//Create connection for any Database (CreateDbConnection(DbName))
	require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
	require_once (RootPath."LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

	/*-------------- Apt Library -----------------------*/
    require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
    require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');
	
	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
	if($ResponseRank != 1 && $ResponseRank != 2){
		$ResponseBuyedService = FetchReuiredDataByGivenData("ServiceMember::::Yes::,::Organization::::".$ResponseLogin['LFR'],"ServiceCode",$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,'all',NULL,'all');
	}else{
		$ResponseBuyedService = FetchReuiredDataByGivenData("Organization::::".$ResponseLogin['LFR'],"ServiceCode",$PdoServiceManage,'service_buy_record',$EncodeAndEncryptPass,'all',NULL,'all');
	}

	if($ResponseBuyedService['code'] != 404 && $ResponseBuyedService['code'] != 200){
		array_push($GetError, ['code'=>'3.0','dis'=>'Buyed service data can not feched!']);
	}else if($ResponseBuyedService['code'] == 404){
		array_push($GetError, ['code'=>'3.0','dis'=>'No Service Buyed For this Organization!']);
	}
	
	$UserPartOfServiceStore = array();
	foreach ($ResponseBuyedService['msg'] as $value) {

		$DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_'.strtolower($value->ServiceCode));
		if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
			$DbConnection = $DbConnection['msg'];
		}else{
			foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
			return_response('Database connection failed'); exit();
		}

		if($ResponseRank != 1 && $ResponseRank != 2){
			$UserPartOfService = FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],NULL,$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
			if($UserPartOfService['code'] != 200){
				continue;
			}
		}
		
		$GetServiceData = FetchReuiredDataByGivenData("Code::::".$value->ServiceCode,'Name',$PdoServiceManage,'service_list',$EncodeAndEncryptPass,'all');

		if($GetServiceData['code'] != 200){
			array_push($GetError, ['code'=>'6.0','dis'=>'Service list data not feched!']);
		}

		array_push($UserPartOfServiceStore, ['Name'=>$GetServiceData['msg']->Name,'Code'=>$value->ServiceCode]);
	}

	$GetOrgAllMember = AptPdoFetchWithAes(['AcceptNullCondtion'=>true, 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'1']);

	$GetOrgStaff = AptPdoFetchWithAes(['Condtion'=>'Position::::Student', 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'1','DefaultCheckType'=>'NotEqual']);
	
	$GetOrgStudent = AptPdoFetchWithAes(['Condtion'=>'Position::::Student', 'DbCon'=> $PdoOrganizationUserAccount, 'TbName'=> $ResponseLogin['LFR'], 'EPass'=> $EncodeAndEncryptPass, 'FetchRowNo'=>'1']);
    
	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseBuyedService' && $SetVarKey != 'ResponseServiceList' && $SetVarKey != 'GetError' && $SetVarKey != 'UserPartOfServiceStore' && $SetVarKey != 'GetOrgAllMember' && $SetVarKey != 'GetOrgStaff' && $SetVarKey != 'GetOrgStudent' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{
		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'OrganizationMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'College'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank == 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}

	if(($GetOrgAllMember['code'] != 200 && $GetOrgAllMember['code'] != 404) || ($GetOrgStaff['code'] != 200 && $GetOrgStaff['code'] != 404) || ($GetOrgStudent['code'] != 200 && $GetOrgStudent['code'] != 404)){
		FullPageErrorMessageDisplay('Organization Data can not be fetched due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	if($ResponseBuyedService['code'] != 200 && $ResponseBuyedService['code'] != 404){
		FullPageErrorMessageDisplay('Service Data can not be fetched due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
	}
	if($GetOrgAllMember['totalrows'] != 0){
		$RatioStaffMemberInOrg = number_format((float)($GetOrgStaff['totalrows']/$GetOrgAllMember['totalrows'])*100, 2, '.', '');
		$RatioStudentInOrg = number_format((float)($GetOrgStudent['totalrows']/$GetOrgAllMember['totalrows'])*100, 2, '.', '');
	}else{
		$RatioStaffMemberInOrg = 0;
		$RatioStudentInOrg = 0;
	}

	define("PageTitle", "Dashboard : Management Panel, College Organizations");
	define("CssFile", "Dashboard");
	require_once RootPath."Site_Header/index.php";
?>
<body>
	<div class="deskdoard">

		<!-- code for left-side bar -->
		<aside>
			<div class="asidebar">
			<div class="Header"><h1>Menu</h1></div>  
			<nav class="SideBar">
				<div class="SideBar-inner">
					<ul class="Sidebar-side">
						<?php if($ResponseRank == 1 || $ResponseRank == 2){ ?>
							<li class="Sidebar-Item MAdministration">
								<div class="desk">
									<p><img src="<?php echo RootPath; ?>Image_store/PowerRangerSuperHeroIconCustom081f47Color48px.png" style='width: 22px;'>Administration</p>
								</div>
							</li>
						<?php } ?>

						<li class="Sidebar-Item MProfile">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/PowerRangerSuperHeroIconGreen48px.png">Profile</p>
							</div>
						</li>

						<li class="Sidebar-Item">
							<div class="desk"><p class="side-link ManageMembers">
							<img src="<?php echo RootPath; ?>Image_store/UsersIconCustom5f00bfColor48px.png">Manage Member</p></div>
						</li>

						<li class="Sidebar-Item MServices">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/BagIconCustom5f00bfColor48px.png">Service</p>
							</div>
						</li>

						<li class="Sidebar-Item">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/SettingIconCustom5f00bfColor48px.png">Setting</p>
							</div>
						</li>

						<li class="Sidebar-Item MTermsAndCondtion">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/Term&ConditionIconCustom5f00bfcolor48px.png">Term & Condation</p>
							</div>
						</li>
						<li class="Sidebar-Item">
							<div class="desk">
									<p><img src="<?php echo RootPath; ?>Image_store/FAQIconCustom5f00bfColor48px.png">FAQ</p>
							</div>
						</li>

						<li class="Sidebar-Item">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/QuestionMarkIcon Custom5f00bfColor48px.png">How it work?</p>
							</div>
						</li>
								
						<li class="Sidebar-Item MContactUs">
								<div class="desk">
									<p><img src="<?php echo RootPath; ?>Image_store/ContactIconCustom5f00bfColor48px.png">Concact Us</p>
								</div>
						</li>

						<li class="Sidebar-Item MPrivacyPolicy">
								<div class="desk">
									<p><img src="<?php echo RootPath; ?>Image_store/PrivacyPolicyIconCustom5f00bfColor48px.png"style="float:left;" >Privacy Policy</p>
								</div>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		</aside>
		
		<!--  RIGHT SIDE ARTICAL START -->

		<article>
			<div class="Main-Container">
				<!--  Header-Container OF ARTICAL => SEARCHBOX  & STUDENTIMAGE -->
				<nav class="Header-Container">
					<div class="MenuShowIcon">
						<img src="<?php echo RootPath; ?>Image_store/BarIconCustom5f00bfColor48px.png">
					</div>
					<div class="SearchBox">
						<div class="SearchInpuBox">
							<img class='HeaderSearchIcon' src="<?php echo RootPath; ?>Image_store/SearchIcon.png" style="cursor: pointer;">
							<img class='HeaderSearchCloseIcon' src="<?php echo RootPath; ?>Image_store/CloseIconCustom5f00bfColor48px.png" style="display: none; cursor: pointer;">
							<input type="text" class="SearchInput" placeholder="Search"/>
						</div>
					</div>
					<div class="TopRightIconBox">
						<div><i class="fa fa-clone" aria-hidden="true"></i></div>
						<div><img src="<?php echo RootPath.'Users/UserDataStore/ProfileImage/Organization/'.$ResponseLogin['LFR'].'/'.$ResponseLogin['msg']['ProfileUrl'] ?>" class="Image" style="cursor: pointer;"></div>
						<div class="ProfileBar" style="display: none;">
								<ul>
									<?php 
										$RandMsg = ['Hello!','Hi!','Welcome!','Namaskar!','Howdy!','Good day!',"What's up!",'Hey!'];
										$RandMsg = $RandMsg[rand(0,7)];
									?>
									<p class='ProfileBarFullname' style='cursor: default;'><?php echo $RandMsg.' '.$ResponseLogin['msg']['Fullname'].' ('.$ResponseLogin['msg']['Position'].')' ?></p>

									 <li class="action">
									 	<span><img src="<?php echo RootPath; ?>Image_store/UserIcon.png" class="MenuProfileIcon">myprofile</span>
									</li>

									<li class="action">
										 <span><img src="<?php echo RootPath; ?>Image_store/ActivityIcon.png"class="MenuProfileIcon">activity</span>
									</li>

									<li class="action">
									 <span><img src="<?php echo RootPath; ?>Image_store/SupportIcon.png"class="MenuProfileIcon">Support</span>
									</li>

									<li class="action LogOut">
										<span><img src="<?php echo RootPath; ?>Image_store/LogOutIcon.png"class="MenuProfileIcon LogOut">logout<span class="LogOutSpinnerAnimationBox" hidden="true"><span class="LogOutSpinnerAnimationBox loader_button_center"><span></span></span></span></span>
									</li>

									
								</ul>
           				</div>
					</div>
				</nav>

				<div class="container">

					<!-- DEFAULT & DESKBOARD WORD -->
					<div class="defaultdesk">
						<div class="default"><p>Default</p></div>
						<div class="sidedesk" ><p><i class="fa fa-home" aria-hidden="true" style="margin-right:5px;"></i>Dashboard</p>
						</div>
					</div>

					<!-- FILTER BUTTON -->
					<div class="filter"><button>Filter</button></div>
				</div>

				<!--  4 CONTROL BOX OF RIGHT SIDE ARTICAL -->
				<?php if($ResponseRank == 1 || $ResponseRank == 2){ ?>
					<div class="Control-Box">
					
						<div class="Sub-Control-box1">

							<div class="Heading-icon">
								<div class="total-trafic SubControlA">Total Member</div>
								<div class="icon"><img src="<?php echo RootPath; ?>Image_store/UsersIconCustom5f00bfColor48px.png"></div>
							</div>
							<?php if($GetOrgAllMember['totalrows'] != 0){ ?>
								<div class="number"><h1><?php echo $GetOrgAllMember['totalrows']; ?></h1></div>
							<?php }else{ ?>
								<div class="number"><h1><?php echo '0'; ?></h1></div>
							<?php } ?>
							<?php if($GetOrgAllMember['totalrows'] != 0){ ?>
								<div class="tag-line"><h1>Good job, <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
							<?php }else{ ?>
								<div class="tag-line"><h1>Oops No Member, <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
							<?php } ?>
						</div>

						<div class="Sub-Control-box1">
							<div class="Heading-icon">
								<div class="Newuser SubControlA">Collage Staff</div>
								<div class="icon"><img src="<?php echo RootPath; ?>Image_store/UsersIconCustom5f00bfColor48px.png"></div>
							</div>
							<?php if($GetOrgStaff['totalrows'] != 0){ ?>
								<div class="number"><h1><?php echo $GetOrgStaff['totalrows']; ?></h1></div>
							<?php }else{ ?>
								<div class="number"><h1><?php echo '0'; ?></h1></div>
							<?php } ?>
							<div class="tag-line"><h1><?php echo $RatioStaffMemberInOrg; ?>% Staff in <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
						</div>

						<div class="Sub-Control-box1">
							<div class="Heading-icon">
								<div class="Sales SubControlA">Student</div>
								<div class="icon"><img src="<?php echo RootPath; ?>Image_store/UsersIconCustom5f00bfColor48px.png"></div>
							</div>
							<?php if($GetOrgStudent['totalrows'] != 0){ ?>
								<div class="number"><h1><?php echo $GetOrgStudent['totalrows']; ?></h1></div>
							<?php }else{ ?>
								<div class="number"><h1><?php echo '0'; ?></h1></div>
							<?php } ?>
							<div class="tag-line"><h1><?php echo $RatioStudentInOrg; ?>% Student in <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
						</div>
						<div class="Sub-Control-box1">
							<div class="Heading-icon">
								<div class="performance SubControlA">Total Service</div>
								<div class="icon"><img src="<?php echo RootPath; ?>Image_store/BagIconCustom5f00bfColor48px.png"></div>
							</div>
							<?php if($ResponseBuyedService['totalrows'] != 0){ ?>
								<div class="number"><h1><?php echo $ResponseBuyedService['totalrows']; ?></h1></div>
							<?php }else{ ?>
								<div class="number"><h1><?php echo '0'; ?></h1></div>
							<?php } ?>
							<?php if($ResponseBuyedService['totalrows'] != 0){ ?>
								<div class="tag-line"><h1>Good job, <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
							<?php }else{ ?>
								<div class="tag-line"><h1>Oops No Service, <?php  echo $ResponseLogin['LFRORNM']; ?></h1></div>
							<?php } ?>
						</div>
					</div>
					<div style="height: 90px; width: 100%;"></div>
				<?php } ?>
			</div>

			<!-- GraphocalReportMainBox -->

			<!-- <div class="GraphocalReportMainBox"> -->

				<!-- GraphocalReport1 -->

				<!-- <div class="GraphocalReport1 GraphocalReport">
					<div class="Grafical-table" style="border-radius: 0px 20px;">
							<div class="Grafical-table-header">
								<div class="Grafical-table-header-box left">
									<h1 style="font-size:15px; color:white;margin-left:14px; ">Overview</h1>
									<h1 style="margin: -16px 0px 2px 10px; color:#fff; ">Service Uses</h1>
								</div>
								<div class="Grafical-table-header-box-right">
									<button style="background-color:#fff;"><p style="color:blue;margin-top:5px; font-size:14px; ">Daily</p></button>
									<button style="background-color:#fff;"><p style="color:blue;margin-top:5px; font-size:14px; ">Week</p></button>
								</div>
							</div>

							<div class="Grafical-table-container">
								<div class="Grafical-table-container-chart">
									<canvas id="ServiceUsageChart" style="display: block; height: 400px; width: 100%;"></canvas>
								</div>
							</div>
					</div>
				</div> -->

				<!-- GraphocalReport2 -->

				<!-- <div class="GraphocalReport2 GraphocalReport:">
					<div class="Grafical-table" style="background-color: #fff; border:none; border-radius: 0px 20px;">
					<div class="Grafical-table-header">
						<div class="Grafical-table-header-box left">
							<h1 style="font-size:15px; color:black;margin-left:14px; ">Overview</h1>
							<h1 style="margin: -16px 0px 2px 10px; color:black; ">Active User</h1>
						</div>
						<div class="Grafical-table-header-box-right">
							<button style="background-color:#fff;"><p style="color:black;margin-top:5px; font-size:14px; ">Daily</p></button>
							<button style="background-color:#fff;"><p style="color:black;margin-top:5px; font-size:14px; ">Week</p></button>
						</div>
					</div>
					<div class="Grafical-table-container">
						<div class="Grafical-table-container-chart" style="border:none;">
							<canvas id="ActiveUserChart" style="display: block;border:none; height: 350px; width: 100%;" class="chartjs-render-monitor"></canvas>
						</div>
					</div>
				</div> -->
				</div>
			<!-- </div> -->
			<div class='Container' <?php if(sizeof($UserPartOfServiceStore) == 0 || sizeof($GetError) > 0 || sizeof($UserPartOfServiceStore) <= 1){ echo "style='grid-template-columns:1fr;'"; }?>>
				<?php
				if(sizeof($GetError) > 0){
					echo "<div style='color:#fff; font-size:20px; font-weight: bold; margin: auto; text-align: center;'>".$GetError[0]['dis']."</div>";
				}
					if(sizeof($UserPartOfServiceStore) == 0){
						echo "<div style='color:#fff; font-size:20px; font-weight: bold; margin: auto; text-align: center;'>You are not a member of any service in this organization</div>";
					}

					foreach ($UserPartOfServiceStore as $value){
						echo"<a class='ServiceBox' href='".RootPath.'Users/Service/Dashbord/'.$value['Name'].'_'.$value['Code']."/index.php'>".$value['Name']."</a>";
					}
				?>
			</div>
		</article>
	</div>
</body>
<div class='Footer'>
	<?php require_once RootPath."Site_Footer/index.php"; ?>
</div>
</html>
<script src="<?php echo RootPath; ?>MainJavascript/Live_Javascript/Chart.js"></script>
<script>
	$(document).ready(()=>{

		/*Load Chart or Creat Chart*/

		/*var ctx = document.getElementById('ServiceUsageChart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
    		type: 'line',

    			// The data for our dataset
    		data: {
        		labels: ['Mon', 'Tue', 'Wed', 'Th', 'Fri', 'Sat', 'Sun'],
        		datasets: [{
            		label: 'Sercice Uses',
            		backgroundColor: 'rgb(0, 0, 255)',
            		borderColor: 'rgb(255, 99, 132)',
            		data: [0, 10, 5, 2, 20, 30, 45]
        		},
		        ]
			},

		});

		var ctx = document.getElementById('ActiveUserChart').getContext('2d');
		var chart = new Chart(ctx, {
		    // The type of chart we want to create
		    type: 'bar',

			// The data for our dataset
    		data: {
        		labels: ['Mon', 'Tue', 'Wed', 'Th', 'Fri', 'Sat', 'Sun'],
        		datasets: [{
            		label: 'Active user',
            		backgroundColor: 'rgb(255, 0,0)',
            		borderColor: 'rgb(255, 99, 132)',
            		data: [0, 10, 5, 2, 20, 30, 45]
        			},
 				]
 			},
		});*/

		$(".Image").click(function(){
			$(".ProfileBar").slideToggle();
		});

		$(".MenuShowIcon").click(function(){
			if($('aside').css('display') === 'none'){
				$('aside').slideToggle().then($('.MenuShowIcon').css('z-index', 2));
			}else{
				$('aside').slideToggle().then($('.MenuShowIcon').css('z-index', 0));
			}
		});

		$(".HeaderSearchIcon").click(function(){
			if($('.SearchInput').css('display') === 'none'){
				$('.HeaderSearchIcon').css({"position": "absolute", "right": "0", "margin-right": "30px"});
				$('.HeaderSearchCloseIcon').css({"position": "absolute", "right": "0", "margin-right": "5px"});
				$('.SearchInput').slideToggle();
				$('.HeaderSearchCloseIcon').slideToggle();
			}else{
				window.location.href = 'ManageMembers/SearchMember/index.php?Search='+$('.SearchInput').val();
			}	
		});

		$(".HeaderSearchCloseIcon").click(function(){
			if($('.SearchInput').css('display') === 'block'){
				$('.HeaderSearchCloseIcon').slideToggle();
				$('.HeaderSearchIcon').css({"position": "unset", "right": "unset", "margin-right": "unset"});
				$('.HeaderSearchCloseIcon').css({"position": "unset", "right": "unset", "margin-right": "unset"});
				$('.SearchInput').slideToggle();
			}
		});

		$('.MAdministration').click(()=>{
			window.location.href = 'ManageAdministration/index.php';
		});

		$('.MProfile').click(()=>{
			window.location.href = 'Account/Profile/index.php';
		});

		$('.ManageMembers').click(()=>{
			window.location.href = 'ManageMembers/index.php';
		});

		$('.MServices').click(()=>{
			window.location.href = 'ManageService/index.php';
		});

		$('.MTermsAndCondtion').click(()=>{
			window.location.href = RootPath+'Page/TermsAndCondtions/index.php';
		});

		$('.MPrivacyPolicy').click(()=>{
			window.location.href = RootPath+'Page/PrivacyPolicy/index.php';
		});
	});
</script>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>