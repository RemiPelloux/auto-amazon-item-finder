<?php

// MINTY CMS - plural.php - plural ORM object

class products
{
	private $dbase;
	private $filter_sql;
	private $order_sql;
	private $limit_sql;
	public $children = array();

	public function __construct($db, $auto_load = true)
	{
		$this->name = get_class($this);
		$this->child_name = "product";
		$this->dbase = $db;
		
		if ($auto_load)
		{
			$this->load_from_db();
		}
	}
	
	// Specifies an SQL filter for selecting children
	public function setFilter($filter)
	{
		$this->filter_sql = " WHERE ".$filter;
	}
	
	// Specifies an SQL order for selecting children
	public function setOrder($order)
	{
		$this->order_sql = " ORDER BY ".$order;
	}
	
	public function setLimit($limit)
	{
		$this->limit_sql = " LIMIT ".$limit;
	}
	
	// Loads all children from database
	function load_from_db()
	{
		$sql = sprintf(
		"SELECT ID 
		FROM %s 
		%s 
		%s
		%s",
		$this->name,
		$this->filter_sql,
		$this->order_sql,
		$this->limit_sql
		);
	
		$result = $this->dbase->query($sql);
		
		while ($row = $this->dbase->fetch_array($result))
		{
			$t = new $this->child_name($this->dbase);
			$t->ID = $row['ID'];
			$t->load_by_id();
			
			$this->children[] = $t;
		}
	}
}

?>