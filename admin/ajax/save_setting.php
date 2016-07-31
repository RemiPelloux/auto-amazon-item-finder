<?php

session_start();

include('../../config.php');

if (!$user->isAuthenticated())
{
	die();
}

$key = $post->key;

$config->$key = $post->value;

sleep(1);
?>