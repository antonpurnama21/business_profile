<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-search4"></i> <?= $breadcrumb[1] ?></h5>
		<div class="heading-elements">
			<ul class="icons-list">
        		<li><a data-action="collapse"></a></li>
        		<li><a data-action="reload"></a></li>
        		<li><a data-action="close"></a></li>
        	</ul>
    	</div>
	</div>

	<div class="panel-body">
		<form class="form-horizontal" action="<?= base_url('search/searchData') ?>" method="POST" name="searchform" id="searchform">
			<div class="col-md-10">
				<input type="text" name="inputsearch" id="inputsearch" class="form-control" required="required" placeholder="Search" title="Search" required>
			</div>
			<div class="col-md-2">
				<div class="pull-right">
					<button type="submit" name="searchbtn" id="searchbtn" class="btn btn-primary"><i class="icon-search4 position-left"></i>  Search</button>
				</div>
			</div>
			<!-- <div style="margin-top: 10px" class="col-md-12">
				<label class="checkbox-inline">
					<input type="checkbox" class="styled" name="cekcompany" value="company">
					Company
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" class="styled" name="cekcomunity" value="coumunity">
					Comunity
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" class="styled" name="cekcampus" value="campus">
					University
				</label>
			</div> -->
		</form>

	</div>
</div>

<div class="panel panel-flat">
	<br>
	<?php if (empty($db)) {?>
	<div style="margin-left: 20px;"><p><i>No Match Data Found (<?=$countotal?>) - "<b><?=$keyword?></b>"</i></p></div>
	<?php }else{ ?>
	<div style="margin-left: 20px;"><p><i>Match Data Found (<?=$countotal?>) - "<b><?=$keyword?></b>"</i></p></div>
	<?php } ?>
		<form class="form-horizontal" action="<?= base_url('report/printResult') ?>" method="POST">
			<div class="col-md-10">
				<input type="hidden" name="dtbase" value="<?=implode(",",$db)?>" class="form-control">
				<input type="hidden" name="key" value="<?=$keyword?>" class="form-control">
			</div>
			<div class="col-md-2">
				<div class="pull-right">
					<button type="submit" class="btn btn-success"><i class="icon-printer position-left"></i>  Print</button>
				</div>
			</div>
		</form>
	<br><br>

	<?php 
	if (!empty($db['cp'])) {?>
	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-law"></i>Result For Company</h5>
	</div>

	<table class="table datatable-responsive-row-control table-hover">
		<thead>
			<tr style="font-size:12px;text-align:center;">
				<th>No</th>
				<?php foreach ($dField['cp'] as $key): 
					$name = $key->name;
					$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
					$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				?>
				<th><?=ucwords($pass2)?></th>
				<?php endforeach ?>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($dMaster['cp'])) {
				$no = 0;
				foreach ($dMaster['cp'] as $key) {
					$no++;
			?>
			<tr class="text-size-mini">
				<td><?=$no?>.</td>
				<?php foreach ($dField['cp'] as $key2){
					$name = $key2->name; ?>

				<td><?= highlightKeywords($key->$name, $keyword) ?></td>

				<?php } ?>
				<td>
					<a data-placement="left" data-popup="tooltip" title="Open Profile" style="margin: 10px" type="button" onclick="location.href='<?=base_url('company/form/').$key->companyID ?>'"><i class="icon-eye"></i></a>
				</td>
			</tr>

			<?php
				}
			}
			?>
		</tbody>
	</table>
	<?php } ?>


	<?php 
	if (!empty($db['cm'])) {?>
	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-law"></i>Result For Comunity</h5>
	</div>

	<table class="table datatable-responsive-row-control table-hover">
		<thead>
			<tr style="font-size:12px;text-align:center;">
				<th>No</th>
				<?php foreach ($dField['cm'] as $key): 
					$name = $key->name;
					$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
					$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				?>
				<th><?=ucwords($pass2)?></th>
				<?php endforeach ?>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($dMaster['cm'])) {
				$no = 0;
				foreach ($dMaster['cm'] as $key) {
					$no++;
			?>
			<tr class="text-size-mini">
				<td><?=$no?>.</td>
				<?php foreach ($dField['cm'] as $key2){
					$name = $key2->name;?>

				<td><?= highlightKeywords($key->$name, $keyword) ?></td>

				<?php } ?>
				<td>
					<a data-placement="left" data-popup="tooltip" title="Open Profile" style="margin: 10px" type="button" onclick="location.href='<?=base_url('comunity/form/').$key->comunityID ?>'"><i class="icon-eye"></i></a>
				</td>
			</tr>

			<?php
				}
			}
			?>
		</tbody>
	</table>

	<?php }?>

	<?php 
	if (!empty($db['un'])) {?>

	<div class="panel-heading">
		<h5 class="panel-title"><i class="icon-law"></i>Result For University</h5>
	</div>

	<table class="table datatable-responsive-row-control table-hover">
		<thead>
			<tr style="font-size:12px;text-align:center;">
				<th>No</th>
				<?php foreach ($dField['un'] as $key): 
					$name = $key->name;
					$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
					$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				?>
				<th><?=ucwords($pass2)?></th>
				<?php endforeach ?>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($dMaster['un'])) {
				$no = 0;
				foreach ($dMaster['un'] as $key) {
					$no++;
			?>
			<tr class="text-size-mini">
				<td><?=$no?>.</td>
				<?php foreach ($dField['un'] as $key2){
					$name = $key2->name;?>

				<td><?= highlightKeywords($key->$name, $keyword) ?></td>

				<?php } ?>
				<td>
					<a data-placement="left" data-popup="tooltip" title="Open Profile" style="margin: 10px" type="button" onclick="location.href='<?=base_url('university/form/').$key->universityID ?>'"><i class="icon-eye"></i></a>
				</td>
			</tr>

			<?php
				}
			}
			?>
		</tbody>
	</table>
		
		<?php }?>

	
</div>