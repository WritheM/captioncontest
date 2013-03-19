<?
require_once(WWW_DIR."/lib/framework/db.php");

class Tag
{		
    private $id, $tag;
    
    public function __construct($id, $tag) 
    {
        $this->id = $id;
        $this->tag = $tag;
    }
}

class TagCollection
{		
    private $tags = array();
    
    public function loadByContest($contest_id)
    {
        if($contest_id > 0)
        {
            // query from the db for the tags.
            
            for ($n=1;$n<3;$n++)
            { // iterate over the results
                // populate a tag object
                $tag = new Tag($n,'test');
                
                // save it to the collection
                $this->tags[] = $tag;
            }
            // return the collection
            return $this->tags;
        }
        else
        {
            return false;
        }
    }
}