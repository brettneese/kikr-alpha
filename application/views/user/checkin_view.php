	<div data-role="header" data-position="inline">
			<h1>kikr</h1>
		</div>


	<div class="ui-body ui-body-a">
    

		<div class="existing entries">


        <?php if ($this->session->userdata('logged_in') == TRUE):?>

		{checkins}
	  
        	 <h1> {user_firstName} {user_lastname} was at <a href="http://foursquare.com/v/{venue_id}"> {venue_name} </a>, and thinks you might want to go too! </h1>
         	 <h2> ... and by using Kikr, you'll earn a cool discount if you decide to visit! </h2>
             <h3> Sadly, this venue isn't Kikr-enabled quite yet, but you can still earn points for referring your friends. Learn more. </h3>
        	<h1> <a href="/checkins/addtodo/"> I want to do this! </a> </h1>
            <h2> <a href="/" rel="external"> Nevermind, take me to my dashboard. </a> </h2>
        	 </br> </br>


            <script type="text/javascript">
            
               $(function() {
                // Also works with: var yourStartLatLng = '59.3426606750, 18.0736160278';
                var yourStartLatLng = new google.maps.LatLng({venue_lat}, {venue_lng});
                $('#map_canvas').gmap({'center': yourStartLatLng});
                $('#map_canvas').gmap('addMarker', { 'position': yourStartLatLng, 'bounds': true } );
         });             
         </script>

         	 <div id="map_canvas" style="width:250px;height:250px"></div>

         	<h3> {venue_name}
         	<h3> {venue_location_address} </h3>
         	<h3> {venue_city}, {venue_state} </h3>

         		</br>
         
      	 
    	{/checkins}

    	<?php else: ?>
	
			{checkins}
    			  
        	 <h1> {user_firstName} {user_lastname} was at {venue_name}, and thinks you might want to go too! </h1>
         	 <h2> ... and by using Kikr, you'll earn a cool discount next time you visit! </h2>
        	 <a href="/u/login" rel="external"> login </a>
            
            {/checkins}

        <?php endif; ?>
		</div>	


	</div>
</body>
</html>