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
						<th width="5%">No</th>
						<?php 
						if (!empty($dMaster)) {
							foreach ($dMaster as $key) {
								foreach ($dField as $key2){ 
								$name = $key2->name;
								$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
								$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1); 
								if (!empty($key->$name)) {?>
						<th><?=ucwords($pass2); ?></th>
						<?php } }
							}
						}?>
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
									$name = $key2->name; 
									if (!empty($key->$name)) {?>

								<td><?= $key->$name ?></td>

								<?php } } ?>
								<td class="text-center">
									<a data-placement="left" data-popup="tooltip" title="Add / Edit Profile" style="margin: 5px" href="<?=base_url('company/form/').$key->companyID ?>"><i class="icon-file-plus"></i></a>
									<a data-placement="left" data-popup="tooltip" title="Edit" style="margin: 5px" onclick="showModal('<?=base_url("company/modalEdit") ?>','<?=$key->companyID.'~'.$key->companyName?>', 'editcompany')"><i class="icon-quill4"></i></a>
									<a data-placement="left" data-popup="tooltip" title="Show Modal Profile" style="margin: 5px" onclick="showModal('<?=base_url("company/modalProfile")?>', '<?=$key->companyID.'~'.$key->companyName?>', 'modalprofile')"><i class="icon-eye"></i></a>
									<a data-placement="left" data-popup="tooltip" title="Delete Data" style="margin: 5px; color: red;" onclick="confirms('Delete','Data `<?=$key->companyName?>`?','<?=base_url("company/delete")?>','<?=$key->companyID?>')"><i class="icon-trash"></i></a>
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
				
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-lg-4">Field Table</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-direction"></i></div>
								<select name="Field" id="Field" class="select2">
									<option value="<?= (isset($field)) ? $field : '' ?>"><?= (isset($field)) ? $field : '' ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-lg-4">Company Sector</label>
						<div class="col-lg-8">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-direction"></i></div>
								<select name="Sector" id="Sector" class="select2">
									<option value="<?= (isset($sector)) ? $sector : '' ?>"><?= (isset($sector)) ? $sector : '' ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-lg-2">Keyword</label>
						<div class="col-lg-10">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-search4"></i></div>
								<input type="text" name="Keyword" id="Keyword" value="<?= (isset($keyword)) ? $keyword : '' ?>" class="form-control" required="required" required>
							</div>
						</div>
					</div>
				</div>



			</fieldset>
			<div class="text-right">
				<button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
				<button type="submit" class="btn btn-primary" id="submit-pengaduan" name="submit-pengaduan">Search <i class="icon-search4 position-right"></i></button>
			</div>
		</form>
	</div>
</div>