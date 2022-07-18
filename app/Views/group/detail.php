<!DOCTYPE html>
<html>
<title>Group Detail</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico'); ?>">
<link rel="stylesheet" href="<?= base_url('css/w3.css'); ?>">
<link rel="stylesheet" href="<?= base_url('css/font-awesome.min.css'); ?>">
<style>
@media screen and (max-width: 455px) {
	.h3 {
		font-size:16px;
	}
}
a {
	text-decoration: none;
}
#footer {
	position:fixed;
	bottom:0;
	width:100%;
	text-align:center;
}
</style>
<body style="color:black;">

<div class="w3-sidebar w3-light-grey w3-card-4 w3-animate-left" style="width:200px" id="mySidebar">
	<div class="w3-bar w3-dark-grey">
		<span class="w3-bar-item w3-padding-16" style="font-size:18px;font-weight:bold">UManager</span>
		<button onclick="w3_close()" class="w3-bar-item w3-button w3-right w3-padding-16" title="close Sidebar">&times;</button>
	</div>
	<div class="w3-bar-block">
		<a class="w3-bar-item w3-button w3-blue" href="<?= base_url(route_to('groups')); ?>"><i class="fa fa-group" style="font-size:20px"></i> Group List</a>
	</div>
</div>

<div id="main" style="margin-left:200px">

	<div class="w3-container w3-display-container">
		<span title="open Sidebar" style="display:none" id="openNav" class="w3-button w3-transparent w3-display-topleft w3-xlarge" onclick="w3_open()">&#9776;</span>
		<h3 class="h3" style="text-align:center;padding-top:20px"><strong>Group Detail</strong></h3>
		
		<div class="w3-container w3-margin-bottom">
			<a href="<?= base_url(route_to('group_edit', $group->id)); ?>" class="w3-btn w3-orange"><i class="fa fa-edit"></i></a>
		</div>
		
		<div class="w3-container w3-margin-bottom">
		<fieldset>
			<legend><b>Group:</b></legend>
			<div>Name: <?= $group->group_name; ?></div>
			<div>Description: <?= $group->group_descript; ?></div>
		</fieldset>
		</div>

		<div class="w3-container w3-margin-bottom">
		<fieldset>
			<legend><b>Check Attribues:</b></legend>
			<div>
				<?php foreach($check_attributes as $check) : ?>
					<?= $check->groupname.' | '.$check->attribute.' '.$check->op.' '.$check->value; ?><br />
				<?php endforeach; ?>
			</div>
		</fieldset>
		</div>
		
		<div class="w3-container">
		<fieldset>
			<legend><b>Reply Attribues:</b></legend>
			<div>
				<?php foreach($reply_attributes as $reply) : ?>
					<?= $reply->groupname.' | '.$reply->attribute.' '.$reply->op.' '.$reply->value; ?><br />
				<?php endforeach; ?>
			</div>
		</fieldset>
		</div>
		
	</div>

	<div id="footer">
		<p>Copyright &copy; 2022 - <?= date('Y', time()); ?>. Developed by <a href="mailto:zawminoo.ait@gmail.com">Zaw Min Oo</a>.</p>
	</div>

</div>

<script>
function w3_open() {
  document.getElementById("main").style.marginLeft = "180px";
  document.getElementById("mySidebar").style.width = "180px";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>
      
</body>
</html> 