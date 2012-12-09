<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	
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


	<!--map includes-->

	   <script type="text/javascript" src="<?=base_url()?>extras/jquery.ui.map.js"></script>
    	<script type="text/javascript" src="/js/ui/jquery.ui.map.services.js"></script>
    	<script type="text/javascript" src="/js/ui/jquery.ui.map.extensions.js"></script>

 

	<!-- tities! I mean, uh, titles. -->
	<title>Kikr [alpha]</title>


	<?php if($this->uri->segment(1) == "checkins"): ?> 
	{checkins}
	    <meta property="og:title" content='{venue_name}'/>
    	<meta property="og:type" content="website"/>
    	<meta property="og:url" content="">
    	<meta property="og:site_name" content="kikr"/>
		<meta property="og:image" content="" />
    	<meta property="og:description"
          content="{user_firstName} {user_lastname} was at {venue_name}, and thinks you might want to go to. By following this 
          link, you might earn a cool discount if you visit!"/>

      {/checkins}

	<?php endif; ?>

</head> 


<body> 