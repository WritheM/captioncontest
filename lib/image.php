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
            $this->id = $id;
            $this->path = 'quotes/test.jpg';
            $this->width = 120;
            $this->height = 120;
            $this->tags = $this->tags->loadBycontest(1);
                
            return $this;
        }
        else
        {
            return false;
        }
    }
}