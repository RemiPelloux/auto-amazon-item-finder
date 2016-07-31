<?php

// MINTY CMS - singular.php - singular ORM object

class product
{
	private $dbase;
	private $properties = array();

	function __construct($db)
	{
		//$this->name = get_class($this);
		//$this->parent_name = "products";
		$this->dbase = $db;
	}
	
	// Load properties from database by ID
	function load_by_id()
	{
		$sql = sprintf(
			"SELECT * 
			FROM products 
			WHERE ID=%d",
			$this->ID
		);
	
		$result = $this->dbase->query($sql);
		
		if ($this->dbase->num_rows($result) > 0)
		{
			$row = $this->dbase->fetch_array($result);
		
			foreach ($row as $k => $v)
			{
				$this->properties[$k] = $v;
			}
		}
		
		$this->images = unserialize($this->images);
	}
	
	// Create new row
	function create()
	{
		$fields = array();
		$values = array();
		
		$this->images = serialize($this->images);
	
		foreach ($this->properties as $k => $v)
		{
			$fields[] = $k;
			$values[] = (is_numeric($v)) ? $v : "'".$v."'";
		}
	
		$sql = sprintf(
			"INSERT INTO products 
			(%s) 
			VALUES (%s)",
			implode(",", $fields),
			implode(",", $values)
		);
		
		$this->dbase->query($sql);
		
		if ($this->dbase->affected_rows() > 0) 
		{
			$this->ID = $this->dbase->insert_id();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Update row
	function update()
	{
		$field_data = array();
		
		$this->images = serialize($this->images);
		
		foreach ($this->properties as $k => $v)
		{
			$field_data[] = $k."='".$v."'";
		}
	
		$sql = sprintf(
		"UPDATE products 
		SET %s 
		WHERE ID=%d",
		implode(",", $field_data),
		$this->ID
		);	
		
		$this->dbase->query($sql);
		
		return ($this->dbase->affected_rows() > 0) ? true : false;
	}
	
	// Delete row
	function delete()
	{
		$sql = sprintf(
		"DELETE FROM products 
		WHERE ID=%d",
		$this->ID
		);
	
		$this->dbase->query($sql);
		return ($this->dbase->affected_rows() > 0) ? true : false;
	}
	
	public function __set($n, $v)
    {
        $this->properties[$n] = $v;
    }
	
	public function __get($n)
	{
		return $this->properties[$n];
	}
	
	public function __isset($n)
	{
		return isset($this->properties[$n]);
	}
	
	public function __unset($n)
	{
		unset($this->properties[$n]);
	}
}

?>