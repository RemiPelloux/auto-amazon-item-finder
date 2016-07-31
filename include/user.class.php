<?php

// MINTY CMS - user.php - auth class

class user
{
	private $authenticated;
	private $dbase;

	function __construct($db)
	{
		session_start();
		
		$this->dbase = $db;
		
		if (isset($_SESSION['user_id']))
		{
			$this->authenticate($_SESSION['user_id']);
		}
	}

	// Login PHP session
	function login($username, $password)
	{
		$username = $this->dbase->clean($username);
		$password = md5($password);
		
		$sql = sprintf(
		"SELECT * 
		FROM minty_users 
		WHERE username='%s'",
		$username
		);
		
		$query = $this->dbase->query($sql);
		$result = $this->dbase->fetch_array($query);
		
		if ($result['password'] == $password)
		{
			$this->authenticate($result['ID']);
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Set user as authenticated
	function authenticate($id)
	{
		$sql = sprintf(
		"SELECT * 
		FROM minty_users 
		WHERE ID=%d",
		$id
		);
		
		$query = $this->dbase->query($sql);
		$result = $this->dbase->fetch_array($query);
	
		session_regenerate_id();
		$_SESSION['user_id'] = $id;
		$this->user_id = $id;
		$this->authenticated = true;
		$this->username = $result['username'];
	}
	
	// Revoke authentication
	function deauthenticate()
	{
		$this->authenticated = false;
		unset($_SESSION['user_id']);
		unset($this->user_id);
		unset($this->username);
	}
	
	// Returns whether or not user is authenticated
	function isAuthenticated()
	{
		return ($this->authenticated);
	}
	
	// Change current user's password
	function change_password($new_password)
	{
		if ($this->authenticated)
		{
			$new_password = md5($new_password);
		
			$sql = sprintf(
			"UPDATE minty_users 
			SET password='%s' 
			WHERE ID=%d",
			$new_password,
			$this->user_id
			);
			
			$this->dbase->query($sql);
		}
	}
}

?>