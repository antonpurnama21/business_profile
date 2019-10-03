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