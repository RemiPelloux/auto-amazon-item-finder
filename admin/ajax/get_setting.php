<?php

session_start();

include('../../config.php');

if (!$user->isAuthenticated())
{
	die();
}

$key = $post->key;

echo $config->$key;

?>