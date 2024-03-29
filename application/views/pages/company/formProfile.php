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
		<input type="hidden" name="getSector" id="getSector" value="<?= base_url('company/get_sector') ?>">
		<!-- <input type="hidden" name="getEnum" id="getEnum" value="<?= base_url('company/get_enum') ?>"> -->
		<form class="form-horizontal form-validate-jquery" action="<?= $actionForm ?>" method="POST" name="pengaduan-form" id="pengaduan-form">
			<fieldset class="content-group">
				
				<legend class="text-semibold">
					<i class="icon-magazine position-left"></i>
					Company Profile
					<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
						<i class="icon-circle-down2"></i>
					</a>
				</legend>

				
				<div>
					<button type="button" class="btn btn-success" onclick="location.href='<?=base_url('company/form_field/'.$dMaster->companyID) ?>'"><i class="icon-add position-left"></i> Add New Record Field</button>
					<a class="btn btn-success pull-right" target="_blank" href="<?=base_url('report/print_company/'.$dMaster->companyID) ?>"><i class="icon-printer position-left"></i> Print Profile</a>
				</div>
				<br><br>

				<div class="collapse in" id="demo1">

					<div class="form-group">

					<?php foreach ($dField as $key):
							$name = $key->name;

							$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
							$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
							if ($name == 'companyProfileID' OR $name == 'companyID' OR $name == 'companyName') {
								$read = 'readonly';
							}else{
								$read = '';
							}

							if ($name == 'companyProfileID' OR $name == 'companyID' OR $name == 'sectorCompany' OR $name == 'companyName') {
								$btnDelete = '';
							}else{
							$btnDelete = '<a data-placement="left" data-popup="tooltip" title="Delete Column Field" style="color: red;" onclick="confirms(`Delete`,`Field '.ucwords($pass2).'?`,`'.base_url("company/delete_field").'`,`'.$key->name.'`)"><i class="icon-trash""></i></a>';
							}

							if ($name == 'sectorCompany') {
								$btnConfig = '<a data-placement="left" data-popup="tooltip" title="Sector Manage" style="color: blue;" target="_blank" href="'.base_url("sector").'"><i class="icon-gear"></i></a>';
							}else{
								$btnConfig = '';
							}

						if ($key->type == 'date') {?>

							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus" style="color: red;"></i></div>
										<input type="text" name="<?=$name?>" id="<?=$name?>" class="form-control pickadate" required="required" placeholder="Pick <?=$pass2?>" value="<?= isset($dMaster->$name) ? $dMaster->$name : '' ?>">
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>

						<?php }elseif ($key->type == 'text') {?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus" style="color: red;"></i></div>
										<textarea data-placement="left" data-popup="tooltip" title="Priority Field" rows="3" cols="3" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$name?>"><?=$dMaster->$name?></textarea>
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>
						<?php }elseif ($key->type == 'int') {?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus" style="color: red;"></i></div>
										<input data-placement="left" data-popup="tooltip" title="Priority Field" type="number" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$pass2?>" value="<?=$dMaster->$name?>" <?=$read?>>
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>
						<?php }else{?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus" style="color: red;"></i></div>
										<input data-placement="left" data-popup="tooltip" title="Priority Field" type="text" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$pass2?>" value="<?=$dMaster->$name?>" <?=$read?>>
									</div>
									<div class="pull-right"><?=$btnConfig?> <?=$btnDelete?></div>
								</div>
							</div>
						<?php } ?>
					
					<?php endforeach ?>

				</div>
			</div>

			</fieldset>

			<div class="text-right">
				<button type="reset" onclick="location.href='<?=base_url('company')?>'" class="btn btn-default" id="reset">Back <i class="icon-reload-alt position-right"></i></button>
				<button type="submit" class="btn btn-primary" id="submit-pengaduan" name="submit-pengaduan">Simpan <i class="icon-arrow-right14 position-right"></i></button>
			</div>
		</form>

	</div>
</div>
