<div id="eventForm">
<form method="post" id="newitemForm" action="#">
<input type="hidden" name="company" value="<?php echo $company;?>" />
<input type="hidden" name="itemType" value="event" />
<ol>
<li>
<label for="event_name">What</label>
<input id="event_name"  value="" name="event_name" class="text" required="true" placeholder="Event Name"/>
</li>

<li>
<label for="event_type">Which</label>
<select name="event_type" required="true">
<option value="">Select Event Type</option>
<option value="Hackathon">Hackathon</option>
<option value="Geeky Lunch">Geeky Lunch</option>
</select>
</li>
<li>
<label for="event_place">Where</label>
<input id="event_place"  value="" name="event_place" required class="text" placeholder="Event Location"/>
</li>
<li>
<label for="event_time">When</label>
<input  value="" name="event_time" id="eventTime" required class="text" placeholder="Event Time"/>
</li>

<li>
<br/>
<input id="formsub" type="image" src="/static/images/submit2.png" />
<span id="formLoad">&nbsp;</span>
</li>
</ol>
</form>
</div>
<div id="eventLoader">
</div>
