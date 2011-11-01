<?php
require_once("../checkid.php");
?>

<div  id="eventBody">
Use this form of feedback to ask how <?php echo $userName ?> is doing
<form method="post" name="newPeerLoop" action="#">
<span><textarea name="feedbackFrom" rows="2" placeholder="Who do you want to requrest feedback from"/></span>
<span><textarea name="message" rows="5" placeholder="Type Your Question"/></span>
</form>
</div>
