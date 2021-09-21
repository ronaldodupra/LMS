<!DOCTYPE html>
<html>
<?php
   //echo "Data= " .base64_decode($_REQUEST['data']);
    
   if ($_REQUEST['data'] != "") {
   	  //echo "Data= " .base64_decode($_REQUEST['data']);
   	  $data = explode("-", base64_decode($_REQUEST['data']));
      $title = $data[0];
 	  $timestamp = $data[1];
      $stud_name = $data[2];
   }
   else { 
      //echo "No data";
      $title = "";
      $timestamp = "";
      $stud_name="";
   }
?>
<head>
	<title>Live Classroom</title>
	<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.8/css/bootstrap.css" />
	<script src='https://meet.jit.si/external_api.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<script>

 	function load_jitsi($title,$timestamp,$display_name){
 		var domain = 'meet.jit.si';
	 	var options = {
	    	roomName: $title+'-'+$timestamp,
	    	width: '100%',
	    	height: 720,
		   	configOverwrite: {startWithAudioMuted: true,
		   		enableClosePage: false,
			},
		   	interfaceConfigOverwrite: { 
				TOOLBAR_BUTTONS: [
	       		'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
	        	'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
	        	'etherpad', 'sharedvideo', 'raisehand', 'videoquality', 'filmstrip',
	        	'tileview', 'download','mute-everyone', 'security'], 
				DISABLE_JOIN_LEAVE_NOTIFICATIONS: false
			},
		    parentNode: document.querySelector('#meet')
	 	}
	 	
	 	//$("#con_join").hide();

	 	var api = new JitsiMeetExternalAPI(domain, options);
	 	    api.executeCommand('displayName', $display_name);
			api.executeCommand('subject', $title);
		 	api.on('readyToClose', () => {
		 	console.log('close current window');
		 	window.close();
		});
 	}

</script>

<body onload="load_jitsi('<?php echo $title?>','<?php echo $timestamp?>','<?php echo $stud_name?>');">

 <!-- <div id="con_join" class="container" style="background-color: black; height: 710px; width: 100%;">
 	 <center>
        <button class="btn btn-primary btn-lg" id="join_meeting" onclick="load_jitsi('<?php //echo $room?>','<?php //echo $stud_name?>')" style="margin-top: 25%; width: 250px; height: 70px;">Join</button>
    </center>
 </div>  -->

 <div id="meet"></div>
 
</body>

</html>
