<?php

class mysql
{
	private $link;
	private $log;
	
	function connect($host, $user, $pass, $dbase)
	{
		$this->link = mysql_connect($host, $user, $pass);
		
		if (!$this->link || !mysql_select_db($dbase, $this->link))
		{
			return false;
		}
		else
		{
			return $this->link;
		}
	}
	
	function clean($str)
	{
		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		
		return mysql_real_escape_string($str);
	}
	
	function error()
	{
		return mysql_error($this->link);
	}
	
	function close()
    {
        mysql_close($this->link);
    }
	
	function query($query, $error_logging = true)
	{
		$query = mysql_query($query, $this->link);
		
		return $query;
	}
	
    function affected_rows()
    {
        $query = mysql_affected_rows($this->link);
        return $query;
    }

    function escape_string($string)
    {
        $query = mysql_escape_string($string);
        return $query;
    }

    function fetch_array($query)
    {
        $query = mysql_fetch_array($query);
        return $query;
    }

    function fetch_row($query)
    {
        $query = mysql_fetch_row($query);
        return $query;
    }

    function field_name($query, $offset)
    {
        $query = mysql_field_name($query, $offset);
        return $query;
    }

    function free_result($query)
    {
        mysql_free_result($query);
    }

    function insert_id()
    {
        $query = mysql_insert_id($this->link);
        return $query;
    }

    function num_fields($query)
    {
        $query = mysql_num_fields($query);
        return $query;
    }

    function num_rows($query)
    {
        $query = mysql_num_rows($query);
        return $query;
    }

    function real_escape_string($string)
    {
        $query = mysql_real_escape_string($string, $this->link);
        return $query;
    }
}

?>