<?php
require_once(WWW_DIR."/lib/framework/db.php");

class Users
{		
	const ROLE_DISABLED = -1;
	const ROLE_GUEST = 0;
	const ROLE_USER = 1;
	const ROLE_MOD = 2;
	const ROLE_ADMIN = 3;
	
	const SALTLEN = 4;
	const SHA1LEN = 40;

    public function get()
	{			
		$db = new DB();
		return $db->query("select * from users");		
        return false;
	}	
	
}