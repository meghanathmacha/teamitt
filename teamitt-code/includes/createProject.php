
<script type="text/javascript" charset="utf-8"> 
Date.firstDayOfWeek = 0;
Date.format = 'yyyy-mm-dd';
$(function()
		{
		$('.date-pick').datePicker({clickInput:true} )
		});
</script> 
<div id="eventForm">
<?php
include ("../checkid.php");
require_once("../DB/initDB.php");
require_once("../DB/goalsDB.php");
if(isset($EDITPROJECTID)){
$project_id=$EDITPROJECTID;
}
?>
<div id="popupRiteCont" style="width:350px;">
<form method="post" id="newProjectForm" action="#">
<!--<input type="hidden" name="company" value="" />-->
<input id="created_by"   type="hidden" name="created_by"  class="text" placeholder="Created By" required="true" value="<?php echo $USERNAME ?>" readonly="readonly" />
<ol>
<li>
<label for="name">Project Name</label>
<input id="name"  value="" name="name" class="text"  placeholder="Project Name"/>
</li>


<li>
<label for="objective">Objectives</label>
<textarea id="objective"   name="objective"  rows='2' cols='7' placeholder="Project Objective"></textarea>
</li>
<li>
<label for="progress">Project Progress</label>
<select id="progress_select" width='150px' name="progress"><option value="1">Not started</option><option value='2'>In progress</option></select>
</li>
<li> 
               <label for="due_date">Due Date</label> 
                <input id="due_date" name="due_date" class="text date-pick"  value=""  autocomplete="off" placeholder="due date"/>
              </li> 

<li>
<br/>
<input id="formsub" type="image" src="/static/images/submit2.png" />
<span id="formLoad">&nbsp;</span>
</li>
</ol>
</form>
</div>
</div>
<div id="eventLoader">
</div>
