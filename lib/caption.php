<?
require_once(WWW_DIR."/lib/framework/db.php");
require_once(WWW_DIR."/lib/contest.php");
require_once(WWW_DIR."/lib/status.php");

class Caption
{		
    public $id, $contest_id, $status, $caption, $sub_disp, $user, $score, $votes;
    
    public function __construct($id=-1,$contest_id=-1,$status_id=-1,$caption='',$sub_disp='',$user=-1,$score=-1,$votes=0) 
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
        $this->score = $score;
        $this->votes = $votes;

    }
}

class CaptionManager
{		
    private $dbo;
    
    public function __construct($dbo)
    {
        $this->dbo = $dbo;
    }
    
    public function load($contest_id=-1)
    {
        if($contest_id > 0)
        {
            // query from the db for the captions.
            $parms = array();
            $query = "SELECT NOW() AS querytime, id, contest_id, status_id, caption, sub_disp, user_id FROM `caption` WHERE `contest_id` = :contest_id";
            $parms[] = array(':contest_id',$contest_id);
            
            $results = $this->dbo->query($query, $parms, true, 3600);
            
            $captions = array();
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
                $captions[] = $caption;
            }
            // return the collection
        }
        return $captions;
    }
}