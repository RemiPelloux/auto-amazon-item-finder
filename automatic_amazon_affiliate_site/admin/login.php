<?php

session_start();

include('../config.php');

if ($get->action == "logout")
{
	$user->deauthenticate();
	$succ = "You have logged out.";
}

if ($user->isAuthenticated())
{
	header('Location: ./index.php');
}

if (isset($post->form_action))
{
	if ($user->login($post->email, $post->password))
	{
		header('Location: ./index.php');
	}
	else
	{
		$err = "Bad email or password.";
	}
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
			Shop Admin Area
        </h1>
        <p class="lead">
			Or go <a href="<?php echo M_ENV_SITE_URL ?>">back</a> if you're lost.
        </p>
        <div class="row">
		  <?php if ($succ) echo "<div class=\"alert alert-success\">".$succ."</div>" ?>
		  <?php if ($err) echo "<div class=\"alert alert-danger\">".$err."</div>" ?>
          <div class="col-md-3">
			<div class="well">
				<form method="post">
				  <div class="form-group">
					<label>
					  Name
					</label>
					<input type="text" name="email" class="form-control">
				  </div>
				  <div class="form-group">
					<label>
					  Password
					</label>
					<input type="password" name="password" class="form-control">
				  </div>
				  <button type="submit" class="btn btn-primary" name="form_action">
					Login
				  </button>
				</form>
			</div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js">
    </script>
  </body>

</html>