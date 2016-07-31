<?php

session_start();

include('../config.php');

if (!$user->isAuthenticated())
{
	header('Location: /admin/login.php');
	die();
}

if (isset($get->del) && is_numeric($get->del))
{
	$db->query("DELETE FROM products WHERE ID=".$get->del);
}

$products = new products($db);

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
						<li><a href="index.php" href="index.php">Basic Settings</a></li>
						<li><a href="settings.php" href="settings.php">Advanced Settings</a></li>
						<li class="active"><a href="products.php" href="products.php">Products</a></li>
					</ul>
				</nav>
			</div>
			
			<div class="col-md-8">
				<h3>Products</h3>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Name</th>
							<th>Category</th>
							<th>Price</th>
							<th>Part No.</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
							<?php
							foreach ($products->children as $p)
							{ ?>
							<tr>
								<td><?php echo $p->name ?></td>
								<td><?php echo $p->category ?></td>
								<td>$<?php echo $p->price ?></td>
								<td><?php echo $p->mfg_part_no ?></td>
								<td><a href="products.php?del=<?php echo $p->ID ?>">Delete</a></td>
							</tr>
							<?php
							} ?>
						</tbody>
					</table>
				</div>
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