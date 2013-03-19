<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/image.php");
require_once(WWW_DIR."/lib/tags.php");

// a quote is classified as any period of time that a contest will run for. 
class Quote
{		
    const QUOTE_STATUS_DELETED = 1;
    const QUOTE_STATUS_PUBLISHED = 2;
    const QUOTE_STATUS_DRAFT = 3;

    private $id, $start, $end, $status, $image;
    
    public function __construct($id, $start, $end, $status) 
    {
        $this->id = $id;
        $this->start = new DateTime($start);
        $this->end = new DateTime($end);
        $this->status = $status;
        $this->image = new Image();
        $this->tags = new TagCollection();
        $this->captions = array(); // new Captions();
    }
    
    public function loadCurrent()
    {
		$db = new DB();
        $query = "SELECT NOW() AS querytime, id, start, end, status, image_id FROM `quotes` WHERE `status` = 2 AND NOW() > `start` ORDER BY `end` DESC LIMIT 0,1";
        $parms = array();
        
        // $query .= "WHERE id = :id";
        // $parms[] = array(':id',$id);
        
        $results = $db->queryOneRow($query, $parms, true, 300);
        
        foreach($results as $k=>$v) 
        {
            $this->$k = $v;
        }
        
        $this->image = $this->image->load($results['image_id']);
        $this->tags = $this->tags->loadByQid($results['id']);
        
        return $this;

    }
}