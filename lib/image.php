<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/tags.php");

// a quote is classified as any period of time that a contest will run for. 
class Image
{		
    private $id;
    public $path, $width, $height;
    
    public function __construct() 
    {
        $this->id = -1;
        $this->path = '';
        $this->width = 0;
        $this->height = 0;
        $this->tags = new TagCollection();
    }
    
    public function load($id = -1)
    {
        if($id > 0)
        {
            $db = new DB();
            $parms = array();
            $query = "SELECT NOW() AS querytime, id, width, height, uri FROM `images` WHERE `id` = :id LIMIT 0,1";
            $parms[] = array(':id',$id);
            
            $results = $db->queryOneRow($query, $parms, true, 3600);
            
            $this->id = (int)$results['id'];
            $this->width = (int)$results['width'];
            $this->height = (int)$results['height'];
            $this->path = (string)$results['uri'];
            $this->tags = $this->tags->loadBycontest($id);
                
            return $this;
        }
        else
        {
            return false;
        }
    }
}