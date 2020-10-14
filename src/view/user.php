<?php $user=json_decode(file_get_contents(dirname(__FILE__,3).'/users/'.$_POST['name'].'.json'),true); ?>
<div class="container pt-4">
	<div class="col-12 border-bottom mb-5 pl-0">
		<h3 class="display-4">
			<?=$_POST['name']?>
		</h3>
	</div>
	<div class="container">
		<form method="post">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fas fa-lock mr-2"></i>Update Password
								</span>
							</div>
							<input type="password" class="form-control" id="userPass" name="password" placeholder="Password" required>
							<input type="password" class="form-control" id="userPass2" name="password2" placeholder="Confirm Password" required>
							<div class="input-group-append">
								<button type="button" onclick="saveUser('<?=$_POST['name']?>')" class="btn btn-success"><i class="fas fa-save mr-1"></i>Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
