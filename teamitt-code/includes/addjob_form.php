<div id="eventForm">
<form method="post" id="newitemForm" action="#">
<input type="hidden" name="company" value="<?php echo $company;?>" />
<input type="hidden" name="itemType" value="job" />
<ol>
<li>
<label for="title">Title</label>
<input id="title"  value="" name="title" class="text" required="true" placeholder="Job Title"/>
</li>

<li>
<label for="skills_reqd">Required Skills</label>
<textarea id="skills_reqd"   name="skills_reqd" required rows='2' cols='7' placeholder="Must have these skills"></textarea>
</li>

<li>
<label for="skills_opt">Optional Skills</label>
<textarea id="skills_opt"   name="skills_opt" required rows='2' cols='7' placeholder="Nice to have these skills"></textarea>
</li>

<li>
<label for="qual">Educational Qualification</label>
<textarea id="qual"   name="qual" required rows='2' cols='7' placeholder="Education qualifications"></textarea>
</li>

<li>
<label for="exp">Experience</label>
<textarea id="exp"   name="exp" required rows='2' cols='7' placeholder="Any past experience requirement"></textarea>
</li>

<li>
<label for="description">Job Description</label>
<textarea id="description"   name="description" required rows='3' cols='7' placeholder="Job Description"></textarea>
</li>

<li>
<label for="about">About Company</label>
<textarea id="about"   name="about" required rows='3' cols='7' placeholder="About the company"></textarea>
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
