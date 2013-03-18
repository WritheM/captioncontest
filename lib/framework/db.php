<?php
require_once(WWW_DIR."/lib/framework/cache.php");

class DB
{
	private static $initialized = false;
	private static $conn = null;

	function DB()
	{
		if (DB::$initialized === false)
		{
            try {
                $connstr = DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME.";charset=utf-8";
                DB::$conn = new PDO(
                    $connstr, 
                    DB_USER, 
                    DB_PASSWORD,
                    array(
                        PDO::ATTR_PERSISTENT => (defined("DB_PERSISTENT") && DB_PERSISTENT ? true : false),
                        PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"
                    )
                );
            } catch (PDOException $e) {
                die("<div id=\"fail_connect\">\n  <error details=\"%s\" />\n</div>\n" % $e->getMessage());
            }

			DB::$initialized = true;
		}			
	}	
				
	public function escapeString($str)
	{
		return "'".mysql_real_escape_string($str, DB::$conn)."'";
	}		

	public function makeLookupTable($rows, $keycol)
	{
		$arr = array();
		foreach($rows as $row)
			$arr[$row[$keycol]] = $row;			
		return $arr;
	}	
	
	public function queryInsert($query, $returnlastid=true)
	{
		$result = mysql_query($query, DB::$conn) or $this->showError();
		return ($returnlastid) ? mysql_insert_id(DB::$conn) : $result;
	}
	
	public function queryOneRow($query, $parms, $useCache=false, $cacheTTL='')
	{
		$rows = $this->query($query, $parms, $useCache, $cacheTTL);
		return ($rows ? $rows[0] : false);
	}	
		
	public function query($query, $parms, $useCache=false, $cacheTTL='')
	{
		if ($useCache)
		{ // check if cache has this already loaded
			$cache = new Cache;
			if ($cache->enabled && $cache->exists($query))
			{
				$ret = $cache->fetch($query);
				if ($ret !== false)
					return $ret;
			}
		}	
        
        { // set up the statement / execute
            $stmt = DB::$conn->prepare($query);
            $cacheQuery = $query;
            if(isset($parms))
                foreach($parms as $parm) {
                    $stmt->bindValue($parm[0], $parm[1]);    
                    $cacheQuery = str_replace(':'.$parm[0],$parm[1],$cacheQuery);
                }

            try 
            {
                $stmt->execute();
            } 
            catch (PDOException $e)
            {
                return("<div id=\"fail_query\">\n  <error details=\"%s\" />\n</div>\n" % $e->getMessage());
            }
        }
          
        { // populate our object / return
            if ($stmt->rowCount() > 0) 
            {
                $rows = $stmt->fetchAll();
            } 
            else 
            {
                return false;
            }
        }
		
		if ($useCache) 
			if ($cache->enabled)
				$cache->store($cacheQuery, $rows, $cacheTTL);
			
		return $rows;
	}	
	
	public function queryDirect($query)
	{
		$ret = mysql_query($query, DB::$conn) or $this->showError();
		return $ret;
	}	

	public function optimise($force = false) 
	{
		$ret = array();
		if ($force)
			$alltables = $this->query("show table status"); 
		else
			$alltables = $this->query("show table status where Data_free != 0"); 

		foreach ($alltables as $tablename) 
		{
			$ret[] = $tablename['Name'];
			$this->queryDirect("REPAIR TABLE `".$tablename['Name']."`"); 
			$this->queryDirect("OPTIMIZE TABLE `".$tablename['Name']."`"); 
			$this->queryDirect("ANALYZE TABLE `".$tablename['Name']."`"); 
		}
			
		return $ret;
	}
	
	private function showError($terminate = false) 
	{
		var_dump(debug_backtrace());
		var_dump(mysql_error());
		if ($terminate)
			die();
    }
}