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

	define("RootPath", "../../../");

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

	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/FetchReuiredDataByGivenData/index.php");
	require_once (RootPath."LibraryStore/PdoMysqlDatabase/AesMethod/CheckGivenDataAvailability/index.php");
	require_once (RootPath."EncodeAndEncryptMethods/EncodeAndEncrypt.php");
	require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
	require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");

	$ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position');

	$ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoMainUserAccountDb,'main_member_setting',$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

	foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();// Unset all vars
	
	if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
		header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
	}else{

		if($ResponseRank == ''){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}
		if($ResponseLogin['LAS'] != 'MainMember'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else if($ResponseLogin['LORT'] != 'Main'){
			header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
		}else{
			if($ResponseRank <= 0){
				header("Location: " . RootPath . "LibraryStore/PhpLibrary/RedirectToLoginDashboard/index.php"); die();
			}
		}
	}
	define("PageTitle", "Dashboard : Main");
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
						<li class="Sidebar-Item MAdministration">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/PowerRangerSuperHeroIconCustom081f47Color48px.png" style='width: 22px;'>Administration</p>
							</div>
						</li>

						<li class="Sidebar-Item">
							<div class="desk"><p class="side-link ManageMembers">
							<img src="<?php echo RootPath; ?>Image_store/UsersIconCustom5f00bfColor48px.png">Manage Member</p></div>
						</li>

						<li class="Sidebar-Item ManageServices">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/BagIconCustom5f00bfColor48px.png">Manage Service</p>
							</div>
						</li>

						<li class="Sidebar-Item">
							<div class="desk">
								<p><img src="<?php echo RootPath; ?>Image_store/SettingIconCustom5f00bfColor48px.png">Setting</p>
							</div>
						</li>

						<li class="Sidebar-Item">
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
								
						<li class="Sidebar-Item">
								<div class="desk">
									<p><img src="<?php echo RootPath; ?>Image_store/ContactIconCustom5f00bfColor48px.png">Concact Us</p>
								</div>
						</li>

						<li class="Sidebar-Item">
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
						<div><img src="<?php echo RootPath.'Users/UsersProfileManage/'.$ResponseLogin['msg']['ProfileUrl'] ?>" class="Image" style="cursor: pointer;"></div>
						<div class="ProfileBar" style="display: none;">
								<ul>
									<?php 
										$RandMsg = ['Hello!','Hi!','Welcome!','Namaskar!'];
										$RandMsg = $RandMsg[rand(0,3)];
									?>
									<p class='ProfileBarFullname' style='cursor: default;'><?php echo $RandMsg.' '.$ResponseLogin['msg']['Fullname'] ?></p>

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
										<span><img src="<?php echo RootPath; ?>Image_store/LogOutIcon.png"class="MenuProfileIcon">logout</span>
									</li>

									
								</ul>
           				</div>
					</div>
				</nav>

				<div class="container">

					<!-- DEFAULT & DESKBOARD WORD -->
					<div class="defaultdesk">
						<div class="default"><p>Default</p></div>
						<div class="sidedesk" ><p><i class="fa fa-home" aria-hidden="true" style="margin-right:5px;"></i>Deskboard</p>
						</div>
					</div>

					<!-- FILTER BUTTON -->
					<div class="filter"><button>Filter</button></div>

				</div>

				<!--  4 CONTROL BOX OF RIGHT SIDE ARTICAL -->

				<div class="Control-Box">
				
					<div class="Sub-Control-box1">

						<div class="Heading-icon">
							<div class="total-trafic SubControlA">Total-Member</div>
							<div class="icon"><img src="<?php echo RootPath; ?>Image_store/ThumbUp.png" style="margin:8px 0 0 8px;"></div>
						</div>
						<div class="number"><h1>350857</h1></div>
						<div class="tag-line"><h1>3.48% since last month</h1></div>
					</div>

					<div class="Sub-Control-box1">
						<div class="Heading-icon">
							<div class="Newuser SubControlA">New Member</div>
							<div class="icon"><img src="<?php echo RootPath; ?>Image_store/User.png" style="margin:8px 0 0 8px;"></div>
						</div>
						<div class="number"><h1>2345</h1></div>
						<div class="tag-line"><h1>3.48% since last month</h1></div>
					</div>

					<div class="Sub-Control-box1">
						<div class="Heading-icon">
							<div class="Sales SubControlA">Total User</div>
							<div class="icon"><img src="<?php echo RootPath; ?>Image_store/money.png" style="margin:8px 0 0 8px;"></div>
						</div>
						<div class="number"><h1>46765</h1></div>
						<div class="tag-line"><h1>3.48% since last month</h1></div>
					</div>
					<div class="Sub-Control-box1">
						<div class="Heading-icon">
							<div class="performance SubControlA">New User</div>
							<div class="icon"><img src="<?php echo RootPath; ?>Image_store/chart.png" style="margin:8px 0 0 8px;"></div>
						</div>
						<div class="number"><h1>4336867</h1></div>
						<div class="tag-line"><h1>3.48% since last month</h1></div>
					</div>
					</div>
					<div style="height: 90px; width: 100%;"></div>
			</div>

			<!-- GraphocalReportMainBox -->

			<div class="GraphocalReportMainBox">

				<!-- GraphocalReport1 -->

				<div class="GraphocalReport1 GraphocalReport">
					<div class="Grafical-table" style="border-radius: 0px 20px;">
							<div class="Grafical-table-header">
								<div class="Grafical-table-header-box left">
									<h1 style="font-size:15px; color:white;margin-left:14px; ">overview</h1>
									<h1 style="margin: -16px 0px 2px 10px; color:#fff; ">sales value</h1>
								</div>
								<div class="Grafical-table-header-box-right">
									<button style="background-color:#fff;"><p style="color:blue;margin-top:5px; font-size:14px; ">Month</p></button>
									<button style="background-color:#fff;"><p style="color:blue;margin-top:5px; font-size:14px; ">Week</p></button>
								</div>
							</div>

							<div class="Grafical-table-container">
								<div class="Grafical-table-container-chart">
									<canvas id="myChart" style="display: block; height: 400px; width: 100%;"></canvas>
									<script>
											var ctx = document.getElementById('myChart').getContext('2d');
												var chart = new Chart(ctx, {
								    			// The type of chart we want to create
								    		type: 'line',

								    			// The data for our dataset
								    		data: {
								        		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
								        		datasets: [{
								            		label: 'My First dataset',
								            		backgroundColor: 'rgb(0, 0, 255)',
								            		borderColor: 'rgb(255, 99, 132)',
								            		data: [0, 10, 5, 2, 20, 30, 45]
								        					},
								 				        		]},

								 				        });
									</script>
								</div>
							</div>
					</div>
				</div>

				<!-- GraphocalReport2 -->

				<div class="GraphocalReport2 GraphocalReport:">
					<div class="Grafical-table" style="background-color: #fff; border:none; border-radius: 0px 20px;">
					<div class="Grafical-table-header">
						<div class="Grafical-table-header-box left">
							<h1 style="font-size:15px; color:black;margin-left:14px; ">overview</h1>
							<h1 style="margin: -16px 0px 2px 10px; color:black; ">Total</h1>
						</div>
					</div>
					<div class="Grafical-table-container">
						<div class="Grafical-table-container-chart" style="border:none;">
							<canvas id="Chart" style="display: block;border:none; height: 350px; width: 100%;" class="chartjs-render-monitor"></canvas>
						</div>
					</div>
				</div>
				</div>
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

		var ctx = document.getElementById('myChart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
    		type: 'line',

    			// The data for our dataset
    		data: {
        		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        		datasets: [{
            		label: 'My First dataset',
            		backgroundColor: 'rgb(0, 0, 255)',
            		borderColor: 'rgb(255, 99, 132)',
            		data: [0, 10, 5, 2, 20, 30, 45]
        		},
		        ]
			},

		});

		var ctx = document.getElementById('Chart').getContext('2d');
		var chart = new Chart(ctx, {
		    // The type of chart we want to create
		    type: 'bar',

			// The data for our dataset
    		data: {
        		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        		datasets: [{
            		label: 'My First dataset',
            		backgroundColor: 'rgb(255, 0,0)',
            		borderColor: 'rgb(255, 99, 132)',
            		data: [0, 10, 5, 2, 20, 30, 45]
        			},
 				]
 			},
		});

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

		$('.ManageServices').click(()=>{
			window.location.href = 'ManageServices/index.php';
		});
	});
</script>
<?php /* Remove all vars of php */ foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); ?>