<!DOCTYPE html>
<html>
<title>User List</title>
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
		<a class="w3-bar-item w3-button w3-blue" href="<?= base_url(route_to('users')); ?>"><i class="fa fa-user-o" style="font-size:20px"></i> User List</a>
		<a class="w3-bar-item w3-button" href="<?= base_url(route_to('groups')); ?>"><i class="fa fa-group" style="font-size:20px"></i> Group List</a>
		<a class="w3-bar-item w3-button" href="<?= base_url(route_to('nases')); ?>"><i class="fa fa-cube" style="font-size:20px"></i> Nas</a>
	</div>
</div>

<div id="main" style="margin-left:200px">

	<div class="w3-container w3-display-container">
		<span title="open Sidebar" style="display:none" id="openNav" class="w3-button w3-transparent w3-display-topleft w3-xlarge" onclick="w3_open()">&#9776;</span>
		<h3 class="h3" style="text-align:center;padding-top:20px"><strong>User List</strong></h3>
		
		<?php if(session()->getFlashdata('msg')) : ?>
		<div class="w3-container">
			<div class="w3-panel w3-pale-green w3-border w3-border-green w3-display-container">
				<span onclick="this.parentElement.style.display='none'" class="w3-button w3-pale-green w3-large w3-display-topright">x</span>
				<p><?= session()->getFlashdata('msg'); ?></p>
			</div>
		</div>
		<?php endif; ?>
		
		<?php $request = \Config\Services::request(); ?>
		<form action="<?= base_url(route_to('users')); ?>" method="get">
		<div class="w3-row-padding">
			<div class="w3-col m3">
				<input class="w3-input w3-border" name="username" type="text" value="<?= $request->getGet('username'); ?>" placeholder="Username">

			</div>
			<div class="w3-col m3">
				<select class="w3-select w3-border" name="group"  onchange="this.form.submit()">
					<option value="">All Group</option>
					<?php foreach($groups as $group) : ?>
					<option value="<?= $group->group; ?>" <?= $group->group == $request->getGet('group') ? 'selected' : ''; ?>><?= $group->group; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="w3-col m1">
				<a href="<?= base_url(route_to('user_add')); ?>" class="w3-btn w3-green"><i class="fa fa-user-plus"></i></a>
			</div>
			<div class="w3-col m2" style="padding-top:10px">
				Result(s): <b><?= $count_users; ?></b>
			</div>
			<input type="submit" style="position: absolute; left: -9999px" />
		</div>
		</form>
		
		<div class="w3-container" style="padding-top:10px">
			<div class="w3-responsive">
			<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-light-grey">
						<th>No.</th>
						<th>Username</th>
						<th>Full Name</th>
						<th>Group</th>
						<th>Email</th>
						<th>Description</th>
						<th>Created at</th>
						<th class="sorter-false" style="background-image:none">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $per_page = $request->getGet('per_page') != null ? $request->getGet('per_page') : 50; ?>
					<?php $i = $request->getGet('page') != null ? ($per_page*($request->getGet('page')-1))+1 : 1; ?>
					<?php foreach($users as $user) : ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $user->username; ?></td>
						<td><?= $user->full_name; ?></td>
						<td><?= $user->group; ?></td>
						<td><?= $user->email; ?></td>
						<td><?= $user->description; ?></td>
						<td><?= $user->created_at; ?></td>
						<td>
							<a href="<?= base_url(route_to('user_show', $user->id)); ?>"><i class="fa fa-eye" style="font-size:20px;color:green"></i></a> 
							<a href="<?= base_url(route_to('user_edit', $user->id)); ?>"><i class="fa fa-edit" style="font-size:20px;color:blue"></i></a> 
							<a href="<?= base_url(route_to('user_delete')); ?>?id=<?= $user->id; ?>"  onClick="return confirm('Are you sure want to delete?')"><i class="fa fa-trash" style="font-size:20px;color:red"></i></a>
							<a href="<?= base_url(route_to('user_reset_passwd', $user->id)); ?>"><i class="fa fa-key" style="font-size:20px;color:blue"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				<tbody>
			</table>
			</div>
		</div>

		<div class="w3-container w3-center w3-margin-top">	
			<?php
				if($pager)
				{
					$pager->setPath(route_to('users'));
					echo $pager->links();
				}
			?>
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