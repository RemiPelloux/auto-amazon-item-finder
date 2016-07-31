<body>
	<div class="container">
		<div class="header">
			<h1><?php echo $config->site_title ?></h1>
		</div>
			
		<div class="col-sm-3 side_nav">
			<h4>Categories</h4>
			<hr>
			<nav>
				<ul class="nav nav-pills nav-stacked">
					<?php foreach ($categories as $c){ ?>
					<li><a href="<? echo M_ENV_SITE_URL."/category/".urlencode($c) ?>"><i class="icon-right-open"></i> <? echo $c ?></a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>

		<div class="col-sm-9">
