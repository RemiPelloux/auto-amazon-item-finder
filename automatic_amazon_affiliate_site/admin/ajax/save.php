<?php

session_start();

include('../../config.php');

if (!$user->isAuthenticated())
{
	die();
}

$config->items = serialize(json_decode(stripslashes($post->l)));

sleep(1);
?>