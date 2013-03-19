<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/tags.php");

// a quote is classified as any period of time that a contest will run for. 
class Image
{		
    private $id, $path, $width, $height;
    
    public function __construct($id=-1, $path='', $width=0, $height=0, $tags = null) 
    {
        $this->id = $id;
        $this->path = $path;
        $this->width = $width;
        $this->height = $height;
        $this->tags = (isset($tags) ? $tags : new TagCollection());
    }
    
    public function set($k, $v)
    {
        $this->$k = $v;
    }
    
    public function load($id = 0)
    {
        if($id > 0)
        {
            $this->id = 1;
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