<!doctype html>
<html>
    
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Install</title>
	<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
</head>

<body>
	<form action="do.php" method="post">
	<div class="container-fluid">
		<div class="hero-unit">
			<h1>Minty Installer</h1>
			<p>Complete all fields and then click the button below. Default values are provided in grey.</p>
			<input type="submit" class="btn btn-primary btn-large" value="Continue" />
		</div>
		
		<div class="well span6">
			<div class="row">
				<div class="span3">
					<label>Website Title</label>
					<input type="text" name="site_title" class="span3" />
					<label>Meta Description</label>
					<input type="text" name="meta_description" class="span3" />
					<label>Meta Keywords</label>
					<input type="text" name="meta_keywords" class="span3" />
					<label>Search Category</label>
					<input type="text" name="search_category" class="span3" placeholder="Electronics" />
					<label>Maximum of Original Price</label>
					<input type="text" name="min_discount" class="span1" placeholder="100" />%
				</div>
			</div>
		</div>
		
		<div class="well span6">
			<div class="row">
				<div class="span3">
					<label>Amazon Associate Tag</label>
					<input type="text" name="associate_tag" class="span3" />
					<label>Amazon Private Key</label>
					<input type="text" name="private_key" class="span3" />
					<label>Amazon Public Key</label>
					<input type="text" name="public_key" class="span3" />
				</div>
			</div>
		</div>
		
		
		<div class="well span6">
			<div class="row">
				<div class="span3">
					<label>Admin Username</label>
					<input type="text" name="admin_user" class="span3" placeholder="admin" />
					<label>Admin Password</label>
					<input type="password" name="admin_password" class="span3" />
				</div>
			</div>
		</div>
		
		<div class="well span6">
			<div class="row">
				<div class="span3">
					<label>Database Server</label>
					<input type="text" name="db_server" class="span3" placeholder="localhost" />
					<label>Database Username</label>
					<input type="text" name="db_user" class="span3" />
					<label>Database Password</label>
					<input type="password" name="db_password" class="span3" />
					<label>Database Name</label>
					<input type="text" name="db_name" class="span3" />
				</div>
			</div>
		</div>
		
	</div>
	</form>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
</body>

</html>