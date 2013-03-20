<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/contest.php");
require_once(WWW_DIR."/lib/status.php");

class Caption
{		
    private $id, $contest, $status, $caption, $user_id;
    
    public function __construct($id=-1,$contest_id=-1,$status_id=-1,$caption='',$sub_disp='',$user=-1) 
    {
        $this->id = $id;
        $this->contest_id = $id;
        $this->status = new Status($status_id);
        $this->caption = $caption;
        $this->sub_disp = $sub_disp;
        if ($user > 0) 
        {
            //fetch a user object
            $this->user = array(
                'id'=>$user,
                'display'=>''
            ); // new User();
        }
        else
        {
            $this->user = array(
                'id'=>-1,
                'display'=>''
            );
        }
    }
}

class CaptionCollection
{		
    private $captions = array();
    
    public function __construct($contest_id=-1)
    {
        return $this->load($contest_id);
    }
    
    public function load($contest_id)
    {
        if($contest_id > 0)
        {
            // query from the db for the captions.
            $db = new DB();
            $parms = array();
            $query = "SELECT NOW() AS querytime, id, contest_id, status_id, caption, sub_disp, user_id FROM `caption` WHERE `contest_id` = :contest_id";
            $parms[] = array(':contest_id',$contest_id);
            
            $results = $db->query($query, $parms, true, 3600);
            
            foreach ($results as $row)
            { // iterate over the results
                // populate a caption object
                $caption = new Caption(
                    $row['id'],
                    $row['contest_id'],
                    $row['status_id'],
                    $row['caption'],
                    $row['sub_disp'],
                    $row['user_id']
                );
                
                // save it to the collection
                $this->captions[] = $caption;
            }
            // return the collection
        }
        return $this->captions;
    }
}