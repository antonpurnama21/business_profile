<div class="sidebar-category sidebar-category-visible">
	<div class="category-content no-padding">
		<ul class="navigation navigation-main navigation-accordion">

			<!-- Main -->
			<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
			<li><a href="<?= base_url() ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>

			<li <?= getActiveFunc('university/index') ?>><a href="<?= base_url('university/index') ?>"><i class="icon-home"></i> <span>University Profile </span></a></li>
			<li <?= getActiveFunc('company/index') ?>><a href="<?= base_url('company/index') ?>"><i class="icon-office"></i> <span>Company Profile </span></a></li>
			<li <?= getActiveFunc('comunity/index') ?>><a href="<?= base_url('comunity/index') ?>"><i class="icon-users"></i> <span>Comunity Profile </span></a></li>
			<li <?= getActiveFunc('search/index') ?>><a href="<?= base_url('search/index') ?>"><i class="icon-search4"></i> <span>Search Data </span></a></li>
						
		</ul>
	</div>
</div>