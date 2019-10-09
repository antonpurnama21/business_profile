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
					<button type="button" class="btn btn-success pull-right" onclick="location.href='<?=base_url('report/print_company/'.$dMaster->companyID) ?>'"><i class="icon-printer position-left"></i> Print Profile</button>
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
							$btnDelete = '<a class="btn btn-danger" onclick="confirms(`Delete`,`Field '.ucwords($pass2).'?`,`'.base_url("company/delete_field").'`,`'.$key->name.'`)"><i class="icon-trash""></i></a>';
							}

						if ($key->type == 'date') {?>

							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus"></i></div>
										<input type="text" name="<?=$name?>" id="<?=$name?>" class="form-control pickadate" required="required" placeholder="Pick <?=$pass2?>" title="Pick <?=$pass2?>" value="<?= isset($dMaster->$name) ? $dMaster->$name : '' ?>">
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>

						<?php }elseif ($key->type == 'text') {?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus"></i></div>
										<textarea rows="3" cols="3" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$name?>" title="Insert <?=$name?>"><?=$dMaster->$name?></textarea>
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>
						<?php }elseif ($key->type == 'int') {?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus"></i></div>
										<input type="number" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$pass2?>" title="Insert <?=$pass2?>" value="<?=$dMaster->$name?>" <?=$read?>>
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>
						<?php }else{?>
							<?php if ($key->name == 'sector'){ ?>
							<div class="form-group">
								<label class="control-label col-lg-3">Select <?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus"></i></div>
										<select name="<?=$name?>" id="<?=$name?>" class="select2" data-placeholder="Select <?=$pass2?>" title="Select <?=$pass2?>" required>
											<option value="<?= (isset($dMaster->$name)) ? $dMaster->$name : '' ?>"><?= (isset($dMaster->$name)) ? name_sector($dMaster->$name) : '' ?></option>
										</select>
									</div>
								</div>
							</div>
							<?php }else{ ?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?=ucwords($pass2)?></label>
								<div class="col-lg-9">
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-file-plus"></i></div>
										<input type="text" name="<?=$name?>" id="<?=$name?>" class="form-control" required="required" placeholder="Insert <?=$pass2?>" title="Insert <?=$pass2?>" value="<?=$dMaster->$name?>" <?=$read?>>
									</div>
									<div class="pull-right"><?=$btnDelete?></div>
								</div>
							</div>
						<?php }}?>
					
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
