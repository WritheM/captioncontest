<?php
require_once(WWW_DIR."/lib/framework/db.php");

class Sites
{	
	const REGISTER_STATUS_OPEN = 0;
	const REGISTER_STATUS_MAINTENANCE = 1;
	const REGISTER_STATUS_CLOSED = 2;

	public function version()
	{
		return "0.0.130318.1";
	}
	
	public function get()
	{			
		$db = new DB();
		$rows = $db->query("select * from site");			

		if ($rows === false)
			return false;
		
		return $this->rows2Object($rows);
	}	
	
	public function rows2Object($rows)
	{
        if ($rows != null)
        {
            $obj = new stdClass;
            foreach($rows as $row)
                $obj->{$row['setting']} = $row['value'];
        
            $obj->{'version'} = $this->version();
            return $obj;
        }
        else
        {
            return null;
        }
	}
	
	public function row2Object($row)
	{
		$obj = new stdClass;
		$rowKeys = array_keys($row);
		foreach($rowKeys as $key)
			$obj->{$key} = $row[$key];
		
		return $obj;
	}
	
	public function updateItem($setting, $value)
	{
		$db = new DB();
		$sql = sprintf("update site set value = %s where setting = %s", $db->escapeString($value), $db->escapeString($setting));
		return $db->query($sql);
	}	
	
	public function updateLatestRegexRevision($rev)
	{
		return $this->updateItem("latestregexrevision", $rev);
	}
	
	public function getLicense($html=false)
	{
		$n = "\r\n";
		if ($html)
			$n = "<br/>";
	
		return $n."wmcc ".$this->version()." Copyright (C) ".date("Y")." writhem.com".$n."

This program is distributed with a commercial licence. See LICENCE.txt for 
further details.".$n;
	}
}