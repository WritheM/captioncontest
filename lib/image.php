<?
require_once(WWW_DIR."/lib/framework/db.php");

// a quote is classified as any period of time that a contest will run for. 
class Image
{		
    private $id, $path, $width, $height;
    
    public function __construct($id, $path, $width, $height) 
    {
        $this->id = $id;
        $this->path = '';
        $this->width = '';
        $this->height = '';
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
                
            return $this;
        }
        else
        {
            return false;
        }
    }
}