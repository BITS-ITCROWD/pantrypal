<!DOCTYPE html>
<?php
   session_start();
   include("config.php");
   //adds the header
   include_once "header.php";
   include_once "sidebar.php";
   //include("mp2.php");

   if(!isset($_SESSION['login_userid'])){
      header("Location: index.php");
   }
   else{
      $userID = $_SESSION['login_userid'];
   }


?>

<head>
   <title>MP test</title>
   <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script>
    $(document).ready(function(){
      $(".update").click(function(){
         
      if (this.id=="update1"){
         console.log("clicked update json 1");

         // $.ajax({
         //    async: true,
         //    url: "mp2.php",
         //    type: 'POST',
         //    data: 'JSON',
         //    success: function(data) {
         //       //var myObj = $.parseJSON(data);
         //       console.log(data);
         //    }
         // });

         
         $.ajax({
            async: true,
            url: "mp1.json",
            success: function(data) {
               var Jstring = JSON.stringify(data);
               var myObj = JSON.parse(Jstring);
               console.log(myObj);
               
               // myObj =  jsonArray.getJSONObject(0).getJSONObject("colour");
               // colour.put("colour", "green");
               
               var newJSON = "";
               newJSON = "[\n";
               newJSON +="{\n";
               newJSON +="\"id\": \"1\",\n";
               newJSON +="\"thing\": \"box\",\n";
               newJSON +="\"colour\": \"green\",\n";
               newJSON +="\"shape\": \"rhomboid\"\n";
               newJSON +="}\n";
               newJSON += "]"; 

               newJSONstring = JSON.stringify(newJSON);
               var encoded = btoa(newJSON);
               //console.log(encoded);
         
               
               var xhr = new XMLHttpRequest();
               xhr.open('POST','mp3.php',true);
               xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
               xhr.send('json=' + encoded);
                     
               
               // $.ajax({
               // async: true,
               // type: 'POST',
               // url: "mp2.php", 
               // data: {newData:newJSON},
               // dataType: "JSON", 
               // success: console.log("JSON should be updated?")  
               // });
               
               
               
            }
         });
         
         
         
      } else {
         console.log("clicked update json 2");
      }
         
      });
      
    });

   </script>


</head>




<body>
   <?php include("mp2.php"); ?>
   
   // <?php
   // $jstring = file_get_contents($myfile);
   // $jobj = json_decode($jstring);
   // var_dump($jobj);
   
   
   // echo "<div class = 'col-sm-9'>";
   // echo "<form id='myForm' method='post' action=".$_SERVER['PHP_SELF'].">";
   // foreach ($jobj as $part) {
   //    foreach ($part as $key=>$value) {
   // //echo "{$key} => {$value} ";
   //    if ($key == "colour"){
   //       echo "<label for='aaa'>".$key."</label>";
   //       echo "<input type='text' id='aaa' value='".$value."'>";
   //       echo "<button type='button' class='update' id='update1'>update json 1</button></br>";  
   //    }

   //    if ($key == "thing"){
   //       echo "<label for='bbb'>".$key."</label>";
   //       echo "<input type='text' id='bbb' value='".$value."'>";
   //       echo "<button type='button' class='update' id='update2'>update json 2</button></br>";
   //    }
   // }
   // print_r($part);
   // }
   
   // echo "<input type='submit' value='save to table'>";
   // echo "</form>";
   // echo "</div>";
   
   // ?>
   
   

   <pre>
   <?php echo "mp 1"; ?>
  	<?php print_r ($_SESSION); ?>
  	<?php print_r ($_POST); ?>
  	<?php print_r ($_GET); ?>
   </pre>

   
</body>