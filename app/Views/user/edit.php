<!DOCTYPE html>
<html>
<title>Edit User</title>
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
		<a class="w3-bar-item w3-button w3-blue" href="<?= base_url(route_to('users')); ?>"><i class="fa fa-user-o" style="font-size:20px"></i> User List</a>
	</div>
</div>

<div id="main" style="margin-left:200px">

	<div class="w3-container w3-display-container">
		<span title="open Sidebar" style="display:none" id="openNav" class="w3-button w3-transparent w3-display-topleft w3-xlarge" onclick="w3_open()">&#9776;</span>
		<h3 class="h3" style="text-align:center;padding-top:20px"><strong>Edit User</strong></h3>
		
		<div class="w3-container w3-margin-bottom">
		<fieldset>
			<form action="<?= base_url(route_to('user_edit', $user->id)); ?>" method="post">
			<?= csrf_field(); ?>
			<input type="hidden" name="_method" value="PUT" />
			<legend><b>User:</b></legend>
			<div class="w3-row-padding" style="padding-top:10px">
				<div class="w3-col m2" style="margin-bottom:7px">
					Username
				</div>
				<div class="w3-rest" style="margin-bottom:7px">
					<input class="w3-input w3-border" type="text" name="username" value="<?= $user->username; ?>">
				</div>
				<div class="w3-col m2" style="margin-bottom:7px">
					Full Name
				</div>
				<div class="w3-rest" style="margin-bottom:7px">
					<input class="w3-input w3-border" type="text" name="full_name" value="<?= $user->full_name; ?>">
				</div>
				<div class="w3-col m2" style="margin-bottom:7px">
					Group
				</div>
				<div class="w3-rest" style="margin-bottom:7px">
					<select class="w3-select w3-border" name="group">
						<option value="0">None</option>
						<?php foreach($groups as $group) : ?>
						<option value="<?= $group->group_name; ?>" <?= $user->group == $group->group_name ? 'selected' : ''; ?>><?= $group->group_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="w3-col m2" style="margin-bottom:7px">
					Email
				</div>
				<div class="w3-rest" style="margin-bottom:7px">
					<input class="w3-input w3-border" type="text" name="email" value="<?= $user->email; ?>">
				</div>
				<div class="w3-col m2" style="margin-bottom:7px">
					Description
				</div>
				<div class="w3-rest" style="margin-bottom:7px">
					<input class="w3-input w3-border" type="text" name="description" value="<?= $user->description; ?>">
				</div>
				<div class="w3-col">
					<button class="w3-btn w3-orange">Update</button>
				</div>
			</div>
			</form>
		</fieldset>
		</div>

		<div class="w3-container w3-margin-bottom">
		<form action="<?= base_url(route_to('user_check_edit')); ?>" method="post">
		<?= csrf_field(); ?>
		<input type="hidden" name="_method" value="PUT" />
		<input type="hidden" name="user_id" value="<?= $user->id; ?>" />
		<fieldset>
			<legend><b>Check Attribues:</b></legend>
			<div>
				<div class="w3-row-padding" style="padding-top:10px;margin-bottom:7px">
					<div class="w3-col">
						<a href="<?= base_url(route_to('user_check_add', $user->id)); ?>" class="w3-btn w3-green"><i class="fa fa-plus"></i></a>
					</div>
				</div>
				<?php foreach($check_attributes as $check) : ?>
					<div class="w3-row-padding"  style="margin-bottom:7px">
						<div class="w3-col m2">
							<?= $check->username; ?>
							<input type="hidden" name="check_id[]" value="<?= $check->id; ?>">
						</div>
						<div class="w3-col m2">
							<input class="w3-input w3-border" type="text" name="check_attribute[]" value="<?= $check->attribute; ?>">
						</div>
						<div class="w3-col m1">
							<input class="w3-input w3-border" type="text" name="check_op[]" value="<?= $check->op; ?>">
						</div>
						<div class="w3-col m3">
							<input class="w3-input w3-border" type="text" name="check_value[]" value="<?= $check->value; ?>">
						</div>
						<div class="w3-col m2">
							<a href="<?= base_url(route_to('user_check_delete')); ?>?id=<?= $check->id; ?>&user_id=<?= $user->id; ?>" onClick="return confirm('Are you sure want to delete?')"><i class="fa fa-trash" style="font-size:20px;color:red;padding-top:8px"></i></a>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="w3-row-padding">
					<div class="w3-col">
						<button class="w3-btn w3-orange">Update</button>
					</div>
				</div>
			</div>
		</fieldset>
		</form>
		</div>
		
		<div class="w3-container">
		<form action="<?= base_url(route_to('user_reply_edit')); ?>" method="post">
		<?= csrf_field(); ?>
		<input type="hidden" name="_method" value="PUT" />
		<input type="hidden" name="user_id" value="<?= $user->id; ?>" />
		<fieldset>
			<legend><b>Reply Attribues:</b></legend>
			<div>
				<div class="w3-row-padding" style="padding-top:10px;margin-bottom:7px">
					<div class="w3-col">
						<a href="<?= base_url(route_to('user_reply_add', $user->id)); ?>" class="w3-btn w3-green"><i class="fa fa-plus"></i></a>
					</div>
				</div>
				<?php foreach($reply_attributes as $reply) : ?>
					<div class="w3-row-padding" style="margin-bottom:7px">
						<div class="w3-col m2">
							<?= $reply->username; ?>
							<input type="hidden" name="reply_id[]" value="<?= $reply->id; ?>">
						</div>
						<div class="w3-col m2">
							<input class="w3-input w3-border" type="text" name="reply_attribute[]" value="<?= $reply->attribute; ?>">
						</div>
						<div class="w3-col m1">
							<input class="w3-input w3-border" type="text" name="reply_op[]" value="<?= $reply->op; ?>">
						</div>
						<div class="w3-col m3">
							<input class="w3-input w3-border" type="text" name="reply_value[]" value="<?= $reply->value; ?>">
						</div>
						<div class="w3-col m2">
							<a href="<?= base_url(route_to('user_reply_delete')); ?>?id=<?= $reply->id; ?>&user_id=<?= $user->id; ?>" onClick="return confirm('Are you sure want to delete?')"><i class="fa fa-trash" style="font-size:20px;color:red;padding-top:8px"></i></a>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="w3-row-padding">
					<div class="w3-col">
						<button class="w3-btn w3-orange">Update</button>
					</div>
				</div>
			</div>
		</fieldset>
		</form>
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