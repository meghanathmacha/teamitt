
<script type="text/javascript" charset="utf-8"> 
Date.firstDayOfWeek = 0;
Date.format = 'yyyy-mm-dd';
$(function()
		{
		$('.date-pick').datePicker({clickInput:true} )
		});
</script> 
<div id="eventForm">
<div id="popupLeftCont"  style="width:150px;float:right;height:300px;font-weight:bold;" >
<!--<div class='comp-pic uppic'>
<?php
include ("../checkid.php");
require_once("../DB/initDB.php");
require_once("../DB/goalsDB.php");
if(isset($EDITGOALID)){
$goal_id=$EDITGOALID;
}
else{
$gDB=new goalsDB();
$result=$gDB->lastGoalId();
$goal_id=1;
while($row=mysql_fetch_array($result)){
$goal_id=$row[0];
}
$goal_id=$goal_id+1;
}

/*$path="uploads/goalimg/goalimg-".$id.".jpg";
$utext="Change Goal Pic";
if(!file_exists($path))
{
$path="./static/images/ambitions.png";
$utext="Add Goal Pic";
}
*/
?>
<img id="goaldp" src="../static/images/ambitions.png" width='142px' height='150px'/>
<?php// if($isowner) { ?>
<div class='upload-text'>
<div class="upload-text-cont">
<span class="txt"><?php //echo $utext;?>Add Goal Pic</span>
<div id="goalfile">
<form name="goalpicformsubmit" id="goalpicformid" action="includes/up_goalpic.php?id=<?php echo $goal_id?>" method="post" target="upframe" enctype='multipart/form-data'>
<input type="file" name="goalpic" onChange="filetaken();"/>
</form>
</div>
</div>
</div>
<div id='upload-load'>&nbsp;</div>
<div style="display:none;">
<iframe name="upframe"></iframe>
</div>
<?php  ?>
</div>-->
<div style="padding-bottom:30px;">
<label for="progress">Goal Progress</label>
<select id="progress_select" width='150px'><option value="1">Not started</option><option value=2>In progress</option></select>
</div>
<div>
<label for="visibility">Visibility</label>
<select id="visibility_select" width='150px'><option value=1>Contributors</option><option value=2>All</option></select>
</div>
</div>
<div id="popupRiteCont" style="width:350px;font-weight:bold;">
<form method="post" id="newitemForm" action="#">
<!--<input type="hidden" name="company" value="" />-->
<input type="hidden" class="text"  name="image_src" value="static/images/ambitions.png" id="fileUpload" />
<input type="hidden" class="text"  name="visibility" value="" id="visibility" />
<input type="hidden" class="text"  name="progress" value="" id="progress" />
<input id="created_by"   type="hidden" name="created_by"  class="text" placeholder="Created By" required="true" value="<?php echo $USERNAME ?>" readonly="readonly" />
<ol>
<li>
<label for="name">Goal Name</label>
<input id="name"  value="" name="name" class="text"  placeholder="Goal Name"/>
</li>


<li>
<label for="objective">Objectives</label>
<textarea id="objective"   name="objective"  rows='2' cols='7' placeholder="Goal Objective"></textarea>
</li>

<li>
<label for="key_result">Key Results</label>
<textarea id="key_result"   name="key_result" rows='2' cols='7' placeholder="Key Results"></textarea>
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
