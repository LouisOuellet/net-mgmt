<?php
shell_exec("cd ".dirname(__FILE__,3)."/repos/".$_POST['name']." && git fetch origin master 2>/dev/null");
if(strpos(shell_exec("cd ".dirname(__FILE__,3)."/repos/".$_POST['name']." && git status -sb 2>/dev/null"), 'behind') !== false){
	shell_exec("cd ".dirname(__FILE__,3)."/repos/".$_POST['name']." && git pull origin master 2>/dev/null");
}
$application=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$_POST['name'].'/app.json'),true);
?>
<div class="container pt-4">
	<div class="col-12 border-bottom mb-5 pl-0">
		<h3 class="display-4">
			<?=$_POST['name']?>
			<button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#clone">
				<i class="fas fa-clone mr-1"></i>
				Clone
			</button>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#token">
				<i class="fas fa-ticket-alt mr-1"></i>
				Get Token Hash
			</button>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#generate">
				<i class="fas fa-key mr-1"></i>
				Generate
			</button>
		</h3>
		<div class="modal fade" id="token" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-light">
						<h5 class="modal-title"><i class="fas fa-hashtag mr-2"></i>Hash</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<textarea class="form-control" style="resize: none;"><?=password_hash($application['token'], PASSWORD_DEFAULT)?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="clone" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-info text-light">
						<h5 class="modal-title"><i class="fas fa-clone mr-2"></i>Clone</h5>
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
												<i class="fas fa-globe-americas mr-2"></i>HTTP
											</span>
										</div>
										<input type="text" class="form-control" value="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'].'/'?>git/<?=$_POST['name']?>.git" >
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="fas fa-lock mr-2"></i>SSH
											</span>
										</div>
										<input type="text" class="form-control" value="git@<?=$_SERVER['HTTP_HOST']?>:<?=dirname(__FILE__,3).'/git/'.$_POST['name'].'.git'?>" >
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<form method="post">
			<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-success text-light">
							<h5 class="modal-title"><i class="fas fa-key mr-2"></i>Generate New Key(s)</h5>
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
													<i class="fas fa-list-ol mr-2"></i>Amount
												</span>
											</div>
											<input type="number" id="AmtKey" class="form-control" value="1" name="amount" placeholder="Amount" required autofocus>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" onclick="genKeys('<?=$_POST['name']?>')" name="GenKey" id="GenKey" class="btn btn-success"><i class="fas fa-key mr-1"></i>Generate</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card mb-4">
	  <div class="card-header">
			<ul class="nav nav-pills nav-justified">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#repo">Readme</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#keys">Keys</a>
			  </li>
			</ul>
	  </div>
	  <div class="card-body p-0">
			<div class="tab-content">
			  <div id="repo" class="tab-pane p-4 active">
			    <?php
					require_once dirname(__FILE__,3).'/src/lib/Parsedown.php';
					$Parsedown = new Parsedown();
					if(file_exists(dirname(__FILE__,3).'/repos/'.$_POST['name'].'/README.md')){
						echo $Parsedown->text(file_get_contents(dirname(__FILE__,3).'/repos/'.$_POST['name'].'/README.md'));
					}
					?>
			  </div>
			  <div id="keys" class="tab-pane pt-3">
					<table id="tblKeys" class="table table-striped">
						<thead>
							<tr>
								<th>Key</th>
								<th>Status</th>
								<th>Owner</th>
								<th>Active</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(file_exists(dirname(__FILE__,3).'/apps/'.$_POST['name'].'/keys.json')){ ?>
								<?php foreach(json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$_POST['name'].'/keys.json'),true) as $key => $value){ ?>
									<tr>
										<td><?=$value['key']?></td>
										<td>
											<?php if($value['status']){ ?>
												<button type="button" onclick="disableKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-success">
													<i class="fas fa-key mr-1"></i>
													Enabled
												</button>
											<?php } else { ?>
												<button type="button" onclick="enableKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-danger">
													<i class="fas fa-key mr-1"></i>
													Disabled
												</button>
											<?php } ?>
										</td>
										<td>
											<form method="post">
												<?php if(isset($value['owner'])){ ?>
													<button type="button" onclick="clearOwnerKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-primary">
														<i class="fas fa-building mr-1"></i>
														<?=$value['owner']?>
													</button>
												<?php } else { ?>
													<div class="form-group">
														<div class="input-group input-group-sm">
															<input type="text" class="form-control" id="owner-<?=$key?>" name="owner" placeholder="Owner">
															<div class="input-group-append">
																<button type="button" onclick="setOwnerKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Save</button>
															</div>
														</div>
													</div>
												<?php } ?>
											</form>
										</td>
										<td>
											<?php if($value['active']){ ?>
												<button type="button" onclick="deactivateKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-success">
													<i class="fas fa-key mr-1"></i>
													Activated
												</button>
											<?php } else { ?>
												<button type="button" onclick="activateKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-danger">
													<i class="fas fa-key mr-1"></i>
													Deactivated
												</button>
											<?php } ?>
										</td>
										<td>
											<button type="button" onclick="delKeys('<?=$_POST['name']?>','<?=$key?>')" class="btn btn-sm btn-danger">
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
			</div>
	  </div>
	</div>
</div>
