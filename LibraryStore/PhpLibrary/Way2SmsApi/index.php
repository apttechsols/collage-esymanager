<?php
if(isset($FileAccessCode) && $FileAccessCode === 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){

    function SendWay2Sms($ApiKey,$Secret,$UseType,$MobNo,$senderid,$Message){
        //post
        $url="https://www.way2sms.com/api/v1/sendCampaign";
        $Message = urlencode($Message,);// urlencode your message
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
        curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$ApiKey&secret=$Secret&usetype=$UseType&phone=$MobNo&senderid=$senderid&message=$Message");// post data
        // query parameter values must be given without squarebrackets.
         // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}else{
    echo 'Page not found';
}
?>