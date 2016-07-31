<?php

include('config.php');

$slug = urldecode($get->slug);
$q = $db->query("SELECT ID FROM products WHERE name LIKE '%".$slug."%'");
$row = $db->fetch_array($q);
$id = $row['ID'];

$p = new product($db);
$p->ID = $id;
$p->load_by_id();

$categories = array();
$q = $db->query("SELECT DISTINCT category FROM products");

while ($row = $db->fetch_array($q))
{
	$categories[] = $row['category'];
}

include(M_ENV_TEMPLATE_ROOT . '/template_head.php');

include(M_ENV_TEMPLATE_ROOT . '/template_body.php');
?>
<div class="details_container">
	<h2><?php echo $p->name ?></h2>

	<div class="row">
		<div class="col-sm-5">
			<div class="image">
				<img src="<?php echo $p->images[0] ?>" />
			</div>
		</div>

		<div class="col-sm-4">
			<div class="details wrapper">
				<p><? echo $p->mfg_part_no ?></p>
				<p><? echo $p->upc ?></p>
				<h2 class="price_old">$<? echo $p->reg_price ?></h2>
				<h2 class="price_new">$<? echo $p->price ?></h2>

				<div class="controls">
					<button type="button" class="btn btn-info btn-lg">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span><a href="<?php echo $p->link ?>"> Buy Now</a>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include(M_ENV_TEMPLATE_ROOT . '/template_foot.php');

?>