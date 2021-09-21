<!DOCTYPE html>
<html>

<head>
	<title>Live Classroom</title>
	<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.8/css/bootstrap.css" />
	<script src='https://meet.jit.si/external_api.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<script>

 	function load_jitsi($room_name,$display_name){
 		var domain = 'meet.jit.si';
	 	var options = {
	    	roomName: $room_name,
	    	width: '100%',
	    	height: 640,
	   	userInfo: {
	      	email: 'email@jitsiexamplemail.com',
	      	displayName: $display_name
	    	},
	   	configOverwrite: {startWithAudioMuted: true,
	   		enableClosePage: false,
			},
	   	interfaceConfigOverwrite: { 
			TOOLBAR_BUTTONS: [
       		'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
        		'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
        		'etherpad', 'sharedvideo', 'raisehand',
        		'videoquality', 'filmstrip','tileview', 'download','mute-everyone', 'security'], 
				DISABLE_JOIN_LEAVE_NOTIFICATIONS: false
			},
	    	parentNode: document.querySelector('#meet')
	 	}
	 	
	 	$("#con_join").hide();

	 	var api = new JitsiMeetExternalAPI(domain, options);
	 	api.on('readyToClose', () => {
	 	console.log('close current window');
	 	window.close();
	 });
 	}

</script>

<body>

 <div id="con_join" class="container" style="background-color: black; height: 640px; margin-top: 20px;">
 	 <center>
        <button class="btn btn-primary btn-lg" id="join_meeting" onclick="load_jitsi('sample','test')" style="margin-top: 25%; width: 250px; height: 70px;">Join</button>
    </center>
 </div> 

 <div id="meet" style="margin-top: 20px;"></div>
 
</body>

</html>
