
<!--facebook javascript sdk -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- end facebook include. so much wizardry. -->



<div data-role="page">

	<a href="/u/settings_dialog" data-rel="dialog" data-transition="flip">
	<div data-role="header" data-position="fixed"> 
		<h1>{firstName}'s Kikr </h1>
	</div>
	</a>



	<div data-role="content" class="ui-body-b">

		<h1> My Recent Checkins </h1>
		<br>	

		<div class="checkin">

		<?php if (empty($checkins)): ?>

		<h2> You'll need to check-in on Foursquare to your favorite Kikr-enabled venues for anything to show up here! </h2>
		
		<?php endif; ?>

		{checkins}
			<h2>{venue_name} </h2>
			<h3> Referrals you've redeemed: {current_received_score} </h3>
			<h3> Referrals you've sent:  {current_init_score} </h3>
			

				<fb:like href="https://localhost/checkins/view/{id}" send="false" layout="button_count" width="450" show_faces="false" action="recommend"></fb:like>
		
			<div> <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://localhost/checkins/{id}" data-text="I was at {venue_name}. You should go to!" data-hashtags="kikr">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> </div>

		{/checkins}

		</div>
	</div>

		<!-- <div data-role="footer" data-position="fixed"> 
			<div class="ui-custom-footer"> 

			    <a class="ui-bar-b" href="/u/settings"> settings </a>
			    </br>
				<a class="ui-bar-b" href="/u/logout"> log-out </a>
			
			
			 </div>
		</div> 	 -->
	
</div>

