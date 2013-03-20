<?
require_once(WWW_DIR."/lib/status.php");
require_once(WWW_DIR."/lib/image.php");
require_once(WWW_DIR."/lib/caption.php");

// a contest is classified as any period of time that a contest will run for. 
class Contest
{		
    public $id, $start, $end, $status, $image, $captions;
    
    public function __construct() 
    {
        $this->id = -1;
        $this->start = new DateTime();
        $this->end = new DateTime();
        $this->status = new Status();
        $this->image = new Image();
        $this->captions = array(new Caption());
    }
}

class ContestManager
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
        $this->imageMan = new ImageManager($db);
        $this->captionMan = new CaptionManager($db);
    }
    
    public function loadCurrent()
    {
        $query = "SELECT NOW() AS querytime, id, start, end, status, image_id FROM `contests` WHERE `status` = ".Status::STATUS_PUBLISHED." AND NOW() > `start` AND NOW() < `end` ORDER BY `end` DESC LIMIT 0,1";
        $parms = array();
        
        $results = $this->db->queryOneRow($query, $parms, true, 3600);
        
        $contest = new Contest();
        $contest->id = (int)$results['id'];
        $contest->start = new DateTime($results['start']);
        $contest->end = new DateTime($results['end']);
        $contest->status = $contest->status->load($results['status']);
        $contest->image = $this->imageMan->loadOne($results['image_id']);
        
        return $contest;

    }
    
    public function loadPrevious()
    {
        $query = "SELECT NOW() AS querytime, id, start, end, status, image_id FROM `contests` WHERE `status` = ".Status::STATUS_PUBLISHED." AND NOW() > `end` ORDER BY `end` DESC LIMIT 0,1";
        $parms = array();
        
        $results = $this->db->queryOneRow($query, $parms, true, 3600);
        
        $contest = new Contest();
        $contest->id = (int)$results['id'];
        $contest->start = new DateTime($results['start']);
        $contest->end = new DateTime($results['end']);
        $contest->status = $contest->status->load($results['status']);
        $contest->image = $this->imageMan->loadOne($results['image_id']);
        $contest->captions = $this->captionMan->load($contest->id);
        
        return $contest;

    }
}