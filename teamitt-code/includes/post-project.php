<div class='postArea'>
<div class="postTitle"> 
<span id="action" class="selected">Action</span>
<span id="update">Updates</span>
</div>
<?php 
$contributors = $pDB->getProjectContributor($project_id, 1);
$contr = False;
$cr = $contributors;
if($row=mysql_fetch_row($cr))
{
$contr = True;
?>

<div id="project_post_recv">
<div class="project_cont">
<div class="project_post_label">Assign to</div>
<ul id="project_post_cont">
<?php
$contributors = $pDB->getProjectContributor($project_id, 1);

echo "<li userid='$USERID' class='sel'>Myself</li>";
//if(!$isowner)
{
echo "<li userid='$created_by'>".$first_name." ".$last_name."</li>";
}
while($row=mysql_fetch_row($contributors))
{
if($row[0] != $USERID)
{
echo "<li userid='$row[0]'>".$row[3]."</li>";
}
}

?>
</ul>
</div>

</div>
<?php
}
?>

<div class="postForm">
<table>
<tr>
<td>
<div class="inputs">
<textarea rows='4' cols='10' id="postEditor" placeholder="Post actions for Project contributors">
</textarea>
<div class="postButton">

<span class="assignedto">(Assigned to <span>1</span> person) </span>
<input type="button" value="Post" class="add_help_answer" >
</div>
</div>
</td>
</tr>
</table>
</div>

</div>

