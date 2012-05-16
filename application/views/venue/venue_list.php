
<!--facebook javascript sdk -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=240675212680102";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- end facebook include. so much wizardry. -->



<div data-role="page">

<a href="/u/settings_dialog" data-rel="dialog" data-transition="flip">
	<div data-role="header" data-position="fixed"> 
		<h1>Kikr [Venue]</h1>
	</div>
	</a>

	<div data-role="content" class="ui-body-a">

		<h1> My Venues </h1>	

		<div class="checkin">

		{venues}

		<div> 
			<h2><a href="/v/set/{venue_id}" rel="external"> {venue_name} </a> </h2>

			<!-- we'll have things like is_kikr_enabled here -->
		</div>

		{/venues}

		</div>
	</div>

	
</div>

