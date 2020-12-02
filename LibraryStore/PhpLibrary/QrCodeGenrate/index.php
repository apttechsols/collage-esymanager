<?php

require_once ('PhpQrCodeGenrateLibarary/qrlib.php');

function GenrateQrCode($Data=array()){
	$DataQrMsg = null; $DataFileName = null; $DataSavePath = null;
	foreach ($Data as $key => $value) {
		${'Data'. $key} = $value;
	}
	if($DataQrMsg == null || $DataFileName == null || $DataSavePath == null){
		return ['status'=>'Error','msg'=>'Inavlid data formate found','code'=>400];
	}
	QRcode::png($DataQrMsg, $DataSavePath.''.$DataFileName, QR_ECLEVEL_L, 5);
	return ['status'=>'Success','msg'=>'Qr genrate Successfully','code'=>200];
}
# GenrateQrCode(['QrMsg'=>'this is my id','FileName'=>rand(10,10000),'SavePath'=>'DGatePassQrCodeStore/']);

?>