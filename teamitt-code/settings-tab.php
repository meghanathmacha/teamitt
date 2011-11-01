<div class="listings">
<ul>
<li>
<a href="settings.php?profile" <?php echo $profileTab;?>>Profile Settings</a>
</li>
<li>
<a href="settings.php?account" <?php echo $accountTab;?>>Account Settings</a>
</li>
<?php if(isset($_SESSION["isAdmin"])) {
?>
<li>
<a href="settings.php?company" <?php echo $settingTab;?>>Company Settings</a>
</li>
<li>
<a href="settings.php?badge" <?php echo $badgeTab;?>>Badge Configuration</a>
</li>
<li>
<a href="settings.php?invite" <?php echo $inviteTab;?>>Send Invites</a>
</li>
<?php
}
?>

</ul>
</div>

