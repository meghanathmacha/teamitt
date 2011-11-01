<?php
require_once("../checkid.php");
?>
<iframe name="feedbackFrame" style="display:none;"></iframe>
<div  id="eventBody">
Give Feedback to <?php echo $userName ?> 

<form  name="giveFeedback" action="#" id="giveFeedback" target="feedbackFrame">
<input type="hidden" value="<?php echo $userProfileId ?>" name="userProfileId" />
<textarea  rows="5" placeholder="Give your feedback" name='feedback'/>
<input type="submit" value="Give Feedback" style=""   />
</form>
</div>
