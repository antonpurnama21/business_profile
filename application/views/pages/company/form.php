<div id="modalPortal" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?= $modalTitle ?></h5>
			</div>

			<form class="form-horizontal form-validate-jquery" action="<?= $formAction ?>" method="post" enctype="multipart/form-data" name="dokumen-form" id="dokumen-form">
				<div class="modal-body">
					<fieldset class="content-group">

						<input type="hidden" name="Companyid" id="Companyid" class="form-control" value="<?= isset($dMaster->companyID) ? $dMaster->companyID : '' ?>" readonly>
						
						<div class="row">
							<div class="form-group">
								<label class="control-label col-lg-4">Company</label>
								<div class="col-lg-8">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-cube4"></i></div>
										<input type="text" name="Companyname" id="Companyname" class="form-control" required="required" placeholder="Insert Company" title="Insert Company" value="<?= isset($dMaster->companyName) ? $dMaster->companyName : '' ?>" required>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<br />
				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Cancel</button>
					<button class="btn btn-success" name="submit-dokumen" id="submit-dokumen"><i class="icon-check"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div>