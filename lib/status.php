<?
class Status
{		
    const STATUS_DELETED = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_DRAFT = 3;
    
    const STATUS_SUBMITTED = 4;
    const STATUS_REVIEWED = 5;

    public $id, $name;
    
    public function __construct($id=-1) 
    {
        return $this->load($id);
    }
    
    public function load($id)
    {
        $this->id = $id;
        switch($id)
        {
            case self::STATUS_DELETED: 
                $this->name = 'Deleted';
                break;
            case self::STATUS_PUBLISHED:
                $this->name = 'Published';
                break;
            case self::STATUS_SUBMITTED:
                $this->name = 'Submitted';
                break;
            case self::STATUS_REVIEWED:
                $this->name = 'Reviewed';
                break;
            case self::STATUS_DRAFT:
            default:
                $this->id = self::STATUS_DRAFT;
                $this->name = 'Draft';
                break;
        }
        return $this;
    }
}