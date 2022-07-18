<!DOCTYPE html>
<html>
<title>Edit Nas</title>
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
		<a class="w3-bar-item w3-button w3-blue" href="<?= base_url(route_to('nases')); ?>"><i class="fa fa-cube" style="font-size:20px"></i> Nas</a>
	</div>
</div>

<div id="main" style="margin-left:200px">

	<div class="w3-container w3-display-container">
		<span title="open Sidebar" style="display:none" id="openNav" class="w3-button w3-transparent w3-display-topleft w3-xlarge" onclick="w3_open()">&#9776;</span>
		<h3 class="h3" style="text-align:center;padding:20px"><strong>Edit Nas</strong></h3>
		
		<?php $validation = session()->getFlashdata('validation'); ?>
		<form class="w3-container" action="<?= base_url(route_to('nas_edit', $nas->id)); ?>" method="post">
			<?= csrf_field(); ?>
			<input type="hidden" name="_method" value="PUT" />
			<p>      
				<label><b>Nas Name:</b></label> <?= isset($validation['nasname']) ? '<span class="w3-text-red">Required Field.</span>' : ''; ?>
				<input class="w3-input w3-border" name="nasname" type="text" style="margin-top:5px" value="<?= $nas->nasname; ?>">
			</p>
			<p>      
				<label><b>Short Name:</b></label>
				<input class="w3-input w3-border" name="shortname" type="text" style="margin-top:5px" value="<?= $nas->shortname; ?>">
			</p>
			<p>      
				<label><b>Type:</b></label>
				<input class="w3-input w3-border" name="type" type="text" style="margin-top:5px" value="<?= $nas->type; ?>">
			</p>
			<p>      
				<label><b>Ports:</b></label>
				<input class="w3-input w3-border" name="ports" type="text" style="margin-top:5px" value="<?= $nas->ports; ?>">
			</p>
			<p>      
				<label><b>Secret:</b></label>
				<input class="w3-input w3-border" name="secret" type="text" style="margin-top:5px" value="<?= $nas->secret; ?>">
			</p>
			<p>      
				<label><b>Server:</b></label>
				<input class="w3-input w3-border" name="server" type="text" style="margin-top:5px" value="<?= $nas->server; ?>">
			</p>
			<p>      
				<label><b>Community:</b></label>
				<input class="w3-input w3-border" name="community" type="text" style="margin-top:5px" value="<?= $nas->community; ?>">
			</p>
			<p>      
				<label><b>Description:</b></label>
				<input class="w3-input w3-border" name="description" type="text" style="margin-top:5px" value="<?= $nas->description; ?>">
			</p>
			<p><button class="w3-btn w3-orange">Update</button></p>
		</form>	
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