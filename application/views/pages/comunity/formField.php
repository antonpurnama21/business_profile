<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-law"></i> <?= $breadcrumb[1] ?></h5>
		<div class="heading-elements">
			<ul class="icons-list">
        		<li><a data-action="collapse"></a></li>
        		<li><a data-action="reload"></a></li>
        		<li><a data-action="close"></a></li>
        	</ul>
    	</div>
	</div>

	<div class="panel-body">
		<input type="hidden" name="getType" id="getType" value="<?= base_url('comunity/getTypedata') ?>">
		<input type="hidden" name="getField" id="getField" value="<?= base_url('comunity/getField') ?>">
		<form class="form-horizontal form-validate-jquery" action="<?= $actionForm ?>" method="POST" enctype="multipart/form-data" name="pengaduan-form" id="pengaduan-form">
			<fieldset class="content-group">

				<input type="hidden" name="Comunityid" id="Comunityid" class="form-control" value="<?= isset($comunityID) ? $comunityID : '' ?>" readonly>
				
				<div class="row">
					<div class="form-group">
						<label class="control-label col-lg-4">Field Name</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-user-tie"></i></div>
								<input type="text" name="Fieldname" id="Fieldname" class="form-control" required="required" placeholder="Example : 'FieldContoh'" title="Insert Field Name" required>
							</div>
							<br>
							<span class="badge badge-primary"># Input Required: a-z,A-Z </span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label class="control-label col-lg-4">Select Type Data</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-direction"></i></div>
								<select name="Typedata" id="Typedata" class="select2" data-placeholder="Select Type data" title="Select Type data" required>
									<option value=""></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group">
						<label class="control-label col-lg-4">Length Data</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-user-tie"></i></div>
								<input type="text" name="Lengthdata" id="Lengthdata" class="form-control" required="required" placeholder="Insert Length data" title="Insert Length data" required>
							</div>
							<br>
							<span class="badge badge-primary"># For Type data DATE,DATETIME,TEXT feel it Zero (0) </span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label class="control-label col-lg-4">Select After Column</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-direction"></i></div>
								<select name="After" id="After" class="select2" data-placeholder="Select After Column" title="Select After Column" required>
									<option value=""></option>
								</select>
							</div>
						</div>
					</div>
				</div>

			</fieldset>
			<div class="text-right">
				<button type="reset" onclick="location.href='<?=base_url('comunity/form/'.$comunityID)?>'" class="btn btn-default" id="reset">Cancel <i class="icon-reload-alt position-right"></i></button>
				<button type="submit" class="btn btn-primary" id="submit-pengaduan" name="submit-pengaduan">Save <i class="icon-arrow-right14 position-right"></i></button>
			</div>
		</form>
	</div>
</div>
