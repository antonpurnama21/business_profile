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
			<?php if (getActiveFunc('company/index')): ?>
			<div class="ml-20">
				<button type="button" class="btn btn-success" onclick="showModal('<?= base_url('company/modalAdd') ?>', '', 'add');"><i class="icon-add position-left"></i> Add</button>
			</div>
			<?php endif ?>
			<?php if (getActiveFunc('company/search')): ?>
				<form class="form-horizontal" action="<?= base_url('report/printSearchCompany') ?>" method="POST">
					<div class="col-md-10">
						<input type="hidden" name="Field" value="<?= (isset($field)) ? $field : '' ?>" class="form-control">
						<input type="hidden" name="Sector" value="<?= (isset($sector)) ? $sector : '' ?>" class="form-control">
						<input type="hidden" name="Keyword" value="<?= (isset($keyword)) ? $keyword : '' ?>" class="form-control">
					</div>
					<div class="col-md-2">
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="icon-printer position-left"></i>  Print</button>
						</div>
					</div>
				</form>
			<?php endif ?>

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

								<td><?= $key->$name ?></td>

								<?php } ?>
								<td class="text-center">
									<a data-placement="top" data-popup="tooltip" title="Add / Edit Profile" style="margin: 5px" onclick="location.href='<?=base_url('company/form/'.$key->companyID) ?>'"><i class="icon-file-plus"></i></a>

									<a data-placement="top" data-popup="tooltip" title="Edit" style="margin: 5px" onclick="showModal('<?=base_url("company/modalEdit") ?>','<?=$key->companyID.'~'.$key->companyName?>', 'editcompany')"><i class="icon-quill4"></i></a>
									<a data-placement="top" data-popup="tooltip" title="Show Modal Profile" style="margin: 5px" onclick="showModal('<?=base_url("company/modalProfile")?>', '<?=$key->companyID.'~'.$key->companyName?>', 'modalprofile')"><i class="icon-eye"></i></a>
									<a data-placement="top" data-popup="tooltip" title="Delete Data" style="margin: 5px; color: red;" onclick="confirms('Delete','Data `<?=$key->companyName?>`?','<?=base_url("company/delete")?>','<?=$key->companyID?>')"><i class="icon-trash"></i></a>
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
		<input type="hidden" name="getSector" id="getSector" value="<?= base_url('company/getSector') ?>">
		<input type="hidden" name="getField" id="getField" value="<?= base_url('company/getField') ?>">
		<form class="form-horizontal form-validate-jquery" action="<?= base_url('company/search') ?>" method="POST" enctype="multipart/form-data" name="pengaduan-form" id="pengaduan-form">
			<fieldset class="content-group">
				<div class="row">
					<div class="col-lg-3">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field1" id="Field1" class="select2">
								<option value="">Default</option>
								<?php foreach ($Field as $key):
									$name = $key->name;
									$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
									$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);?>
								<option value="<?=$name?>"><?= ucwords($pass2)?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field2" id="Field2" class="select2">
								<option value="">Default</option>
								<?php foreach ($Field as $key):
									$name = $key->name;
									$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
									$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);?>
								<option value="<?=$name?>"><?= ucwords($pass2)?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field3" id="Field3" class="select2">
								<option value="">Default</option>
								<?php foreach ($Field as $key):
									$name = $key->name;
									$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
									$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);?>
								<option value="<?=$name?>"><?= ucwords($pass2)?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Field4" id="Field4" class="select2">
								<option value="">Default</option>
								<?php foreach ($Field as $key):
									$name = $key->name;
									$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
									$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);?>
								<option value="<?=$name?>"><?= ucwords($pass2)?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-4">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-direction"></i></div>
							<select name="Sector" id="Sector" class="select2">
								<option value="">Pick Company Sector</option>
								<option value="<?= (isset($sector)) ? $sector : '' ?>"><?= (isset($sector)) ? $sector : '' ?></option>
							</select>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="input-group">
							<div class="input-group-addon"><i class="icon-search4"></i></div>
							<input type="text" name="Keyword" id="Keyword" value="<?= (isset($keyword)) ? $keyword : '' ?>" class="form-control" required="required" required>
						</div>
					</div>
				</div>



			</fieldset>
			<div class="text-left">
				<button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
				<button type="submit" class="btn btn-primary" id="submit-pengaduan" name="submit-pengaduan">Search <i class="icon-search4 position-right"></i></button>
			</div>
		</form>
	</div>
</div>