<div id="staticRegion">
<div id="mainHeader">
<div class="welcome-name">
<?php echo $company_name;?>
</div>
<div class="props">

</div>



</div>
<?php
include("includes/post-home.php");
?>

<div class="feedArea">
<?php
 $TYPE_NAME = 3;
include('feeds.php'); 
?>

</div>
</div>
<div id="dynamicRegion" style='display:none;'>
<b style='text-align:center;font-size:18px;'> Loading....</b></div>
