<!DOCTYPE html>
<html>
<title>Nas List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico'); ?>">
<link rel="stylesheet" href="<?= base_url('css/w3.css'); ?>">
<link rel="stylesheet" href="<?= base_url('css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('css/tablesorter.css'); ?>">
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
		<a class="w3-bar-item w3-button" href="<?= base_url(route_to('users')); ?>"><i class="fa fa-user-o" style="font-size:20px"></i> User List</a>
		<a class="w3-bar-item w3-button" href="<?= base_url(route_to('groups')); ?>"><i class="fa fa-group" style="font-size:20px"></i> Group List</a>
		<a class="w3-bar-item w3-button w3-blue" href="<?= base_url(route_to('nases')); ?>"><i class="fa fa-cube" style="font-size:20px"></i> Nas</a>
	</div>
</div>

<div id="main" style="margin-left:200px">

	<div class="w3-container w3-display-container">
		<span title="open Sidebar" style="display:none" id="openNav" class="w3-button w3-transparent w3-display-topleft w3-xlarge" onclick="w3_open()">&#9776;</span>
		<h3 class="h3" style="text-align:center;padding-top:20px"><strong>Nas List</strong></h3>
		
		<?php if(session()->getFlashdata('msg')) : ?>
		<div class="w3-container">
			<div class="w3-panel w3-pale-green w3-border w3-border-green w3-display-container">
				<span onclick="this.parentElement.style.display='none'" class="w3-button w3-pale-green w3-large w3-display-topright">x</span>
				<p><?= session()->getFlashdata('msg'); ?></p>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="w3-row-padding">
			<div class="w3-col m2">
				<a href="<?= base_url(route_to('nas_add')); ?>" class="w3-btn w3-green"><i class="fa fa-plus"></i></a>
			</div>
		</div>
		
		<div class="w3-container" style="padding-top:10px">
			<div class="w3-responsive">
			<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-light-grey">
						<th>No.</th>
						<th>Nas Name</th>
						<th>Short Name</th>
						<th>Type</th>
						<th>Ports</th>
						<th>Secret</th>
						<th>Server</th>
						<th>Community</th>
						<th>Description</th>
						<th class="sorter-false" style="background-image:none">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i =  1; ?>
					<?php foreach($nases as $nas) : ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $nas->nasname; ?></td>
						<td><?= $nas->shortname; ?></td>
						<td><?= $nas->type; ?></td>
						<td><?= $nas->ports; ?></td>
						<td><?= $nas->secret; ?></td>
						<td><?= $nas->server; ?></td>
						<td><?= $nas->community; ?></td>
						<td><?= $nas->description; ?></td>
						<td>
							<a href="<?= base_url(route_to('nas_edit', $nas->id)); ?>"><i class="fa fa-edit" style="font-size:20px;color:blue"></i></a> 
							<a href="<?= base_url(route_to('nas_delete')); ?>?id=<?= $nas->id; ?>"  onClick="return confirm('Are you sure want to delete?')"><i class="fa fa-trash" style="font-size:20px;color:red"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				<tbody>
			</table>
			</div>
		</div>
	</div>

	<div id="footer">
		<p>Copyright &copy; 2022 - <?= date('Y', time()); ?>. Developed by <a href="mailto:zawminoo.ait@gmail.com">Zaw Min Oo</a>.</p>
	</div>

</div>

<script src="<?= base_url('js/jquery.min.js'); ?>"></script>
<script src="<?= base_url('js/jquery.tablesorter.min.js'); ?>"></script>
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

//Table sorter.
$('table').tablesorter({
	cssNone: 'none',
	cssAsc: 'up',
	cssDesc: 'down'
});
</script>
      
</body>
</html> 