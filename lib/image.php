<?
require_once(WWW_DIR."/lib/tags.php");

// a quote is classified as any period of time that a contest will run for. 
class Image
{		
    public $id, $path, $width, $height;
    
    public function __construct() 
    {
        $this->id = -1;
        $this->path = '';
        $this->width = 0;
        $this->height = 0;
        $this->tags = new TagCollection();
    }
}

class ImageManager
{
    private $dbo;
    
    public function __construct($dbo)
    {
        $this->dbo = $dbo;
    }
    
    public function loadOne($id = -1)
    {
        if($id > 0)
        {
            $parms = array();
            $query = "SELECT NOW() AS querytime, id, width, height, uri FROM `images` WHERE `id` = :id LIMIT 0,1";
            $parms[] = array(':id',$id);
            
            $results = $this->dbo->queryOneRow($query, $parms, true, 3600);
            
            $image = new Image();
            $image->id = (int)$results['id'];
            $image->width = (int)$results['width'];
            $image->height = (int)$results['height'];
            $image->path = (string)$results['uri'];
            $image->tags = $image->tags->loadBycontest($id);
                
            return $image;
        }
        else
        {
            return false;
        }
    }
}