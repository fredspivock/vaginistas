<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/style.jrac.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet">
	

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body id="body">


	@include('navbar.navbar')

	<div class="container">
	
	<!-- Adds Flash Messages -->
	@if(Session::has('flash_notification.message'))

		@include('partials.flash')
	
	@endif
	<!-- End Flash Messages -->

	@yield('content')

	@yield('footer')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	 <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<!-- The main application script -->
{!! Html::script("js/all.js") !!}
	   
	 	<!-- Move scripts to JS page-->


	   <script type="text/javascript">
  			
  				$(document).ready(function(){
    			$( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd"});


          


            });

          //Tag Selecting
          $('select').select2({placeholder: 'Place Tags Here', tags:true});


          var imageWidth = $('.container').width();

          

          var cropHeight;

          var cropWidth;

          var viewportHeight;
          var viewportWidth;


          function multiplierfunc()
          {

            var multiplier = imageWidth/cropWidth;

            console.log($('#imageWidth').val());
            console.log($('#imageHeight').val());

            console.log(multiplier);

            $('#imageWidth').val($('#imageWidth').val() / multiplier);
            $('#imageHeight').val($('#imageHeight').val() / multiplier);

            console.log($('#imageWidth').val());
            console.log($('#imageHeight').val());

            console.log('aaaa');
          }

          if( $('#editImageProfile').length ) 
          {
              cropHeight = 200;
              cropWidth = 200;
              viewportHeight = 200;
              viewportWidth = 200;
          }
          else
          {
              cropHeight = 400;
              cropWidth = 960;
              viewportHeight = imageWidth;
              viewportWidth = imageWidth * 400/900;
          }

        

  			$('#imageEdit').jrac({
    		'crop_width':  cropWidth,
    		'crop_height': cropHeight,
    		'crop_left': 100,
    		'crop_top': 100,
    		'image_width': 400,
        'viewport_width': viewportHeight,
        'viewport_height': viewportWidth,
   			'viewport_onload': function() {
      		var $viewport = this;
      		var inputs = $viewport.$container.parent('.pane').find('.coords input:text');
     		 var events = ['jrac_crop_x','jrac_crop_y','jrac_crop_width','jrac_crop_height','jrac_image_width','jrac_image_height'];
      		for (var i = 0; i < events.length; i++) {
        var event_name = events[i];
        // Register an event with an element.
        $viewport.observator.register(event_name, inputs.eq(i));
        // Attach a handler to that event for the element.
        inputs.eq(i).bind(event_name, function(event, $viewport, value) {
          $(this).val(value);
        })
        // Attach a handler for the built-in jQuery change event, handler
        // which read user input and apply it to relevent viewport object.
        .change(event_name, function(event) {
          var event_name = event.data;
          $viewport.$image.scale_proportion_locked = $viewport.$container.parent('.pane').find('.coords input:checkbox').is(':checked');
          $viewport.observator.set_property(event_name,$(this).val());
        })
      }
    }
  })
  // React on all viewport events.
  .bind('jrac_events', function(event, $viewport) {
    var inputs = $(this).parents('.pane').find('.coords input');
    inputs.css('background-color',($viewport.observator.crop_consistent())?'chartreuse':'salmon');
  });

		
  		


 		 </script>
</div>
</body>
</html>