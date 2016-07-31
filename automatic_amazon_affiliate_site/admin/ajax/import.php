<?php

session_start();

include('../../config.php');

if (!$user->isAuthenticated())
{
	die();
}

set_time_limit(9999);

$items = unserialize($config->items);
	
$db->query("TRUNCATE TABLE products");

$amazon = new amazonAPI(
	$config->public_key, 
	$config->private_key,
	$config->associate_tag,
	(int)$config->min_discount*0.01,
	$config->region
	);

foreach ($items as $item)
{
	$listing = $amazon->searchProducts($item, $config->search_category);
	
	echo $item.": total products - ".count($listing)."<br />";
	
	foreach ($listing as $i)
	{
		$p = new product($db);
		$p->vendor = $i['vendor'];
		$p->mfg_part_no = $i['mfg_part_no'];
		$p->upc = $i['upc'];
		$p->name = $i['name'];
		$p->price = $i['price'];
		$p->reg_price = $i['reg_price'];
		$p->category = $i['category'];
		$p->images = $i['images'];
		$p->link = $i['link'];
		
		$p->create();
	}
	
	sleep((int)$config->sleep_time);
}

?>