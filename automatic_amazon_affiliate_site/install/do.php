<?php
// Defaults
if ($_POST['db_server'] == "") $_POST['db_server'] = "localhost";
if ($_POST['admin_user'] == "") $_POST['admin_user'] = "admin";
if ($_POST['min_discount'] == "") $_POST['min_discount'] = "100";
if ($_POST['search_category'] == "") $_POST['search_category'] = "Electronics";

$status = "";
$succ = "<span style=\"color:green\">Done!</span><br />";
$fail = "<span style=\"color:red\">Failed.</span><br />";
$err = false;

// Validation
foreach ($_POST as $p)
{
	if ($p == "") $err = "You left a field blank. Please press the back button and try again.";
}

// Placeholders
if (!$err)
{
	$f = file_get_contents("../config.php");
	
	$f = str_replace("DB_SERVER_PLACEHOLDER", $_POST['db_server'], $f);
	$f = str_replace("DB_USER_PLACEHOLDER", $_POST['db_user'], $f);
	$f = str_replace("DB_PASSWORD_PLACEHOLDER", $_POST['db_password'], $f);
	$f = str_replace("DB_NAME_PLACEHOLDER", $_POST['db_name'], $f);
	
	if (!file_put_contents("../config.php", $f))
	{
		$msg .= "Writing config file... ".$fail;
		$err = "Unable to open config.php for writing. Try changing permissions.";
	}
	else
	{
		$msg .= "Writing config file... ".$succ;
		require('../config.php');
	}
}

// SQL
if (!$err)
{
	if ($mysql_err)
	{
		$msg .= "Checking database connection... ".$fail;
		$err = $mysql_err;
	}
	else
	{
		$msg .= "Checking database connection... ".$succ;
		
		$sql_file = (M_ENV_SITE_ROOT."/install/install.sql");
		$file_handle = fopen($sql_file, 'r+'); 
		$contents = fread($file_handle, filesize($sql_file)); 
		$cont = preg_split("/;/", $contents); 

		foreach($cont as $query)
		{
			$result = @mysql_query($query); 
		} 
		
		fclose($file_handle);
		
		$msg .= "Running SQL queries... ".$succ;
	}
}

// Settings inserts
if (!$err)
{
	$sql = sprintf(
		"INSERT INTO minty_users 
		(username, password) 
		VALUES ('%s', '%s')",
		$db->clean($post->admin_user),
		md5($post->admin_password)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('search_category', '%s')",
		$db->clean($post->search_category)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('site_title', '%s')",
		$db->clean($post->site_title)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('meta_description', '%s')",
		$db->clean($post->meta_description)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('meta_keywords', '%s')",
		$db->clean($post->meta_keywords)
	);
		
	$db->query($sql);

	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('associate_tag', '%s')",
		$db->clean($post->associate_tag)
	);
		
	$db->query($sql);

	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('public_key', '%s')",
		$db->clean($post->public_key)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('private_key', '%s')",
		$db->clean($post->private_key)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('min_discount', '%s')",
		$db->clean($post->min_discount)
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('region', 'com')"
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('items', '')"
	);
		
	$db->query($sql);
	
	$sql = sprintf(
		"INSERT INTO minty_config 
		(name, value) 
		VALUES ('sleep_time', '10')"
	);
		
	$db->query($sql);
	
	$msg .= "Creating settings... ".$succ;
}

?>
<!doctype html>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Install</title>
        <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
    
    <body>
        <div class="container-fluid">
            <div class="hero-unit">
				<?php 
				if (!$err)
				{ ?>
                <h1>Installation complete.</h1>
				<p><strong>PLEASE DELETE THE ENTIRE /install/ FOLDER FROM THE SERVER.</strong></p>
                <p>Click <a href="<?php echo M_ENV_SITE_URL ?>">here</a> to continue.</p>
				<?php 
				}
				else
				{ ?>
				<h1>There was a problem during installation.</h1>
                <p><?php echo $err ?></p>
				<?php
				} ?>
            </div>
			<div class="span9">
				<p><?php echo $msg ?></p>
			</div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    </body>

</html>