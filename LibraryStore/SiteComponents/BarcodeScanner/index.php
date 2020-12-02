<style>
.Container{
    max-width:800px;
    width: 95%;
    margin:auto;
    text-align: center;
    border:1px solid darkgrey;
    padding: 10px;

}
#ScannerCamera{
    border:5px solid green;
    min-height: 70%;
    width: calc(100% - 15px);
    max-width: 780px;
}
</style>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div class="Container">
<video id="ScannerCamera"></video>
</div>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
    var scanner = new Instascan.Scanner({ video: document.getElementById('ScannerCamera'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan',function(content){
        document.write(content);
        //window.location.href=content;
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
