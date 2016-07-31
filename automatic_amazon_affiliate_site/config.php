<?php

// Database server, username, password, and database name.

define("M_DATABASE_SERVER", "DB_SERVER_PLACEHOLDER");
define("M_DATABASE_USER", "DB_USER_PLACEHOLDER");
define("M_DATABASE_PASSWORD", "DB_PASSWORD_PLACEHOLDER");
define("M_DATABASE_NAME", "DB_NAME_PLACEHOLDER");

// Paths

if (strpos(getcwd(), "admin"))
	$root =  substr(getcwd(), 0, strpos(getcwd(), "admin"));
else if (strpos(getcwd(), "install"))
	$root =  substr(getcwd(), 0, strpos(getcwd(), "install"));
else
	$root = getcwd();

define("M_ENV_SITE_ROOT", $root);
define("M_ENV_SITE_URL", "http://".$_SERVER["HTTP_HOST"]."/");
define("M_ENV_TEMPLATE_PATH", "/templates/default");
define("M_ENV_TEMPLATE_ROOT", M_ENV_SITE_ROOT.M_ENV_TEMPLATE_PATH);

// Autoload classes
function __autoload($classname)
{
	require(M_ENV_SITE_ROOT.'/include/'.$classname.'.class.php');
}

// An alternative
//array_walk(glob('./include/*.class.php'),create_function('$v,$i', 'return require_once($v);')); 

// Open database

$mysql_err = false;
$db = new mysql();

if(!$db->connect(M_DATABASE_SERVER, M_DATABASE_USER, M_DATABASE_PASSWORD, M_DATABASE_NAME))
{
	$mysql_err = "Could not connect to database.";
}

// Represents all post and get variables

$post = new post($db);
$get = new get($db);

// Initialize current admin user

$user = new user($db);

// Initialize config object

$config = new config($db);

?>