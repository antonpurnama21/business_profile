<div class="row">
	<div class="col-md-12">
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
				<form class="form-horizontal" action="<?= base_url('report/print_result_company') ?>" method="POST">
					<div class="col-md-10">
						<input type="hidden" name="Field" 	value="<?= implode(',', $field)?>" class="form-control">
						<input type="hidden" name="Sector" 	value="<?= $sector?>" class="form-control">
						<input type="hidden" name="Keyword" value="<?= $keyword?>" class="form-control">
					</div>
					<div class="col-md-2">
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="icon-printer position-left"></i>  Print</button>
						</div>
					</div>
				</form>

			<table class="table datatable-responsive-row-control table-hover">
				<thead>
					<tr style="font-size:12px;text-align:center;">
						<th>No</th>
						<?php foreach ($dField as $key){ 
								$name = $key->name;
								$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
								$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);?>
						<th><?=ucwords($pass2); ?></th>
						<?php } ?>
						<th width="20%">Action</th>
					</tr>
				</thead>
				<tbody>
						<?php
							if (!empty($dMaster)) {
								$no = 0;
								foreach ($dMaster as $key) {
									$no++;
						?>
							<tr class="text-size-mini">
								<td><?= $no ?>.</td>
								<?php foreach ($dField as $key2){
									$name = $key2->name; ?>

								<td><?= highlightKeywords($key->$name, $keyword) ?></td>

								<?php } ?>
								<td class="text-center">
									<a data-placement="top" data-popup="tooltip" title="Add / Edit Profile" style="margin: 10px" onclick="location.href='<?=base_url('company/form/'.$key->companyID) ?>'"><i class="icon-file-plus"></i></a>

									<a data-placement="top" data-popup="tooltip" title="Edit" style="margin: 10px" onclick="showModal('<?=base_url("company/modal_edit") ?>','<?=$key->companyID.'~'.$key->companyName?>', 'editcompany')"><i class="icon-quill4"></i></a>
									<a data-placement="top" data-popup="tooltip" title="Show Modal Profile" style="margin: 10px" onclick="showModal('<?=base_url("company/modal_profile")?>', '<?=$key->companyID.'~'.$key->companyName?>', 'modalprofile')"><i class="icon-eye"></i></a>
									<a data-placement="top" data-popup="tooltip" title="Delete Data" style="margin: 10px; color: red;" onclick="confirms('Delete','Data `<?=$key->companyName?>`?','<?=base_url("company/delete")?>','<?=$key->companyID?>')"><i class="icon-trash"></i></a>
								</td>
							</tr>
						<?php
								}
							}
						?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-law"></i> Multi Category Seacrh</h5>
		<div class="heading-elements">
			<ul class="icons-list">
        		<li><a data-action="collapse"></a></li>
        		<li><a data-action="reload"></a></li>
        		<li><a data-action="close"></a></li>
        	</ul>
    	</div>
	</div>

	<div class="panel-body">
		<!-- mamanggil data -->
		<input type="hidden" name="getSector" id="getSector" value="<?= base_url('company/get_sector') ?>">
		<input type="hidden" name="getField1" id="getField1" value="<?= base_url('company/get_field') ?>">
		<input type="hidden" name="getField2" id="getField2" value="<?= base_url('company/get_field') ?>">
		<input type="hidden" name="getField3" id="getField3" value="<?= base_url('company/get_field') ?>">
		<input type="hidden" name="getField4" id="getField4" value="<?= base_url('company/get_field') ?>">
		<input type="hidden" name="getField5" id="getField5" value="<?= base_url('company/get_field') ?>">
		<!-- memanggil data -->
		<form class="form-horizontal form-validate-jquery" action="<?= base_url('company/search') ?>" method="POST" enctype="multipart/form-data" name="pengaduan-form" id="pengaduan-form">
			<fieldset class="content-group">
				<div class="row">
					<div class="col-lg-2">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field1" id="Field1" class="select2">
								<option value="<?= (isset($field[1])) ? $field[1] : '' ?>"><?= (isset($field[1])) ? ucwords($field[1]) : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field2" id="Field2" class="select2">
								<option value="<?= (isset($field[2])) ? $field[2] : '' ?>"><?= (isset($field[2])) ? ucwords($field[2]) : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field3" id="Field3" class="select2">
								<option value="<?= (isset($field[3])) ? $field[3] : '' ?>"><?= (isset($field[3])) ? ucwords($field[3]) : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field4" id="Field4" class="select2">
								<option value="<?= (isset($field[4])) ? $field[4] : '' ?>"><?= (isset($field[4])) ? ucwords($field[4]) : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field5" id="Field5" class="select2">
								<option value="<?= (isset($field[5])) ? $field[5] : '' ?>"><?= (isset($field[5])) ? ucwords($field[5]) : '' ?></option>
							</select>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-3">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Sector" id="Sector" class="select2">
								<option value="<?= (isset($sector)) ? $sector : '' ?>"><?= (isset($sector)) ? $sector : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-search4"></i></div>
							<input type="text" name="Keyword" id="Keyword" value="<?= (isset($keyword)) ? $keyword : '' ?>" class="form-control" required="required" required>
						</div>
					</div>
				</div>

			</fieldset>
			<div class="text-left">
				<button type="reset" class="btn btn-default" onclick="location.href='<?=base_url('company') ?>'" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
				<button type="submit" class="btn btn-primary" id="submit-pengaduan" name="submit-pengaduan">Search <i class="icon-search4 position-right"></i></button>
			</div>
		</form>
	</div>
</div>