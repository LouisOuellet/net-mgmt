<div class="container pt-4">
	<div class="col-12 border-bottom mb-5 pl-0">
		<h3 class="display-4">
			Your Users
			<button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#new">
				<i class="fas fa-plus mr-1"></i>
				New
			</button>
		</h3>
		<form method="post">
			<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-success text-light">
							<h5 class="modal-title"><i class="fas fa-plus mr-2"></i>New User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-user mr-2"></i>Username
												</span>
											</div>
											<input type="text" class="form-control" id="userName" placeholder="Username">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-user mr-2"></i>Password
												</span>
											</div>
											<input type="password" class="form-control" id="userPass" placeholder="Password" required>
											<input type="password" class="form-control" id="userPass2" placeholder="Confirm Password" required>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" onclick="genUser()" class="btn btn-success"><i class="fas fa-plus mr-1"></i>Create</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<table id="tblUsers" class="table table-striped display">
		<thead>
			<tr>
				<th>User</th>
				<th style="width:250px;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(scandir(dirname(__FILE__,3) . '/users/') as $user){ ?>
				<?php if(("$user" != "..") and ("$user" != ".") and ("$user" != ".htaccess")){ ?>
					<tr>
						<td><?=str_replace('.json','',$user)?></td>
						<td>
							<button type="button" class="btn btn-sm btn-primary" onclick="loadUser('<?=str_replace('.json','',$user)?>')">
								<i class="fas fa-eye mr-1"></i>
								Details
							</button>
							<button type="submit" name="DeleteUser" class="btn btn-sm btn-danger" onclick="delUser('<?=str_replace('.json','',$user)?>')">
								<i class="fas fa-trash-alt mr-1"></i>
								Delete
							</button>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
	</table>
</div>
