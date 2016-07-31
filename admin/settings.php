<?php

session_start();

include('../config.php');

if (!$user->isAuthenticated())
{
	header('Location: /admin/login.php');
	die();
}

$html = "<option value=\"\">Select a setting...</option>";

$result = $db->query("SELECT name FROM minty_config");

while ($row = $db->fetch_array($result))
{
	if ($row['name'] != "items")
		$html .= "<option value=\"".$row['name']."\">".$row['name']."</option>";
}

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
						<li class="active"><a href="settings.php" href="settings.php">Advanced Settings</a></li>  
						<li><a href="products.php" href="products.php">Products</a></li>
					</ul>
				</nav>
			</div>
			
			<div class="col-md-8">
				<h3>Advanced Settings</h3>
				<div class="well">
					<div class="control-group">
						<div class="form-group">
							<label>Setting</label>
							<select id="setting" class="form-control">
								<?php echo $html ?>
							</select>
						</div>
						<div class="form-group">
							<label>Value</label>
							<input type="text" id="new_value" class="form-control" />
						</div>
						<button id="save_setting" data-loading-text="Saving..." class="btn btn-large btn-primary">Save</button>
					</div>
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