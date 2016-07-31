<?php

class config
{
	private $dbase;
	private $properties = array();
	
	function __construct($db)
	{
		$this->dbase = $db;
		$this->load_from_db();
	}
	
	// Load all config values from database
	function load_from_db()
	{
		$result = $this->dbase->query("SELECT *  FROM minty_config");
		
		while ($row = $this->dbase->fetch_array($result))
		{
			$this->properties[$row['name']] = $row['value'];
		}
	}
	
	// Set property and update database at the same time
	public function __set($n, $v)
    {
        $this->properties[$n] = $v;
		
		$sql = sprintf(
		"SELECT * 
		FROM minty_config 
		WHERE name='%s'",
		$n
		);
		
		$check_row = $this->dbase->query($sql);
		
		if ($this->dbase->num_rows($check_row) > 0)
		{
			$sql = sprintf(
			"UPDATE minty_config 
			SET value='%s' 
			WHERE name='%s'",
			$v,
			$n
			);
		}
		else
		{
			$sql = sprintf(
			"INSERT INTO minty_config 
			(name, value)
			VALUES ('%s', '%s')",
			$n,
			$v
			);
		}
		
		$this->dbase->query($sql);
    }
	
	public function __get($n)
	{
		return $this->properties[$n];
	}
	
	public function __isset($n)
	{
		return isset($this->properties[$n]);
	}
}

?>