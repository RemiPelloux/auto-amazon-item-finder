<?php

include('config.php');

$products = new products($db);
$category = "All Products";

$categories = array();
$q = $db->query("SELECT DISTINCT category FROM products");

while ($row = $db->fetch_array($q))
{
	$categories[] = $row['category'];
}

include(M_ENV_TEMPLATE_ROOT . '/template_head.php');

include(M_ENV_TEMPLATE_ROOT . '/template_body.php');
?>
			<div class="category_title">
				<h2>All Products</h2><hr>
			</div>
			
			<div class="items_container">
<?php
foreach ($products->children as $p)
{ ?>
				<div class="col-sm-4">
					<div class="item">
						<div class="thumb">
							<div class="image">
								<a href="<? echo M_ENV_SITE_URL."product/".urlencode(substr($p->name,0,30)) ?>"><img src="<? echo $p->images[0] ?>" alt="<?php echo $p->name ?>" /></a>
							</div>
							<div class="description">
								<p><? echo $p->description ?></p>
							</div>
						</div>
						
						<div class="price">
							<?php 
							if ((float)$p->price != (float)$p->reg_price)
							{
							?>
							<span class="price_old">$<? echo $p->reg_price ?></span>
							<?php	
							} ?>
							<span class="price_new">$<? echo $p->price ?></span>
						</div>
						<p class="product_name"><a href="<? echo M_ENV_SITE_URL."product/".urlencode(substr($p->name,0,30)) ?>"><? echo $p->name ?></a></p>
					</div>
				</div>
<?
} ?>
			</div>
<?php
include(M_ENV_TEMPLATE_ROOT . '/template_foot.php');

?>