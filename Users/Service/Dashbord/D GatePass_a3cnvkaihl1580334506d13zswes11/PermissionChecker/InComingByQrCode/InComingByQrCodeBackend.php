<?php
/*
*@FileName CheckUserByQrCodeBackend.php
*@Des ----
*@Author arpit sharma
*/

// Not show any error
error_reporting(0);
// Get server port type (exampale - http:// or https://)
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
  $HeaderSecureType = "https://";
}else{
  $HeaderSecureType = "http://";
}
// Create Domain name and save it in const variable
define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
define("RootPath", "../../../../../../");

// Get all requested data
if(isset($_POST['Content']) && isset($_POST['Token_CSRF']) && isset($_POST['BrowserClientId1']) && isset($_POST['BrowserClientId2'])){
  require_once (RootPath."JsonShowError/index.php"); // Require Show error file

  // Verify data send from same page or not
  
  if($_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/PermissionChecker/OutGoingByQrCode/index.php" || $_SERVER['HTTP_REFERER'] === DomainName."/Users/Service/Dashbord/D%20GatePass_a3cnvkaihl1580334506d13zswes11/PermissionChecker/InComingByQrCode/index.php"){
    
    session_start();
    if($_POST['Token_CSRF'] === $_SESSION['Token_CSRF']){

      // Create variable from get data by request (example Post and Get methos)

      $Content = preg_replace('!\s+!', ' ',strip_tags($_POST['Content']));


      if($_POST['BrowserClientId1'] == "" || $_POST['BrowserClientId2'] == ""){
        foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal); // Unset all vars
        return_response("Process failed! Try again later");
      }else{

        // Create New BrowserUniqueDetails
        $BrowserClientId1 = hash_hmac("sha512",str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])),'sWmM@#WvHvraIt!22a!54h^8As4e+$wMa!yQ'.str_replace($_SESSION['RandomPass2'], '', str_replace($_SESSION['RandomPass1'], '', $_POST['BrowserClientId1'])));
        
        $BrowserClientId2 = hash_hmac("sha512",str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])),'pKW%94aItyfCcTuKwMat8XyfCcE%4x*!7eFQL$re'.str_replace($_SESSION['RandomPass4'], '', str_replace($_SESSION['RandomPass3'], '', $_POST['BrowserClientId2'])));
      }


      class CheckUserRequestData{
        public static function ValidedData($Content,$BrowserClientId1,$BrowserClientId2){

          // Create isset time according Asia/Kolkata
          date_default_timezone_set('Asia/Kolkata');
          
          $CurrentTime = time();
          
          // Venue valided in backend
          if($Content != preg_replace('/[^A-Za-z0-9":};{]/',"",$Content)){
            return_response("Invalid Qr Code detect"); exit();

          }
          $TempContent = unserialize($Content);
          foreach ($TempContent as $key => $value) {
            if($key != preg_replace('/[^A-Za-z0-9]/',"",$key) || $value != preg_replace('/[^A-Za-z0-9]/',"",$value)){
              return_response("Invalid Qr Code detect"); exit();
            }
            ${'Content'. $key } = $value;
          }
          
          if(strlen($ContentReqId) != 30 || $ContentReqId != preg_replace('/[^A-Za-z0-9]/',"",$ContentReqId)){
            return_response("Invalid Qr Code detect"); exit();
          }

          // Call encode_post_input function
          CheckUserRequestData::EncryptData($ContentReqId,$BrowserClientId1,$BrowserClientId2);
        }

        // Encode data by self design method
        private static function EncryptData($ContentReqId,$BrowserClientId1,$BrowserClientId2){

          $EncodeAndEncryptPass ='DK2YMDh4BsB4qWFm&R@WpAWXw#_-quc^?#hkvmqh4WUuapq%hGN#PhS8PC4a7uwx';
          
          // Create Hash Password
          #$SecurityCode =  hash_hmac("sha256",hash_hmac("sha512",base64_encode($SecurityCode),$EncodeAndEncryptPass,true),$EncodeAndEncryptPass,false);

          // Call profile_imageResize function
          CheckUserRequestData::CkeckLoginAndAuthenticate($ContentReqId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass);
        }

        private static function CkeckLoginAndAuthenticate($ContentReqId,$BrowserClientId1,$BrowserClientId2,$EncodeAndEncryptPass){
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

          //Create connection for any Database (CreateDbConnection(DbName))
          require_once (RootPath."DatabaseConnections/Normal/CreateDbConnection.php");

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
          require_once (RootPath."LibraryStore/PhpLibrary/CheckServiceBuyStatus/index.php");
          require_once (RootPath."Users/Service/Dashbord/SMS_axtxbyl4qn1583926727nb91ipl6rj/SendSms/Fast2SmsApi/index.php");
          require_once (RootPath."LibraryStore/SiteComponents/ServiceUseReport/index.php");
          require_once (RootPath."LibraryStore/SiteComponents/ServiceStatusForOrg/index.php");

          /*-------------- Apt Library -----------------------*/
          require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoFetchWithAes/index.php");
          require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoUpdateWithAes/index.php");
          require_once (RootPath."LibraryStore/Apt/Pdo/Aes/AptPdoDeleteWithAes/index.php");

          // Check user login
          $ResponseLogin = CkeckLogin($EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserAccount,'Position::::UserUrl::::SecurityCode','ClientAndServer',['BrowserClientId1'=>$BrowserClientId1,'BrowserClientId2'=>$BrowserClientId2]);

          if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('User not login'); exit();
          }

         /* if($ResponseLogin['msg']['SecurityCode'] != $SecurityCode){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('Invalid Security code 1.0'); exit();
          }*/

          if($ResponseLogin['LAS'] === 'OrganizationMember' && $ResponseLogin['LORT'] === 'College'){
            $ResponseRank = GetSubStringBetweenTwoCharacter(FetchReuiredDataByGivenData("SettingKeyUnique::::Position",'SettingValue',$PdoOrganizationUserSetting,$ResponseLogin['LFR'],$EncodeAndEncryptPass)['msg']->SettingValue, $ResponseLogin['msg']['Position'].':', ':');
            if($ResponseRank == ''){
              foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
              return_response('Org setting data not fetched!'); exit();
            }
          }else{
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('You are not authorized for take this action'); exit();
          }

          if($ResponseLogin['status'] != 'Success' || $ResponseLogin['code'] != 200){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('Some error occur! Try again later'); exit();
          }
          $LgUserUrl = $ResponseLogin['msg']['UserUrl'];
          $LgUserPosition = $ResponseLogin['msg']['Position'];
          $LgPositionRank = $ResponseRank;
          
          if($LgUserPosition == 1 || $LgUserPosition == 2){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('You are not authorize to take this action 1.0'); exit();
          }

          CheckUserRequestData::CheckUserRequestDataProccess($ContentReqId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank);
        }
        
        private static function CheckUserRequestDataProccess($ContentReqId,$EncodeAndEncryptPass,$PdoMainUserAccountDb,$PdoOrganizationUserSetting,$PdoOrganizationUserAccount,$PdoServiceManage,$ResponseLogin,$LgUserUrl,$LgUserPosition,$LgPositionRank){

          // Create isset time according Asia/Kolkata
          date_default_timezone_set('Asia/Kolkata');
          
          $CurrentTime = time();

          $LgFor = $ResponseLogin['LFR'];

          $DGatePassServiceBuyStatus = CheckServiceBuyStatus('a3cnvkaihl1580334506d13zswes11',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
          if($DGatePassServiceBuyStatus['status'] != 'Success' || $DGatePassServiceBuyStatus['code'] != 200 || $DGatePassServiceBuyStatus['msg']['ServiceBuy'] != True/* || $DGatePassServiceBuyStatus['msg']['IsServiceActiveted'] != True*/ ){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('D GatePass service not active for this organization'); exit();
          }

          $DbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_a3cnvkaihl1580334506d13zswes11');
          if($DbConnection['status'] === 'Success' && $DbConnection['code'] === 200){
            $DbConnection = $DbConnection['msg'];
          }else{
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('Database connection failed'); exit();
          }

          $ServiceMemberData =FetchReuiredDataByGivenData("UserUrl::::$LgUserUrl",'Position',$DbConnection,$LgFor.'_member',$EncodeAndEncryptPass);

          if($ServiceMemberData['status'] != "Success" || $ServiceMemberData['code'] != 200){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('You are not authorize to take this action 1.1'); exit();
          }

          $ServiceMemberDataPosition = $ServiceMemberData['msg']->Position;

          $GetServiceSetting =  FetchReuiredDataByGivenData("SettingKeyUnique::::Position::,::SettingKeyUnique::::ServiceActiveSchedule::,::SettingKeyUnique::::SmsUpdatePermission::,::SettingKeyUnique::::GeneralSetting","SettingKeyUnique::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_setting',$EncodeAndEncryptPass,'any',NULL,'all');

          if($GetServiceSetting['status'] != "Success" || $GetServiceSetting['code'] != 200){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('Service data can not feched!'); exit();
          }

          foreach ($GetServiceSetting['msg'] as $value){
            ${'GetServiceSetting' . $value->SettingKeyUnique} = $value->SettingValue;
          }

          $LgUserServicePositionRank = GetSubStringBetweenTwoCharacter('*'.$GetServiceSettingPosition.'*', $ServiceMemberData['msg']->Position.':', '*');
          if($LgUserServicePositionRank == ''){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('You are not a member of this service'); exit();
          }
          if($LgUserServicePositionRank != -1){
            return_response('You are not authorize to take this action 1.1'); exit();
          }

          foreach (explode(',', $GetServiceSettingGeneralSetting) as $value) {
            $Temp =  explode(':', $value);
            ${'GetServiceSettingGeneralSetting' . $Temp[0]} = $Temp[1];
          }

          $TempGetServiceSettingSmsUpdatePermission = explode(',', $GetServiceSettingSmsUpdatePermission);
          foreach ($TempGetServiceSettingSmsUpdatePermission as $value) {
            $Temp =  explode('-', $value);
            ${'GetServiceSettingSmsUpdatePermission' . $Temp[0]} = $Temp[1];
          }
          if($GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Yes' || $GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Optional' ){

            $SmsServiceBuyStatus = CheckServiceBuyStatus('aXTxByL4Qn1583926727NB91IPL6rj',$PdoMainUserAccountDb,$PdoServiceManage,$EncodeAndEncryptPass,$LgFor,$CurrentTime);
            if($SmsServiceBuyStatus['status'] != 'Success' || $SmsServiceBuyStatus['code'] != 200 || $SmsServiceBuyStatus['msg']['ServiceBuy'] != True /*|| $SmsServiceBuyStatus['msg']['IsServiceActiveted'] != True*/){
              if($GetServiceSettingSmsUpdatePermissionGuardianOutGoingSmsUpdate == 'Optional'){
                $SmsServiceError = true;
              }else{
                foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
                return_response('SMS service not active for this organization'); exit();
              }
            }else{
              $SmsServiceError = false;
            }
            if($SmsServiceError == false){
              $SmsServiceDbConnection = CreateDbConnection('topicste_Ap9919t','_L6sTh-FD2*hPpSjDeWSF5tMy-7D8ct:FfMSE@,-*VZ9EP_BvJSVe-4u*PhUJuWr','topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj');
              if($SmsServiceDbConnection['status'] === 'Success' && $SmsServiceDbConnection['code'] === 200){
                $SmsServiceDbConnection = $SmsServiceDbConnection['msg'];
              }else{
                foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
                return_response('Sms service database connection failed'); exit();
              }
            }
          }
          
          $GetRequestData = FetchReuiredDataByGivenData("RequestId::::$ContentReqId","Status::::GuardianPermission::::WardenPermission::::RequestOutGoingTime::::OutGoingStatus::::ExactOutGoingTime::::InComingStatus::::RequestFrom::::SettingValue",$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all');
          
          if($GetRequestData['status'] != "Success" || $GetRequestData['code'] != 200){
            return_response(json_encode($GetRequestData));
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('Request data can not feched! due to technical error'); exit();
          }

          if(($GetRequestData['msg']->GuardianPermission != 'Approve' && $GetRequestData['msg']->GuardianPermission != 'NotNeeded') || ($GetRequestData['msg']->WardenPermission != 'Approve' && $GetRequestData['msg']->WardenPermission != 'NotNeeded') || ($GetRequestData['msg']->RequestOutGoingTime > $CurrentTime) || ($GetRequestData['msg']->OutGoingStatus != 'Approve' && $GetRequestData['msg']->OutGoingStatus != 'NotNeeded') || ($GetRequestData['msg']->InComingStatus != 'Pending' && $GetRequestData['msg']->InComingStatus != 'NotNeeded') || ($GetRequestData['msg']->Status != 'Approve' && $GetRequestData['msg']->Status != 'NotNeeded')){
            return_response('Invalid QR code detect'); exit();
          }
          $GetRequestDataSettingValueArray = unserialize($GetRequestData['msg']->SettingValue);
          if($GetRequestDataSettingValueArray['StMaxInComingTime'] < $CurrentTime){
            return_response('Your max InComing Time Expired!'); exit();
          }

          $PreStatus = $GetRequestData['msg']->Status;

         if($GetRequestData['msg']->InComingStatus == 'Pending'){
            $InComingStatus = 'Approve';
            $PreInComingStatus = $GetRequestData['msg']->InComingStatus;
          }else{
             $InComingStatus = $GetRequestData['msg']->InComingStatus;
             $PreInComingStatus = $GetRequestData['msg']->InComingStatus;
          }
          
          $GetOrgStudentData = FetchReuiredDataByGivenData("UserUrl::::".$GetRequestData['msg']->RequestFrom,"FatherMobile::::GuardianMobile::::FatherFullname::::GuardianFullname::::GuardianGender::::ProfileUrl::::Fullname",$PdoOrganizationUserAccount,$ResponseLogin['LFR'],$EncodeAndEncryptPass,'all');
          
          if($GetOrgStudentData['status'] != "Success" || $GetOrgStudentData['code'] != 200){
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('This student not exist in this Organization'); exit();
          }
          
          if($GetServiceSettingGeneralSettingGuardianPermissionPriorityFor == 'Guardian'){
            if($GetOrgStudentData['msg']->GuardianMobile != ''){
              $PGander = $GetOrgStudentData['msg']->GuardianGender;
              $PName = $GetOrgStudentData['msg']->GuardianFullname;
              $PMob = $GetOrgStudentData['msg']->GuardianMobile;
            }else{
              $PGander = 'Male';
              $PName = $GetOrgStudentData['msg']->FatherFullname;
              $PMob = $GetOrgStudentData['msg']->FatherMobile;
            }
          }else{
            $PGander = 'Male';
            $PName = $GetOrgStudentData['msg']->FatherFullname;
            $PMob = $GetOrgStudentData['msg']->FatherMobile;
          }

          $StProfileImg = $GetOrgStudentData['msg']->ProfileUrl;
          $StName = $GetOrgStudentData['msg']->Fullname;

          if($GetRequestData['msg']->ExactOutGoingTime != ''){
            $OutAndInComingDiff = $CurrentTime - $GetRequestData['msg']->ExactOutGoingTime;
            $OutAndInComingDiffString = "::,::OutAndInComingDiff::::$OutAndInComingDiff";
          }else{
            $OutAndInComingDiffString = '';
          }
          
          $Response = UpdateGivenData("Status::::Closed::,::InComingStatus::::$InComingStatus::,::ExactInComingTime::::$CurrentTime$OutAndInComingDiffString","RequestId::::$ContentReqId",$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all');
          
          if($Response['code'] === 404 || $Response['code'] === 200){
           
           if($GetServiceSettingSmsUpdatePermissionGuardianInComingSmsUpdate == 'Yes' || $GetServiceSettingSmsUpdatePermissionGuardianInComingSmsUpdate == 'Optional'){
              $SmsResponse = SendSmsByFast2Sms(['DbConnection'=>$SmsServiceDbConnection,'PdoMainUserAccountDb'=>$PdoMainUserAccountDb,'PdoServiceManage'=>$PdoServiceManage,'EncodeAndEncryptPass'=>$EncodeAndEncryptPass,'OrgUrl'=>$ResponseLogin['LFR'],'CurrentTime'=>$CurrentTime,'SmsBody'=>'25472','SendTo'=>$PMob,'sender_id'=>'FSTSMS','language'=>'english','route'=>'qt','variables'=>'{#FF#}|{#EE#}','variables_values'=>substr($StName, 0, 30)."|".substr(date('d-M-Y, h:i:s A',$CurrentTime), 0, 25),'MsgType'=>'QuickTransactional','SendBy'=>$ResponseLogin['msg']['UserUrl'],'MsgLable'=>'HDGatePass','ExtMsg'=>"Dear Guardian, Your ward (".substr($StName, 0, 30).") enter in collage at ".substr(date('d-M-Y, h:i:s A',$CurrentTime), 0, 25)]);

              if(($SmsResponse['status'] != 'Success' || $SmsResponse['code'] != 200) && ($GetServiceSettingSmsUpdatePermissionGuardianInComingSmsUpdate == 'Yes')){
                $Response = UpdateGivenData("Status::::$PreStatus::,::InComingStatus::::$PreInComingStatus::,::ExactInComingTime::,::OutAndInComingDiff","RequestId::::$ContentReqId",$DbConnection,$ResponseLogin['LFR'].'_request_store',$EncodeAndEncryptPass,'all',false,null,['AcceptNullGivenData'=>true]);
                if($Response['status'] === 'Success' && $Response['code'] === 200){
                  if($SmsResponse['surc'] == 2){
                    $error_dic = $SmsResponse['msg'];
                  }else{
                    $error_dic = 'Sms service not work properly due to technical error';
                  }
                  foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'error_dic'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
                  return_response($error_dic); exit();
                }
              }
            }
            unlink(RootPath.'Users/Service/Dashbord/D GatePass_a3cnvkaihl1580334506d13zswes11/DataStore/Service/StudentRequestApproveQrCode/'.$ResponseLogin['LFR'].'/'.$ContentReqId.'.png');
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ if($SetVarKey != 'StName' && $SetVarKey != 'StProfileImg'){ unset($$SetVarKey); }} unset($SetVarKey,$SetVarVal);
            return_response(['msg'=>'You can come inside','UserData'=>['ProfileUrl'=>$StProfileImg,'Name'=>$StName]],true,'Success',200); exit();
          }else{
            foreach (get_defined_vars() as $SetVarKey=>$SetVarVal){ unset($$SetVarKey); } unset($SetVarKey,$SetVarVal);
            return_response('A technical error occur! try again later'); exit();
          }
        } 
      }
      
      // Call classname public function 
      CheckUserRequestData::ValidedData($Content,$BrowserClientId1,$BrowserClientId2);
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