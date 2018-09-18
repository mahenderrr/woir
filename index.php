<?php
session_start();

include_once 'dbconnect.php';
include_once 'sessions_citi.php';
include_once 'header.html';

include_once 'carosal.html';

?>

<div class="container-fluid mainb" style="background-color: #f3f3f3;color:black;">
<div class="container-fluid mobile" style="background-color: #f9f9f9;border: 1px solid #e7e7e7;">


<!-- Third Container (Grid) -->

<div id="band" class="container-fluid text-center" style="border: 1px solid #e7e7e7; background-color:white; width: auto;">      
<div>
</div>
  <p class='heading bold ln20'>Upcoming Events</p>
<div class="carousel slide row" data-ride="carousel" data-type="multi" data-interval="4000" id="fruitscarousel">
    <div class="carousel-inner">

<?php

      if (strcmp($city,'all_cities') == 0 ) {
          $results_event= mysqli_query($con,"SELECT  * FROM Events where isPastEvent=False and city  like '%%' and short_description is not null ORDER BY RAND()  LIMIT 3");
      }else{
          $results_event= mysqli_query($con,"SELECT  * FROM Events where isPastEvent=False and city = '$city' and short_description is not null ORDER BY RAND()  LIMIT 3");
      }
      //echo "portid=$port_id";
      if(! $results_event ) {
           die('Could not get data for events for upcoming events');
      }
	  	  $i=0;

      while ($row_event = mysqli_fetch_array($results_event)){
                
          $event_id=$row_event['id'];
		  $fromdate_time=$row_event['fromdate_time'];
		  $todate_time=$row_event['todate_time'];
      
          $result = mysqli_query($con,"SELECT  * FROM Image_Event where eventid=$event_id and image_url is not null ORDER BY RAND()  LIMIT 1");
        // echo "eventid=$event_id";
          if(! $result ) {
            die('Could not get data: ' . mysql_error());
          }
          while ($row = mysqli_fetch_array($result)) {
			   if ( $i == 0 ) {
				  
				  
              echo '<div class="item active">';
          }else{

              echo '<div class="item">';
          }
		   $i=$i+1;
            echo '<div class="col-md-4 col-sm-4 col-xs-12">';
			
            echo '<p align="center" class="colorbg">';
			echo "<a style='color:white' href=upevent.php?eventid=" . $event_id. ">";
  			$title=$row_event['title'];
            $line_break="";
            echo substr($row_event['title'],0,25)."...";
            echo '</a></p>';
            echo '<a style="color:white"  href="upevent.php?eventid=';
            echo $event_id;
            echo '"><img src="';
            echo $row['image_url'];
            echo '" class="img-responsive" style="width:100%; height:200px;"></a>';
	    echo '<p align="center" class="colorbg">';
	    $from_date =date('D,d M,Y', strtotime($fromdate_time));
	    $to_date =date('D,d M,Y', strtotime($todate_time));
	    echo "$from_date  ";
	    echo "to  $to_date";
	    echo "<br>";
	    echo $row_event['venue'];
	    echo " ";
	    echo $row_event['city'];
	    echo '</p>';
            echo '</div>';
	    echo '</div>';
          }
      }
?>
  </div>
   <a class="left carousel-control" href="#fruitscarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
    <a class="right carousel-control" href="#fruitscarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a> 

</div>
<br>
<a class="btn" style="font-size:16px;" href="see_more_upcoming_all.php?city=<?php echo $city?>">View All Upcoming Events</a>
</div>

<br></br>

<!-- up coming Container (Grid) -->
<div id="band" class="container-fluid text-center" style="border: 1px solid #e7e7e7; background-color:white; width: auto;">      
 
<p class='heading bold ln20'>Organizers</p>
<!--The main div for carousel-->
<div class="carousel slide row" data-ride="carousel" data-type="multi" data-interval="4000" id="fruitscarousel1">

    <div class="carousel-inner">
 
 
    <?php

          if (strcmp($city,'all_cities') == 0 ) {
              #$results_event= mysqli_query($con,"SELECT   DISTINCT Portfolio.* FROM Portfolio,  Events  where lower(Events.city) like '%%'  limit 10");
              $results_event= mysqli_query($con,"SELECT   DISTINCT Portfolio.* FROM Portfolio  where lower(Portfolio.city_name) like '%%'  limit 10");
          }else{
              $results_event= mysqli_query($con,"SELECT DISTINCT  a.* FROM Portfolio a  where lower(a.city_name) = '".$city."'  limit 10");
          }

          if(! $results_event ) {
                die('Could not get data: no portfolios found.' );
          }
	  $i=0;
          #echo "CITY = $city";
          while ($row_event1 = mysqli_fetch_array($results_event)){
                $user_email=$row_event1['user_email'];
  
		if ( $i == 0 ) {

                   echo '<div class="item active">';
               }else{

                   echo '<div class="item">';
               }
                $i=$i+1;
                echo '<div class="col-md-4 col-sm-4 col-xs-12">';
                echo '<p align="center" class="colorbg">';
				echo "<span style='cursor:pointer'><a class='click_org' id='clickorg_$i' style='color:white' href=organiser.php?useremail=" . $user_email. ">";
                $theme=$row_event1['theme'];
                $title=$row_event1['title'];
                $line_break="";
                echo substr($row_event1['title'],0,25);
                echo "<br>";
                echo substr($row_event1['theme'],0,25).' ...';
                echo "<br>";
                echo '</span></a></p>';
                echo '<a  href="organiser.php?useremail=' . $user_email. '" > <img src="';
                echo $row_event1['img_url1'];
                echo '" class="img-responsive" style="width:100%; heigth:200px;"></a>';
                echo '</div>';
				echo '</div>';
          }
      
?>
  </div>
  <a class="left carousel-control" href="#fruitscarousel1" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
    <a class="right carousel-control" href="#fruitscarousel1" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a> 

</div>
<br>
<a class="btn" style="font-size:16px;" href="see_more_organisers.php">View All Organizers</a>
</div>
<br></br>
<!-- up coming Container (Grid) -->
<div id="band" class="container-fluid text-center" style="border: 1px solid #e7e7e7; background-color:white; width: auto;">      
 
<p class='heading bold ln20'>Exhibitors</p>
<!--The main div for carousel-->
<div class="carousel slide row" data-ride="carousel" data-type="multi" data-interval="4000" id="fruitscarousel2">

    <div class="carousel-inner">
 
 
    <?php

      if (strcmp($city,'all_cities') == 0 ) {
          $results_event= mysqli_query($con,"SELECT  * FROM Exhibitors where city  like '%%' and short_description is not null ORDER BY RAND()");
      }else{
          $results_event= mysqli_query($con,"SELECT  * FROM Exhibitors where city = '$city' and short_description is not null ORDER BY RAND()");
      }

          if(! $results_event ) {
                die('Could not get data: not found.' );
          }
		        $i=0;

          while ($row_event1 = mysqli_fetch_array($results_event)){
                $ex_id=$row_event1['id'];
  
			  if ( $i == 0 ) {

              echo '<div class="item active">';
          }else{

              echo '<div class="item">';
          }
          $i=$i+1;
                echo '<div class="col-md-4 col-sm-4 col-xs-12">';
                echo '<p align="center" class="colorbg">';
                echo "<a style='color:white' href=exhibitors.php?id=" . $ex_id. ">";
				$name=$row_event1['name'];
                $title=$row_event1['title'];
                $line_break="";
                echo substr($row_event1['name'],0,28)."...";
                echo "<br>";
                echo substr($row_event1['title'],0,25);
                echo "<br>";
                echo '</a></p>';
                echo '<a style="color:white" href="exhibitors.php?id=';
				echo $ex_id;
				echo '" > <img src="';
                echo $row_event1['main_img_url1'];
                echo '" class="img-responsive" style="width:100%; heigth:200px;"></a>';
                echo '</div>';
				echo '</div>';
          }
      
?>
  </div>
  <a class="left carousel-control" href="#fruitscarousel2" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
    <a class="right carousel-control" href="#fruitscarousel2" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a> 

</div>
<br>
<a class="btn" style="font-size:16px;" href="see_more_exhibitors.php">View All Exhibitors..</a>
</div>
<br></br>

</div>
</div>
<?php
include_once 'footer.html';
?>

</body>
<script src="js/event.js"></script>
<script>
       $(document).ready(function()
       {  
        // code to get all records from table via select box
        $(".click_org").click(function()
        {    
         //var id = $(this).find(":selected").val();
         var click_url = $(this).attr("href");
         //click_url = "http://kibanto.com";
        //alert("Hello");
         console.log(click_url); 
         $.ajax
         ({
          url: click_url,
          data: "",
          cache: false,
          success: function(r)
          {
           $("#myPage").html(r);
          } 
         });
        })
        // code to get all records from table via select box
       });
</script>
</html>

