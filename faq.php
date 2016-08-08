<!DOCTYPE html>
<?php
   session_start();
   include_once "header.php";
?>

<head>
   <title>FAQ</title>
   
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
   
   <script>
   $(function() {
      $(".accordion" ).accordion({
         active: 0,
         heightStyle: 'content',
         collapsible: true
      });
   });
   $(function() {
      $(".accordion-sub" ).accordion({
         active: false,
         heightStyle: 'content',
         collapsible: true
      });
   });
  </script>



</head>

<body>
   <div class='container'>
      <h1>Frequently Asked Questions</h1>
      <p>Click on a category to view the questions most asked by our users.
      If there is something else you need to know <a href='https://bits-it-crowd-melbnetworks.c9users.io/contactus.php'>click here</a>
      to contact us.
      </p>
      
      <div class='col-sm-12'>
         <!--this the jquery ui accordian. Note that each category contains another accordian with class of 'accordian-sub'-->
         <div class="accordion">
            
            <!--Recipes Category-->
            <h3>Recipes - yum yum</h3>
            <div class="accordion-sub">
               <h4>Where do all these recipes come from ?</h4>
               <p>
               We have a professional team of master chefs working around the clock to bring you the latest
               culinary delights from around the world.
               </p>
               <h4>How many recipes are there ?</h4>
               <p>
               There are more than 1,000 and less than a googolplex. And the count is growing daily. All the 
               latest recipes and much more.
               </p>
               <h4>How can I find a recipe ?</h4>
               <p>
               This is easy. There is a seach box on every page. Just type in an ingredient like "chicken" 
               and the magic just happens. Click on a recipe and away you go.
               </p>
               <h4>How can I find a recipe I found before ?</h4>
               <p>
               When you search PantryPal allows you to add a recipe to your favourites. Next time you log in those 
               favourites will be saved for you <a href='https://bits-it-crowd-melbnetworks.c9users.io/favourites.php'>here</a>
               at the Favourites page.
               </p>
            </div>
            
            <!--My List Category-->
            <h3>My List - your shopping list </h3>
            <div class="accordion-sub">
               <h4>What does it do ?</h4>
               <p>
               This incredible piece of technology allows you to produce a shopping list based on the recipes
               stored in your meal planner. 
               </p>
               <h4>How go I create a shopping list ?</h4>
               <p>
               When you search for a recipe you will be able to add it to your meal planner for a specific date and 
               meal time. The <a href='https://bits-it-crowd-melbnetworks.c9users.io/mylist.php'>'My List'</a> 
               shopping list generates a list of the ingredients needed for those recipes. 
               You just need to put in the date you saved the recipe to.
               </p>
               <h4>What can I do with my shopping list ?</h4>
               <p>
               The shopping list can be printed out so that you can take it with you to the shop. It can also be 
               emailed to the retailer of your choice.
               </p>
            </div>
            
            <!--Meal Plan Category-->
            <h3>Meal Plan - organise your gastronomic life</h3>
            <div class="accordion-sub">
               <h4>What does it do ?</h4>
               <p>
               This incredible piece of technology allows you to add recipes to a given date and mealtime on a weekly planner.
               You can move the recipes around, delete them, print the weekly planner, and add your own comments.
               </p>
               <h4>How does the planner work with the shopping list ('myList') ?</h4>
               <p>
               When you search for a recipe you will be able to add it to your meal planner for a specific date and 
               meal time. The <a href='https://bits-it-crowd-melbnetworks.c9users.io/mylist.php'>'My List'</a> 
               shopping list generates a list of the ingredients needed for those recipes. 
               From the meal plan page just click on the 'See My List' button and the shopping list is generated for you.
               </p>
               <h4>Can I reset the meal planner ?</h4>
               <p>
               To reset any changes made on the meal planner simply click the 'reset' button.
               You can reset any changes you make as long as you have not clicked 'save'.
               </p>
            </div>
            
            
            <!--User Account and Privacy Category-->
            <h3>My Account & Privacy</h3>
            <div class="accordion-sub">
               <h4>How do I become a user ?</h4>
               <p>
               Simply <a href = 'https://bits-it-crowd-melbnetworks.c9users.io/registeruser.php'>click here</a> 
               and fill in the form. It's easy !
               </p>
               <h4>How long will my account last ?</h4>
               <p>
               Your account be kept active until you decide to remove it. We haven't built any way to do this yet.
               But I am sure that will be part of the next release.
               </p>
               <h4>What do you do with my personal information ?</h4>
               <p>
               We have the right to sell all your personal details to the highest bidder on Ebay.
               </p>
               <h4>Can I access my personal details ?</h4>
               <p>
               That's a bit of a silly question isn't it ? You should know it already but I suppose we could 
               let you have if you ask us nicely.
               </p>
               <h4>Who is Quinto ?</h4>
               <p>
               A man. Just an ordinary man.
               </p>
            </div>
         </div>
      </div>
   </div>
<?php include_once "footer.php"; ?>   
   
</body>