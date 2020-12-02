<?php
  // Not show any error
  error_reporting(0);
  // Get server port type (exampale - http:// or https://)
  if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
    $HeaderSecureType = "https://";
  }else{
    $HeaderSecureType = "http://";
  }
  
  define("RootPath", "../../../../../../");

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
  require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
  require_once (RootPath."LibraryStore/PhpLibrary/CheckLogin/index.php");
  require_once (RootPath."LibraryStore/PhpLibrary/LogOut/index.php");
  require_once (RootPath."LibraryStore/PhpLibrary/GetSubStringBetweenTwoCharacter/index.php");
  require_once (RootPath."/LibraryStore/SiteComponents/FullPageErrorMessageDisplay/index.php");

  // Create isset time according Asia/Kolkata
  date_default_timezone_set('Asia/Kolkata');
  
  $CurrentTime = time();

  $GetOpenRequestError = False;
  $StoreResponseByData = array();

  $ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Fullname::::Mobile::::ProfileUrl::::Position::::UserUrl');
  $ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');

  if($ResponseLogin['status'] == 'Success' && $ResponseLogin['code'] == 200){
    $ResponseCheckServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$ResponseLogin['LFR'],$CurrentTime);
    if($ResponseCheckServiceBuyStatus['status'] == 'Success' && $ResponseCheckServiceBuyStatus['code'] == 200 && $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] == True){
      $DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
      if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
        $DbConnection = $DbConnection['msg'];
        $ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::".$ResponseLogin['msg']['UserUrl'],'Status::::Position',$DbConnection,$ResponseLogin['LFR'].'_member',$EncodeAndEncryptPass);
        $GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');
      }
    }
  }
  
  foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'RootPath' && $SetVarKey != 'ResponseLogin' && $SetVarKey != 'ResponseRank' && $SetVarKey != 'ResponseCheckServiceBuyStatus' && $SetVarKey != 'ServiceMemberData' && $SetVarKey != 'GetServiceSetting' && $SetVarKey != '_GET' && $SetVarKey != '_POST' && $SetVarKey != '_SESSION' && $SetVarKey != '_COOKIE' && $SetVarKey != 'RandomPass1' && $SetVarKey != 'RandomPass2' && $SetVarKey != 'RandomPass3' && $SetVarKey != 'RandomPass4' && $SetVarKey != 'RandomPass5' && $SetVarKey != 'Token_CSRF'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal); ob_end_clean();
  
  if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200 || $ResponseRank == '' || $ResponseLogin['LAS'] != 'OrganizationMember' || $ResponseCheckServiceBuyStatus['status'] != 'Success' || $ResponseCheckServiceBuyStatus['code'] != 200 || $ResponseCheckServiceBuyStatus['msg']['ServiceBuy'] != True){
    header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
  }

  if((($ServiceMemberData['status'] != 'Success' || $ServiceMemberData['code'] != 200 ) && $CheckManager == True ) || ($ServiceMemberData['msg']->Status != 'Active' && $CheckManager != false)){
      header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
  }
  if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
      foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
    FullPageErrorMessageDisplay('Service setting not feched! due to technical error',true,['MSGpadding'=>'40vh 10px']); exit();
  }
  foreach ($GetServiceSetting['msg'] as $value){
    ${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
  }
  $LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
  if($LgUserServicePositionRank == ''){
    foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
    FullPageErrorMessageDisplay('You are not a member of this service',true,['MSGpadding'=>'40vh 10px']); exit();
  }
  if($LgUserServicePositionRank != -1){
    header("Location: " . RootPath . "Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/index.php"); die();
  }

  define("PageTitle", "D GatePass : Verifyer");
  define("CssFile", "");
  require_once RootPath."Site_Header/index.php";
?>
<style>
  .PgName{
    font-size: 22px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    margin: 20px 0px;
  }
.Container{
    max-width:800px;
    width: 95%;
    margin: 20px auto;
    text-align: center;
}
#ScannerCamera,#ResponseBox{
    display: block;
    border: 5px solid green;
    max-width: 780px;
    height: 70vh;
    margin: auto;
}
#ResponseBox{
  border: 5px solid #8e8e8e;
  background: green;
  display: none;
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  padding: 10px 0px;
  width: calc(100% - 15px);
  min-height: calc(70vh - 20px);
  height: unset;
}
.PImgBox{
  border: 5px solid #fff;
  height: 180px;
  width: 180px;
  border-radius: 50%;
  margin: auto;
  overflow: hidden;
}
.PImg{
  width: 100%;
  height: 100%;
}
.PImg:hover{
  opacity: 0.6;
}
.StFullname{
  background: #8e8e8e;
  width: max-content;
  padding: 5px 10px;
  margin: 15px auto;
}
.StErrorMsg{
  background: #8e8e8e;
  padding: 15%;
  margin: 20px auto;
}
#ScannAnotherQr{
  display: none;
  border: 5px solid #8e8e8e;
  background: green;
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  height: 25px;
  padding: 10px 5px;
  width: calc(100% - 30px);
  cursor: pointer;
  margin: auto;
}
@media (max-width: 320px){
  .Container{
    margin: 10px auto;
  }
  #ResponseBox{
    width: calc(100% - 10px);
  }
}
</style>
<div class='PgName'>Verify OutGoing By QR</div>
<div class="Container">
  <video id="ScannerCamera"></video>
  <div id="ResponseBox"></div>
  <div id='ScannAnotherQr'>Scan Another QR</div>
</div>
<script src="<?php echo RootPath; ?>MainJavascript/Live_Javascript/instascan.min.js"></script>
<script type="text/javascript">
    window.Submit_process = false;
    var scanner = new Instascan.Scanner({ video: document.getElementById('ScannerCamera'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan',function(Content){

        scanner.stop();
        if(window.Submit_process == true){
          swal('','A request already in queue','warning'); return false;
        }
        StartSubmit();
        
        var client = new ClientJS();

        imprint.test(browserTests).then(function(result){
          var fingerprint_1 = new Fingerprint().get();
          var customfingerprint_1 = new Fingerprint({screen_resolution: true}).get();
          audioFingerprint.run(function (fingerprint_2) {
            var BrowserClientId1 = "<?php echo $RandomPass1; ?>".toString() + new jsSHA(fingerprint_1.toString()+customfingerprint_1.toString()+result+fingerprint_3.toString()+uid.toString()+client.getFingerprint().toString()+fingerprint_2+fingerprint_canvas()+client.getCanvasPrint()+fingerprint_display().toString()+fingerprint_touch().toString()+client.getBrowser().toString()+client.getOS().toString()+client.getScreenPrint().toString()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass2; ?>";
            

            var BrowserClientId2 = "<?php echo $RandomPass3; ?>"+ new jsSHA(customfingerprint_1.toString()+fingerprint_1.toString()+fingerprint_2+uid.toString()+client.getFingerprint().toString()+fingerprint_3.toString()+result+fingerprint_display().toString()+client.getScreenPrint().toString()+client.getBrowser().toString()+client.getOS().toString()+fingerprint_touch().toString()+client.getCanvasPrint()+fingerprint_canvas()).getHash("SHA-512", "HEX") +"<?php echo $RandomPass4; ?>";

            // append data which we want to send data on targeted page
            var formdata = new FormData();
            formdata.append("Content", Content);
            formdata.append("Token_CSRF", "<?php echo $Token_CSRF; ?>");
            formdata.append("BrowserClientId1", BrowserClientId1);
            formdata.append("BrowserClientId2", BrowserClientId2);

            if(navigator.onLine == false){
              swal('',"Please check your internet connection",'warning');
              SubmitReset(); return false;
            };
            $('#ScannerCamera').css({'display':'none'});
            $('#ResponseBox').css({'display':'block','background':'blue'});
            $("#ResponseBox").append("<div class='StErrorMsg'>QR Code checking...</div>");
            try{
              var ajax = new XMLHttpRequest();
              ajax.addEventListener("load",ResponseHandler,false);
              ajax.open("POST", 'OutGoingByQrCodeBackend.php');
              ajax.send(formdata);
            }catch(error){
               swal('',error,'warning'); SubmitReset(); return false;
            }

            function ResponseHandler(event){
              SubmitReset();
              scanner.stop();
              $('#ResponseBox').html('');
              try{
                var response = $.parseJSON(event.target.responseText);
                if(response['status'] === "Success" && response['code'] === 200){
                  $('#ResponseBox').css({'display':'block','background':'green'});
                  $('#ScannAnotherQr').css({'display':'block'});
                  $("#ResponseBox").append("<div class='PImgBox'><img class='PImg' id='PImg' src='<?php echo RootPath; ?>Users/UserDataStore/ProfileImage/Organization/<?php echo $ResponseLogin['LFR']; ?>/"+response['msg']['UserData']['ProfileUrl']+"'></div><div class='StFullname'>"+response['msg']['UserData']['Name']+"</div><div class='StErrorMsg'>"+response['msg']['msg']+"</div>");
                }else{
                  $('#ResponseBox').css({'display':'block','background':'red'});
                  $('#ScannAnotherQr').css({'display':'block'});
                  $("#ResponseBox").append("<div class='StErrorMsg'>"+response['msg']+"</div>");
                }
              }catch(error){
                $('#ResponseBox').css({'display':'block','background':'black'});
                $('#ScannAnotherQr').css({'display':'block'});
                $("#ResponseBox").append("<div class='StErrorMsg'>An technical error accour!</div>");
              }
              scanner.stop();
              return false;
            }
          });
        }); 

      function StartSubmit(){
        window.Submit_process = true;
        $(".loader_round_main").prop('hidden',false);
      }
      function SubmitReset(){
        window.Submit_process = false;
        $(".loader_round_main").prop('hidden',true);
      }
    });

    $('#ScannAnotherQr').click( function(){
      $('#ResponseBox').html('');
      $('#ResponseBox').css({'display':'none','background':'red'});
      $('#ScannAnotherQr').css({'display':'none'});
      $('#ScannerCamera').css({'display':'block'});
      Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
          if(typeof(cameras[1]) == 'object'){
              scanner.start(cameras[1]);
          }else{
              scanner.start(cameras[0]);
          }
        }else{
          console.error('No cameras found.');
          alert('No cameras found.');
        }
      }).catch(function(e){
        console.error(e);
      });
    });

    Instascan.Camera.getCameras().then(function (cameras){
      if(cameras.length>0){
        if(typeof(cameras[1]) == 'object'){
            scanner.start(cameras[1]);
        }else{
            scanner.start(cameras[0]);
        }
      }else{
        console.error('No cameras found.');
        alert('No cameras found.');
      }
    }).catch(function(e){
       console.error(e);
    });
</script>