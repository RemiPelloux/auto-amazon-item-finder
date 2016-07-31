<?php

session_start();

include('../config.php');

if (!$user->isAuthenticated())
{
	header('Location: ./login.php');
	die();
}

$q = $db->query("SELECT DISTINCT category FROM products");
$num_categories = $db->num_rows($q);

$q = $db->query("SELECT ID FROM products");
$num_items = $db->num_rows($q);

?>

<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body>
    <div class="container">
      <div class="starter-template">
        <h1>
          Automatic Amazon Affiliate Site
        </h1>
        <div class="row">
			<div class="col-sm-2">
				<nav class="nav-sidebar">
					<ul class="nav">
						<li class="active"><a href="index.php" href="index.php">Basic Settings</a></li>
						<li><a href="settings.php" href="settings.php">Advanced Settings</a></li>
						<li><a href="products.php" href="products.php">Products</a></li>
					</ul>
				</nav>
			</div>
			
			<div class="col-md-8">
				<h3>Stats</h3>
				<p>
				  Total Categories: <?php echo $num_categories ?><br />
				  Total Items: <?php echo $num_items ?>
				</p>
				<hr />
				<h3>Search Terms</h3>
				<div class="control-group">
					<div class="form-group">
						<textarea class="form-control" id="item_list" rows="3"><?php if ($config->items != "") echo implode(', ', unserialize($config->items)) ?></textarea>
					</div>
					<button id="save_button" data-loading-text="Saving..." class="btn btn-large btn-primary">Save</button>
				</div>
				<hr />
				<h3>Update Catalog</h3>
				<div class="control-group">
					<div class="form-group">
						<button name="update" id="update_button" class="btn btn-large btn-primary">Begin Update</button>
					</div>
				</div>
				<div id="update_window"></div>
			</div>
		  
			<div class="col-md-2">
				<p>Welcome, <?php echo $user->username ?>.</p>
				<a href="login.php?action=logout" class="btn btn-danger">Log Out</a>
			</div>
        </div>
      </div>
    </div>
    <!-- /.container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js">
    </script>
	<script src="local.js"></script>
  </body>

</html>