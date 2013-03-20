<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/image.php");
require_once(WWW_DIR."/lib/status.php");

// a contest is classified as any period of time that a contest will run for. 
class Contest
{		
    private $id, $start, $end, $status, $image, $captions;
    
    public function __construct() 
    {
        $this->id = -1;
        $this->start = new DateTime();
        $this->end = new DateTime();
        $this->status = new Status(-1);
        $this->image = new Image(-1);
        $this->captions = array(); // new Captions();
    }
    
    public function __get($v)
    {
        return $this->$v;
    }
    
    public function loadCurrent()
    {
		$db = new DB();
        $query = "SELECT NOW() AS querytime, id, start, end, status, image_id FROM `contests` WHERE `status` = ".Status::STATUS_PUBLISHED." AND NOW() > `start` AND NOW() < `end` ORDER BY `end` DESC LIMIT 0,1";
        $parms = array();
        
        $results = $db->queryOneRow($query, $parms, true, 3600);
        
        $this->id = (int)$results['id'];
        $this->start = new DateTime($results['start']);
        $this->end = new DateTime($results['end']);
        $this->status = new Status($results['status']);
        $this->image = $this->image->load($results['image_id']);
        
        return $this;

    }
    
    public function loadPrevious()
    {
		$db = new DB();
        $query = "SELECT NOW() AS querytime, id, start, end, status, image_id FROM `contests` WHERE `status` = ".Status::STATUS_PUBLISHED." AND NOW() > `start` ORDER BY `end` DESC LIMIT 1,2";
        $parms = array();
        
        $results = $db->queryOneRow($query, $parms, true, 3600);
        
        $this->id = (int)$results['id'];
        $this->start = new DateTime($results['start']);
        $this->end = new DateTime($results['end']);
        $this->status = new Status($results['status']);
        $this->image = $this->image->load($results['image_id']);
        
        return $this;

    }
}