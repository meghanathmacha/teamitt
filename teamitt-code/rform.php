<form action="" method="post" id="loginform">
<ol>
<li>

<label>First Name *</label>
<input type="text" pattern="[A-z,0-9 \.]{1,50}" title="[A-z,0-9, ]{1, 50}" name="fname" value="<?php echo $fname;?>" class="text" placeholder="Enter your first name" required="true" />
</li>

<li>
<label>Last Name *</label>
<input type="text" pattern="[A-z,0-9 \.]{1,50}"  title="[A-z,0-9 ]{1,50}" name="lname" value="<?php echo $lname;?>" class="text" placeholder="Enter your last name" required="true" />
</li>

<li>
<label>I am</label>
<select name="gender">
<option value="F" <?php echo $f_type;?>>Female</option>
<option value="M" <?php echo $m_type;?>>Male</option>

</select>
</li>

<li>
<label>Title *</label>
<input type="text" pattern="[A-z,0-9 \.]{0,50}" name="title" value="<?php echo $title;?>" class="text" placeholder="Enter title" required="true"/>
</li>

<li>
<label>Password *</label>
<input type="password" name="userpassword" class="text" placeholder="Enter your password" required="true" id="userpassword"> <small>(at least 6 characters)</small>
</li>

<li>
<label>Confirm Password *</label>
<input type="password" name="cuserpassword"  class="text" placeholder="Confirm your password" required="true" id="cuserpassword">
</li>


<li>
<label></label>
<input type="submit" value="submit" class="btn_small">
</li>
</ol>
</ul>
