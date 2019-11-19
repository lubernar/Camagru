<!DOCTYPE html> 
<html lang="fr">
<head>
    <title>HTML5 Camera</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">

	<script type="text/javascript">

	function init() {

		navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 800, height: 600 } }).then(function(mediaStream) {
			
			var video = document.getElementById('sourcevid');
			video.srcObject = mediaStream;
			
			video.onloadedmetadata = function(e) {
				video.play();
			};
		  
		}).catch(function(err) { console.log(err.name + ": " + err.message); });
	
	}

	function clone(){
		var vivi = document.getElementById('sourcevid');
		var canvas1 = document.getElementById('cvs').getContext('2d');
		canvas1.drawImage(vivi, 0,0, 150, 112);
		var base64=document.getElementById('cvs').toDataURL("image/png");	//l'image au format base 64
		document.getElementById('tar').value='';
		document.getElementById('tar').value=base64;
	}

	window.onload = init;
	</script>
	
</head>

<body>
    
        <video id="sourcevid" height='150' width='150' autoplay="true"  style='display:inline'></video>
		
		<div id="main" style='height:150px;width:150px;margin:auto;display:inline'>
		
        <canvas id="cvs" height='150' width='150'></canvas>
		
		</div>
<button onclick='clone()' style='height:50px;width:80px;margin:auto'>photo</button>
<textarea id='tar' style='width:50%;height:200px;'></textarea>
</body>
</html>
 