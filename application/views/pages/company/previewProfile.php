<div id="modalPortal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?= $modalTitle ?></h5>
			</div>

				<div class="modal-body">
					<fieldset class="content-group">
						<legend class="text-semibold">
							<i class="icon-magazine position-left"></i>
							Profile
							<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
								<i class="icon-circle-down2"></i>
							</a>
						</legend>

						<div class="collapse in" id="demo1">
							<div class="col-md-12">
						<?php 
						$no = 0;
						foreach ($dField as $key):
						$no++;
						$name = $key->name;
						$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
						$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
						
						if ($key->type == 'date') { ?>
							<div class="row">
								<div class="form-group">
									<label class="control-label col-lg-4 text-bold "><?=ucwords($pass2)?></label>
									<div class="col-lg-8">
										<div class="input-group">
											<div class="input-group-addon" style="padding-top:0px;">:</div>
											<label class="control-label"><?= date_format(date_create($dMaster->$name), 'd F Y')  ?></label>
										</div>
									</div>
								</div>
							</div>
							<br>
						<?php }else{ ?>
							<div class="row">
								<div class="form-group">
									<label class="control-label col-lg-4 text-bold "><?=ucwords($pass2)?></label>
									<div class="col-lg-8">
										<div class="input-group">
											<div class="input-group-addon" style="padding-top:0px;">:</div>
											<label class="control-label"><?= nl2br($dMaster->$name) ?></label>
										</div>
									</div>
								</div>
							</div>
							<br>
						<?php } ?>
						<?php endforeach ?>
							</div>
						</div>				
					</fieldset>
				</div>
				<br />
				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
				</div>
		</div>
	</div>
</div>