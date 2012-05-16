

<!DOCTYPE html>

<html>
	<title>kikr</title>







	<!-- administrata -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPtuIgPpbkGxx23ZWDspwdNPjOASGmqfw&sensor=true">
    </script>

	<!-- moar administrata -->
	<script src="<?=base_url()?>extras/jquery-1.6.4.min.js"></script> 
	<script src="<?=base_url()?>extras/jquery.mobile.min.js"></script>
	<link rel="stylesheet" href="<?=base_url()?>extras/jquery.mobile.structure.min.css">

	<!--oooh, pretty --> 
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?=base_url()?>extras/kikr_theme.css" />


	<!-- viewport bs -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />



		<script src="http://js.pusher.com/1.11/pusher.min.js"></script>

		<link rel="stylesheet" href="http://alpha.kikr.in/extras/jquery.mobile.custom.css">


	</head>


		<script>
			

		// Simulates PHP's date function

		$(document).ready(function(){
	
		Date.prototype.format=function(format){var returnStr='';var replace=Date.replaceChars;for(var i=0;i<format.length;i++){var curChar=format.charAt(i);if(i-1>=0&&format.charAt(i-1)=="\\"){returnStr+=curChar}else if(replace[curChar]){returnStr+=replace[curChar].call(this)}else if(curChar!="\\"){returnStr+=curChar}}return returnStr};Date.replaceChars={shortMonths:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],longMonths:['January','February','March','April','May','June','July','August','September','October','November','December'],shortDays:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],longDays:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],d:function(){return(this.getDate()<10?'0':'')+this.getDate()},D:function(){return Date.replaceChars.shortDays[this.getDay()]},j:function(){return this.getDate()},l:function(){return Date.replaceChars.longDays[this.getDay()]},N:function(){return this.getDay()+1},S:function(){return(this.getDate()%10==1&&this.getDate()!=11?'st':(this.getDate()%10==2&&this.getDate()!=12?'nd':(this.getDate()%10==3&&this.getDate()!=13?'rd':'th')))},w:function(){return this.getDay()},z:function(){var d=new Date(this.getFullYear(),0,1);return Math.ceil((this-d)/86400000)}, W:function(){var d=new Date(this.getFullYear(),0,1);return Math.ceil((((this-d)/86400000)+d.getDay()+1)/7)},F:function(){return Date.replaceChars.longMonths[this.getMonth()]},m:function(){return(this.getMonth()<9?'0':'')+(this.getMonth()+1)},M:function(){return Date.replaceChars.shortMonths[this.getMonth()]},n:function(){return this.getMonth()+1},t:function(){var d=new Date();return new Date(d.getFullYear(),d.getMonth(),0).getDate()},L:function(){var year=this.getFullYear();return(year%400==0||(year%100!=0&&year%4==0))},o:function(){var d=new Date(this.valueOf());d.setDate(d.getDate()-((this.getDay()+6)%7)+3);return d.getFullYear()},Y:function(){return this.getFullYear()},y:function(){return(''+this.getFullYear()).substr(2)},a:function(){return this.getHours()<12?'am':'pm'},A:function(){return this.getHours()<12?'AM':'PM'},B:function(){return Math.floor((((this.getUTCHours()+1)%24)+this.getUTCMinutes()/60+this.getUTCSeconds()/ 3600) * 1000/24)}, g:function(){return this.getHours()%12||12},G:function(){return this.getHours()},h:function(){return((this.getHours()%12||12)<10?'0':'')+(this.getHours()%12||12)},H:function(){return(this.getHours()<10?'0':'')+this.getHours()},i:function(){return(this.getMinutes()<10?'0':'')+this.getMinutes()},s:function(){return(this.getSeconds()<10?'0':'')+this.getSeconds()},u:function(){var m=this.getMilliseconds();return(m<10?'00':(m<100?'0':''))+m},e:function(){return"Not Yet Supported"},I:function(){return"Not Yet Supported"},O:function(){return(-this.getTimezoneOffset()<0?'-':'+')+(Math.abs(this.getTimezoneOffset()/60)<10?'0':'')+(Math.abs(this.getTimezoneOffset()/60))+'00'},P:function(){return(-this.getTimezoneOffset()<0?'-':'+')+(Math.abs(this.getTimezoneOffset()/60)<10?'0':'')+(Math.abs(this.getTimezoneOffset()/60))+':00'},T:function(){var m=this.getMonth();this.setMonth(0);var result=this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/,'$1');this.setMonth(m);return result},Z:function(){return-this.getTimezoneOffset()*60},c:function(){return this.format("Y-m-d\\TH:i:sP")},r:function(){return this.toString()},U:function(){return this.getTime()/1000}};

		var pusher = new Pusher(''); // Replace with your app key
		var venueidChannel = pusher.subscribe('{venue_id}');


		venueidChannel.bind('checkin', function(data) {
			// Create a new item

			var dt = new Date(data.createdAt*1000);
			var time = dt.format('g\\:i a');


			var elm = '<li class="checkin-list-border ui-btn ui-btn-up-c ui-btn-icon-right ui-li-has-arrow ui-li" data-theme="c"><div class="ui-btn-inner ui-li" aria-hidden="true"><div class="ui-btn-text"><a class="single-checkin ui-link-inherit"  href="http://google.com" data-rel="dialog"><h2 class="ui-li-heading">'+data.user_firstName+' '+data.user_lastName+'  &#8594; '+data.current_kikr_score+' </h2><p class="ui-li-desc"> Time: ' + time + '</p><p class="ui-li-desc"> Times referred: ' +data.current_received_score + '</p><p class="ui-li-desc"> Referrals sent: '+data.current_init_score+' </div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span></div></li>';
				
			// Add the item to the list
			$('.pushes ul').prepend(elm);
			
			// Slide the item in

			$('.new').slideDown();
			$('.new').removeClass('new');
			
		});
		
	});

		
	</script>





		<a href="/v/settings_dialog" data-rel="dialog" data-transition="flip">
	<div data-role="header" data-position="fixed"> 
<h1>kikr @ {venue_name} </h1>	</div>
	</a>



	<div class="ui-body ui-body-a">


	

		<div class="existing-checkins pushes">

			<ul data-role="listview" data-inset="true" data-filter="true">

			<?php $i=1?>

			<?php foreach ($checkins as $checkin_item):?>

				<script> 

					Date.prototype.format=function(format){var returnStr='';var replace=Date.replaceChars;for(var i=0;i<format.length;i++){var curChar=format.charAt(i);if(i-1>=0&&format.charAt(i-1)=="\\"){returnStr+=curChar}else if(replace[curChar]){returnStr+=replace[curChar].call(this)}else if(curChar!="\\"){returnStr+=curChar}}return returnStr};Date.replaceChars={shortMonths:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],longMonths:['January','February','March','April','May','June','July','August','September','October','November','December'],shortDays:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],longDays:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],d:function(){return(this.getDate()<10?'0':'')+this.getDate()},D:function(){return Date.replaceChars.shortDays[this.getDay()]},j:function(){return this.getDate()},l:function(){return Date.replaceChars.longDays[this.getDay()]},N:function(){return this.getDay()+1},S:function(){return(this.getDate()%10==1&&this.getDate()!=11?'st':(this.getDate()%10==2&&this.getDate()!=12?'nd':(this.getDate()%10==3&&this.getDate()!=13?'rd':'th')))},w:function(){return this.getDay()},z:function(){var d=new Date(this.getFullYear(),0,1);return Math.ceil((this-d)/86400000)}, W:function(){var d=new Date(this.getFullYear(),0,1);return Math.ceil((((this-d)/86400000)+d.getDay()+1)/7)},F:function(){return Date.replaceChars.longMonths[this.getMonth()]},m:function(){return(this.getMonth()<9?'0':'')+(this.getMonth()+1)},M:function(){return Date.replaceChars.shortMonths[this.getMonth()]},n:function(){return this.getMonth()+1},t:function(){var d=new Date();return new Date(d.getFullYear(),d.getMonth(),0).getDate()},L:function(){var year=this.getFullYear();return(year%400==0||(year%100!=0&&year%4==0))},o:function(){var d=new Date(this.valueOf());d.setDate(d.getDate()-((this.getDay()+6)%7)+3);return d.getFullYear()},Y:function(){return this.getFullYear()},y:function(){return(''+this.getFullYear()).substr(2)},a:function(){return this.getHours()<12?'am':'pm'},A:function(){return this.getHours()<12?'AM':'PM'},B:function(){return Math.floor((((this.getUTCHours()+1)%24)+this.getUTCMinutes()/60+this.getUTCSeconds()/ 3600) * 1000/24)}, g:function(){return this.getHours()%12||12},G:function(){return this.getHours()},h:function(){return((this.getHours()%12||12)<10?'0':'')+(this.getHours()%12||12)},H:function(){return(this.getHours()<10?'0':'')+this.getHours()},i:function(){return(this.getMinutes()<10?'0':'')+this.getMinutes()},s:function(){return(this.getSeconds()<10?'0':'')+this.getSeconds()},u:function(){var m=this.getMilliseconds();return(m<10?'00':(m<100?'0':''))+m},e:function(){return"Not Yet Supported"},I:function(){return"Not Yet Supported"},O:function(){return(-this.getTimezoneOffset()<0?'-':'+')+(Math.abs(this.getTimezoneOffset()/60)<10?'0':'')+(Math.abs(this.getTimezoneOffset()/60))+'00'},P:function(){return(-this.getTimezoneOffset()<0?'-':'+')+(Math.abs(this.getTimezoneOffset()/60)<10?'0':'')+(Math.abs(this.getTimezoneOffset()/60))+':00'},T:function(){var m=this.getMonth();this.setMonth(0);var result=this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/,'$1');this.setMonth(m);return result},Z:function(){return-this.getTimezoneOffset()*60},c:function(){return this.format("Y-m-d\\TH:i:sP")},r:function(){return this.toString()},U:function(){return this.getTime()/1000}};

					var dt = new Date(<?php echo $checkin_item['createdAt']?> * 1000);
					var time = dt.format('g\\:i a');
					var date = dt.format('F j')
					document.getElementById('<?php echo "checkinTime" . $i?>').innerHTML = time;
					document.getElementById('<?php echo "checkinDate" . $i?>').innerHTML = date;

					</script>


				<li class="checkin-list-border">
				<a class="single-checkin" href="http://google.com" data-rel="dialog">
					<h2> <?php echo $checkin_item['user_firstName'] . " " . $checkin_item['user_lastname'];?> &#8594; <?php echo $checkin_item['current_kikr_score'];?> </h2>
					<p id="<?php echo "checkinTime" . $i?>"> </p> 
					<p> Times referred: <?php echo $checkin_item['current_received_score']; ?> </p>
					<p> Referrals sent: <?php echo $checkin_item['current_init_score'];?> </p>
					<p id="<?php echo "checkinDate" . $i?>"> </p> 


				
				</a>
				</li>
			<?php $i++?>
			<?php endforeach;?>
		

		</div>	


	</div>
</body>
</html>