<? php

<!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->

            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
 					<script src="//code.jquery.com/jquery-1.10.2.js"></script>
					<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
				   <link rel="stylesheet" href="/resources/demos/style.css">
					
					<script>
						  $(function() {
						    $( "#datepicker" ).datepicker();
						    $( "#anim" ).change(function() {
						      $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
						    });
						  });
					</script>
 
					<p>Date: <input type="text" id="datepicker" size="30"></p>
               
               <p>Meal:<br>
                 <select id="Meal">
                   <option value="Breakfast">Breakfast (default)</option>
                   <option value="Lunch">Lunch</option>
                   <option value="Dinner">Dinner</option>
                   <option value="Dessert">Dessert</option>
                   <option value="MorningSnack">Morning Snack</option>
                   <option value="AfternoonSnack">Afternoon Snack</option>
                 </select>
               </p>

   ?>